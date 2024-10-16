<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function place(Request $request)
    {
        $fields = $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'address'=>'nullable',
            'duration'=>'nullable',
            'payment_method'=>'required|in:cod,cc',
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

    public function history(Request $request) {
        // DB::enableQueryLog();
        $userId = auth('sanctum')->user()->id;

        $orders = Order::with('items.product')->where('user_id', $userId)->get();

        $ordersAndItems = $orders->map(function($order) {
            return [
                "status"=> $order->status,
                "address"=> $order->address,
                "duration"=> $order->duration,
                "total_price"=> $order->totalPrice(),
                "payment_method"=> $order->payment_method,
                "created_at"=> $order->created_at,
                "lat"=> $order->lat,
                "long"=> $order->long,
                "items"=>$order->items->map(function($item) {
                    return [
                        "product_name"=>$item->product->name,
                        "product_image"=>$item->product->image,
                        "quantity"=>$item->quantity,
                    ];
                }),

            ];
        });

        // $queries = DB::getQueryLog();
        return response()->json($ordersAndItems);
    }
}
