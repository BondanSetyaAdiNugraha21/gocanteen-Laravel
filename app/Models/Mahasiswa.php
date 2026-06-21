<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama',
        'email',
        'password',
        'aktif',
    ];

    protected $hidden = [
        'password',
    ];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}