<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::unguard();
        Supplier::create([
            'RUT' => '12345678-9',
            'user_id' => 4
        ]);
        Supplier::reguard();
    }
}
