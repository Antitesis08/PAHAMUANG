<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - PAHAMUANG
|--------------------------------------------------------------------------
| Endpoint publik tanpa autentikasi.
| Prefix otomatis: /api
*/

// GET /api/konsultans — daftar semua konsultan (role=2)
Route::get('/konsultans', function () {
    $konsultans = \App\Models\User::where('role', 2)
        ->select('id', 'nama', 'spesialisasi', 'tarif', 'rating', 'is_available', 'foto_profil')
        ->get()
        ->map(function ($item) {
            return [
                'id'              => $item->id,
                'nama'            => $item->nama,
                'spesialisasi'    => $item->spesialisasi,
                'tarif'           => $item->tarif,
                'rating'          => $item->rating,
                'is_available'    => $item->is_available,
                'foto_profil_url' => $item->foto_profil_url,
            ];
        });

    return response()->json([
        'success' => true,
        'data'    => $konsultans,
    ]);
});

// GET /api/konsultans/{id} — detail satu konsultan + bookedSlots
Route::get('/konsultans/{id}', function ($id) {
    $konsultan = \App\Models\User::where('role', 2)->find($id);

    if (!$konsultan) {
        return response()->json([
            'success' => false,
            'message' => 'Konsultan tidak ditemukan.',
        ], 404);
    }

    $bookedSlots = \App\Models\Konsultasi::where('konsultan_id', $id)
        ->whereIn('status', ['pending', 'aktif'])
        ->pluck('jadwal')
        ->toArray();

    return response()->json([
        'success' => true,
        'data'    => [
            'id'              => $konsultan->id,
            'nama'            => $konsultan->nama,
            'spesialisasi'    => $konsultan->spesialisasi,
            'tarif'           => $konsultan->tarif,
            'rating'          => $konsultan->rating,
            'is_available'    => $konsultan->is_available,
            'foto_profil_url' => $konsultan->foto_profil_url,
            'deskripsi'       => $konsultan->deskripsi,
            'bookedSlots'     => $bookedSlots,
        ],
    ]);
});

// GET /api/booking/{kode} — cek status booking berdasarkan kode_transaksi
Route::get('/booking/{kode}', function ($kode) {
    $pembayaran = \App\Models\Pembayaran::where('kode_transaksi', $kode)
        ->with(['konsultasi.konsultan', 'konsultasi.user'])
        ->first();

    if (!$pembayaran) {
        return response()->json(['message' => 'Kode booking tidak ditemukan.'], 404);
    }

    $konsultasi = $pembayaran->konsultasi;

    return response()->json([
        'kode_transaksi' => $pembayaran->kode_transaksi,
        'status' => $konsultasi->status,
        'nama_user' => $konsultasi->user->nama ?? '-',
        'nama_konsultan' => $konsultasi->konsultan->nama ?? '-',
        'jadwal' => $konsultasi->jadwal
            ? \Carbon\Carbon::parse($konsultasi->jadwal)->format('d M Y, H:i')
            : '-',
        'jumlah_bayar' => 'Rp ' . number_format($pembayaran->jumlah, 0, ',', '.'),
        'metode_pembayaran' => $pembayaran->metode_pembayaran,
        'status_pembayaran' => $pembayaran->status_pembayaran,
        'sudah_dirating' => $pembayaran->sudah_dirating,
        'bisa_rating' => $konsultasi->status === 'selesai' && !$pembayaran->sudah_dirating,
    ]);
});

// POST /api/booking/{kode}/rating — submit rating & review
Route::post('/booking/{kode}/rating', function (\Illuminate\Http\Request $request, $kode) {
    // Validasi input
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'ulasan' => 'nullable|string|max:500',
    ]);

    // Cari pembayaran berdasarkan kode transaksi
    $pembayaran = \App\Models\Pembayaran::where('kode_transaksi', $kode)
        ->with('konsultasi.konsultan')
        ->first();

    if (!$pembayaran) {
        return response()->json(['message' => 'Kode booking tidak ditemukan.'], 404);
    }

    // Cek apakah konsultasi sudah selesai
    if ($pembayaran->konsultasi->status !== 'selesai') {
        return response()->json(['message' => 'Rating hanya bisa diberikan setelah konsultasi selesai.'], 422);
    }

    // Cek apakah sudah pernah dirating
    if ($pembayaran->sudah_dirating) {
        return response()->json(['message' => 'Anda sudah memberikan rating untuk konsultasi ini.'], 422);
    }

    // Simpan rating ke pembayaran
    $pembayaran->update([
        'rating' => $request->rating,
        'ulasan' => $request->ulasan,
        'sudah_dirating' => true,
    ]);

    // Hitung ulang rating konsultan secara akurat
    $konsultan = $pembayaran->konsultasi->konsultan;

    $ratingData = \App\Models\Pembayaran::whereHas('konsultasi', function ($q) use ($konsultan) {
            $q->where('konsultan_id', $konsultan->id);
        })
        ->where('sudah_dirating', true)
        ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total')
        ->first();

    $konsultan->update([
        'rating' => round($ratingData->avg_rating, 1),
        'jumlah_ulasan' => $ratingData->total,
    ]);

    return response()->json([
        'message' => 'Rating berhasil disimpan. Terima kasih atas ulasan Anda!',
        'rating' => $request->rating,
    ]);
});
