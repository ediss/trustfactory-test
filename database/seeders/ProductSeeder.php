<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate products using Factory
        Product::factory(30)->create(); // 30 random products with normal stock
        Product::factory(5)->lowStock()->create(); // 5 products with low stock
        Product::factory(3)->outOfStock()->create(); // 3 out of stock products
    }
}
