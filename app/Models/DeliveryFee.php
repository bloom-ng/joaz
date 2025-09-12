<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryFee extends Model
{
    protected $fillable = [
        'country',
        'amount'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];
}
