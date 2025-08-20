<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the cart.
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the total amount of the cart.
     */
    public function getTotal(string $currency = 'NGN'): float
    {
        return $this->items->sum(function ($item) use ($currency) {
            return $item->unit_price * $item->quantity;
        });
    }

    /**
     * Update the cart's total amount.
     */
    public function updateTotal(): void
    {
        $this->total = $this->getTotal();
        $this->save();
    }

    /**
     * Get the total number of items in the cart.
     */
    public function getItemCount(): int
    {
        return $this->items->sum('quantity');
    }
}
