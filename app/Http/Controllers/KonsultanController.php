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

        $jadwals = \App\Models\Konsultasi::where('konsultan_id', $user->id)
            ->with(['user', 'layanan'])
            ->orderBy('jadwal', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_user' => $item->user ? $item->user->nama : '-',
                    'topik' => $item->catatan ?? '-',
                    'status' => $item->status,
                    'tanggal' => $item->jadwal ? \Carbon\Carbon::parse($item->jadwal)->translatedFormat('d F Y') : '-',
                    'jam' => $item->jadwal ? \Carbon\Carbon::parse($item->jadwal)->format('H:i') : '-',
                    'metode' => 'Video Call',
                ];
            });

        return Inertia::render('Konsultan/Jadwal', [
            'konsultan' => $user->only(
                'id',
                'nama',
                'email',
                'is_available'
            ),

            'jadwals' => $jadwals,
        ]);
    }

    /**
     * Tampilkan halaman edit profil konsultan.
     * GET /konsultan/profil
     */
    public function editProfil(): \Inertia\Response
    {
        return Inertia::render('Konsultan/Profil', [
            'konsultan' => Auth::user(),
        ]);
    }

    /**
     * Update profil konsultan (nama, telepon, dll).
     * PATCH /konsultan/profil
     */
    public function updateProfil(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'nama'         => 'required|string|max:255',
            'no_telepon'   => 'nullable|string|max:20',
            'email'        => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'deskripsi'    => 'nullable|string',
            'spesialisasi' => 'nullable|string|max:255',
            'tarif'        => 'nullable|integer|min:0',
            'foto_profil'  => 'nullable|image|max:2048', // max 2MB
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->foto_profil);
            }
            // Simpan foto baru
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $validated['foto_profil'] = $path;
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.')
            ->withHeaders(['Cache-Control' => 'no-cache, no-store, must-revalidate']);
    }

    /**
     * Tampilkan riwayat konsultasi milik konsultan yang login.
     * GET /konsultan/riwayat
     */
    public function getRiwayatKonsultasi(): \Inertia\Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $riwayat = \App\Models\Konsultasi::where('konsultan_id', $user->id)
            ->where('status', 'selesai')
            ->with(['user', 'layanan', 'pembayaran'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_user' => $item->user ? $item->user->nama : '-',
                    'layanan' => $item->layanan ? $item->layanan->nama_layanan : '-',
                    'topik' => $item->catatan ?? '-',
                    'tanggal' => $item->jadwal ? \Carbon\Carbon::parse($item->jadwal)->translatedFormat('d F Y') : '-',
                    'jam' => $item->jadwal ? \Carbon\Carbon::parse($item->jadwal)->format('H:i') : '-',
                    'catatan' => $item->catatan ?? '-',
                    'pembayaran' => $item->pembayaran ? 'Rp ' . number_format($item->pembayaran->jumlah, 0, ',', '.') . ' (' . $item->pembayaran->status_pembayaran . ')' : 'Belum Bayar',
                ];
            });

        return Inertia::render('Konsultan/Riwayat', [
            'konsultan' => $user->only('id', 'nama', 'email'),
            'riwayat'   => $riwayat,
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

        $totalKlien = \App\Models\Konsultasi::where('konsultan_id', $user->id)
            ->distinct('user_id')
            ->count('user_id');

        $totalJadwal = \App\Models\Konsultasi::where('konsultan_id', $user->id)
            ->where('jadwal', '>=', now())
            ->count();

        $totalSelesai = \App\Models\Konsultasi::where('konsultan_id', $user->id)
            ->where('status', 'selesai')
            ->count();

        $totalPendapatan = \App\Models\Pembayaran::whereHas('konsultasi', function ($query) use ($user) {
                $query->where('konsultan_id', $user->id);
            })
            ->sum('jumlah');

        $incomingConsultations = \App\Models\Konsultasi::where('konsultan_id', $user->id)
            ->whereIn('status', ['pending', 'aktif'])
            ->with(['user', 'layanan'])
            ->orderBy('jadwal', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama_user' => $item->user ? $item->user->nama : '-',
                    'topik' => $item->catatan ?? '-',
                    'status' => $item->status,
                    'tanggal' => $item->jadwal ? \Carbon\Carbon::parse($item->jadwal)->translatedFormat('d F Y') : '-',
                    'jam' => $item->jadwal ? \Carbon\Carbon::parse($item->jadwal)->format('H:i') : '-',
                    'layanan' => $item->layanan ? $item->layanan->nama_layanan : '-',
                ];
            });

        return Inertia::render('Konsultan/Dashboard', [
            'konsultan' => $user->only(
                'id',
                'nama',
                'email',
                'is_available',
                'no_telepon',
                'foto_profil_url',
                'deskripsi',
                'spesialisasi'
            ),

            'stats' => [
                'total_jadwal' => $totalJadwal,
                'total_klien' => $totalKlien,
                'total_selesai' => $totalSelesai,
                'total_pendapatan' => $totalPendapatan,
            ],

            'incomingConsultations' => $incomingConsultations,
        ]);
    }

    /**
     * Update status konsultasi pelanggan.
     * PATCH /konsultan/konsultasi/{id}/status
     */
    public function updateKonsultasiStatus(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:aktif,selesai,ditolak',
            'alasan_tolak' => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $konsultasi = \App\Models\Konsultasi::where('konsultan_id', $user->id)
            ->findOrFail($id);

        if ($request->status === 'ditolak') {
            $konsultasi->update([
                'status' => 'ditolak',
                'alasan_tolak' => $request->input('alasan_tolak'),
            ]);

            return back()->with('success', 'Permintaan konsultasi berhasil ditolak.');
        }

        $konsultasi->update(['status' => $request->status]);

        if ($request->status === 'aktif') {
            return back()->with('success', 'Permintaan konsultasi diterima. Pelanggan akan dihubungi untuk konfirmasi.');
        }

        return back()->with('success', 'Konsultasi ditandai selesai.');
    }
}