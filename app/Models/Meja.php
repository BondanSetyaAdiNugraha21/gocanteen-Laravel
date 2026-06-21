<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $fillable = ['nomor', 'tersedia'];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }
}