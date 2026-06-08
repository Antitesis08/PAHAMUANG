<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Konsultasi;
use App\Models\User;
use App\Models\Layanan;
use App\Models\Pembayaran;
use Carbon\Carbon;

class KonsultasiSeeder extends Seeder
{
    public function run(): void
    {
        $client = User::where('role', 3)->first();
        if (!$client) {
            $client = User::create([
                'nama' => 'Rian Pelanggan',
                'email' => 'client@pahamuang.com',
                'password' => bcrypt('password'),
                'role' => 3,
                'no_telepon' => '082134567890',
            ]);
        }

        $konsultan = User::where('role', 2)->first();
        $layananPensiun = Layanan::where('nama_layanan', 'Perencanaan Pensiun')->first();
        $layananInvestasi = Layanan::where('nama_layanan', 'Perencanaan Investasi')->first();

        if ($client && $konsultan && $layananPensiun && $layananInvestasi) {
            // 1. Konsultasi Selesai (dengan Pembayaran)
            $k1 = Konsultasi::create([
                'user_id' => $client->id,
                'konsultan_id' => $konsultan->id,
                'layanan_id' => $layananInvestasi->id,
                'status' => 'selesai',
                'jadwal' => Carbon::now()->subDays(2)->setTime(10, 0),
                'catatan' => 'Konsultasi investasi saham dan reksa dana untuk pemula.',
            ]);

            Pembayaran::create([
                'konsultasi_id' => $k1->id,
                'jumlah' => $layananInvestasi->harga,
                'status_pembayaran' => 'lunas',
                'metode_pembayaran' => 'Transfer Bank',
                'kode_transaksi' => 'TX' . strtoupper(uniqid()),
                'tanggal_bayar' => Carbon::now()->subDays(2)->setTime(9, 30),
            ]);

            // 2. Konsultasi Aktif/Jadwal Mendatang (dengan Pembayaran)
            $k2 = Konsultasi::create([
                'user_id' => $client->id,
                'konsultan_id' => $konsultan->id,
                'layanan_id' => $layananPensiun->id,
                'status' => 'aktif',
                'jadwal' => Carbon::now()->addDays(2)->setTime(13, 0),
                'catatan' => 'Perencanaan pensiun dini usia 45 tahun.',
            ]);

            Pembayaran::create([
                'konsultasi_id' => $k2->id,
                'jumlah' => $layananPensiun->harga,
                'status_pembayaran' => 'lunas',
                'metode_pembayaran' => 'QRIS',
                'kode_transaksi' => 'TX' . strtoupper(uniqid()),
                'tanggal_bayar' => Carbon::now()->subDays(1)->setTime(14, 0),
            ]);

            // 3. Konsultasi Pending (belum dibayar/proses pembayaran)
            $k3 = Konsultasi::create([
                'user_id' => $client->id,
                'konsultan_id' => $konsultan->id,
                'layanan_id' => $layananPensiun->id,
                'status' => 'pending',
                'jadwal' => Carbon::now()->addDays(5)->setTime(15, 0),
                'catatan' => 'Konsultasi pengelolaan dana hari tua.',
            ]);
            
            Pembayaran::create([
                'konsultasi_id' => $k3->id,
                'jumlah' => $layananPensiun->harga,
                'status_pembayaran' => 'pending',
                'metode_pembayaran' => 'E-Wallet',
                'kode_transaksi' => 'TX' . strtoupper(uniqid()),
                'tanggal_bayar' => null,
            ]);
        }
    }
}
