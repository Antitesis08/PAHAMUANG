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
        'rating',
        'ulasan',
        'sudah_dirating',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'sudah_dirating' => 'boolean',
        'rating' => 'integer',
    ];

    public function konsultasi(): BelongsTo
    {
        return $this->belongsTo(Konsultasi::class, 'konsultasi_id');
    }
}
