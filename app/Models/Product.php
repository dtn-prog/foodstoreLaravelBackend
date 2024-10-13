<?php

namespace App\Models;

use App\Models\Cat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Cat::class, 'cat_id');
    }

    protected $guarded = [];
    use HasFactory;
}
