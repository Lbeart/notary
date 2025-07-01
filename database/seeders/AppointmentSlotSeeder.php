<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppointmentSlot;
use App\Models\Notary;

class AppointmentSlotSeeder extends Seeder
{
    public function run(): void
    {
        // Merr një noter ekzistues
        $notary = Notary::first();

        if (!$notary) {
            echo "Nuk ka noterë në databazë. Shto noterët me NotarySeeder para se të krijosh slot-e.\n";
            return;
        }

        // Krijo disa slot-e për atë noter
        $slots = [
            [
                'date' => '2025-07-02',
                'start_time' => '09:00',
                'end_time' => '10:00',
            ],
            [
                'date' => '2025-07-02',
                'start_time' => '10:00',
                'end_time' => '11:00',
            ],
        ];

        foreach ($slots as $slot) {
            AppointmentSlot::create([
                'notary_id' => $notary->id,
                'date' => $slot['date'],
                'start_time' => $slot['start_time'],
                'end_time' => $slot['end_time'],
            ]);
        }
    }
}
