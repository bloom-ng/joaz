<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class PickupAddress extends Model
{
   
    protected $fillable = [
        'country',
        'state',
        'address'
    ];
}
