<?php

namespace App\Http\Controllers;

use App\Models\FileCategory;
use Illuminate\Http\Request;

class FileCategoryController extends Controller
{
    public function index()
    {
        $categories = FileCategory::all();
        return view('file-categories.index', compact('categories'));
    }
    public function create()
    {
        return view('file-categories.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        FileCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('file-categories.index')->with('success', 'Kategori berhasil dibuat!');
    }

    public function show(string $id) {}

    public function edit(string $id)
    {
        $category = FileCategory::findOrFail($id);
        return view('file-categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = FileCategory::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('file-categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $category = FileCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('file-categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
