<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        /**
         * 2. Logika pengecekan role sesuai database pahamuang.sql
         * role 1 = Admin, role 2 = Konsultan, role 3 = User
         */
        
        // Proteksi Halaman Admin
        if ($role == 'admin' && $user->role != 1) {
            return redirect('/')->with('error', 'Akses ditolak! Anda bukan Admin.');
        }

        // Proteksi Halaman Konsultan
       // Proteksi Halaman Konsultan
        if ($role == 'konsultan' && $user->role != 2) {
            return redirect('/')->with('error', 'Akses ditolak! Anda bukan Konsultan.');
        }

        return $next($request);
    }
}