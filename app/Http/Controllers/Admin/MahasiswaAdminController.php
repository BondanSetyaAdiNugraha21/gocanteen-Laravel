<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;

class MahasiswaAdminController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::orderBy('id', 'desc')->get();
        return view('admin.mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim'      => 'required|unique:mahasiswas,nim',
            'nama'     => 'required|min:3',
            'email'    => 'required|email|unique:mahasiswas,email',
            'password' => 'required|min:6',
        ]);

        Mahasiswa::create([
            'nim'      => $request->nim,
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'aktif'    => $request->aktif ? 1 : 0,
        ]);

        return redirect('/admin/mahasiswa')->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nim'   => 'required|unique:mahasiswas,nim,'.$mahasiswa->id,
            'nama'  => 'required|min:3',
            'email' => 'required|email|unique:mahasiswas,email,'.$mahasiswa->id,
        ]);

        $data = [
            'nim'   => $request->nim,
            'nama'  => $request->nama,
            'email' => $request->email,
            'aktif' => $request->aktif ? 1 : 0,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $mahasiswa->update($data);
        return redirect('/admin/mahasiswa')->with('success', 'Mahasiswa berhasil diupdate!');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect('/admin/mahasiswa')->with('success', 'Mahasiswa berhasil dihapus!');
    }
}