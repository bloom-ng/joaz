<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = User::role('customer')->get();
        $products = Product::all();
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $currencies = ['USD', 'NGN'];

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No customers or products found. Skipping order seeding.');
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            $customer = $customers->random();
            $currency = $currencies[array_rand($currencies)];
            $orderStatus = $statuses[array_rand($statuses)];

            $order = Order::create([
                'user_id' => $customer->id,
                'payment_currency' => $currency,
                'total_amount' => 0, // will update after items
                'payment_status' => $orderStatus === 'cancelled' ? 'pending' : 'paid',
                'delivery_method' => rand(0, 1) ? 'delivery' : 'pickup',
                'order_status' => $orderStatus,
                'tracking_number' => 'TRK' . rand(100000, 999999),
            ]);

            $itemCount = rand(1, 3);
            $orderTotal = 0;
            $usedProductIds = [];
            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->whereNotIn('id', $usedProductIds)->random();
                $usedProductIds[] = $product->id;
                $quantity = rand(1, 5);
                $unitPrice = $currency === 'USD' ? $product->price_usd : $product->price_ngn;
                $orderTotal += $unitPrice * $quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                ]);
            }
            $order->update(['total_amount' => $orderTotal]);
        }
    }
}
