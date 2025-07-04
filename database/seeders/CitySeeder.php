<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   

public function run(): void
{
    $cities = ['Prishtinë', 'Gjakovë', 'Ferizaj', 'Pejë', 'Mitrovicë'];
    foreach ($cities as $city) {
        City::create(['name' => $city]);
    }
}
}
