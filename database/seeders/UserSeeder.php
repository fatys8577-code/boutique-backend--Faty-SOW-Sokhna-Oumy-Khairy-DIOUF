<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@boutique.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Gestionnaire',
            'email' => 'gestionnaire@boutique.com',
            'password' => Hash::make('password123'),
            'role' => 'gestionnaire',
        ]);

        User::create([
            'name' => 'Employe',
            'email' => 'employe@boutique.com',
            'password' => Hash::make('password123'),
            'role' => 'employe',
        ]);
    }
}