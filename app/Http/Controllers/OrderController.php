<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::all();

        dd($orders[0]);

        return view('orders.index', compact('orders'));
    }
}
