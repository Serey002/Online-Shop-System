<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Electronics', 'slug' => 'electronics'],
            ['id' => 2, 'name' => 'Clothing', 'slug' => 'clothing'],
            ['id' => 3, 'name' => 'Shoes', 'slug' => 'shoes'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
