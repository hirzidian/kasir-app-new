<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class detail_purchase extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'sale_id',
        'product_id',
        'amount',
        'subtotal'
    ];
    public function Purchase() 
    {
        return $this->belongsTo(Purchase::class);
    }
    public function Product() 
    {
        return $this->belongsTo(Product::class);
    }
}
