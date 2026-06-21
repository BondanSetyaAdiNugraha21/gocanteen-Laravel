<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    public function create()
{
    $kategoris = Kategori::all();
    return view('menu.create', compact('kategoris'));
}

    public function store(Request $request)
{
    $request->validate([
        'nama'        => 'required|min:3',
        'harga'       => 'required|numeric|min:0',
        'stok'        => 'required|numeric|min:0',
        'kategori_id' => 'required|numeric',
    ]);

    Menu::create([
        'nama'        => $request->nama,
        'deskripsi'   => $request->deskripsi,
        'harga'       => $request->harga,
        'emoji'       => $request->emoji ?? '🍽️',
        'stok'        => $request->stok,
        'kategori_id' => $request->kategori_id,
        'tersedia'    => $request->tersedia ? 1 : 0,
    ]);

    return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan!');
}

    public function edit(Menu $menu)
{
    $kategoris = Kategori::all();
    return view('menu.edit', compact('menu', 'kategoris'));
}

    public function update(Request $request, Menu $menu)
{
    $request->validate([
        'nama'        => 'required|min:3',
        'harga'       => 'required|numeric|min:0',
        'stok'        => 'required|numeric|min:0',
        'kategori_id' => 'required|numeric',
    ]);

    $menu->update([
        'nama'        => $request->nama,
        'deskripsi'   => $request->deskripsi,
        'harga'       => $request->harga,
        'emoji'       => $request->emoji ?? '🍽️',
        'stok'        => $request->stok,
        'kategori_id' => $request->kategori_id,
        'tersedia'    => $request->tersedia ? 1 : 0,
    ]);

    return redirect('/menu')->with('success', 'Menu berhasil diupdate!');
}
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menu.index')->with('success', 'Menu berhasil dihapus!');
    }
}