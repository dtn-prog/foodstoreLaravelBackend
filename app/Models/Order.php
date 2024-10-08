<?php

namespace App\Models;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(Item::class);
    }

    public function totalPrice():int {
        $items = $this->items;
        $price = $items->sum(function ($item) {
            return $item->price();
        });

        return $price;
    }

    use HasFactory;
}
