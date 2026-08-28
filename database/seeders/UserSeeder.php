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
            'email' => 'Qa@starfood.com',
            'password' => Hash::make('Qapc$123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Operator PC',
            'email' => 'operatorpc@starfood.com',
            'password' => Hash::make('Operatorpc$123'),
            'role' => 'operatorpc',
        ]);
    }
}