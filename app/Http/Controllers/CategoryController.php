<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    public function index()
    {
        Gate::authorize('manage-category');

        $categories = Kategori::withCount('products')->paginate(10);

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        Gate::authorize('manage-category');

        return view('category.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-category');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:kategoris,name',
        ], [
            'name.required' => 'Nama category wajib diisi.',
            'name.max' => 'Nama category tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama category sudah digunakan.',
        ]);

        Kategori::create($validated);

        return redirect()->route('category.index')->with('success', 'Category berhasil ditambahkan.');
    }

    public function edit($id)
    {
        Gate::authorize('manage-category');

        $category = Kategori::findOrFail($id);

        return view('category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('manage-category');

        $category = Kategori::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:kategoris,name,' . $category->id,
        ], [
            'name.required' => 'Nama category wajib diisi.',
            'name.max' => 'Nama category tidak boleh lebih dari 255 karakter.',
            'name.unique' => 'Nama category sudah digunakan.',
        ]);

        $category->update($validated);

        return redirect()->route('category.index')->with('success', 'Category berhasil diupdate.');
    }

    public function delete($id)
    {
        Gate::authorize('manage-category');

        $category = Kategori::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Category berhasil dihapus.');
    }
}
