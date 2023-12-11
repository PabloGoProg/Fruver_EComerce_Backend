<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserType::create([
            'name' => 'Administrador',
        ]);
        UserType::create([
            'name' => 'Cliente',
        ]);
        UserType::create([
            'name' => 'Proveedor',
        ]);
    }
}
