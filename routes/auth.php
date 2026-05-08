<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// Login Page - DIUBAH: Bisa diakses oleh siapa saja (authenticated atau tidak)
// Ini memungkinkan user untuk switch role dengan login kembali
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

// Login Action - DIUBAH: Juga bisa diakses siapa saja, tapi controller handle auto-logout
// jika user sudah authenticated dan mencoba login dengan email lain
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});