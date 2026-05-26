<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Layanan::create([
            'nama_layanan' => 'Perencanaan Pensiun',
            'deskripsi' => 'Rencanakan masa pensiun Anda dengan strategi terbaik.',
            'harga' => 500000,
            'kategori' => 'Pensiun',
        ]);

        \App\Models\Layanan::create([
            'nama_layanan' => 'Manajemen Utang',
            'deskripsi' => 'Kelola utang secara efektif dan aman.',
            'harga' => 400000,
            'kategori' => 'Manajemen',
        ]);

        \App\Models\Layanan::create([
            'nama_layanan' => 'Perencanaan Investasi',
            'deskripsi' => 'Optimalkan investasi untuk masa depan.',
            'harga' => 750000,
            'kategori' => 'Investasi',
        ]);
    }
}
