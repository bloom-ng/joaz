<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = \App\Models\Product::all();
        $users = \App\Models\User::all();

        if ($products->isEmpty() || $users->isEmpty()) {
            $this->command->info('No products or users found, skipping review seeding.');
            return;
        }

        foreach ($products as $product) {
            // Create 1 to 5 reviews for each product
            $numberOfReviews = rand(1, 5);

            for ($i = 0; $i < $numberOfReviews; $i++) {
                \App\Models\Review::create([
                    'product_id' => $product->id,
                    'user_id' => $users->random()->id,
                    'rating' => rand(3, 5),
                    'review' => fake()->paragraph,
                ]);
            }
        }
    }
}
