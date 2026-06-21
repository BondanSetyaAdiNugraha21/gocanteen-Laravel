<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Mahasiswa;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMenu     = Menu::count();
        $totalPesanan  = Pesanan::count();
        $totalMhs      = Mahasiswa::where('aktif', true)->count();
        $stokHabis     = Menu::where('stok', 0)->count();
        $pending       = Pesanan::where('status', 'pending')->count();
        $recentOrders  = Pesanan::with('mahasiswa', 'stand')
                                ->orderBy('created_at', 'desc')
                                ->limit(6)
                                ->get();
        $lowStock      = Menu::with('stand')
                             ->where('stok', '<=', 5)
                             ->orderBy('stok')
                             ->limit(6)
                             ->get();

        return view('admin.dashboard', compact(
            'totalMenu', 'totalPesanan', 'totalMhs',
            'stokHabis', 'pending', 'recentOrders', 'lowStock'
        ));
    }
}