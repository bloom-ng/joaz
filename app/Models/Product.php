<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sku',
        'description',
        'price_usd',
        'price_ngn',
        'sale_price',
        'quantity',
        'category_id',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_usd' => 'double',
        'price_ngn' => 'double',
        'sale_price' => 'double',
        'quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model and add event listeners.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->sku)) {
                $product->sku = $product->generateSku();
            }
        });

        static::updating(function ($product) {
            if (empty($product->sku)) {
                $product->sku = $product->generateSku();
            }
        });
    }

    /**
     * Generate a unique SKU from the product name.
     */
    public function generateSku(): string
    {
        $baseSku = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $this->name));
        $baseSku = substr($baseSku, 0, 8); // Limit to 8 characters

        $sku = $baseSku;
        $counter = 1;

        // Check if SKU already exists and append number if needed
        while (static::where('sku', $sku)->where('id', '!=', $this->id ?? 0)->exists()) {
            $sku = $baseSku . $counter;
            $counter++;
        }

        return $sku;
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the images for the product.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock(): bool
    {
        return $this->quantity > 0;
    }

    /**
     * Get the price based on currency.
     */
    public function getPrice(string $currency = 'NGN'): float
    {
        return $currency === 'USD' ? $this->price_usd : $this->price_ngn;
    }
}
