<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-gray-800 text-white py-4">
        <h1 class="text-center text-2xl">Admin Dashboard</h1>
    </header>
    <nav class="bg-gray-800 text-white py-2">
        <div class="container mx-auto flex justify-center">
            <a href="{{ route('home') }}" class="mx-4 hover:underline">Home</a>
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('products.index') }}" class="mx-4 hover:underline">Products</a>
                <a href="{{ route('users.index') }}" class="mx-4 hover:underline">Users</a>
                <a href="{{ route('orders.index') }}" class="mx-4 hover:underline">Orders</a>
                <a href="{{ route('cats.index') }}" class="mx-4 hover:underline">Cats</a>
            @endif
        </div>
    </nav>
    <div class="container mx-auto mt-6 p-4 bg-white rounded-lg shadow">
        @if(session('success'))
            <div id="flash-message" class="bg-green-500 text-white p-4 rounded mb-4 transition-opacity duration-500">
                {{ session('success') }}
            </div>
        @endif
        @yield('content')
    </div>
    <footer class="bg-gray-800 text-white text-center py-4 mt-6">
        <p>&copy; nhóm 10 L01</p>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.classList.add('opacity-0');
                    setTimeout(() => {
                        flashMessage.remove();
                    }, 500);
                }, 3000);
            }
        });
    </script>
    @yield('js')
</body>
</html>
