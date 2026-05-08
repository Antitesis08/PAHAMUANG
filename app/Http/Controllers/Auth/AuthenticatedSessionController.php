<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Proses login masuk.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Jika user sudah authenticated dengan email berbeda, logout dulu
        // Ini memungkinkan user untuk switch role/user di login page yang sama
        $currentUser = Auth::user();
        if ($currentUser && $currentUser->email !== $request->string('email')) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $request->authenticate();

        $request->session()->regenerate();

        // Ambil data user yang baru saja login
        $user = Auth::user();

        /**
         * REDIRECT BERDASARKAN ROLE (Sesuai database pahamuang.sql)
         * 1 = Admin
         * 2 = Konsultan
         * 3 = Nasabah/User
         */
        if ($user->role == 1) {
            return redirect()->intended(route('admin.dashboard'));
        } 
        
        if ($user->role == 2) {
            return redirect()->route('konsultan.dashboard'); // Hapus intended() untuk tes
        }

        // Jika user biasa, lempar ke halaman utama (/)
        // Menggunakan redirect('/') lebih aman jika nama route 'dashboard' diubah
        return redirect()->intended('/');
    }

    /**
     * Proses logout keluar.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}