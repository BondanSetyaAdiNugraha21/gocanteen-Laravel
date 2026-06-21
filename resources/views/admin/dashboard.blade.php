@extends('admin.layout')

@section('title', 'Dashboard — Go.Canteen')

@section('content')

<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-400 text-sm mt-1">Selamat datang, <strong class="text-green-700">{{ Auth::user()->name }}</strong> 👋 — {{ date('d F Y') }}</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    @foreach([
        ['🍽️', 'Total Menu',     $totalMenu,    'bg-green-700'],
        ['📋', 'Total Pesanan',  $totalPesanan, 'bg-blue-600'],
        ['🎓', 'Mahasiswa',      $totalMhs,     'bg-indigo-600'],
        ['⏳', 'Menunggu',       $pending,      'bg-yellow-500'],
    ] as [$icon, $label, $value, $bg])
    <div class="{{ $bg }} rounded-2xl p-4 text-white">
        <div class="text-2xl mb-2">{{ $icon }}</div>
        <p class="text-white/70 text-xs font-medium">{{ $label }}</p>
        <h3 class="text-3xl font-bold mt-0.5">{{ $value }}</h3>
    </div>
    @endforeach
</div>

<!-- Pesanan Terbaru -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="flex items-center justify-between p-5 border-b border-gray-50">
        <h3 class="font-bold text-gray-800">📋 Pesanan Terbaru</h3>
        <a href="/admin/pesanan" class="text-green-700 text-sm font-medium hover:text-green-800">Lihat Semua →</a>
    </div>
    <div class="divide-y divide-gray-50">
        @forelse($recentOrders as $o)
        @php
            $sc = match($o->status) {
                'pending'    => 'bg-yellow-100 text-yellow-700',
                'diproses'   => 'bg-blue-100 text-blue-700',
                'siap'       => 'bg-green-100 text-green-700',
                'selesai'    => 'bg-gray-100 text-gray-500',
                'dibatalkan' => 'bg-red-100 text-red-600',
                default      => 'bg-gray-100 text-gray-500'
            };
        @endphp
        <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
            <div>
                <p class="font-semibold text-gray-800 text-sm">{{ $o->kode_pesanan }}</p>
                <p class="text-gray-400 text-xs">{{ $o->mahasiswa->nama }} · {{ $o->stand->nama }}</p>
            </div>
            <div class="text-right">
                <p class="text-green-700 font-bold text-sm">Rp {{ number_format($o->total, 0, ',', '.') }}</p>
                <span class="{{ $sc }} text-xs font-medium px-2 py-0.5 rounded-full">{{ ucfirst($o->status) }}</span>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-sm p-5 text-center">Belum ada pesanan</p>
        @endforelse
    </div>
</div>

@endsection