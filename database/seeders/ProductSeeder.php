<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Fresh Mangoes',
                'description' => 'Sweet and juicy mangoes from Zambales.',
                'price' => 120.00,
                'stock' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Organic Eggs',
                'description' => 'Farm-raised brown eggs, 1 dozen.',
                'price' => 85.00,
                'stock' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tilapia',
                'description' => 'Fresh tilapia, 1kg.',
                'price' => 150.00,
                'stock' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
