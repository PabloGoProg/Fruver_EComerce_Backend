<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::unguard();
        Product::create([
            'name' => 'Maracuyá',
            'description' => 'Description 1',
            'price' => 100,
            'category' => 1,
            'product_type' => 1,
            'quantity' => 10,
            'image' => 'https://via.placeholder.com/150',
        ]);
        Product::create([
            'name' => 'Naranja',
            'description' => 'Description 2',
            'price' => 200,
            'category' => 2,
            'product_type' => 2,
            'quantity' => 20,
            'image' => 'https://via.placeholder.com/150',
        ]);
        Product::create([
            'name' => 'Zanahoria',
            'description' => 'Description 3',
            'price' => 300,
            'category' => 3,
            'product_type' => 3,
            'quantity' => 30,
            'image' => 'https://via.placeholder.com/150',
        ]);
        Product::reguard();
    }
}
