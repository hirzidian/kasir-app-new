<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customers extends Model
{
    protected $table = 'customers';
    protected $fillable = 
    [
        'name',
        'no_hp',
        'total_point'
    ];

    public function transactions (){
        return $this->hasMany(Transaction::class,'customer_id');
    }
}
