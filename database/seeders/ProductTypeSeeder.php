<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductType;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductType::unguard();
        ProductType::create([
            'name' => 'tipo 1'
        ]);
        ProductType::create([
            'name' => 'tipo 2'
        ]);
        ProductType::create([
            'name' => 'tipo 3'
        ]);
        ProductType::reguard();
    }
}
