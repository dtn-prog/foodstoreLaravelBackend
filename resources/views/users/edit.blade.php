@extends('layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Edit User</h1>
    <form method="POST" action="{{ route('users.update', $user->id) }}" onsubmit="return validatePasswordConfirmation()">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2" id="name" name="name" value="{{ $user->name }}" required>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone:</label>
            <input type="tel" class="mt-1 block w-full border border-gray-300 rounded-md p-2" id="phone" name="phone" value="{{ $user->phone }}" required>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password (leave blank to keep current):</label>
            <input type="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2" id="password" name="password">
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password:</label>
            <input type="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Roles:</label>
            @foreach ($roles as $role)
                <div class="flex items-center mt-2">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                        {{ $userRoles->contains($role->name) ? 'checked' : '' }} class="mr-2">
                    <label class="text-gray-700">{{ $role->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="w-full bg-green-500 text-white font-bold py-2 rounded hover:bg-green-600">Update User</button>
    </form>
</div>
@endsection
