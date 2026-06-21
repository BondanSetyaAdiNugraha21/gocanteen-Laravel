@extends('penjual.layout')

@section('title', 'Pesanan Masuk — Go.Canteen')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl md:text-2xl font-bold text-gray-800">📋 Pesanan Masuk</h1>
    <span class="bg-green-100 text-green-700 font-semibold px-4 py-1.5 rounded-xl text-sm">
        {{ $pesanans->count() }} pesanan
    </span>
</div>

@if($pesanans->isEmpty())
<div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
    <div class="text-5xl mb-3">📋</div>
    <p class="text-gray-400">Belum ada pesanan masuk</p>
</div>
@else
<div class="space-y-4">
    @foreach($pesanans as $p)
    @php
        $statusColor = match($p->status) {
            'pending'    => 'bg-yellow-100 text-yellow-700',
            'diproses'   => 'bg-blue-100 text-blue-700',
            'siap'       => 'bg-green-100 text-green-700',
            'selesai'    => 'bg-gray-100 text-gray-600',
            'dibatalkan' => 'bg-red-100 text-red-600',
            default      => 'bg-gray-100 text-gray-600'
        };
        $statusLabel = match($p->status) {
            'pending'    => '⏳ Pending',
            'diproses'   => '👨‍🍳 Diproses',
            'siap'       => '✅ Siap',
            'selesai'    => '🎉 Selesai',
            'dibatalkan' => '❌ Dibatalkan',
            default      => $p->status
        };
    @endphp
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

        {{-- Header kartu --}}
        <div class="p-4 border-b border-gray-50">
            {{-- Baris 1: Kode + Waktu --}}
            <div class="flex items-center justify-between mb-2">
                <span class="font-bold text-green-700 text-sm">{{ $p->kode_pesanan }}</span>
                <span class="text-xs text-gray-400">{{ $p->created_at->format('d M, H:i') }}</span>
            </div>
            {{-- Baris 2: Badge status + tipe + metode --}}
            <div class="flex flex-wrap gap-2">
                <span class="text-xs px-2.5 py-1 rounded-lg {{ $statusColor }} font-medium">
                    {{ $statusLabel }}
                </span>
                <span class="text-xs px-2.5 py-1 rounded-lg bg-gray-100 text-gray-500 font-medium">
                    {{ $p->tipe === 'dine-in' ? '🪑 '.$p->meja?->nomor : '🛍️ Take Away' }}
                </span>
                <span class="text-xs px-2.5 py-1 rounded-lg bg-gray-100 text-gray-500 font-medium">
                    {{ $p->metode_bayar === 'qris' ? '📱 QRIS' : '💵 Cash' }}
                </span>
            </div>
        </div>

        {{-- Isi pesanan --}}
        <div class="p-4">
            <p class="text-sm font-medium text-gray-700 mb-3">
                👤 {{ $p->mahasiswa->nama ?? '-' }}
            </p>
            <div class="space-y-1.5 mb-3">
                @foreach($p->details as $d)
                <div class="flex justify-between text-sm text-gray-600">
                    <span>{{ $d->nama_menu }} × {{ $d->qty }}</span>
                    <span class="font-medium">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>

            {{-- Footer: Total + Ganti Status --}}
            <div class="flex items-center justify-between pt-3 border-t border-gray-50 gap-3">
                <span class="font-bold text-gray-800 text-sm">
                    Total: Rp {{ number_format($p->total, 0, ',', '.') }}
                </span>
                @if(!in_array($p->status, ['selesai', 'dibatalkan']))
                <form action="/penjual/pesanan/{{ $p->id }}/status" method="POST">
                    @csrf
                    <select name="status" onchange="this.form.submit()"
                            class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:border-green-500 focus:outline-none bg-white">
                        <option value="pending"    {{ $p->status === 'pending'    ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="diproses"   {{ $p->status === 'diproses'   ? 'selected' : '' }}>👨‍🍳 Diproses</option>
                        <option value="siap"       {{ $p->status === 'siap'       ? 'selected' : '' }}>✅ Siap</option>
                        <option value="selesai"    {{ $p->status === 'selesai'    ? 'selected' : '' }}>🎉 Selesai</option>
                        <option value="dibatalkan" {{ $p->status === 'dibatalkan' ? 'selected' : '' }}>❌ Batalkan</option>
                    </select>
                </form>
                @endif
            </div>
        </div>

    </div>
    @endforeach
</div>
@endif
@endsection

@section('scripts')
<script>
setInterval(function() { location.reload(); }, 15000);
</script>
@endsection