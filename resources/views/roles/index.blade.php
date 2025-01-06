@extends('layout')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold my-4">Roles</h1>
    <a href="{{ route('roles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Create Role</a>
    <ul class="mt-4">
        @foreach ($roles as $role)
            <li class="flex justify-between items-center border-b py-2">
                <span class="text-lg">{{ $role->name }}</span>
                <div>
                    <a href="{{ route('roles.edit', $role) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline ml-4">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
