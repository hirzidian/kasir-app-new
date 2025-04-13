<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_details';
    protected $fillable = 
    [
        'transaction_id',
        'product_id',
        'quantity',
        'sub_total'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function transaction(){
        return $this->belongsTo(transaction::class,'');
    }
}
