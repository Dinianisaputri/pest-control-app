<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin QC',
            'email' => 'admin@starfood.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pengelola Hama',
            'email' => 'pengelola@starfood.com',
            'password' => Hash::make('password123'),
            'role' => 'pengelola',
        ]);
    }
}