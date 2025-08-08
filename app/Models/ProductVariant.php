<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'color',
        'length_in_inches',
        'price_usd_modifier',
        'price_ngn_modifier',
        'stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
