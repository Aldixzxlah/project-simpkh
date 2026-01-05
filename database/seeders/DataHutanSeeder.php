<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DataHutanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $datasets = [
            ['Karimunjawa National Park', -6.8489125, 110.439609375, 1116, 'Jawa Tengah', 'Jawa'],
            ['Bromo Tengger Semeru National Park', -7.0218625, 109.952453125, 503, 'Jawa Timur', 'Jawa'],
            ['Betung Kerihun National Park', 0.2015125, 114.188578125, 8000, 'Kalimantan Barat', 'Kalimantan'],
            ['Kayan Mentarang National Park', -0.1281875, 114.378578125, 13605, 'Kalimantan Utara', 'Kalimantan'],
            ['Gunung Leuser National Park', -0.4807125, 101.463421875, 7927, 'Aceh', 'Sumatera'],
            ['Bukit Barisan Selatan National Park', -0.4484625, 101.351578125, 3650, 'Lampung', 'Sumatera'],
            ['Kerinci Seblat National Park', 0.1428375, 100.508046875, 13750, 'Sumatera Barat', 'Sumatera'],
            ['Bukit Tigapuluh National Park', 0.0774125, 101.468453125, 1277, 'Riau', 'Sumatera'],
            ['Bantimurung-Bulusaraung National Park', -1.8011875, 120.823484375, 480, 'Sulawesi Selatan', 'Sulawesi'],
            ['Bogani Nani Wartabone National Park', -2.4406375, 121.163421875, 2871, 'Sulawesi Utara', 'Sulawesi'],
            ['Lore Lindu National Park', -2.4749625, 121.188953125, 2290, 'Sulawesi Tengah', 'Sulawesi'],
            ['Wakatobi National Park', -1.5634625, 120.930421875, 13900, 'Sulawesi Tenggara', 'Sulawesi'],
            ['Lorentz National Park', -4.6297625, 140.972671875, 25050, 'Papua', 'Papua'],
            ['Teluk Cenderawasih National Park', -4.5482375, 141.478390625, 14535, 'Papua Barat', 'Papua'],
            ['Wasur National Park', -4.6006375, 140.833671875, 4138, 'Papua Selatan', 'Papua'],
            ['Mamberamo Foja National Park', -4.7674375, 140.8391875, 0, 'Papua', 'Papua'], // Area N/A in prompt
            ['Hutan warioaro Watiaro', -4.5446875, 140.7693125, 0, 'Papua', 'Papua'], // Area N/A
            ['Hutan Pasir Putih', -4.8714375, 141.0868125, 0, 'Papua Barat', 'Papua'], // Area N/A
            ['Kelimutu National Park', -7.7415375, 119.793609375, 50, 'Nusa Tenggara Timur', 'Bali & Nusa Tenggara'],
            ['Ujung Kulon National Park', -6.7846875, 110.375109375, 1206, 'Banten', 'Jawa'],
            ['Bali Barat National Park', -8.1276125, 120.475328125, 190, 'Bali', 'Bali & Nusa Tenggara'],
            ['Aketajawe-Lolobata National Park', -2.5070875, 127.745390625, 1673, 'Maluku Utara', 'Maluku'],
            ['Manusela National Park', -3.0050625, 128.182734375, 1890, 'Maluku', 'Maluku'],
        ];

        $data = [];

        foreach ($datasets as $item) {
            $name = $item[0];
            $lat = $item[1];
            $lng = $item[2];
            $areaKm2 = $item[3];
            $province = $item[4];
            $island = $item[5];

            // Convert Area: km2 to Ha (1 km2 = 100 Ha)
            // If area is 0 (N/A), generate random
            $luasHektar = ($areaKm2 > 0) ? $areaKm2 * 100 : $faker->numberBetween(1000, 50000);

            // Clean Island name for Bali & Nusa Tenggara to just match typical filtering if needed
            if ($island == 'Bali & Nusa Tenggara') {
                $island = 'Nusa Tenggara'; // Simplify or keep as is depending on usages
            }

            $data[] = [
                'provinsi' => $province,
                'pulau' => $island,
                'luas_hektar' => $luasHektar,
                'jenis_vegetasi' => json_encode($faker->randomElements(['Mangrove', 'Gambut', 'Hujan Tropis', 'Sabana', 'Pinus', 'Jati'], $faker->numberBetween(1, 3))),
                // Randomize status but bias towards 'konservasi' for National Parks
                'status_konservasi' => (str_contains($name, 'National Park')) ? $faker->randomElement(['konservasi', 'lindung', 'produksi']) : 'produksi',
                'geojson' => json_encode([
                    "type" => "FeatureCollection",
                    "features" => [
                        [
                            "type" => "Feature",
                            "properties" => ["name" => $name],
                            "geometry" => [
                                "type" => "Point",
                                "coordinates" => [$lng, $lat]
                            ]
                        ]
                    ]
                ]),
                'latitude' => $lat,
                'longitude' => $lng,
                'tahun_data' => 2025,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('data_hutans')->insert($data);
    }
}
