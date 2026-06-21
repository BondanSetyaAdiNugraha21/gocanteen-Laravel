<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Stand;
use Illuminate\Support\Facades\Auth;

class StokPenjualController extends Controller
{
    private function standId()
    {
        return Auth::user()->stand_id;
    }

    public function index()
    {
        if (!Auth::check() || !Auth::user()->isPenjual()) return redirect('/');

        $stand = Stand::where('id', $this->standId())
                      ->with(['menus' => function($q) {
                          $q->with('kategori');
                      }])
                      ->firstOrFail();

        return view('penjual.stok', compact('stand'));
    }

    public function update(Request $request, Menu $menu)
    {
        if ($menu->stand_id !== $this->standId()) abort(403);

        $menu->update(['stok' => max(0, (int) $request->stok)]);
        return redirect('/penjual/stok')->with('success', 'Stok berhasil diupdate!');
    }
}