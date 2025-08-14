<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class NewsletterSubscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'token',
        'is_subscribed',
        'subscribed_at',
        'unsubscribed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_subscribed' => 'boolean',
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($subscription) {
            $subscription->token = $subscription->token ?? Str::random(32);
            $subscription->is_subscribed = true;
            $subscription->subscribed_at = now();
        });
    }

    /**
     * Get the unsubscribe URL.
     */
    public function getUnsubscribeUrlAttribute(): string
    {
        return route('newsletter.unsubscribe', $this->token);
    }

    /**
     * Scope a query to only include active subscribers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_subscribed', true);
    }
}
