<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi data sesuai dengan kolom di database PAHAMUANG
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|string|lowercase|email|max:150|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_telepon' => 'required|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        // 2. Simpan data ke tabel users menggunakan kolom yang benar (nama & no_telepon)
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}