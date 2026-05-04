<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories.
     */
    public function index()
    {
        try {
            $categories = Kategori::withCount('products')->get();

            return response()->json([
                'message' => 'Categories retrieved successfully',
                'data' => $categories,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data kategori', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data kategori',
            ], 500);
        }
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:kategoris,name',
            ], [
                'name.required' => 'Nama category wajib diisi.',
                'name.max' => 'Nama category tidak boleh lebih dari 255 karakter.',
                'name.unique' => 'Nama category sudah digunakan.',
            ]);

            $category = Kategori::create($validated);

            Log::info('Menambah data kategori', [
                'list' => $category
            ]);

            return response()->json([
                'message' => 'Category berhasil ditambahkan!!',
                'data' => $category,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 400);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menambah kategori',
            ], 500);
        }
    }

    /**
     * Display the specified category.
     */
    public function show(int $id)
    {
        try {
            $category = Kategori::withCount('products')->find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'message' => 'Category retrieved successfully',
                'data' => $category,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data kategori', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data kategori',
            ], 500);
        }
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $category = Kategori::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:kategoris,name,' . $category->id,
            ], [
                'name.required' => 'Nama category wajib diisi.',
                'name.max' => 'Nama category tidak boleh lebih dari 255 karakter.',
                'name.unique' => 'Nama category sudah digunakan.',
            ]);

            $category->update($validated);

            Log::info('Mengupdate data kategori', [
                'list' => $category
            ]);

            return response()->json([
                'message' => 'Category berhasil diupdate!!',
                'data' => $category,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $e->errors(),
            ], 400);
        } catch (\Throwable $e) {
            Log::error('Error saat mengupdate category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat mengupdate kategori',
            ], 500);
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(int $id)
    {
        try {
            $category = Kategori::find($id);

            if (!$category) {
                return response()->json([
                    'message' => 'Category tidak ditemukan',
                ], 404);
            }

            $category->delete();

            Log::info('Menghapus data kategori', [
                'id' => $id
            ]);

            return response()->json([
                'message' => 'Category berhasil dihapus!!',
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat menghapus category', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus kategori',
            ], 500);
        }
    }
}
