<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foodCategories = [
            'Bakery',
            'Burger',
            'Beverage',
            'Chicken',
            'Pizza',
            'Seafood'
        ];

        foreach ($foodCategories as $name) {
            Category::updateOrCreate(
                ['slug' => Str::slug($name)], // Keeps it clean if run multiple times
                ['name' => $name]
            );
        }
    }
}
