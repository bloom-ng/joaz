<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'status',
        'courier_name',
        'tracking_url',
        'delivered_at',
        'estimated_delivery',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'delivered_at' => 'datetime',
        'estimated_delivery' => 'datetime',
    ];

    /**
     * Get the order that owns the delivery.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if delivery is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if delivery is in transit.
     */
    public function isInTransit(): bool
    {
        return $this->status === 'in_transit';
    }

    /**
     * Check if delivery is delivered.
     */
    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }
}
