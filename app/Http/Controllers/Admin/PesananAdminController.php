<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Meja;

class PesananAdminController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with('mahasiswa', 'stand', 'details', 'meja')
                           ->orderBy('created_at', 'desc')
                           ->get();
        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $status = $request->status;
        if (in_array($status, ['pending', 'diproses', 'siap', 'selesai', 'dibatalkan'])) {
            $pesanan->update(['status' => $status]);

            // Bebaskan meja jika pesanan selesai atau dibatalkan
            if (in_array($status, ['selesai', 'dibatalkan']) && $pesanan->meja_id) {
                Meja::where('id', $pesanan->meja_id)->update(['tersedia' => true]);
            }
        }
        return redirect('/admin/pesanan')->with('success', 'Status berhasil diupdate!');
    }

    public function destroy(Pesanan $pesanan)
    {
        if ($pesanan->meja_id && !in_array($pesanan->status, ['selesai', 'dibatalkan'])) {
            Meja::where('id', $pesanan->meja_id)->update(['tersedia' => true]);
        }
        $pesanan->delete();
        return redirect('/admin/pesanan')->with('success', 'Pesanan berhasil dihapus!');
    }
}