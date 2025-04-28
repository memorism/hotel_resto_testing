<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resto;

class RestoSeeder extends Seeder
{
    public function run(): void
    {
        Resto::create([
            'name' => 'Resto Ayam Bakar',
            'address' => 'Jl. Merdeka No.10',
            'phone' => '08123456789',
        ]);

        Resto::create([
            'name' => 'Resto Seafood Maknyus',
            'address' => 'Jl. Laut Selatan No.7',
            'phone' => '08211234567',
        ]);
    }
}

