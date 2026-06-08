<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $fillable = [
        'konsultasi_id',
        'jumlah',
        'status_pembayaran',
        'metode_pembayaran',
        'kode_transaksi',
        'tanggal_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
    ];

    public function konsultasi(): BelongsTo
    {
        return $this->belongsTo(Konsultasi::class, 'konsultasi_id');
    }

    // Methods from Class Diagram:
    // +prosesPembayaran(metode, jumlah) : Pembayaran
    public static function prosesPembayaran($metode, $jumlah, array $attributes = []): self
    {
        return self::create(array_merge([
            'metode_pembayaran' => $metode,
            'jumlah' => $jumlah,
        ], $attributes));
    }

    // +verifikasiPembayaran() : bool
    public function verifikasiPembayaran(): bool
    {
        return $this->update(['status_pembayaran' => 'lunas']);
    }

    // +getBukti() : string
    public function getBukti(): string
    {
        return "BUKTI-" . ($this->kode_transaksi ?? $this->id);
    }
}
