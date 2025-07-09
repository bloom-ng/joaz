<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'label',
        'address',
        'country',
        'state',
        'city',
        'postal_code',
        'is_default',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the address.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the orders for this address.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the full address as a string.
     */
    public function getFullAddress(): string
    {
        $parts = [
            $this->address,
            $this->city,
            $this->state,
            $this->country,
        ];

        if ($this->postal_code) {
            $parts[] = $this->postal_code;
        }

        return implode(', ', array_filter($parts));
    }
}
