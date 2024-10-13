@extends('layout')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <h2 class="text-3xl font-semibold mb-6">Edit Category</h2>
    <form action="{{ route('cats.update', $cat) }}" method="POST" class="bg-white p-4 rounded shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $cat->name) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded @error('name') border-red-500 @enderror" required>
            @error('name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Update Category</button>
        <a href="{{ route('cats.index') }}" class="ml-4 text-gray-500">Cancel</a>
    </form>
</div>
@endsection
