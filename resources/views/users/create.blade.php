@extends('layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Create User</h1>

    @if ($errors->any())
        <div class="mb-4">
            <ul class="bg-red-200 border border-red-400 text-red-700 p-3 rounded">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}" onsubmit="return validatePasswordConfirmation()">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
            <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone:</label>
            <input type="tel" class="mt-1 block w-full border border-gray-300 rounded-md p-2" id="phone" name="phone" value="{{ old('phone') }}" required>
        </div>
        {{-- <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
            <select id="role" name="role" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div> --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
            <input type="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2" id="password" name="password" required>
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password:</label>
            <input type="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="w-full bg-green-500 text-white font-bold py-2 rounded hover:bg-green-600">Create User</button>
    </form>
</div>
@endsection

@section('js')
<script>
function validatePasswordConfirmation() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false;
    }
    return true;
}
</script>
@endsection
