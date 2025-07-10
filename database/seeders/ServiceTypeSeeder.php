<?php

namespace Database\Seeders;

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
        'Legalizim',
         'Perkthim',
          'Noterizim',
    'Përpilimi i testamentit',
    'Proces-verbali i hapjes së testamentit',
    'Vërtetimi se personi është gjallë',
    'Kontrata për transferimin e paluajtshmërisë',
    'Kontrata për hipotekën e pasurisë së paluajtshme',
    'Kontrata për këmbimin e pasurisë së paluajtshme',
    'Kontrata për qiraje',
    'Heqje dorë nga bashkëpronësia',
    'Kontrata për pengun e pasurisë së luajtshme',
    'Kontrata mbi të drejtat pronësore (uzufrukt, servitut)',
    'Përpilimi i akteve të shoqërive tregtare',
    'Pjesëmarrje në mbledhje të ortakëve',
    'Vërtetimi i nënshkrimeve në aktet e shoqërive tregtare',
    'Vërtetimi i kontratave të punës',
    'Autorizimi për tërheqje pensioni',
    'Verifikimi i nënshkrimeve',
    'Verifikimi i kontratave',
    'Autorizimi i përgjithshëm',
    'Autorizimi i posaçëm',
    'Vërtetim i kopjes nga arkiva noteriale',
    'Ekstrakte nga arkiva',
    'Ruajtje e testamenteve',
    'Depozitim i gjësendeve me vlerë (stoli ari, letra me vlerë)',
    'Përkthim dhe legalizim dokumentesh',
    'Legalizim i kontratës së shitjes',
    'Legalizim i kontratës së dhurimit',
    'Legalizim i kontratës së qirasë',
    'Hartim deklarate noteriale',
    'Autorizim për udhëtim të fëmijëve',
    'Konfirmim fakti (psh. ekzistenca e një dokumenti apo ngjarjeje)',
];

        foreach ($services as $service) {
            ServiceType::create([
                'name' => $service
            ]);
        }
    }
}
