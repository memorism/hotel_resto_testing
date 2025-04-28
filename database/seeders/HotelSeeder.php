<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        Hotel::create([
            'name'        => 'Hotel Melati A',
            'street'      => 'Jl. Sudirman No. 10',
            'village'     => 'Cihapit',
            'district'    => 'Bandung Wetan',
            'city'        => 'Bandung',
            'province'    => 'Jawa Barat',
            'postal_code' => '40114',
            'phone'       => '022-1234567',
            'email'       => 'melatia@example.com'
        ]);

        Hotel::create([
            'name'        => 'Hotel Mawar B',
            'street'      => 'Jl. Diponegoro No. 5',
            'village'     => 'Menteng',
            'district'    => 'Menteng',
            'city'        => 'Jakarta Pusat',
            'province'    => 'DKI Jakarta',
            'postal_code' => '10310',
            'phone'       => '021-7654321',
            'email'       => 'mawarb@example.com'
        ]);
    }
}

