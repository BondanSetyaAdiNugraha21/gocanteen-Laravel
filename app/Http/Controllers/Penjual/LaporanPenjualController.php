<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class LaporanPenjualController extends Controller
{
    public function index(Request $request)
    {
        $standId = Auth::user()->stand_id;
        $periode = $request->periode ?? 'minggu';

        $query = Pesanan::where('status', 'selesai')->where('stand_id', $standId);

        if ($periode === 'hari') {
            $query->whereDate('created_at', today());
        } elseif ($periode === 'minggu') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($periode === 'bulan') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        }

        $pesanans        = $query->with('details')->get();
        $totalPendapatan = $pesanans->sum('total');
        $totalPesanan    = $pesanans->count();

        // Menu terlaris
        $menuTerlaris = $pesanans->flatMap->details
            ->groupBy('menu_id')
            ->map(fn($d) => ['nama' => $d->first()->nama_menu, 'qty' => $d->sum('qty'), 'total' => $d->sum('subtotal')])
            ->sortByDesc('qty')
            ->take(5)
            ->values();

        // Grafik 7 hari terakhir
        $grafik = collect();
        for ($i = 6; $i >= 0; $i--) {
            $tgl = now()->subDays($i);
            $q   = Pesanan::where('status', 'selesai')
                          ->where('stand_id', $standId)
                          ->whereDate('created_at', $tgl);
            $grafik->push([
                'label' => $tgl->format('d M'),
                'total' => $q->sum('total'),
                'count' => $q->count(),
            ]);
        }

        // Ulasan terbaru untuk stand ini
        $ulasan = Review::whereHas('menu', function($q) use ($standId) {
                    $q->where('stand_id', $standId);
                })
                ->with('mahasiswa:id,nama', 'menu:id,nama,emoji')
                ->latest()
                ->take(10)
                ->get();

        return view('penjual.laporan', compact(
            'periode', 'totalPendapatan', 'totalPesanan', 'menuTerlaris', 'grafik', 'ulasan'
        ));
    }
}