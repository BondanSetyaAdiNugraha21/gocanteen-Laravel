<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Stand;

class StokController extends Controller
{
    public function index()
    {
        $stands = Stand::with('menus')->get();
        $menus  = Menu::with('stand', 'kategori')->orderBy('stok')->get();
        return view('admin.stok.index', compact('stands', 'menus'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'stok' => 'required|numeric|min:0',
        ]);

        $menu->update(['stok' => $request->stok]);
        return redirect('/admin/stok')->with('success', "Stok {$menu->nama} berhasil diupdate!");
    }
}