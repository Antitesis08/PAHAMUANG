<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes - PAHAMUANG
|--------------------------------------------------------------------------
*/

// 1. HALAMAN UTAMA (Dashboard Nasabah/Umum)
Route::get('/', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// Force redirect jika ada link lama yang mengakses /dashboard
Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

// 2. AREA KONSULTAN (Role 2)
Route::middleware(['auth', 'verified', 'role:konsultan'])->group(function () {
    Route::get('/konsultan/dashboard', function () {
        return Inertia::render('Konsultan/Dashboard'); // Pastikan K dan D besar sesuai folder
    })->name('konsultan.dashboard');
});

// 3. AREA ADMIN (Role 1)
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->name('admin.dashboard');
});

// 4. PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';