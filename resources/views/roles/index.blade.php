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
                    <a href="{{ route('roles.edit', $role) }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Edit</a>
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event);">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-4">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<script>
    function confirmDelete(event) {
        const confirmed = confirm("Are you sure you want to delete this role?");
        if (!confirmed) {
            event.preventDefault(); // Prevent the form from submitting
        }
        return confirmed; // Return true to allow form submission
    }
</script>
@endsection
