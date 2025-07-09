<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $humanHair = Category::where('name', 'Human Hair')->first();
        $syntheticHair = Category::where('name', 'Synthetic Hair')->first();
        $shampoo = Category::where('name', 'Shampoo')->first();
        $conditioner = Category::where('name', 'Conditioner')->first();
        $hairOil = Category::where('name', 'Hair Oil')->first();
        $flatIrons = Category::where('name', 'Flat Irons')->first();
        $hairBrushes = Category::where('name', 'Hair Brushes')->first();

        // Create products
        $products = [
            [
                'name' => 'Premium Brazilian Human Hair Weave',
                'description' => 'High-quality 100% Brazilian human hair weave. Soft, silky, and tangle-free. Perfect for natural-looking extensions.',
                'price_usd' => 89.99,
                'price_ngn' => 45000,
                'quantity' => 50,
                'category_id' => $humanHair->id,
            ],
            [
                'name' => 'Synthetic Hair Extensions Bundle',
                'description' => 'Affordable synthetic hair extensions in various colors. Great for temporary styling and costume use.',
                'price_usd' => 24.99,
                'price_ngn' => 12500,
                'quantity' => 100,
                'category_id' => $syntheticHair->id,
            ],
            [
                'name' => 'Moisturizing Hair Shampoo',
                'description' => 'Gentle moisturizing shampoo for all hair types. Contains natural ingredients to nourish and strengthen hair.',
                'price_usd' => 12.99,
                'price_ngn' => 6500,
                'quantity' => 75,
                'category_id' => $shampoo->id,
            ],
            [
                'name' => 'Deep Conditioning Treatment',
                'description' => 'Intensive deep conditioning treatment for damaged and dry hair. Restores moisture and improves hair texture.',
                'price_usd' => 15.99,
                'price_ngn' => 8000,
                'quantity' => 60,
                'category_id' => $conditioner->id,
            ],
            [
                'name' => 'Argan Hair Oil',
                'description' => 'Pure argan oil for hair care. Reduces frizz, adds shine, and promotes healthy hair growth.',
                'price_usd' => 18.99,
                'price_ngn' => 9500,
                'quantity' => 80,
                'category_id' => $hairOil->id,
            ],
            [
                'name' => 'Professional Flat Iron',
                'description' => 'Professional-grade flat iron with ceramic plates. Adjustable temperature settings for all hair types.',
                'price_usd' => 45.99,
                'price_ngn' => 23000,
                'quantity' => 30,
                'category_id' => $flatIrons->id,
            ],
            [
                'name' => 'Boar Bristle Hair Brush',
                'description' => 'Natural boar bristle hair brush for smooth, shiny hair. Distributes natural oils and reduces breakage.',
                'price_usd' => 22.99,
                'price_ngn' => 11500,
                'quantity' => 45,
                'category_id' => $hairBrushes->id,
            ],
            [
                'name' => 'Curly Human Hair Extensions',
                'description' => 'Natural curly human hair extensions. Perfect for adding volume and texture to natural hair.',
                'price_usd' => 75.99,
                'price_ngn' => 38000,
                'quantity' => 25,
                'category_id' => $humanHair->id,
            ],
            [
                'name' => 'Anti-Dandruff Shampoo',
                'description' => 'Effective anti-dandruff shampoo with tea tree oil. Soothes scalp and eliminates dandruff.',
                'price_usd' => 14.99,
                'price_ngn' => 7500,
                'quantity' => 65,
                'category_id' => $shampoo->id,
            ],
            [
                'name' => 'Heat Protectant Spray',
                'description' => 'Advanced heat protectant spray for styling tools. Protects hair from heat damage up to 450°F.',
                'price_usd' => 16.99,
                'price_ngn' => 8500,
                'quantity' => 70,
                'category_id' => $conditioner->id,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
