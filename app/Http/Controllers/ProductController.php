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

    // Store a newly created product in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'cat_id' => 'required|exists:cats,id', // Validate category ID
        ]);

        // Store the image and get the path
        $imagePath = $request->file('image')->store('images', 'public');

        // Create the product
        Product::create([
            'name' => $request->name,
            'image' => $imagePath,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'cat_id' => $request->cat_id, // Assign category ID
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        $categories = Cat::all(); // Fetch all categories
        return view('products.edit', compact('product', 'categories'));
    }

    // Update the specified product in storage
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'cat_id' => 'required|exists:cats,id', // Validate category ID
        ]);

        // Update the product details
        $data = $request->only(['name', 'price', 'quantity', 'cat_id']); // Include category ID

        // Check if an image is being uploaded
        if ($request->hasFile('image')) {
            // Store the new image and get the path
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
