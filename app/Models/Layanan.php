<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = [
        'nama_layanan',
        'deskripsi',
        'harga',
        'kategori', 
    ];

    public function getDetail(): self
    {
        return $this;
    }

    public function isAvailable(): bool
    {
        return $this->harga > 0;
    }
}