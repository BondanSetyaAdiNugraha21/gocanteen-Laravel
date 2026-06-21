<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Pesanan;
use App\Models\Menu;

class ReviewController extends Controller
{
    // Tampilkan form review
    public function create($pesanan_id)
    {
        if (!session('mhs_id')) return redirect('/');

        $pesanan = Pesanan::where('id', $pesanan_id)
                          ->where('mahasiswa_id', session('mhs_id'))
                          ->where('status', 'selesai')
                          ->with('details.menu', 'stand')
                          ->firstOrFail();

        // Cek apakah sudah pernah review
        $sudahReview = Review::where('pesanan_id', $pesanan_id)
                             ->where('mahasiswa_id', session('mhs_id'))
                             ->exists();

        if ($sudahReview) {
            return redirect('/riwayat')->with('info', 'Kamu sudah memberikan review untuk pesanan ini!');
        }

        return view('mahasiswa.review', compact('pesanan'));
    }

    // Simpan review
    public function store(Request $request, $pesanan_id)
    {
        if (!session('mhs_id')) return redirect('/');

        $pesanan = Pesanan::where('id', $pesanan_id)
                          ->where('mahasiswa_id', session('mhs_id'))
                          ->where('status', 'selesai')
                          ->with('details')
                          ->firstOrFail();

        $ratings   = $request->input('rating', []);
        $komentar  = $request->input('komentar', []);

        foreach ($pesanan->details as $detail) {
            $menuId = $detail->menu_id;
            if (!isset($ratings[$menuId])) continue;

            Review::updateOrCreate(
                ['pesanan_id' => $pesanan_id, 'menu_id' => $menuId],
                [
                    'mahasiswa_id' => session('mhs_id'),
                    'rating'       => (int) $ratings[$menuId],
                    'komentar'     => $komentar[$menuId] ?? null,
                ]
            );
        }

        return redirect('/riwayat')->with('success', 'Terima kasih atas reviewmu! ⭐');
    }

    // API: ambil review untuk satu menu (untuk popup di halaman menu)
    public function menuReviews($menu_id)
    {
        $reviews = Review::where('menu_id', $menu_id)
                         ->with('mahasiswa:id,nama')
                         ->latest()
                         ->take(20)
                         ->get()
                         ->map(fn($r) => [
                             'nama'      => $r->mahasiswa->nama,
                             'rating'    => $r->rating,
                             'komentar'  => $r->komentar,
                             'tanggal'   => $r->created_at->format('d M Y'),
                         ]);

        $avg = Review::where('menu_id', $menu_id)->avg('rating');
        $count = Review::where('menu_id', $menu_id)->count();

        return response()->json([
            'reviews' => $reviews,
            'avg'     => round($avg, 1),
            'count'   => $count,
        ]);
    }
}