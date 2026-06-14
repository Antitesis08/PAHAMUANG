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

/*
|--------------------------------------------------------------------------
| Helper Functions untuk Konsultan
|--------------------------------------------------------------------------
| Dipakai di route booking, checkout, dan booking-success.
| Mengambil tarif dari kolom `tarif` di tabel users (konsultan).
| Jika konsultan belum punya tarif, fallback ke harga layanan pertama.
*/

function getKonsultanHarga($konsultanId)
{
    $konsultan = \App\Models\User::find($konsultanId);
    if ($konsultan && $konsultan->tarif) {
        return $konsultan->tarif;
    }
    // Fallback: ambil harga layanan pertama
    $layanan = \App\Models\Layanan::first();
    return $layanan ? $layanan->harga : 500000;
}

function buildLayananForKonsultan($konsultanId)
{
    // Ambil layanan pertama sebagai layanan default untuk konsultan.
    // Di masa depan bisa dikembangkan jadi relasi many-to-many konsultan <-> layanan.
    $layanan = \App\Models\Layanan::first();

    if ($layanan) {
        // Override harga layanan dengan tarif konsultan agar konsisten
        $harga = getKonsultanHarga($konsultanId);
        $layanan->harga = $harga;
    }

    return $layanan;
}


// 1. HALAMAN UTAMA (publik)
Route::get('/', function () {
    $layanan = \App\Models\Layanan::all();

    // Ambil konsultan top dari database (yang tersedia, rating tertinggi)
    $topKonsultans = \App\Models\User::where('role', 2)
        ->where('is_available', true)
        ->orderByDesc('rating')
        ->limit(3)
        ->get()
        ->map(function ($item) {
            $item->status_aktif = $item->is_available;
            return $item;
        });

    return Inertia::render('Dashboard', [
        'layanans' => $layanan,
        'topKonsultans' => $topKonsultans,
    ]);
})->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

Route::get('/konsultan-public', function () {
    $konsultan = \App\Models\User::where('role', 2)->get()->map(function ($item) {
        $item->status_aktif = $item->is_available;
        return $item;
    });
    return Inertia::render('Public/KonsultanList', [
        'initialKonsultans' => $konsultan
    ]);
})->name('public.konsultan');

// detail konsultan
Route::get('/konsultan-public/{id}', function ($id) {
    $konsultan = \App\Models\User::where('role', 2)->findOrFail($id);
    $konsultan->status_aktif = $konsultan->is_available;
    return Inertia::render('Public/KonsultanDetail', [
        'konsultan' => $konsultan
    ]);
})->name('public.konsultan.detail');

// Halaman publik Tentang Kami
Route::get('/tentang-kami', function () {
    return Inertia::render('Public/AboutUs');
})->name('public.about');

// layanan keuangan
Route::get('/layanan/{slug}', function ($slug) {
    return Inertia::render('Public/LayananDetail', [
        'slug' => $slug
    ]);
})->name('public.layanan');

// booking jadwal
Route::get('/booking/{id}', function ($id) {
    $konsultan = \App\Models\User::where('role', 2)->findOrFail($id);
    
    // Server-side check
    if (!$konsultan->is_available) {
        return redirect()->route('public.konsultan')->with('error', 'Konsultan sedang tidak menerima booking saat ini.');
    }

    $layanan = buildLayananForKonsultan($id);

    // Get booked slots
    $bookedSlots = \App\Models\Konsultasi::where('konsultan_id', $id)
        ->whereIn('status', ['pending', 'aktif'])
        ->pluck('jadwal')
        ->toArray();

    return Inertia::render('Public/BookingSchedule', [
        'id' => $id,
        'konsultan' => $konsultan,
        'layanan' => $layanan,
        'bookedSlots' => $bookedSlots,
    ]);
})->name('public.booking');

// checkout pembayaran
Route::get('/checkout/{id}', function ($id) {
    $konsultan = \App\Models\User::where('role', 2)->findOrFail($id);
    
    // Server-side check
    if (!$konsultan->is_available) {
        return redirect()->route('public.konsultan')->with('error', 'Konsultan sedang tidak menerima booking saat ini.');
    }

    $layanan = buildLayananForKonsultan($id);

    return Inertia::render('Public/Checkout', [
        'id' => $id,
        'date' => request('date'),
        'time' => request('time'),
        'topic' => request('topic'),
        'konsultan' => $konsultan,
        'layanan' => $layanan,
    ]);
})->name('public.checkout');

// Halaman konfirmasi booking sukses
Route::get('/booking-success/{id}', function ($id) {
    $konsultasi = \App\Models\Konsultasi::with(['konsultan', 'layanan', 'pembayaran'])->findOrFail($id);
    
    if ($konsultasi->layanan) {
        $konsultasi->layanan->harga = getKonsultanHarga($konsultasi->konsultan_id);
    }
    
    return Inertia::render('Public/BookingSuccess', [
        'konsultasi' => $konsultasi
    ]);
})->name('public.booking.success');

// proses booking & pembayaran palsu
Route::post('/checkout/{id}', function (\Illuminate\Http\Request $request, $id) {
    $rules = [
        'date' => 'required|date',
        'time' => 'required',
        'topic' => 'nullable|string',
        'payment_method' => 'required|string',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
    ];

    $request->validate($rules);

    // Tolak jika tanggal yang dipilih sudah lewat
    $today = date('Y-m-d');
    if ($request->input('date') < $today) {
        return back()->withErrors(['date' => 'Tanggal yang dipilih sudah lewat, silakan pilih tanggal lain.']);
    }

    $konsultan = \App\Models\User::where('role', 2)->findOrFail($id);
    
    // Server-side check
    if (!$konsultan->is_available) {
        return redirect()->route('public.konsultan')->with('error', 'Konsultan sedang tidak menerima booking saat ini.');
    }

    $jadwalTime = $request->input('date') . ' ' . $request->input('time') . ':00';

    // Cek bentrok jadwal (pending/aktif)
    $bentrok = \App\Models\Konsultasi::where('konsultan_id', $id)
        ->where('jadwal', $jadwalTime)
        ->whereIn('status', ['pending', 'aktif'])
        ->exists();

    if ($bentrok) {
        return back()->withErrors(['date' => 'Jadwal ini sudah dibooking, silakan pilih jadwal lain.']);
    }

    $hargaKonsultan = getKonsultanHarga($id);
    $layanan = buildLayananForKonsultan($id);

    // Selalu ambil data klien dari form input (BUKAN dari auth user)
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
        $client->update([
            'nama' => $request->input('name'),
            'no_telepon' => $request->input('phone'),
        ]);
    }

    // Buat konsultasi
    $konsultasi = \App\Models\Konsultasi::create([
        'user_id' => $client->id,
        'konsultan_id' => $konsultan->id,
        'layanan_id' => $layanan ? $layanan->id : 1,
        'status' => 'pending',
        'jadwal' => $jadwalTime,
        'catatan' => $request->input('topic'),
    ]);

    // Buat pembayaran palsu
    \App\Models\Pembayaran::create([
        'konsultasi_id' => $konsultasi->id,
        'jumlah' => $hargaKonsultan,
        'status_pembayaran' => 'lunas',
        'metode_pembayaran' => $request->input('payment_method'),
        'kode_transaksi' => 'TX-' . strtoupper(uniqid()),
        'tanggal_bayar' => now(),
    ]);

    return redirect()->route('public.booking.success', $konsultasi->id)->with('success', 'Booking konsultasi berhasil.');
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

        // Create konsultan (admin)
        Route::get('/konsultan/create', [AdminController::class, 'createKonsultan'])
            ->name('konsultan.create');

        Route::post('/konsultan', [AdminController::class, 'storeKonsultan'])
            ->name('konsultan.store');

        Route::get('/pelanggan', [AdminController::class, 'indexPelanggan'])
            ->name('pelanggan.index');

        Route::get('/konsultasi', [AdminController::class, 'indexKonsultasiBooking'])
            ->name('konsultasi.index');

        Route::delete('/konsultasi/{id}', [AdminController::class, 'destroyKonsultasiBooking'])
            ->name('konsultasi.destroy');
    });

// 3. AREA KONSULTAN (Role 2)
Route::middleware(['auth', 'verified', 'role:konsultan'])->prefix('konsultan')->name('konsultan.')->group(function () {

    // Dashboard Konsultan
    Route::get('/dashboard',         [KonsultanController::class, 'dashboard'])->name('dashboard');

    // Sesuai class diagram KonsultanController
    Route::patch('/status',          [KonsultanController::class, 'kelolaStatus'])->name('status');
    Route::patch('/konsultasi/{id}/status', [KonsultanController::class, 'updateKonsultasiStatus'])->name('konsultasi.status');
    Route::get('/jadwal',            [KonsultanController::class, 'getJadwal'])->name('jadwal');
    Route::get('/profil',            [KonsultanController::class, 'editProfil'])->name('profil.edit');
    Route::post('/profil',           [KonsultanController::class, 'updateProfil'])->name('profil.post');
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
