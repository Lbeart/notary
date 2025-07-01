<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceType;
class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run(): void
{
    $services = [
        ['name' => 'Legalizim', 'description' => 'Dokumente të legalizuara nga noteri.'],
        ['name' => 'Përkthim', 'description' => 'Përkthime të certifikuara noteriale.'],
        ['name' => 'Noterizim', 'description' => 'Vërtetime noteriale të dokumenteve.'],
    ];

    foreach ($services as $service) {
        ServiceType::create($service);
    }
}
}
