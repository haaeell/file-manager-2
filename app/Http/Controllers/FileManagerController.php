<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    public function index($parentId = null)
    {
        $files = File::where('folder_id', $parentId)->get();
        $folders = Folder::where('parent_id', $parentId)->get();
        return view('filemanager.index', compact('files', 'folders', 'parentId'));
    }

    public function create()
    {
        return view('filemanager.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file',
        ]);

        $path = $request->file('file')->store('uploads');

        File::create([
            'name' => $request->name,
            'path' => $path,
            'user_id' => auth()->id(),
            'department_id' => 1,
            'folder_id' => $request->folder_id, // Tambahkan ini
        ]);

        return redirect()->route('filemanager.index', $request->folder_id)->with('success', 'File uploaded successfully.');
    }

    public function createFolder()
    {
        return view('filemanager.create_folder');
    }

    public function storeFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Folder::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
            'department_id' => 1,
            'parent_id' => $request->parent_id, // Tambahkan ini
        ]);

        return redirect()->route('filemanager.index', $request->parent_id)->with('success', 'Folder created successfully.');
    }
}
