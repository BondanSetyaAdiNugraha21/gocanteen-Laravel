<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect('/admin/dashboard')
                : redirect('/penjual/pesanan');
        }
        if (session('mhs_id')) {
            return redirect('/stand');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $identity = trim($request->identity);
        $password = $request->password;

        // Cek admin / penjual
        if (Auth::attempt(['email' => $identity, 'password' => $password])) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect('/admin/dashboard');
            } else {
                // Penjual
                if (!$user->stand_id) {
                    Auth::logout();
                    return back()->with('error', 'Akun penjual belum dikaitkan dengan stand!');
                }
                return redirect('/penjual/dashboard');
            }
        }

        // Cek mahasiswa
        $mhs = Mahasiswa::where('nim', $identity)->where('aktif', true)->first();
        if ($mhs && Hash::check($password, $mhs->password)) {
            session([
                'mhs_id'   => $mhs->id,
                'mhs_nama' => $mhs->nama,
                'mhs_nim'  => $mhs->nim,
            ]);
            return redirect('/stand');
        }

        return back()->with('error', 'NIM/Email atau password salah!');
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect('/');
    }
}