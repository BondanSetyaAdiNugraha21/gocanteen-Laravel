<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stand;

class StandController extends Controller
{
    public function index()
    {
        if (!session('mhs_id')) return redirect('/');
        $stands = Stand::where('aktif', true)->get();
        return view('mahasiswa.stand', compact('stands'));
    }
}