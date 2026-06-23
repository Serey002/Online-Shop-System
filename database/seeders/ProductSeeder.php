<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Electronics (category_id: 1)
            [
                'category_id' => 1,
                'name' => 'Smartphone Pro',
                'description' => 'A high-end smartphone with an incredible display.',
                'price' => 799.99,
                'image' => 'products/smartphone.jpg',
                'stock' => 50,
            ],
            [
                'category_id' => 1,
                'name' => 'Wireless Headphones',
                'description' => 'Noise-canceling over-ear wireless headphones.',
                'price' => 149.99,
                'image' => 'products/headphones.jpg',
                'stock' => 120,
            ],
            // Clothing (category_id: 2)
            [
                'category_id' => 2,
                'name' => 'Classic Denim Jacket',
                'description' => 'Timeless denim jacket with a relaxed fit.',
                'price' => 59.99,
                'image' => 'products/jacket.jpg',
                'stock' => 45,
            ],
            // Shoes (category_id: 3)
            [
                'category_id' => 3,
                'name' => 'Sport Running Shoes',
                'description' => 'Lightweight and breathable shoes engineered for running.',
                'price' => 89.99,
                'image' => 'products/shoes.jpg',
                'stock' => 30,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
