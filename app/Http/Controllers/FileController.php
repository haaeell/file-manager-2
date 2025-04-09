<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Models\FileCategory;
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


        if ($request->type === 'folder') {
            $folder = new Folder();
            $folder->name = $request->name;
            $folder->user_id = Auth::user()->id;
            $folder->parent_id = $request->folder_id;
            $folder->department_id =  $request->department_id ?? null;
            $folder->save();
        }

        if ($request->type === 'file') {
            $fileSize = $request->file('file')->getSize() / (1024 * 1024);
            $usedSpace = $user->calculateDiskSpace();
            $maxSpace = $user->disk_space;

            if (($usedSpace + $fileSize) > $maxSpace) {
                return back()->withErrors(['message' => 'Upload failed: Disk space limit exceeded.']);
            }
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
                    $file->folder_id = $request->folder_id;
                    $file->file_category_id = $request->category_id;
                    $file->department_id =  $request->department_id ?? null;
                    $file->save();
                } else {
                    return redirect()->back()->withErrors(['File tidak valid atau sudah dihapus.']);
                }
            }
        }

        return redirect()->back()->with('success', 'Folder atau file berhasil ditambahkan.');
    }

    public function showFolder($id = null, Request $request)
    {
        $search = $request->input('search');
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
        $files = File::where('folder_id', $folder->id ?? null)->get();
        $users = User::with('pegawai')->where('role', '!=', 'admin')->get();
        $categories = FileCategory::all();

        return view('folder.show', compact('folder', 'breadcrumbs', 'subfolders', 'files', 'users', 'categories'));
    }

    public function rename(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'type' => 'required|string|in:folder,file',
            'new_name' => 'required|string|max:255',
        ]);
        if ($request->type === 'folder') {
            $checkUserFolder = Folder::where('id', $request->id)->where('user_id', Auth::user()->id)->exists();

            if (!$checkUserFolder) {
                return redirect()->back()->with(['success' => false, 'message' => 'Anda tidak memiliki akses untuk menghapus file atau folder ini!.'], 401);
            }
            $folder = Folder::findOrFail($request->id);
            $folder->name = $request->new_name;
            $folder->save();
        } elseif ($request->type === 'file') {
            $checkUserFile = File::where('id', $request->id)->where('user_id', Auth::user()->id)->exists();
            if (!$checkUserFile) {
                return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus file atau folder ini!.');
            }
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
        $userId = Auth::id();
    
        // Cek file (kalau ada yang dikirim)
        if (!empty($fileIds)) {
            $validFileCount = File::whereIn('id', $fileIds)
                ->where('user_id', $userId)
                ->count();
    
            if ($validFileCount !== count($fileIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ada file yang bukan milik Anda!',
                ], 401);
            }
    
            File::whereIn('id', $fileIds)->delete();
        }
    
        // Cek folder (kalau ada yang dikirim)
        if (!empty($folderIds)) {
            $validFolderCount = Folder::whereIn('id', $folderIds)
                ->where('user_id', $userId)
                ->count();
    
            if ($validFolderCount !== count($folderIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ada folder yang bukan milik Anda!',
                ], 401);
            }
    
            Folder::whereIn('id', $folderIds)->delete();
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Items deleted successfully.',
        ]);
    }
    

    public function destroyFileShare($id)
    {
        $fileShare = FileShare::where('file_id', $id)
            ->where('shared_with_id', auth()->id())
            ->first();

        if (!$fileShare) {
            abort(403, 'Kamu tidak punya akses untuk menghapus file ini.');
        }

        $file = $fileShare->file;

        if ($file && file_exists(public_path($file->path))) {
            unlink(public_path($file->path));
        }
        if ($file) {
            $file->delete();
        }

        $fileShare->delete();

        return redirect()->back()->with('success', 'File dan data share berhasil dihapus.');
    }

    public function shareItems(Request $request)
    {
        $fileIds = $request->input('file_ids', []);
        $folderIds = $request->input('folder_ids', []);
        $sharedWithIds = $request->input('shared_with_ids', []);
        $permission = $request->input('permission', 'view');

        $sharedWithUsers = User::whereIn('id', $sharedWithIds)->get();

        if ($sharedWithUsers->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Users not found.'], 404);
        }

        foreach ($fileIds as $fileId) {
            foreach ($sharedWithUsers as $sharedWithUser) {
                $existingShare = FileShare::where('file_id', $fileId)
                    ->where('shared_with_id', $sharedWithUser->id)
                    ->exists();

                if ($existingShare) {
                    return response()->json([
                        'success' => false,
                        'message' => 'File sudah dibagikan ke ' . $sharedWithUser->name
                    ], 400);
                }

                FileShare::updateOrCreate(
                    ['file_id' => $fileId, 'shared_with_id' => $sharedWithUser->id],
                    ['permission' => $permission]
                );

                $file = File::find($fileId);
                if ($file) {
                    $sharedWithUser->notify(new FileSharedNotification($file->name, Auth::user()->name));
                }
            }
        }

        foreach ($folderIds as $folderId) {
            foreach ($sharedWithUsers as $sharedWithUser) {

                $existingShare = FileShare::where('folder_id', $folderId)
                    ->where('shared_with_id', $sharedWithUser->id)
                    ->exists();

                if ($existingShare) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Folder sudah dibagikan ke ' . $sharedWithUser->name
                    ], 400);
                }

                FileShare::updateOrCreate(
                    ['folder_id' => $folderId, 'shared_with_id' => $sharedWithUser->id],
                    ['permission' => $permission]
                );

                $folder = Folder::find($folderId);
                if ($folder) {
                    $sharedWithUser->notify(new FileSharedNotification($folder->name, Auth::user()->name));
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Items shared successfully.']);
    }

    public function updatePermission(Request $request, $id)
    {
        $item = FileShare::findOrFail($id);
        $item->permission = $request->permission;
        $item->save();

        return response()->json(['success' => true]);
    }
}
