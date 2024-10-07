<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public function order() {
        $this->belongsTo(Order::class);
    }

    protected $guarded = [];
    use HasFactory;
}
