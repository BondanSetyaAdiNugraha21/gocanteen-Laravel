<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Meja;
use Illuminate\Support\Facades\Auth;

class PesananPenjualController extends Controller
{
    private function standId()
    {
        return Auth::user()->stand_id;
    }

    public function index()
    {
        if (!Auth::check() || !Auth::user()->isPenjual()) return redirect('/');

        $pesanans = Pesanan::where('stand_id', $this->standId())
                           ->with('mahasiswa', 'details', 'meja')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('penjual.pesanan', compact('pesanans'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        if ($pesanan->stand_id !== $this->standId()) abort(403);

        $status = $request->status;
        if (in_array($status, ['pending', 'diproses', 'siap', 'selesai', 'dibatalkan'])) {
            $pesanan->update(['status' => $status]);

            if (in_array($status, ['selesai', 'dibatalkan']) && $pesanan->meja_id) {
                Meja::where('id', $pesanan->meja_id)->update(['tersedia' => true]);
            }
        }

        return redirect('/penjual/pesanan')->with('success', 'Status berhasil diupdate!');
    }
}