<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cat; // Import the Cat model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Product::with('category')->get(); // Eager load category
        return view('products.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        $categories = Cat::all(); // Fetch all categories
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string', // Add validation for desc
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'cat_id' => 'required|exists:cats,id',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        Product::create([
            'name' => $request->name,
            'desc' => $request->desc, // Include desc in creation
            'image' => $imagePath,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'cat_id' => $request->cat_id,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        $categories = Cat::all(); // Fetch all categories
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'required|string', // Add validation for desc
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'cat_id' => 'required|exists:cats,id',
        ]);

        $data = $request->only(['name', 'desc', 'price', 'quantity', 'cat_id']); // Include desc

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        // Delete the image from storage if it exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
