<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stand;
use App\Models\Menu;
use App\Models\Kategori;

class MenuMhsController extends Controller
{
    public function index($stand_id)
    {
        if (!session('mhs_id')) return redirect('/');
        
        $stand = Stand::where('id', $stand_id)->where('aktif', true)->firstOrFail();
        
        $menus = Menu::where('stand_id', $stand_id)
                     ->where('tersedia', true)
                     ->where('stok', '>', 0)
                     ->with('kategori')
                     ->get();
        
        // Hanya tampilkan kategori yang ada di stand ini
        $kategoriIds = $menus->pluck('kategori_id')->unique();
        $kategoris = Kategori::whereIn('id', $kategoriIds)->get();
        
        $grouped = $menus->groupBy('kategori_id');
        
        return view('mahasiswa.menu', compact('stand', 'kategoris', 'menus', 'grouped'));
    }
}