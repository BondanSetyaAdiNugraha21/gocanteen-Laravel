<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Stand;

class PenjualAdminController extends Controller
{
    public function index()
    {
        $penjuals = User::where('role', 'penjual')->with('stand')->get();
        return view('admin.penjual.index', compact('penjuals'));
    }

    public function create()
    {
        $stands = Stand::all();
        return view('admin.penjual.create', compact('stands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'stand_id' => 'required|exists:stands,id',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'penjual',
            'stand_id' => $request->stand_id,
        ]);

        return redirect('/admin/penjual')->with('success', 'Akun penjual berhasil dibuat!');
    }

    public function edit(User $user)
    {
        $stands = Stand::all();
        return view('admin.penjual.edit', compact('user', 'stands'));
    }

    public function update(Request $request, User $user)
    {
        $data = [
            'name'     => $request->name,
            'email'    => $request->email,
            'stand_id' => $request->stand_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect('/admin/penjual')->with('success', 'Akun penjual berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/admin/penjual')->with('success', 'Akun penjual berhasil dihapus!');
    }
}