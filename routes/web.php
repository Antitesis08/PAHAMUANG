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
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

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

        // NEW
        Route::get('/konsultan', function () {
            return Inertia::render('Admin/Konsultan/Index');
        })->name('konsultan.index');

        Route::get('/pelanggan', function () {
            return Inertia::render('Admin/Pelanggan/Index');
        })->name('pelanggan.index');
    });

// 3. AREA KONSULTAN (Role 2)
Route::middleware(['auth', 'verified', 'role:konsultan'])->prefix('konsultan')->name('konsultan.')->group(function () {

    // Dashboard Konsultan
    Route::get('/dashboard',         [KonsultanController::class, 'dashboard'])->name('dashboard');

    // Sesuai class diagram KonsultanController
    Route::patch('/status',          [KonsultanController::class, 'kelolaStatus'])->name('status');
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
