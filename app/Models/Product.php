<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'detail',
        'price',
        'stock',
        'discount'
    ];

    public function reviews(){

        return $this->hasMany(Review::class);
    }
}
