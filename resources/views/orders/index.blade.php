@extends('layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Orders</h1>

    <!-- Search and Filter Form -->
    <form method="GET" class="mb-6">
        <input type="text" name="search" placeholder="Search by user or status" class="border p-2 rounded" />
        <select name="status" class="border p-2 rounded">
            <option value="">All Statuses</option>
            <option value="confirmed">Confirmed</option>
            <option value="shipped">Shipped</option>
            <option value="completed">Completed</option>
            <option value="bombed">Bombed</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Search</button>
    </form>

    @foreach($orders as $order)
    <div class="bg-white shadow-md rounded-lg p-4 mb-6">
        <h2 class="text-xl font-semibold">Order #{{ $order->id }}</h2>
        <h2 class="text-xl font-semibold">Order of user: {{ $order->user->name }}</h2>
        <p class="text-gray-600">Status: {{ ucfirst($order->status) }}</p>
        <p class="text-gray-600">Payment method: {{ $order->payment_method }}</p>
        <p class="text-gray-600">Address: {{ $order->address }}</p>
        <p class="text-gray-600">Duration: {{ $order->duration }}</p>
        <p class="text-gray-600">Lat: {{ $order->lat }}</p>
        <p class="text-gray-600">Long: {{ $order->long }}</p>

        <p class="text-gray-600">Total Price: ${{ number_format($order->total_price, 2) }}</p> <!-- Display total price -->

        <h3 class="text-lg font-medium mt-4">Items:</h3>
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Product</th>
                    <th class="border px-4 py-2">Image</th>
                    <th class="border px-4 py-2">Price</th>
                    <th class="border px-4 py-2">Quantity</th>
                    <th class="border px-4 py-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td class="border px-4 py-2">{{ $item->product->name }}</td>
                        <td class="border px-4 py-2">
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover">
                        </td>
                        <td class="border px-4 py-2">${{ number_format($item->product->price, 2) }}</td>
                        <td class="border px-4 py-2">{{ $item->quantity }}</td>
                        <td class="border px-4 py-2">${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Edit Status Button -->
        <form method="POST" action="{{ route('orders.update', $order->id) }}" class="mt-4">
            @csrf
            @method('PUT')
            <select name="status" class="border p-2 rounded">
                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="bombed" {{ $order->status == 'bombed' ? 'selected' : '' }}>Bombed</option>
            </select>
            <button type="submit" class="bg-green-500 text-white p-2 rounded">Update Status</button>
        </form>
    </div>
@endforeach
</div>
@endsection
