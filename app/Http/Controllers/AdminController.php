<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminController extends Controller implements ApiInterface
{
    /**
     * =========================================================
     * LIST USER
     * =========================================================
     */
    public function index(): \Inertia\Response
    {
        $users = User::select(
                'id',
                'nama',
                'email',
                'password',
                'role',
                'is_available',
                'no_telepon',
                'created_at',
                'updated_at'
            )
            ->orderBy('id', 'asc')
            ->get();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * =========================================================
     * HALAMAN CREATE USER
     * =========================================================
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Admin/Users/Create');
    }

    /**
     * =========================================================
     * SIMPAN USER
     * =========================================================
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8',
            'role'       => 'required|in:1,2,3',
            'no_telepon' => 'required|string|max:20',
        ]);

        User::create([
            'nama'         => $validated['nama'],
            'email'        => $validated['email'],
            'password'     => Hash::make($validated['password']),
            'role'         => $validated['role'],
            'no_telepon'   => $validated['no_telepon'],
            'is_available' => false,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * =========================================================
     * HALAMAN EDIT USER
     * =========================================================
     */
    public function edit($id): \Inertia\Response
    {
        $user = User::findOrFail($id);

        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * =========================================================
     * UPDATE USER
     * =========================================================
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $id,
            'role'       => 'required|in:1,2,3',
            'no_telepon' => 'required|string|max:20',
        ]);

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * =========================================================
     * DELETE USER
     * =========================================================
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()
            ->back()
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * =========================================================
     * KELOLA USER
     * =========================================================
     */
    public function kelolaUser(): \Inertia\Response
    {
        $users = User::select(
                'id',
                'nama',
                'email',
                'password',
                'role',
                'is_available',
                'no_telepon',
                'created_at',
                'updated_at'
            )
            ->orderBy('id', 'asc')
            ->get();

        return Inertia::render('Admin/Users/Kelola', [
            'users' => $users,
        ]);
    }

    /**
     * =========================================================
     * DAFTAR KONSULTAN
     * =========================================================
     */
    public function indexKonsultan(): \Inertia\Response
    {
        $konsultans = User::select(
                'id',
                'nama',
                'email',
                'no_telepon',
                'created_at',
                'updated_at',
                'is_available',
                'tarif'
            )
            ->where('role', 2)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'no_telepon' => $user->no_telepon,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                    'is_available' => $user->is_available,
                    'spesialisasi' => $user->spesialisasi ?? null,
                    'rating' => $user->rating ?? null,
                    'tarif' => $user->tarif ?? 0,
                ];
            });

        return Inertia::render('Admin/Konsultan/Index', [
            'konsultans' => $konsultans,
        ]);
    }

    /**
     * =========================================================
     * HALAMAN CREATE KONSULTAN (ADMIN)
     * =========================================================
     */
    public function createKonsultan(): \Inertia\Response
    {
        return Inertia::render('Admin/Konsultan/Create');
    }

    /**
     * =========================================================
     * SIMPAN KONSULTAN (ADMIN)
     * =========================================================
     */
    public function storeKonsultan(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8',
            'nama'       => 'nullable|string|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'tarif'      => 'nullable|integer|min:0',
        ]);

        User::create([
            'nama'         => $validated['nama'] ?? ($validated['email'] ?? 'Konsultan'),
            'email'        => $validated['email'],
            'password'     => Hash::make($validated['password']),
            'role'         => 2, // konsultan
            'no_telepon'   => $validated['no_telepon'] ?? null,
            'tarif'        => $validated['tarif'] ?? 0,
            'is_available' => false,
        ]);

        return redirect()
            ->route('admin.konsultan.index')
            ->with('success', 'Konsultan berhasil ditambahkan.');
    }

    /**
     * =========================================================
     * DAFTAR PELANGGAN
     * =========================================================
     */
    public function indexPelanggan(): \Inertia\Response
    {
        $pelanggan = User::select(
                'id',
                'nama',
                'email',
                'no_telepon',
                'created_at',
                'updated_at',
                'email_verified_at'
            )
            ->where('role', 3)
            ->orderBy('id', 'asc')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'nama' => $user->nama,
                    'email' => $user->email,
                    'no_telepon' => $user->no_telepon,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                    'email_verified_at' => $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : null,
                ];
            });

        return Inertia::render('Admin/Pelanggan/Index', [
            'pelanggan' => $pelanggan,
        ]);
    }

    /**
     * =========================================================
     * DASHBOARD STATS
     * =========================================================
     */
    public function getDashboardStats(): \Inertia\Response
    {
        $stats = [
            'total_user'      => User::where('role', 3)->count(),
            'total_konsultan' => User::where('role', 2)->count(),
            'total_admin'     => User::where('role', 1)->count(),
            'konsultan_aktif' => User::where('role', 2)
                                    ->where('is_available', true)
                                    ->count(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
        ]);
    }

    /**
     * =========================================================
     * DAFTAR KONSULTASI / BOOKING
     * =========================================================
     */
    public function indexKonsultasiBooking(): \Inertia\Response
    {
        $konsultasis = \App\Models\Konsultasi::with(['user', 'konsultan', 'layanan', 'pembayaran'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'user_nama' => $item->user->nama ?? 'Guest/Unknown',
                    'user_email' => $item->user->email ?? '-',
                    'konsultan_nama' => $item->konsultan->nama ?? 'Unknown',
                    'layanan_nama' => $item->layanan->nama_layanan ?? 'Konsultasi Keuangan',
                    'status' => $item->status,
                    'jadwal' => $item->jadwal ? $item->jadwal->format('Y-m-d H:i') : '-',
                    'jumlah_bayar' => $item->pembayaran->jumlah ?? 0,
                    'status_pembayaran' => $item->pembayaran->status_pembayaran ?? '-',
                ];
            });

        return Inertia::render('Admin/Konsultasi/Index', [
            'konsultasis' => $konsultasis,
        ]);
    }

    /**
     * =========================================================
     * HAPUS KONSULTASI / BOOKING
     * =========================================================
     */
    public function destroyKonsultasiBooking($id): \Illuminate\Http\RedirectResponse
    {
        $konsultasi = \App\Models\Konsultasi::findOrFail($id);
        $konsultasi->delete();

        return redirect()
            ->back()
            ->with('success', 'Jadwal konsultasi berhasil dihapus.');
    }
}