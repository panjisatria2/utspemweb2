<?php

namespace App\Http\Controllers;

use App\Models\Product; // Pastikan model Product sudah ada
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $products = Product::all();
        return view('dashboard.products.index', compact('products'));
    }

    // Menampilkan form untuk membuat produk baru
    public function create()
    {
        return view('dashboard.products.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'image_source' => 'required|in:file,url',
    ]);

    $imagePath = null;

    if ($request->image_source === 'file' && $request->hasFile('image_file')) {
        $imagePath = $request->file('image_file')->store('products', 'public');
    } elseif ($request->image_source === 'url') {
        $imagePath = $request->image_url; // Simpan URL langsung
    }

    Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'image' => $imagePath,
    ]);

    return redirect()->route('products.index')->with('successMessage', 'Product created successfully!');
}


    // Menampilkan form untuk mengedit produk
    public function edit(Product $product)
    {
        return view('dashboard.products.edit', compact('product'));
    }

    // Memperbarui produk
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Menghapus produk
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function show(string $id)
    {
        $product = Product::find($id);
    }
}