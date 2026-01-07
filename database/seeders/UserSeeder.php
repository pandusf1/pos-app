<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ADMIN
        User::create([
            'name' => 'Admin',
            'email' => 'admin@tes.com',
            'password' => Hash::make('12345'),
            'role' => 'admin',
        ]);

        // KASIR
        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@test.com',
            'password' => Hash::make('12345'),
            'role' => 'kasir',
        ]);
    }
}