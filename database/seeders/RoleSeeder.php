<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Create permissions
        $permissions = [
            // Product permissions
            'view products',
            'create products',
            'edit products',
            'delete products',

            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Order permissions
            'view orders',
            'create orders',
            'edit orders',
            'delete orders',
            'manage orders',

            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Report permissions
            'view reports',
            'generate reports',

            // Customer permissions
            'view own orders',
            'create own orders',
            'view own profile',
            'edit own profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign customer permissions to customer role
        $customerRole->givePermissionTo([
            'view own orders',
            'create own orders',
            'view own profile',
            'edit own profile',
        ]);
    }
}
