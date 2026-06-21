@extends('penjual.layout')

@section('title', 'Dashboard — Go.Canteen')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">📊 Dashboard</h1>
    <p class="text-gray-400 text-sm mt-1">
        Selamat datang, <span class="font-semibold text-gray-600">{{ Auth::user()->name }}</span>
        {{ $stand ? '· '.$stand->emoji.' '.$stand->nama : '' }}
        — {{ now()->translatedFormat('d F Y') }}
    </p>
</div>

<!-- Kartu Ringkasan -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-green-700 rounded-2xl p-5 text-white">
        <p class="text-green-200 text-xs font-medium mb-1">Pesanan Hari Ini</p>
        <p class="text-3xl font-bold">{{ $pesananHariIni }}</p>
    </div>
    <div class="bg-blue-600 rounded-2xl p-5 text-white">
        <p class="text-blue-200 text-xs font-medium mb-1">Pendapatan Hari Ini</p>
        <p class="text-xl font-bold">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
    </div>
    <div class="bg-yellow-500 rounded-2xl p-5 text-white">
        <p class="text-yellow-100 text-xs font-medium mb-1">Pesanan Aktif</p>
        <p class="text-3xl font-bold">{{ $pesananAktif }}</p>
    </div>
    <div class="bg-red-500 rounded-2xl p-5 text-white">
        <p class="text-red-100 text-xs font-medium mb-1">Stok Menipis</p>
        <p class="text-3xl font-bold">{{ $stokMenipis->count() }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Pesanan Terbaru -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-gray-800">📋 Pesanan Terbaru</h2>
            <a href="/penjual/pesanan" class="text-sm text-green-700 font-medium hover:underline">Lihat Semua →</a>
        </div>
        @if($pesananTerbaru->isEmpty())
        <p class="text-gray-400 text-sm text-center py-8">Belum ada pesanan</p>
        @else
        <div class="space-y-3">
            @foreach($pesananTerbaru as $p)
            @php
                $statusColor = match($p->status) {
                    'pending'    => 'bg-yellow-100 text-yellow-700',
                    'diproses'   => 'bg-blue-100 text-blue-700',
                    'siap'       => 'bg-green-100 text-green-700',
                    'selesai'    => 'bg-gray-100 text-gray-500',
                    'dibatalkan' => 'bg-red-100 text-red-600',
                    default      => 'bg-gray-100 text-gray-500'
                };
            @endphp
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                <div>
                    <p class="font-semibold text-sm text-gray-800">{{ $p->kode_pesanan }}</p>
                    <p class="text-xs text-gray-400">{{ $p->mahasiswa->nama ?? '-' }} · {{ $p->created_at->format('H:i') }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-sm text-green-700">Rp {{ number_format($p->total, 0, ',', '.') }}</p>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $statusColor }}">{{ ucfirst($p->status) }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Stok Menipis -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-gray-800">⚠️ Stok Menipis</h2>
            <a href="/penjual/stok" class="text-sm text-green-700 font-medium hover:underline">Kelola →</a>
        </div>
        @if($stokMenipis->isEmpty())
        <div class="text-center py-8">
            <p class="text-2xl mb-2">✅</p>
            <p class="text-gray-400 text-sm">Semua stok aman!</p>
        </div>
        @else
        <div class="space-y-3">
            @foreach($stokMenipis as $m)
            <div class="flex items-center justify-between p-3 {{ $m->stok == 0 ? 'bg-red-50' : 'bg-yellow-50' }} rounded-xl">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">{{ $m->emoji }}</span>
                    <p class="font-medium text-sm text-gray-800">{{ $m->nama }}</p>
                </div>
                <span class="font-bold text-sm {{ $m->stok == 0 ? 'text-red-600' : 'text-yellow-600' }}">
                    {{ $m->stok == 0 ? 'HABIS' : 'Sisa '.$m->stok }}
                </span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection