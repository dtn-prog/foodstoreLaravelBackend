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
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Status</th>
                    <th class="py-2 px-4 border-b border-gray-300 text-left">Bombs</th> <!-- New column -->
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
                        @if ($user->isBlacklisted())
                            <span class="text-red-500">Blacklisted</span>
                        @else
                            <span class="text-green-500">Active</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border-b border-gray-300">{{ $user->number_of_bombs }}</td> <!-- Display number of bombs -->
                    <td class="py-2 px-4 border-b border-gray-300">
                        @can('edit users')
                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                        @endcan
                        @can('delete users')
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirmDelete();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        @endcan
                        @can('blacklist users')
                            @if ($user->isBlacklisted())
                                <form action="{{ route('users.unblacklist', $user->id) }}" method="POST" class="inline" onsubmit="return confirmUnblacklist();">
                                    @csrf
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">Unblacklist</button>
                                </form>
                            @else
                                <form action="{{ route('users.blacklist', $user->id) }}" method="POST" class="inline" onsubmit="return confirmBlacklist();">
                                    @csrf
                                    <button type="submit" class="text-yellow-500 hover:text-yellow-700">Blacklist</button>
                                </form>
                            @endif
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this user?');
    }

    function confirmBlacklist() {
        return confirm('Are you sure you want to blacklist this user?');
    }

    function confirmUnblacklist() {
        return confirm('Are you sure you want to unblacklist this user?');
    }
</script>
@endsection
