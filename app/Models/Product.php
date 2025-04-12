<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
            'name',
            'price',
            'stock',
            'image',
    ];

    //Relasi : Satu Product bisa muncul di banyak Purchase
    public function purchase()
    {
        return $this->hasMany(Purchase::class);
    }
}
