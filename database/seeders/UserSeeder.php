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

        // Data Konsultan 1 — Dr. Budi Santoso, CFP
        User::create([
            'nama' => 'Dr. Budi Santoso, CFP',
            'email' => 'konsultan@pahamuang.com',
            'password' => Hash::make('password'),
            'role' => 2,
            'no_telepon' => '089876543210',
            'is_available' => true,
            'spesialisasi' => 'Perencanaan Pensiun, Investasi',
            'bidang' => 'Investasi & Pensiun',
            'tarif' => 750000,
            'rating' => 4.9,
            'jumlah_ulasan' => 120,
            'deskripsi' => 'Certified Financial Planner berpengalaman 15 tahun dalam perencanaan investasi dan pensiun.',
        ]);

        // Data Konsultan 2 — Sari Dewi, CFP
        User::create([
            'nama' => 'Sari Dewi, CFP',
            'email' => 'sari@pahamuang.com',
            'password' => Hash::make('password'),
            'role' => 2,
            'no_telepon' => '081298765432',
            'is_available' => true,
            'spesialisasi' => 'Manajemen Utang, Asuransi',
            'bidang' => 'Manajemen Keuangan',
            'tarif' => 600000,
            'rating' => 4.7,
            'jumlah_ulasan' => 85,
            'deskripsi' => 'Spesialis manajemen utang dan perencanaan asuransi keluarga.',
        ]);

        // Data Konsultan 3 — Andi Pratama, CFP
        User::create([
            'nama' => 'Andi Pratama, CFP',
            'email' => 'andi@pahamuang.com',
            'password' => Hash::make('password'),
            'role' => 2,
            'no_telepon' => '085612345678',
            'is_available' => false,
            'spesialisasi' => 'Perencanaan Pensiun, Investasi, Pajak',
            'bidang' => 'Perencanaan Pajak & Pensiun',
            'tarif' => 850000,
            'rating' => 4.8,
            'jumlah_ulasan' => 95,
            'deskripsi' => 'Ahli perencanaan pajak dan strategi pensiun dini.',
        ]);

        // Data Pelanggan/Client (Role 3)
        User::create([
            'nama' => 'Rian Pelanggan',
            'email' => 'client@pahamuang.com',
            'password' => Hash::make('password'),
            'role' => 3, // 3 untuk Pelanggan
            'no_telepon' => '082134567890',
        ]);
    }
}