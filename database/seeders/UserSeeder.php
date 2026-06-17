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
            'nama'       => 'Administrator',
            'email'      => 'admin@pahamuang.com',
            'password'   => Hash::make('password'),
            'role'       => 1,
            'no_telepon' => '081234567890',
        ]);

        User::create([
            'nama'          => 'Dr. Budi Santoso, CFP',
            'email'         => 'konsultan@pahamuang.com',
            'password'      => Hash::make('password'),
            'role'          => 2,
            'no_telepon'    => '089876543210',
            'is_available'  => true,
            'spesialisasi'  => 'Perencanaan Pensiun, Investasi',
            'bidang'        => 'Investasi & Pensiun',
            'tarif'         => 750000,
            'rating'        => 0,
            'jumlah_ulasan' => 0,
            'deskripsi'     => 'Certified Financial Planner berpengalaman dalam perencanaan investasi dan pensiun.',
        ]);
    }
}