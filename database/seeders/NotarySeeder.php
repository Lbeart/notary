<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $city = \App\Models\City::firstOrCreate(['name' => 'Prishtina']);

    for ($i = 1; $i <= 5; $i++) {
        $user = \App\Models\User::create([
            'name' => "Noteri $i",
            'email' => "noteri$i@example.com",
            'password' => bcrypt('password'),
            'role' => 'notary',
        ]);

        \App\Models\Notary::create([
            'user_id' => $user->id,
            'city_id' => $city->id,
            'phone' => "04412345$i",
            'address' => "Adresa $i, Prishtinë",
        ]);
    }
}
}
