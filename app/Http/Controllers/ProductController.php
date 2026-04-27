<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('kategori')->paginate(10);

        return view('product.index', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        Gate::authorize('create', Product::class);

        $validated = $request->validated();

        // Map quantity -> qty untuk database column
        if (isset($validated['quantity'])) {
            $validated['qty'] = $validated['quantity'];
            unset($validated['quantity']);
        }

        $product = Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function create()
    {
        Gate::authorize('create', Product::class);

        $users = User::orderBy('name')->get();
        $categories = Kategori::orderBy('name')->get();

        return view('product.create', compact('users', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('product.view', compact('product'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        // Policy: hanya admin pemilik product yang bisa update
        Gate::authorize('update', $product);

        $validated = $request->validated();

        // Map quantity -> qty untuk database column
        if (isset($validated['quantity'])) {
            $validated['qty'] = $validated['quantity'];
            unset($validated['quantity']);
        }

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function edit(Product $product)
    {
        // Policy: hanya admin pemilik product yang bisa edit
        Gate::authorize('update', $product);

        $users = User::orderBy('name')->get();
        $categories = Kategori::orderBy('name')->get();

        return view('product.edit', compact('product', 'users', 'categories'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // Policy: hanya admin pemilik product yang bisa delete
        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}