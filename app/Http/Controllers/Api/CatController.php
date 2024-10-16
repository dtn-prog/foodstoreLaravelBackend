<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cat;
use Illuminate\Http\Request;

class CatController extends Controller
{
    public function index() {
        $cats = Cat::all();
        return response()->json($cats);
    }

    public function productsThroughCats() {
        $cats = Cat::with('products')->get();

        return response()->json($cats->map(function ($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'products' => $cat->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'desc' => $product->desc,
                        'image' => $product->image,
                    ];
                }),
            ];
        }));
    }
}
