<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class KonsultanController extends Controller
{
    /**
     * Kelola status ketersediaan konsultan (online/offline).
     * PATCH /konsultan/status
     */
    public function kelolaStatus(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'is_available' => 'required|boolean',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'is_available' => $request->boolean('is_available'),
        ]);

        return back()->with('success', 'Status ketersediaan berhasil diperbarui.');
    }

    /**
     * Tampilkan jadwal konsultasi konsultan yang sedang login.
     * GET /konsultan/jadwal
     */
    public function getJadwal(): \Inertia\Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ketika model Konsultasi sudah dibuat, uncomment baris di bawah:
        // $jadwal = \App\Models\Konsultasi::where('konsultan_id', $user->id)
        //     ->with(['user:id,nama,email', 'layanan:id,nama_layanan'])
        //     ->orderBy('jadwal', 'asc')
        //     ->get();

        return Inertia::render('Konsultan/Jadwal', [
            'konsultan' => $user->only('id', 'nama', 'email', 'is_available'),
            'jadwal'    => [], // ganti dengan $jadwal setelah model Konsultasi dibuat
        ]);
    }

    /**
     * Update profil konsultan (nama, telepon, dll).
     * PATCH /konsultan/profil
     */
    public function updateProfil(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Tampilkan riwayat konsultasi milik konsultan yang login.
     * GET /konsultan/riwayat
     */
    public function getRiwayatKonsultasi(): \Inertia\Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Ketika model Konsultasi sudah dibuat, uncomment baris di bawah:
        // $riwayat = \App\Models\Konsultasi::where('konsultan_id', $user->id)
        //     ->with(['user:id,nama,email', 'layanan:id,nama_layanan', 'pembayaran'])
        //     ->orderBy('created_at', 'desc')
        //     ->get();

        return Inertia::render('Konsultan/Riwayat', [
            'konsultan' => $user->only('id', 'nama', 'email'),
            'riwayat'   => [], // ganti dengan $riwayat setelah model Konsultasi dibuat
        ]);
    }

    /**
     * Dashboard utama konsultan.
     * GET /konsultan/dashboard
     */
    public function dashboard(): \Inertia\Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return Inertia::render('Konsultan/Dashboard', [
            'konsultan' => $user->only('id', 'nama', 'email', 'is_available', 'no_telepon'),
        ]);
    }
}