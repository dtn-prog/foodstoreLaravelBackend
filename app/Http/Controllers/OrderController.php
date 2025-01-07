<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request) {
        $query = Order::with('items.product')->latest();

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhere('status', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get()->map(function ($order) {
            $order->total_price = $order->totalPrice();
            return $order;
        });

        return view('orders.index', compact('orders'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:confirmed,shipped,completed,bombed',
        ]);

        $order = Order::findOrFail($id);

        if ($order->status == 'confirmed' && $request->status != 'confirmed') {
            foreach ($order->items as $item) {
                $product = $item->product;

                if ($product->quantity >= $item->quantity) {
                    $product->quantity -= $item->quantity;
                    $product->save();
                } else {
                    return redirect()->back()->with('error', 'Not enough product quantity available.')->withInput();
                }
            }
        }

        // Increase the number_of_bombs if the status is set to 'bombed'
        if ($request->status == 'bombed') {
            $user = $order->user;
            $user->increment('number_of_bombs');
        }

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function destroy($id) {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully!');
    }
}
