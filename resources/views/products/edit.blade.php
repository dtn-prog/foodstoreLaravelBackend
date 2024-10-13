@extends('layout')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h2 class="text-3xl font-semibold mb-6">Edit Product</h2>
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('name') border-red-500 @enderror" required>
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="desc" class="block text-gray-700">Description</label>
            <textarea name="desc" id="desc" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('desc') border-red-500 @enderror" required>{{ old('desc', $product->desc) }}</textarea>
            @error('desc')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="cat_id" class="block text-gray-700">Category</label>
            <select name="cat_id" id="cat_id" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('cat_id') border-red-500 @enderror" required>
                <option value="" disabled>Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->cat_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            @error('cat_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700">Price</label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('price') border-red-500 @enderror" required>
            @error('price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700">Image</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('image') border-red-500 @enderror" onchange="previewImage(event)">
            @error('image')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="mt-2 w-full h-48 object-cover rounded @if(!$product->image) hidden @endif" />
        </div>

        <div class="mb-4">
            <label for="quantity" class="block text-gray-700">Quantity</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('quantity') border-red-500 @enderror" required>
            @error('quantity')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Update Product</button>
        <a href="{{ route('products.index') }}" class="ml-4 text-gray-500">Cancel</a>
    </form>
</div>

<script>
    function previewImage(event) {
        const imagePreview = document.getElementById('image-preview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.classList.add('hidden');
        }
    }
</script>
@endsection
