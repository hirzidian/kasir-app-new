<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['user_id', 'total', 'member', 'no_hp', 'total_pay', 'kembalian'];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
    
    // app/Models/Purchase.php
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}

