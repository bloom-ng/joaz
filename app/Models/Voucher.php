<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'type',
        'discount_type',
        'discount_value',
        'user_id',
        'status',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'discount_value' => 'double',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the voucher.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if voucher is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' &&
            ($this->expires_at === null || $this->expires_at->isFuture());
    }

    /**
     * Check if voucher is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }

    /**
     * Check if voucher is used.
     */
    public function isUsed(): bool
    {
        return $this->status === 'used';
    }

    /**
     * Calculate discount amount.
     */
    public function calculateDiscount(float $amount): float
    {
        if ($this->discount_type === 'percent') {
            return ($amount * $this->discount_value) / 100;
        }

        return min($this->discount_value, $amount);
    }
}
