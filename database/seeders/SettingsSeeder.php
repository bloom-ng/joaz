<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'name'       => 'Value Added Tax',
            'key'        => 'vat',
            'value'      => '7.5', 
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
