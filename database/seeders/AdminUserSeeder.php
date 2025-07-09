<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'phone' => '+2348012345678',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Assign admin role using Spatie
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create a sample customer user
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'John Doe',
                'phone' => '+2348098765432',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // Assign customer role
        if (!$customer->hasRole('customer')) {
            $customer->assignRole('customer');
        }

        // Create profile for admin
        $admin->profile()->firstOrCreate([], [
            'gender' => 'other',
            'bio' => 'System Administrator',
        ]);

        // Create profile for customer
        $customer->profile()->firstOrCreate([], [
            'gender' => 'female',
            'bio' => 'Regular customer',
        ]);

        // Create default address for customer
        $customer->addresses()->firstOrCreate(
            ['label' => 'Home'],
            [
                'address' => '123 Main Street',
                'country' => 'Nigeria',
                'state' => 'Lagos',
                'city' => 'Lagos',
                'postal_code' => '100001',
                'is_default' => true,
            ]
        );

        // Create cart for customer
        $customer->cart()->firstOrCreate([]);
    }
}
