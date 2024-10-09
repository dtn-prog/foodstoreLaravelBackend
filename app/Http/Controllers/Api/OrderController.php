<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Item;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function place(Request $request)
    {
        $fields = $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'address'=>'nullable',
            'duration'=>'nullable',
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $userId = auth('sanctum')->user()->id;

        $order = new Order([
            'user_id'=>$userId,
            'status'=>'confirmed',
            'address'=>$fields['address'],
            'lat'=>$fields['lat'],
            'long'=>$fields['long'],
            'duration'=>$fields['duration']
        ]);
        $order->save();

        $orderId = $order->id;

        foreach($fields['items'] as $item) {
            $orderItem = new Item([
                'product_id'=>$item['product_id'],
                'quantity'=>$item['quantity'],
                'order_id'=>$orderId,
            ]);
            $orderItem->save();
        }

        return response()->json(['totalPrice'=>$order->totalPrice()], $status=200);
    }
}
