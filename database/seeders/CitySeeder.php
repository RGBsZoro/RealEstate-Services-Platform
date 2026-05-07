<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name' => ['ar' => 'دمشق', 'en' => 'Damascus'],
                'latitude' => 33.5138, 'longitude' => 36.2765, 'radius' => 15
            ],
            [
                'name' => ['ar' => 'ريف دمشق', 'en' => 'Rif Dimashq'],
                'latitude' => 33.5100, 'longitude' => 36.3000, 'radius' => 40
            ],
            [
                'name' => ['ar' => 'حلب', 'en' => 'Aleppo'],
                'latitude' => 36.2021, 'longitude' => 37.1343, 'radius' => 25
            ],
            [
                'name' => ['ar' => 'حمص', 'en' => 'Homs'],
                'latitude' => 34.7324, 'longitude' => 36.7137, 'radius' => 20
            ],
            [
                'name' => ['ar' => 'حماة', 'en' => 'Hama'],
                'latitude' => 35.1318, 'longitude' => 36.7578, 'radius' => 15
            ],
            [
                'name' => ['ar' => 'اللاذقية', 'en' => 'Lattakia'],
                'latitude' => 35.5312, 'longitude' => 35.7908, 'radius' => 15
            ],
            [
                'name' => ['ar' => 'طرطوس', 'en' => 'Tartous'],
                'latitude' => 34.8890, 'longitude' => 35.8866, 'radius' => 12
            ],
            [
                'name' => ['ar' => 'إدلب', 'en' => 'Idlib'],
                'latitude' => 35.9306, 'longitude' => 36.6339, 'radius' => 15
            ],
            [
                'name' => ['ar' => 'دير الزور', 'en' => 'Deir ez-Zor'],
                'latitude' => 35.3359, 'longitude' => 40.1407, 'radius' => 20
            ],
            [
                'name' => ['ar' => 'الحسكة', 'en' => 'Al-Hasakah'],
                'latitude' => 36.5024, 'longitude' => 40.7477, 'radius' => 20
            ],
            [
                'name' => ['ar' => 'الرقة', 'en' => 'Raqa'],
                'latitude' => 35.9428, 'longitude' => 39.0079, 'radius' => 18
            ],
            [
                'name' => ['ar' => 'السويداء', 'en' => 'As-Suwayda'],
                'latitude' => 32.7083, 'longitude' => 36.5667, 'radius' => 15
            ],
            [
                'name' => ['ar' => 'درعا', 'en' => 'Daraa'],
                'latitude' => 32.6256, 'longitude' => 36.1053, 'radius' => 15
            ],
            [
                'name' => ['ar' => 'القنيطرة', 'en' => 'Quneitra'],
                'latitude' => 33.1258, 'longitude' => 35.8242, 'radius' => 10
            ],
        ];

        foreach ($cities as $cityData) {
            City::create($cityData);
        }
    }
}