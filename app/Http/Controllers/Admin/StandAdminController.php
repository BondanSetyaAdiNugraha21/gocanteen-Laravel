<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stand;

class StandAdminController extends Controller
{
    public function index()
    {
        $stands = Stand::withCount('menus')->get();
        return view('admin.stand.index', compact('stands'));
    }

    public function create()
    {
        return view('admin.stand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'  => 'required|unique:stands,nama',
            'emoji' => 'required',
        ]);

        Stand::create([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'emoji'     => $request->emoji,
            'aktif'     => $request->has('aktif'),
        ]);

        return redirect('/admin/stand')->with('success', 'Stand berhasil ditambahkan!');
    }

    public function edit(Stand $stand)
    {
        return view('admin.stand.edit', compact('stand'));
    }

    public function update(Request $request, Stand $stand)
    {
        $stand->update([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'emoji'     => $request->emoji,
            'aktif'     => $request->has('aktif'),
        ]);

        return redirect('/admin/stand')->with('success', 'Stand berhasil diupdate!');
    }

    public function destroy(Stand $stand)
    {
        $stand->delete();
        return redirect('/admin/stand')->with('success', 'Stand berhasil dihapus!');
    }
}