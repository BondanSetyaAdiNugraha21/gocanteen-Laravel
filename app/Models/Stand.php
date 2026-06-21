<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'emoji',
        'aktif',
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}