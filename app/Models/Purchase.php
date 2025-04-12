<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Purchase extends Model
{
    use HasFactory, Notifiable;
    
    protected $table = 'purchases';
    protected $fillable = [
        'sale_date',
        'total_price',
        'total_pay',
        'total_return',
        'customer_id',
        'user_id',
        'point',
        'total_point',
    ];
    

    //Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);   
    }
    //Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function detail_purchase() 
    {
        return $this->hasMany(detail_purchase::class, 'sale_id', 'id');
    }

    public function customer(){
        return $this->belongsTo(Customers::class,'customer_id');
    }
}
