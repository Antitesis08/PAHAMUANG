<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware untuk mengizinkan authenticated user mengakses halaman login
 * ketika mereka ingin login sebagai role yang berbeda.
 * 
 * Berbeda dengan middleware 'guest' yang menghalangi authenticated user,
 * middleware ini mengizinkan mereka untuk switch role/user.
 */
class AllowLoginAccess
{
    /**
     * Handle an incoming request.
     * Jika user sudah authenticated, mereka bisa langsung akses halaman login
     * (tidak diredirect ke dashboard).
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user sudah authenticated, mereka bisa akses login page untuk switch role
        // Middleware 'guest' akan auto-logout atau redirect, kita skip itu
        
        // Jika ada parameter 'switch=true', auto logout user terlebih dahulu
        if ($request->query('switch') === 'true' && Auth::check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        
        return $next($request);
    }
}
