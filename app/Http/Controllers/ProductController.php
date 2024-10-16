<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('desc', 'like', '%' . $searchTerm . '%');
            });
        }

        if ($request->filled('cat_id')) {
            $query->where('cat_id', $request->input('cat_id'));
        }

        $products = $query->paginate(8);
        $categories = Cat::all();
        return view('products.index', compact('products', 'categories'));
    }


    public function create()
    {
        $categories = Cat::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'cat_id' => 'required|exists:cats,id',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        Product::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'image' => $imagePath,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'cat_id' => $request->cat_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Cat::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'cat_id' => 'required|exists:cats,id',
        ]);

        $data = $request->only(['name', 'desc', 'price', 'quantity', 'cat_id']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
