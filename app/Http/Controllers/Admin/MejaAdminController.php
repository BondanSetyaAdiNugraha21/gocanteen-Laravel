<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meja;

class MejaAdminController extends Controller
{
    public function index()
    {
        $mejas = Meja::all()->sortBy(function($m) { return (int) filter_var($m->nomor, FILTER_SANITIZE_NUMBER_INT); })->values();
        return view('admin.meja.index', compact('mejas'));
    }

    public function store(Request $request)
    {
        $request->validate(['nomor' => 'required|unique:mejas,nomor']);
        Meja::create(['nomor' => $request->nomor, 'tersedia' => true]);
        return redirect('/admin/meja')->with('success', 'Meja berhasil ditambahkan!');
    }

    public function destroy(Meja $meja)
    {
        $meja->delete();
        return redirect('/admin/meja')->with('success', 'Meja berhasil dihapus!');
    }

    public function toggleStatus(Meja $meja)
    {
        $meja->update(['tersedia' => !$meja->tersedia]);
        return redirect('/admin/meja')->with('success', 'Status meja berhasil diupdate!');
    }
}