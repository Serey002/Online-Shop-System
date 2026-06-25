<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // 1. Fetch categories from the database to ensure proper relational foreign keys
        $bakery = Category::where('slug', 'bakery')->first();
        $burger = Category::where('slug', 'burger')->first();
        $beverage = Category::where('slug', 'beverage')->first();
        $chicken = Category::where('slug', 'chicken')->first();
        $pizza = Category::where('slug', 'pizza')->first();
        $seafood = Category::where('slug', 'seafood')->first();

        // 2. Define menu products linked directly to their respective food categories
        $products = [
            // --- Bakery Category ---
            [
                'category_id' => $bakery?->id,
                'name' => 'Chocolate Fudge Brownie',
                'description' => 'Rich, gooey chocolate brownie topped with chocolate chunks and served warm.',
                'price' => 3.50,
                'stock' => 25,
                'image' => null,
            ],
            [
                'category_id' => $bakery?->id,
                'name' => 'Glazed Cinnamon Roll',
                'description' => 'Freshly baked pastry roll with sweet cinnamon swirl and rich cream cheese icing.',
                'price' => 2.99,
                'stock' => 15,
                'image' => null,
            ],

            // --- Burger Category ---
            [
                'category_id' => $burger?->id,
                'name' => 'Classic Double Cheeseburger',
                'description' => 'Two flame-grilled beef patties, cheddar cheese, lettuce, tomato, onions, and house sauce on a brioche bun.',
                'price' => 8.99,
                'stock' => 50,
                'image' => null,
            ],
            [
                'category_id' => $burger?->id,
                'name' => 'Spicy BBQ Bacon Burger',
                'description' => 'Crispy bacon, onion rings, jalapeños, cheddar cheese, and smoky BBQ sauce.',
                'price' => 9.50,
                'stock' => 30,
                'image' => null,
            ],

            // --- Beverage Category ---
            [
                'category_id' => $beverage?->id,
                'name' => 'Iced Caramel Macchiato',
                'description' => 'Chilled espresso combined with whole milk, vanilla syrup, and a rich caramel drizzle.',
                'price' => 4.25,
                'stock' => 100,
                'image' => null,
            ],
            [
                'category_id' => $beverage?->id,
                'name' => 'Fresh Mint Lemonade',
                'description' => 'Squeezed lemons blended with ice, sugar, and fresh crushed mint leaves.',
                'price' => 3.00,
                'stock' => 80,
                'image' => null,
            ],

            // --- Chicken Category ---
            [
                'category_id' => $chicken?->id,
                'name' => 'Crispy Chicken Tenders (5 Pcs)',
                'description' => 'Golden brown, hand-breaded chicken breast strips served with honey mustard dipping sauce.',
                'price' => 7.99,
                'stock' => 45,
                'image' => null,
            ],
            [
                'category_id' => $chicken?->id,
                'name' => 'Buffalo Chicken Wings',
                'description' => 'Tossed in signature spicy buffalo sauce and served with celery sticks and blue cheese.',
                'price' => 8.50,
                'stock' => 40,
                'image' => null,
            ],

            // --- Pizza Category ---
            [
                'category_id' => $pizza?->id,
                'name' => 'Ultimate Pepperoni Pizza',
                'description' => 'Mozzarella cheese and an abundance of spicy pepperoni slices over robust tomato sauce.',
                'price' => 12.99,
                'stock' => 20,
                'image' => null,
            ],
            [
                'category_id' => $pizza?->id,
                'name' => 'BBQ Chicken & Mushroom Pizza',
                'description' => 'Grilled chicken, fresh mushrooms, red onions, cilantro, and sweet BBQ sauce base.',
                'price' => 14.25,
                'stock' => 15,
                'image' => null,
            ],

            // --- Seafood Category ---
            [
                'category_id' => $seafood?->id,
                'name' => 'Golden Fish and Chips',
                'description' => 'Crispy beer-battered cod fillets served with sea salt french fries and tartar sauce.',
                'price' => 11.50,
                'stock' => 25,
                'image' => null,
            ],
            [
                'category_id' => $seafood?->id,
                'name' => 'Garlic Butter Grilled Shrimp',
                'description' => 'Plump shrimp skewers basted with dynamic garlic herb butter sauce, served over white rice.',
                'price' => 13.99,
                'stock' => 18,
                'image' => null,
            ],
        ];

        // 3. Insert into database
        foreach ($products as $item) {
            // Only seed if the target category exists in the system
            if ($item['category_id'] !== null) {
                Product::create($item);
            }
        }
    }
}
