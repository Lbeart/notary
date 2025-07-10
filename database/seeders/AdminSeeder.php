<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('fjalekalimiire'), // përdor të njëjtin password që e ke përdor në tinker
                'role' => 'admin',
            ]
        );
    }
}
