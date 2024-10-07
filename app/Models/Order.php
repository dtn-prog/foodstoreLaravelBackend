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
        $this->belongsTo(User::class);
    }

    public function items() {
        $this->hasMany(Item::class);
    }

    use HasFactory;
}
