@extends('layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-6">Welcome to Our Website</h1>

    @auth
    <h3>user: {{ auth()->user()->name }}</h3>
    <h3>role: {{ auth()->user()->role }}</h3>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="inline-block px-4 py-2 text-white bg-red-600 rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
         type="submit">Logout</button>
    </form>
    @endauth

    @guest
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="login_phone" class="block text-sm font-medium text-gray-700">Phone:</label>
                    <input type="tel" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    id="login_phone" name="phone" required pattern="\d{1,15}" title="Please enter a valid phone number (1-15 digits).">
                    @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="login_password" class="block text-sm font-medium text-gray-700">Password:</label>
                    <input type="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    id="login_password" name="password" required>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 rounded hover:bg-blue-600">Login</button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-4">Register</h2>
            <form method="POST" action="{{ route('register') }}" onsubmit="return validatePasswords()">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                    <input type="text" class="mt-1 block w-full border border-gray-300 rounded-md p-2" id="name" name="name" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="register_phone" class="block text-sm font-medium text-gray-700">Phone:</label>
                    <input type="tel" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    id="register_phone" name="phone" required pattern="\d{1,15}" title="Please enter a valid phone number (1-15 digits).">
                    @error('phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="register_password" class="block text-sm font-medium text-gray-700">Password:</label>
                    <input type="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    id="register_password" name="password" required>
                    @error('password')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password:</label>
                    <input type="password" class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                    id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-green-500 text-white font-bold py-2 rounded hover:bg-green-600">Register</button>
            </form>
        </div>
    </div>
    @endguest
</div>
@endsection

@section('js')
<script>
function validatePasswords() {
    const password = document.getElementById('register_password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;

    if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
</script>
@endsection
