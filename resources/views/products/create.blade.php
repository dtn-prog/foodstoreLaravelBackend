@extends('layout')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h2 class="text-3xl font-semibold mb-6">Add Product</h2>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('name') border-red-500 @enderror" required>
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700">Price</label>
            <input type="number" name="price" id="price" value="{{ old('price') }}" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('price') border-red-500 @enderror" required>
            @error('price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700">Image</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('image') border-red-500 @enderror" required onchange="previewImage(event)">
            @error('image')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            <img id="image-preview" class="mt-2 w-full h-48 object-cover rounded hidden" />
        </div>

        <div class="mb-4">
            <label for="in_stock" class="block text-gray-700">In Stock</label>
            <select name="in_stock" id="in_stock" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('in_stock') border-red-500 @enderror" required>
                <option value="1" {{ old('in_stock') ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('in_stock') === '0' ? 'selected' : '' }}>No</option>
            </select>
            @error('in_stock')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Add Product</button>
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
