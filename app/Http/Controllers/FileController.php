<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\FileShare;
use App\Models\Folder;
use App\Models\User;
use App\Notifications\FileSharedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

class FileController extends Controller
{
    public function index()
    {
        $folders = Folder::with('children')->where('user_id', Auth::user()->id)->where('parent_id', null)->get();
        dd($folders);
        $files = File::all();

        return view('files.index', compact('folders', 'files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'type' => 'required|in:folder,file',
            'file' => 'nullable|file|max:2048',
            'folder_id' => 'nullable|exists:folders,id',
        ]);

        $user = Auth::user();
        $fileSize = $request->file('file')->getSize() / (1024 * 1024); 
        $usedSpace = $user->calculateDiskSpace();
        $maxSpace = $user->disk_space;

        if (($usedSpace + $fileSize) > $maxSpace) {
            return back()->withErrors(['message' => 'Upload failed: Disk space limit exceeded.']);
        }

        if ($request->type === 'folder') {
            $folder = new Folder();
            $folder->name = $request->name;
            $folder->user_id = Auth::user()->id;
            $folder->department_id = Auth::user()->pegawai->department_id ?? 1;
            $folder->parent_id = $request->folder_id;
            $folder->save();
        }

        if ($request->type === 'file') {
            if ($request->hasFile('file')) {
                $uploadedFile = $request->file('file');

                if ($uploadedFile->isValid()) {
                    $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $uploadedFile->getClientOriginalExtension();
                    $destinationPath = public_path('file-manager');

                    $fileName = $originalFileName;
                    $counter = 1;

                    while (file_exists($destinationPath . '/' . $fileName . '.' . $extension)) {
                        $fileName = $originalFileName . " ($counter)";
                        $counter++;
                    }

                    $finalFileName = $fileName . '.' . $extension;
                    $uploadedFile->move($destinationPath, $finalFileName);

                    $fileSize = filesize($destinationPath . '/' . $finalFileName);

                    $file = new File();
                    $file->name = $finalFileName;
                    $file->path = 'file-manager/' . $finalFileName;
                    $file->type = $uploadedFile->getClientMimeType();
                    $file->size = $fileSize;
                    $file->user_id = Auth::user()->id;
                    $file->department_id = Auth::user()->pegawai->department_id ?? 1;
                    $file->folder_id = $request->folder_id;

                    $file->save();
                } else {
                    return redirect()->back()->withErrors(['File tidak valid atau sudah dihapus.']);
                }
            }
        }

        return redirect()->back()->with('success', 'Folder atau file berhasil ditambahkan.');
    }

    public function showFolder($id = null)
    {
        $folder = $id ? Folder::findOrFail($id) : null;
        $breadcrumbs = [];

        if ($folder) {
            $parent = $folder;
            while ($parent) {
                array_unshift($breadcrumbs, $parent);
                $parent = $parent->parent;
            }
        }

        $subfolders = $folder ? $folder->subfolders : Folder::whereNull('parent_id')->get();
        $files = File::where('user_id', Auth::user()->id)->where('folder_id', $folder->id ?? null)->get();
        $users = User::with('pegawai')->get();

        return view('folder.show', compact('folder', 'breadcrumbs', 'subfolders', 'files', 'users'));
    }

    public function rename(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:folder,file',
            'new_name' => 'required|string|max:255',
        ]);

        if ($request->type === 'folder') {
            $folder = Folder::findOrFail($request->id);
            $folder->name = $request->new_name;
            $folder->save();
        } elseif ($request->type === 'file') {
            $file = File::findOrFail($request->id);
            $file->name = $request->new_name;
            $file->save();
        }

        return redirect()->back()->with('success', 'Item renamed successfully.');
    }

    public function toggleFavorite(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:folder,file',
        ]);

        if ($request->type === 'folder') {
            $item = Folder::findOrFail($request->id);
        } elseif ($request->type === 'file') {
            $item = File::findOrFail($request->id);
        }

        $item->is_favorite = !$item->is_favorite;
        $item->save();

        return response()->json(['success' => true, 'is_favorite' => $item->is_favorite]);
    }

    public function downloadFolder($folderId)
    {
        $folder = Folder::findOrFail($folderId);
        $folderPath = public_path($folder->path);
        $zipFileName = $folder->name . '.zip';
        $zipFilePath = public_path("zips/{$zipFileName}");

        if (!file_exists(public_path('zips'))) {
            mkdir(public_path('zips'), 0777, true);
        }

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath));
            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($folderPath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function deleteItems(Request $request)
    {
        $fileIds = $request->input('file_ids', []);
        $folderIds = $request->input('folder_ids', []);
        if (!empty($fileIds)) {
            File::whereIn('id', $fileIds)->delete();
        }

        if (!empty($folderIds)) {
            Folder::whereIn('id', $folderIds)->delete();
        }

        return response()->json(['success' => true, 'message' => 'Items deleted successfully.']);
    }

    public function shareItems(Request $request)
    {
        $fileIds = $request->input('file_ids', []);
        $folderIds = $request->input('folder_ids', []);
        $sharedWithId = $request->input('shared_with_id');
        $permission = $request->input('permission', 'view');

        $sharedWithUser = User::find($sharedWithId);

        if (!$sharedWithUser) {
            return response()->json(['success' => false, 'message' => 'User not found.'], 404);
        }

        foreach ($fileIds as $fileId) {
            FileShare::updateOrCreate(
                ['file_id' => $fileId, 'shared_with_id' => $sharedWithId],
                ['permission' => $permission]
            );

            $file = File::find($fileId);
            if ($file) {
                $sharedWithUser->notify(new FileSharedNotification($file->name, Auth::user()->name));
            }
        }

        foreach ($folderIds as $folderId) {
            FileShare::updateOrCreate(
                ['folder_id' => $folderId, 'shared_with_id' => $sharedWithId],
                ['permission' => $permission]
            );

            $folder = Folder::find($folderId);
            if ($folder) {
                $sharedWithUser->notify(new FileSharedNotification($folder->name, Auth::user()->name));
            }
        }

        return response()->json(['success' => true, 'message' => 'Items shared successfully.']);
    }
}