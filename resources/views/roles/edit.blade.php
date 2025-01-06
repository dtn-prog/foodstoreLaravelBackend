@extends('layout')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Edit Role</h1>
    <form action="{{ route('roles.update', $role) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')
        <label for="name" class="block text-sm font-medium text-gray-700">Role Name:</label>
        <input type="text" name="name" value="{{ $role->name }}" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">

        <h3 class="mt-4 text-lg font-semibold">Permissions</h3>
        @foreach ($permissions as $permission)
            <div class="flex items-center mt-2">
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} class="mr-2">
                <label class="text-gray-700">{{ $permission->name }}</label>
            </div>
        @endforeach

        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
