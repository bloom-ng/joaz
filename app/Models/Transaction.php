<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'gateway',
        'transaction_reference',
        'amount',
        'currency',
        'status',
        'paid_at',
        'response_payload',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'double',
        'paid_at' => 'datetime',
        'response_payload' => 'array',
    ];

    /**
     * Get the order that owns the transaction.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if transaction is successful.
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'successful';
    }

    /**
     * Check if transaction is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if transaction is failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
