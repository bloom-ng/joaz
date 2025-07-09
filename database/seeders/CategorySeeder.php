<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create main categories
        $mainCategories = [
            'Hair Extensions',
            'Hair Care Products',
            'Styling Tools',
            'Accessories',
        ];

        foreach ($mainCategories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        // Create subcategories for Hair Extensions
        $hairExtensions = Category::where('name', 'Hair Extensions')->first();
        $extensionSubcategories = [
            'Synthetic Hair',
            'Human Hair',
            'Blonde Extensions',
            'Black Extensions',
            'Colored Extensions',
        ];

        foreach ($extensionSubcategories as $subcategory) {
            Category::create([
                'name' => $subcategory,
                'parent_category_id' => $hairExtensions->id,
            ]);
        }

        // Create subcategories for Hair Care Products
        $hairCare = Category::where('name', 'Hair Care Products')->first();
        $careSubcategories = [
            'Shampoo',
            'Conditioner',
            'Hair Oil',
            'Hair Mask',
            'Hair Growth Products',
        ];

        foreach ($careSubcategories as $subcategory) {
            Category::create([
                'name' => $subcategory,
                'parent_category_id' => $hairCare->id,
            ]);
        }

        // Create subcategories for Styling Tools
        $stylingTools = Category::where('name', 'Styling Tools')->first();
        $toolSubcategories = [
            'Hair Dryers',
            'Flat Irons',
            'Curling Irons',
            'Hair Brushes',
            'Combs',
        ];

        foreach ($toolSubcategories as $subcategory) {
            Category::create([
                'name' => $subcategory,
                'parent_category_id' => $stylingTools->id,
            ]);
        }

        // Create subcategories for Accessories
        $accessories = Category::where('name', 'Accessories')->first();
        $accessorySubcategories = [
            'Hair Clips',
            'Hair Bands',
            'Hair Pins',
            'Hair Ties',
            'Headbands',
        ];

        foreach ($accessorySubcategories as $subcategory) {
            Category::create([
                'name' => $subcategory,
                'parent_category_id' => $accessories->id,
            ]);
        }
    }
}
