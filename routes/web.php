<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KonsultanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes - PAHAMUANG
|--------------------------------------------------------------------------
*/


// 1. HALAMAN UTAMA (publik)
Route::get('/', function () {
    $layanan = \App\Models\Layanan::all();
    return Inertia::render('Dashboard', [
        'layanans' => $layanan
    ]);
})->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

Route::get('/konsultan-public', function () {
    $konsultan = \App\Models\User::where('role', 2)->get();
    return Inertia::render('Public/KonsultanList', [
        'initialKonsultans' => $konsultan
    ]);
})->name('public.konsultan');

// detail konsultan
Route::get('/konsultan-public/{id}', function ($id) {
    $konsultan = \App\Models\User::where('role', 2)->findOrFail($id);
    return Inertia::render('Public/KonsultanDetail', [
        'konsultan' => $konsultan
    ]);
})->name('public.konsultan.detail');

// layanan keuangan
Route::get('/layanan/{slug}', function ($slug) {
    return Inertia::render('Public/LayananDetail', [
        'slug' => $slug
    ]);
})->name('public.layanan');

// booking jadwal
Route::get('/booking/{id}', function ($id) {
    $konsultan = \App\Models\User::where('role', 2)->findOrFail($id);
    $layanan = \App\Models\Layanan::where('harga', 750000)->first() ?? \App\Models\Layanan::first();

    return Inertia::render('Public/BookingSchedule', [
        'id' => $id,
        'konsultan' => $konsultan,
        'layanan' => $layanan,
    ]);
})->name('public.booking');

// checkout pembayaran
Route::get('/checkout/{id}', function ($id) {
    $konsultan = \App\Models\User::where('role', 2)->findOrFail($id);
    $layanan = \App\Models\Layanan::where('harga', 750000)->first() ?? \App\Models\Layanan::first();

    return Inertia::render('Public/Checkout', [
        'id' => $id,
        'date' => request('date'),
        'time' => request('time'),
        'topic' => request('topic'),
        'konsultan' => $konsultan,
        'layanan' => $layanan,
    ]);
})->name('public.checkout');

// proses booking & pembayaran palsu
Route::post('/checkout/{id}', function (\Illuminate\Http\Request $request, $id) {
    $rules = [
        'date' => 'required|date',
        'time' => 'required',
        'topic' => 'nullable|string',
        'payment_method' => 'required|string',
    ];

    if (!auth()->check()) {
        $rules['name'] = 'required|string|max:255';
        $rules['email'] = 'required|email|max:255';
        $rules['phone'] = 'required|string|max:20';
    }

    $request->validate($rules);

    $konsultan = \App\Models\User::where('role', 2)->findOrFail($id);
    $layanan = \App\Models\Layanan::where('harga', 750000)->first() ?? \App\Models\Layanan::first();

    if (auth()->check()) {
        $client = auth()->user();
    } else {
        // Cari atau buat user berdasarkan email
        $client = \App\Models\User::where('email', $request->input('email'))->first();
        if (!$client) {
            $client = \App\Models\User::create([
                'nama' => $request->input('name'),
                'email' => $request->input('email'),
                'no_telepon' => $request->input('phone'),
                'password' => \Illuminate\Support\Facades\Hash::make('password_pahamuang_guest_123'),
                'role' => 3, // Pelanggan
            ]);
        } else {
            if ($request->input('phone')) {
                $client->update(['no_telepon' => $request->input('phone')]);
            }
        }
    }

    $jadwalTime = $request->input('date') . ' ' . $request->input('time') . ':00';

    // Buat konsultasi
    $konsultasi = \App\Models\Konsultasi::create([
        'user_id' => $client->id,
        'konsultan_id' => $konsultan->id,
        'layanan_id' => $layanan->id,
        'status' => 'pending',
        'jadwal' => $jadwalTime,
        'catatan' => $request->input('topic'),
    ]);

    // Buat pembayaran palsu
    \App\Models\Pembayaran::create([
        'konsultasi_id' => $konsultasi->id,
        'jumlah' => $layanan->harga,
        'status_pembayaran' => 'lunas',
        'metode_pembayaran' => $request->input('payment_method'),
        'kode_transaksi' => 'TX-' . strtoupper(uniqid()),
        'tanggal_bayar' => now(),
    ]);

    return redirect()->route('dashboard')->with('success', 'Booking konsultasi berhasil. Konsultan akan segera menghubungi Anda melalui WhatsApp atau Email untuk konfirmasi jadwal.');
})->name('public.checkout.store');

// 2. AREA ADMIN (Role 1)
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'getDashboardStats'])
            ->name('dashboard');

        Route::get('/users', [AdminController::class, 'index'])
            ->name('users.index');

        Route::get('/users/create', [AdminController::class, 'create'])
            ->name('users.create');

        Route::post('/users', [AdminController::class, 'store'])
            ->name('users.store');

        Route::get('/users/{id}/edit', [AdminController::class, 'edit'])
            ->name('users.edit');

        Route::put('/users/{id}', [AdminController::class, 'update'])
            ->name('users.update');

        Route::delete('/users/{id}', [AdminController::class, 'destroy'])
            ->name('users.destroy');

        Route::get('/users/kelola', [AdminController::class, 'kelolaUser'])
            ->name('users.kelola');

        Route::get('/konsultan', [AdminController::class, 'indexKonsultan'])
            ->name('konsultan.index');

        Route::get('/pelanggan', [AdminController::class, 'indexPelanggan'])
            ->name('pelanggan.index');
    });

// 3. AREA KONSULTAN (Role 2)
Route::middleware(['auth', 'verified', 'role:konsultan'])->prefix('konsultan')->name('konsultan.')->group(function () {

    // Dashboard Konsultan
    Route::get('/dashboard',         [KonsultanController::class, 'dashboard'])->name('dashboard');

    // Sesuai class diagram KonsultanController
    Route::patch('/status',          [KonsultanController::class, 'kelolaStatus'])->name('status');
    Route::patch('/konsultasi/{id}/status', [KonsultanController::class, 'updateKonsultasiStatus'])->name('konsultasi.status');
    Route::get('/jadwal',            [KonsultanController::class, 'getJadwal'])->name('jadwal');
    Route::patch('/profil',          [KonsultanController::class, 'updateProfil'])->name('profil');
    Route::get('/riwayat',           [KonsultanController::class, 'getRiwayatKonsultasi'])->name('riwayat');
});

// 4. PROFILE (semua user login)
Route::middleware('auth')->group(function () {
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/konsultan', function () {
    return 'Halaman Manajemen Konsultan';
})->name('konsultan.index');

Route::get('/pelanggan', function () {
    return 'Halaman User Pelanggan';
})->name('pelanggan.index');

require __DIR__ . '/auth.php';
