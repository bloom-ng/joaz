<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsletterSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 25 active subscribers
        NewsletterSubscription::factory()
            ->count(25)
            ->create([
                'is_subscribed' => true,
                'email_verified_at' => now(),
            ]);

        // Create 5 unsubscribed users
        NewsletterSubscription::factory()
            ->count(5)
            ->unsubscribed()
            ->create([
                'email_verified_at' => now(),
                'unsubscribed_at' => now()->subDays(rand(1, 30)),
            ]);

        $this->command->info('Successfully seeded newsletter subscribers!');
    }
}
