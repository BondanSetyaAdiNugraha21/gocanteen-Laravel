@extends('admin.layout')

@section('title', 'Pesanan — Go.Canteen')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">📋 Daftar Pesanan</h1>
        <p class="text-gray-400 text-sm mt-1">{{ count($pesanans) }} pesanan ditemukan</p>
    </div>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
    {{ session('success') }}
</div>
@endif

@if($pesanans->isEmpty())
<div class="text-center py-20 text-gray-400">
    <div class="text-5xl mb-3">📋</div>
    <p>Belum ada pesanan</p>
</div>
@else
<div class="space-y-4">
    @foreach($pesanans as $p)
    @php
        $sc = match($p->status) {
            'pending'    => 'bg-yellow-100 text-yellow-700',
            'diproses'   => 'bg-blue-100 text-blue-700',
            'siap'       => 'bg-green-100 text-green-700',
            'selesai'    => 'bg-gray-100 text-gray-500',
            'dibatalkan' => 'bg-red-100 text-red-600',
            default      => 'bg-gray-100 text-gray-500'
        };
        $si = match($p->status) {
            'pending'    => '⏳',
            'diproses'   => '👨‍🍳',
            'siap'       => '✅',
            'selesai'    => '🎉',
            'dibatalkan' => '❌',
            default      => '❓'
        };
    @endphp
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b border-gray-50">
            <div>
                <p class="font-bold text-gray-800">{{ $p->kode_pesanan }}</p>
                <p class="text-gray-400 text-xs mt-0.5">
                    {{ $p->mahasiswa->nama }} · {{ $p->stand->nama }} · {{ $p->created_at->format('d M Y H:i') }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="{{ $p->tipe === 'dine-in' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }} text-xs font-medium px-3 py-1 rounded-full">
                    {{ $p->tipe === 'dine-in' ? '🪑 Dine In' : '🛍️ Take Away' }}
                </span>
                <span class="{{ $sc }} text-xs font-medium px-3 py-1 rounded-full">
                    {{ $si }} {{ ucfirst($p->status) }}
                </span>
            </div>
        </div>
        <div class="p-4 space-y-1.5">
            @foreach($p->details as $d)
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">{{ $d->nama_menu }} <span class="text-gray-400">×{{ $d->qty }}</span></span>
                <span class="font-medium text-gray-700">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
        <div class="flex items-center justify-between p-4 bg-gray-50 border-t border-gray-100">
            <span class="font-bold text-green-700">Rp {{ number_format($p->total, 0, ',', '.') }}</span>
            <form action="/admin/pesanan/{{ $p->id }}" method="POST"
                  onsubmit="return confirm('Hapus pesanan ini?')">
                @csrf
                @method('DELETE')
                <button class="bg-red-50 text-red-500 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">🗑️ Hapus</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection