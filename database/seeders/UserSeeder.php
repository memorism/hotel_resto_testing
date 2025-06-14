<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin PHRI
        User::create([
            'name' => 'Admin PHRI',
            'email' => 'admin@phri.com',
            'password' => Hash::make('password'),
            'usertype' => 'admin_phri',
            'hotel_id' => null, // Admin PHRI tidak punya hotel
        ]);

        // Manager Hotel A
        User::create([
            'name' => 'Manager Hotel A',
            'email' => 'manager@a.com',
            'password' => Hash::make('password'),
            'usertype' => 'manager_hotel',
            'hotel_id' => 1, // Sesuai Hotel Melati A
        ]);

        // Front Office Hotel A
        User::create([
            'name' => 'Front Office Hotel A',
            'email' => 'front@a.com',
            'password' => Hash::make('password'),
            'usertype' => 'front_office',
            'hotel_id' => 1,
        ]);

        // Finance Hotel A
        User::create([
            'name' => 'Finance Hotel A',
            'email' => 'finance@a.com',
            'password' => Hash::make('password'),
            'usertype' => 'finance',
            'hotel_id' => 1,
        ]);

        // Manager Hotel B
        User::create([
            'name' => 'Manager Hotel B',
            'email' => 'manager@b.com',
            'password' => Hash::make('password'),
            'usertype' => 'manager_hotel',
            'hotel_id' => 2, // Sesuai Hotel Mawar B
        ]);
    }
}
