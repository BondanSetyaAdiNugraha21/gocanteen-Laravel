<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class MenuPenjualController extends Controller
{
    private function standId()
    {
        return Auth::user()->stand_id;
    }

    public function index()
    {
        if (!Auth::check() || !Auth::user()->isPenjual()) return redirect('/');
        $menus = Menu::where('stand_id', $this->standId())->with('kategori')->get();
        $kategoris = Kategori::all();
        return view('penjual.menu.index', compact('menus', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('penjual.menu.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required',
            'harga'       => 'required|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        Menu::create([
            'stand_id'    => $this->standId(),
            'kategori_id' => $request->kategori_id,
            'nama'        => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'emoji'       => $request->emoji ?? '🍽️',
            'tersedia'    => $request->has('tersedia'),
        ]);

        return redirect('/penjual/menu')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function edit(Menu $menu)
    {
        if ($menu->stand_id !== $this->standId()) abort(403);
        $kategoris = Kategori::all();
        return view('penjual.menu.edit', compact('menu', 'kategoris'));
    }

    public function update(Request $request, Menu $menu)
    {
        if ($menu->stand_id !== $this->standId()) abort(403);

        $menu->update([
            'kategori_id' => $request->kategori_id,
            'nama'        => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok,
            'emoji'       => $request->emoji ?? $menu->emoji,
            'tersedia'    => $request->has('tersedia'),
        ]);

        return redirect('/penjual/menu')->with('success', 'Menu berhasil diupdate!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->stand_id !== $this->standId()) abort(403);
        $menu->delete();
        return redirect('/penjual/menu')->with('success', 'Menu berhasil dihapus!');
    }
}