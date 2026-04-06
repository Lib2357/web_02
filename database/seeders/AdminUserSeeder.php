<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sv23810310276.local'],
            [
                'name' => 'Admin SV23810310276',
                'password' => 'password',
            ]
        );
    }
}
