<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_pesanan',
        'mahasiswa_id',
        'stand_id',
        'tipe',
        'info',
        'meja_id',
        'total',
        'metode_bayar',
        'status_bayar',
        'bukti_bayar',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class);
    }

    public function details()
    {
        return $this->hasMany(DetailPesanan::class);
    }
}