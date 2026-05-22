<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminController extends Controller implements ApiInterface
{
    /**
     * Tampilkan daftar semua user.
     * GET /admin/users
     */
    public function index(): \Inertia\Response
    {
        $users = User::select('id', 'nama', 'email', 'role', 'no_telepon', 'is_available', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    /**
     * Simpan user baru.
     * POST /admin/users
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8',
            'role'       => 'required|in:1,2,3',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        User::create([
            'nama'       => $validated['nama'],
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'role'       => $validated['role'],
            'no_telepon' => $validated['no_telepon'] ?? null,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Update data user.
     * PUT /admin/users/{id}
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nama'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $id,
            'role'       => 'required|in:1,2,3',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user.
     * DELETE /admin/users/{id}
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    /**
     * Kelola semua user (tampilan manajemen pengguna).
     * GET /admin/users/kelola
     */
    public function kelolaUser(): \Inertia\Response
{
    return Inertia::render('Admin/Users/Kelola');
}

    /**
     * Statistik dashboard admin.
     * GET /admin/dashboard-stats
     */
    public function getDashboardStats(): \Inertia\Response
    {
        $stats = [
            'total_user'      => User::where('role', 3)->count(),
            'total_konsultan' => User::where('role', 2)->count(),
            'total_admin'     => User::where('role', 1)->count(),
            'konsultan_aktif' => User::where('role', 2)->where('is_available', true)->count(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
        ]);
    }
}
