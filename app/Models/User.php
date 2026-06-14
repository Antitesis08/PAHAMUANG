<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   // Pastikan ini ada di Model User
protected $fillable = [
    'nama',
    'email',
    'password',
    'role',
    'no_telepon',
    'alamat',
    'is_available',
    'foto_profil',
    'deskripsi',
    'spesialisasi',
    'tarif',
    'rating',
    'jumlah_ulasan',
    'bidang',
];

protected $appends = [
    'foto_profil_url',
    'name',
];

public function getFotoProfilUrlAttribute()
{
    return $this->foto_profil ? asset('storage/' . $this->foto_profil) : null;
}

public function getNameAttribute()
{
    return $this->nama;
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_available' => 'boolean',
        'tarif' => 'decimal:0',
        'rating' => 'decimal:1',
        'jumlah_ulasan' => 'integer',
    ];

    public function createBooking($layanan_id, $jadwal): Konsultasi
    {
        $konsultan = self::where('role', 2)->first();
        return Konsultasi::create([
            'user_id' => $this->id,
            'konsultan_id' => $konsultan ? $konsultan->id : $this->id,
            'layanan_id' => $layanan_id,
            'status' => 'pending',
            'jadwal' => $jadwal,
        ]);
    }

    public function updateStatus($is_available): bool
    {
        return $this->update(['is_available' => $is_available]);
    }

    public function getKonsultasiList(): \Illuminate\Database\Eloquent\Collection
    {
        if ($this->role == 2) {
            return Konsultasi::where('konsultan_id', $this->id)->get();
        }
        return Konsultasi::where('user_id', $this->id)->get();
    }
}
