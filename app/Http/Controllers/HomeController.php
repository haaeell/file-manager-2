<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileShare;
use App\Models\Folder;
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
        $users = User::with('pegawai')->get();

        return view('home', compact('folders', 'files', 'users'));
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

    public function search(Request $request)
    {
        $query = $request->input('search');
        $userId = Auth::id();

        $fileResults = File::where('user_id', $userId)
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                    ->orWhere('type', 'LIKE', '%' . $query . '%');
            })
            ->get(['id', 'name', 'type', 'user_id', 'path']);

        $folderResults = Folder::where('user_id', $userId)
            ->where('name', 'LIKE', '%' . $query . '%')
            ->get(['id', 'name', 'user_id']);

        $sharedFiles = FileShare::with('file')
            ->where('shared_with_id', $userId)
            ->whereHas('file', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->get()
            ->pluck('file');

        $sharedFolders = FileShare::with('folder')
            ->where('shared_with_id', $userId)
            ->whereHas('folder', function ($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%');
            })
            ->get()
            ->pluck('folder');

        $results = $fileResults->merge($folderResults)->merge($sharedFiles)->merge($sharedFolders);

        return response()->json($results);
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }
}
