@extends('layout')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h2 class="text-3xl font-semibold mb-6">Products</h2>

    <div class="flex justify-between mb-4">
        @can('create products')
            <a href="{{ route('products.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Add Product</a>
        @endcan

        <form method="GET" action="{{ route('products.index') }}" class="flex items-center">
            <input type="text" name="search" placeholder="Search by name or description" class="border rounded p-2" value="{{ request('search') }}">
            <select name="cat_id" class="border rounded p-2 ml-2">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('cat_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 ml-2">Filter</button>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
        @foreach ($products as $product)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-transform duration-300 transform hover:scale-105">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-bold text-gray-800">{{ $product->name }} | {{ $product->id }}</h3>
                    <p class="text-gray-800 font-semibold mt-2">{{ $product->price }} đ</p>
                    <p class="text-gray-800 font-semibold mt-2">Cat: {{ $product->category->name }}</p>
                    <p class="text-gray-600 mt-2">Quantity: {{ $product->quantity }}</p>
                    <div class="mt-4 flex justify-between">

                        @can('edit products')
                            <a href="{{ route('products.edit', $product) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Edit</a>
                        @endcan

                        @can('delete products')
                            <button onclick="document.getElementById('delete-box-{{ $product->id }}').showModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200">Delete</button>
                        @endcan
                    </div>
                </div>
            </div>

            <dialog id='delete-box-{{ $product->id }}' class="rounded-lg p-4">
                <form method="POST" action="{{ route('products.destroy', $product) }}" class="flex flex-col">
                    @csrf
                    @method('DELETE')
                    <p class="mb-4 text-gray-700">Are you sure you want to delete this product?</p>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200">Delete</button>
                        <button type="button" onclick="document.getElementById('delete-box-{{ $product->id }}').close()" class="ml-3 bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition duration-200">Cancel</button>
                    </div>
                </form>
            </dialog>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
