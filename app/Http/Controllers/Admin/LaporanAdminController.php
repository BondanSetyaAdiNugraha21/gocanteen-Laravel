<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Stand;
use App\Models\Menu;

class LaporanAdminController extends Controller
{
    public function index(Request $request)
    {
        $stands   = Stand::all();
        $standId  = $request->stand_id;
        $periode  = $request->periode ?? 'minggu';

        $query = Pesanan::where('status', 'selesai');
        if ($standId) $query->where('stand_id', $standId);

        if ($periode === 'hari') {
            $query->whereDate('created_at', today());
        } elseif ($periode === 'minggu') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($periode === 'bulan') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        }

        $pesanans     = $query->with('stand', 'details')->get();
        $totalPendapatan = $pesanans->sum('total');
        $totalPesanan    = $pesanans->count();

        $perStand = $pesanans->groupBy('stand_id')->map(function($p) {
            return [
                'nama'  => $p->first()->stand->nama ?? '-',
                'emoji' => $p->first()->stand->emoji ?? '🍽️',
                'total' => $p->sum('total'),
                'count' => $p->count(),
            ];
        })->values();

        $menuTerlaris = $pesanans->flatMap->details
            ->groupBy('menu_id')
            ->map(fn($d) => ['nama' => $d->first()->nama_menu, 'qty' => $d->sum('qty'), 'total' => $d->sum('subtotal')])
            ->sortByDesc('qty')
            ->take(5)
            ->values();

        $grafik = collect();
        for ($i = 6; $i >= 0; $i--) {
            $tgl = now()->subDays($i);
            $q   = Pesanan::where('status', 'selesai')->whereDate('created_at', $tgl);
            if ($standId) $q->where('stand_id', $standId);
            $grafik->push([
                'label' => $tgl->format('d M'),
                'total' => $q->sum('total'),
                'count' => $q->count(),
            ]);
        }

        return view('admin.laporan', compact(
            'stands', 'standId', 'periode',
            'totalPendapatan', 'totalPesanan',
            'perStand', 'menuTerlaris', 'grafik'
        ));
    }
}