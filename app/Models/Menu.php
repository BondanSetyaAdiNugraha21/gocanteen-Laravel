<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'stand_id',
        'kategori_id',
        'nama',
        'deskripsi',
        'harga',
        'emoji',
        'stok',
        'tersedia',
    ];

    public function stand()
    {
        return $this->belongsTo(Stand::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}