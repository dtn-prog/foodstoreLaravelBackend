@extends('layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">User Management</h1>

    <div class="mb-4">
        @can('create users')
            <a href="{{ route('users.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Add New User</a>
        @endcan
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Name</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Phone</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Roles</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-300">{{ $user->name }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ $user->phone }}</td>
                    <td class="py-2 px-4 border-b border-gray-300">
                        @if($user->roles->isEmpty())
                            No roles assigned
                        @else
                            @foreach($user->roles as $role)
                                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded">{{ $role->name }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b border-gray-300">
                        @can('edit users')
                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                        @endcan
                        @can('delete users')
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
