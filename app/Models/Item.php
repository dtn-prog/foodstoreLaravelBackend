<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function price() {
        $productPrice = $this->product ? $this->product->price : 0;
        return $this->quantity * $productPrice;
    }

    protected $guarded = [];
    use HasFactory;
}
