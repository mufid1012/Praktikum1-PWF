<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index()
    {
        try {
            $products = Product::with('category')->get();

            return response()->json([
                'message' => 'Products retrieved successfully',
                'data' => $products,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data produk',
            ], 500);
        }
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['user_id'] = Auth::id();

            $product = Product::create($validated);

            Log::info('Menambah data produk', [
                'list' => $product
            ]);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan!!',
                'data' => $product,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menambah produk',
            ], 500);
        }
    }

    /**
     * Display the specified product.
     */
    public function show(int $id)
    {
        try {
            $product = Product::with('category')->find($id);

            if (!$product)
            {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'data' => $product
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat mengambil data produk',
            ], 500);
        }
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'qty' => 'sometimes|required|integer',
                'price' => 'sometimes|required|numeric',
                'category_id' => 'sometimes|required|exists:kategoris,id',
            ]);

            $product->update($validated);

            Log::info('Mengupdate data produk', [
                'list' => $product
            ]);

            return response()->json([
                'message' => 'Produk berhasil diupdate!!',
                'data' => $product,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat mengupdate product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat mengupdate produk',
            ], 500);
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            $product->delete();

            Log::info('Menghapus data produk', [
                'id' => $id
            ]);

            return response()->json([
                'message' => 'Produk berhasil dihapus!!',
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat menghapus product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus produk',
            ], 500);
        }
    }
}
