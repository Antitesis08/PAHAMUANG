<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Data Admin
        User::create([
            'nama' => 'Administrator',
            'email' => 'admin@pahamuang.com',
            'password' => Hash::make('password'),
            'role' => 1, // 1 untuk Admin
            'no_telepon' => '081234567890',
        ]);

        // Data Konsultan
        User::create([
            'nama' => 'Budi Konsultan',
            'email' => 'konsultan@pahamuang.com',
            'password' => Hash::make('password'),
            'role' => 2, // 2 untuk Konsultan
            'no_telepon' => '089876543210',
        ]);
    }
}