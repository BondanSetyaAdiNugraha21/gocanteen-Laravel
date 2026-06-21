<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Meja;

class PesananController extends Controller
{
    public function getMeja()
    {
        $mejas = Meja::where('tersedia', true)->get();
        return response()->json($mejas);
    }

    public function proses(Request $request)
    {
        if (!session('mhs_id')) {
            return response()->json(['success' => false, 'message' => 'Silakan login dulu!']);
        }

        $cart        = json_decode($request->cart, true);
        $tipe        = $request->tipe;
        $info        = $request->info;
        $standId     = $request->stand_id;
        $mejaId      = $request->meja_id ?? null;
        $metodeBayar = $request->metode_bayar ?? 'cash';

        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong!']);
        }

        if ($tipe === 'dine-in') {
            if (!$mejaId) {
                return response()->json(['success' => false, 'message' => 'Pilih meja terlebih dahulu!']);
            }
            $meja = Meja::find($mejaId);
            if (!$meja || !$meja->tersedia) {
                return response()->json(['success' => false, 'message' => 'Meja sudah tidak tersedia!']);
            }
        }

        try {
            \DB::beginTransaction();

            $subtotal = 0;
            $items = [];

            foreach ($cart as $item) {
                $menu = Menu::lockForUpdate()->find($item['id']);
                if (!$menu || $menu->stok < $item['qty']) {
                    throw new \Exception("Stok {$menu->nama} tidak cukup!");
                }
                $sub = $menu->harga * $item['qty'];
                $subtotal += $sub;
                $items[] = ['menu' => $menu, 'qty' => $item['qty'], 'subtotal' => $sub];
            }

            $pack  = $tipe === 'takeaway' ? 2000 : 0;
            $total = $subtotal + $pack;
            $kode  = 'GC-' . strtoupper(substr(md5(uniqid()), 0, 8));

            $pesanan = Pesanan::create([
                'kode_pesanan' => $kode,
                'mahasiswa_id' => session('mhs_id'),
                'stand_id'     => $standId,
                'tipe'         => $tipe,
                'info'         => $info,
                'meja_id'      => $tipe === 'dine-in' ? $mejaId : null,
                'total'        => $total,
                'metode_bayar' => $metodeBayar,
                'status'       => 'pending',
            ]);

            if ($tipe === 'dine-in' && $mejaId) {
                Meja::where('id', $mejaId)->update(['tersedia' => false]);
            }

            foreach ($items as $it) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'menu_id'    => $it['menu']->id,
                    'nama_menu'  => $it['menu']->nama,
                    'harga'      => $it['menu']->harga,
                    'qty'        => $it['qty'],
                    'subtotal'   => $it['subtotal'],
                ]);
                $it['menu']->decrement('stok', $it['qty']);
            }

            \DB::commit();

            return response()->json([
                'success'      => true,
                'kode'         => $kode,
                'total'        => 'Rp ' . number_format($total, 0, ',', '.'),
                'metode_bayar' => $metodeBayar,
            ]);

        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function riwayat()
    {
        if (!session('mhs_id')) return redirect('/');
        $pesanans = Pesanan::where('mahasiswa_id', session('mhs_id'))
                           ->with('stand', 'details', 'meja')
                           ->orderBy('created_at', 'desc')
                           ->get();
        return view('mahasiswa.riwayat', compact('pesanans'));
    }
}