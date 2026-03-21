<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@email.com'], // unique check
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );
    }
}
