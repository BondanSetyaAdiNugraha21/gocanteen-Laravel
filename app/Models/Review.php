<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['pesanan_id', 'mahasiswa_id', 'menu_id', 'rating', 'komentar'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}