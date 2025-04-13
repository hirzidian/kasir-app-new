<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = 
    [
        'user_id',
        'customer_id',
        'total_price',
        'total_payment',
        'total_return',
        'point',
        'used_point'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customers::class,'customer_id');
    }

    public function transaction_details(){
        return $this->hasMany(TransactionDetail::class,'transaction_id');
    }
}
