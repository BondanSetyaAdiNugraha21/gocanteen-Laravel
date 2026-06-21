<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\Stand;
use Illuminate\Support\Facades\Auth;

class DashboardPenjualController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isPenjual()) return redirect('/');

        $standId = Auth::user()->stand_id;
        $stand   = Stand::find($standId);

        // Pesanan hari ini
        $pesananHariIni = Pesanan::where('stand_id', $standId)
                                  ->whereDate('created_at', today())
                                  ->count();

        // Pendapatan hari ini
        $pendapatanHariIni = Pesanan::where('stand_id', $standId)
                                     ->where('status', 'selesai')
                                     ->whereDate('created_at', today())
                                     ->sum('total');

        // Pesanan pending/diproses
        $pesananAktif = Pesanan::where('stand_id', $standId)
                                ->whereIn('status', ['pending', 'diproses'])
                                ->count();

        // Menu stok menipis (stok <= 5)
        $stokMenipis = Menu::where('stand_id', $standId)
                            ->where('stok', '<=', 5)
                            ->where('tersedia', true)
                            ->get();

        // Pesanan terbaru
        $pesananTerbaru = Pesanan::where('stand_id', $standId)
                                  ->with('mahasiswa', 'details')
                                  ->latest()
                                  ->take(5)
                                  ->get();

        return view('penjual.dashboard', compact(
            'stand', 'pesananHariIni', 'pendapatanHariIni',
            'pesananAktif', 'stokMenipis', 'pesananTerbaru'
        ));
    }
}