<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Konsultasi extends Model
{
    protected $fillable = [
        'user_id',
        'konsultan_id',
        'layanan_id',
        'status',
        'jadwal',
        'catatan',
    ];

    protected $casts = [
        'jadwal' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function konsultan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'konsultan_id');
    }

    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'konsultasi_id');
    }

    // Methods from Class Diagram:
    // +createBooking(user_id, konsultan_id) : Konsultasi
    public static function createBooking($user_id, $konsultan_id, array $attributes = []): self
    {
        return self::create(array_merge([
            'user_id' => $user_id,
            'konsultan_id' => $konsultan_id,
        ], $attributes));
    }

    // +updateStatus(status) : bool
    public function updateStatus($status): bool
    {
        return $this->update(['status' => $status]);
    }

    // +getDetail() : Konsultasi
    public function getDetail(): self
    {
        return $this->load(['user', 'konsultan', 'layanan', 'pembayaran']);
    }
}
