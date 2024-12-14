<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\File;
use App\Models\FileCategory;
use App\Models\FileShare;
use App\Models\Folder;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $userId = auth()->id();
        $folders = Folder::where('user_id', Auth::user()->id)->where('parent_id', null)->get();

        $files = File::where('user_id', $userId)->where('folder_id', null)->get();
        $categories = FileCategory::all();
        $users = User::with('pegawai')->where('role', '!=', 'admin')->get();


        return view('home', compact('folders', 'files', 'users', 'categories'));
    }

    public function sharedByMe()
    {
        $userId = auth()->id();
        $sharedItems = FileShare::with(['file', 'folder'])
            ->whereHas('file', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orWhereHas('folder', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();

        return view('shared_by_me', compact('sharedItems'));
    }


    public function sharedWithMe()
    {
        $userId = auth()->id();
        $sharedItems = FileShare::with(['file', 'folder'])
            ->where('shared_with_id', $userId)
            ->get();

        return view('shared_with_me', compact('sharedItems'));
    }

    public function trash()
    {
        $deletedFiles = File::onlyTrashed()->get();
        $deletedFolders = Folder::onlyTrashed()->get();

        return view('trash', compact('deletedFiles', 'deletedFolders'));
    }
    public function restoreItem(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');

        if ($type === 'file') {
            File::withTrashed()->findOrFail($id)->restore();
        } elseif ($type === 'folder') {
            Folder::withTrashed()->findOrFail($id)->restore();
        }

        return response()->json(['success' => true, 'message' => 'Item restored successfully.']);
    }
    public function deleteItemPermanently(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');

        if ($type === 'file') {
            File::withTrashed()->findOrFail($id)->forceDelete();
        } elseif ($type === 'folder') {
            Folder::withTrashed()->findOrFail($id)->forceDelete();
        }

        return response()->json(['success' => true, 'message' => 'Item deleted permanently.']);
    }
    public function search()
    {
        // Mengambil ID User yang sedang login
        $userId = Auth::user()->id;

        // Mengambil semua file yang dimiliki oleh User yang sedang login
        $fileResults = File::where('user_id', $userId)->get(['id', 'name', 'type', 'path']);

        // Mengambil semua folder yang dimiliki oleh User yang sedang login
        $folderResults = Folder::where('user_id', $userId)->get(['id', 'name']);

        // Mengambil semua file yang dibagikan kepada User
        $sharedFiles = FileShare::with('file')
            ->where('shared_with_id', $userId)
            ->get()
            ->filter(function ($fileShare) {
                // Pastikan 'file' tidak null
                return $fileShare->file !== null;
            })
            ->pluck('file');

        // Mengambil semua folder yang dibagikan kepada User
        $sharedFolders = FileShare::with('folder')
            ->where('shared_with_id', $userId)
            ->get()
            ->filter(function ($fileShare) {
                // Pastikan 'folder' tidak null
                return $fileShare->folder !== null;
            })
            ->pluck('folder');

        // Gabungkan hasil pencarian file, folder, dan file serta folder yang dibagikan
        $results = $fileResults->merge($folderResults)->merge($sharedFiles)->merge($sharedFolders);

        // Return semua data yang ditemukan
        return response()->json($results);
    }


    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    public function favorites()
    {
        $fileFavorites = File::where('user_id', Auth::id())
            ->where('is_favorite', true)
            ->get();
        $folderFavorites = Folder::where('user_id', Auth::id())
            ->where('is_favorite', true)
            ->get();

        return view('favorites.index', compact('fileFavorites', 'folderFavorites'));
    }
    public function departemenFiles($id)
    {
        $folders = Folder::where('department_id', $id)->get();
        $files = File::where('department_id', $id)->get();
        $departmentName = Department::find($id)->name;
        $departmentId = Department::find($id)->id;
        $users = User::with('pegawai')->where('role', '!=', 'admin')->get();
        $categories = FileCategory::all();

        return view('departemen-files', compact('files', 'folders', 'users', 'departmentName', 'categories', 'departmentId'));
    }
}
