<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customers extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'no_hp',
        'point',
    ];

    public function purchase() 
    {
        return $this->hasMany(Purchase::class);
    }
}
