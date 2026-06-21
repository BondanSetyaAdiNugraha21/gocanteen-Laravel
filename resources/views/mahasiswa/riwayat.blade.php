@extends('layout')

@section('title', 'Riwayat Pesanan — Go.Canteen')

@section('content')
<div class="min-h-screen bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 px-4 sm:px-6 py-3 sm:py-4">
        <div class="max-w-3xl mx-auto flex items-center justify-between gap-2">
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <a href="/stand" class="w-8 h-8 shrink-0 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200">←</a>
                <span class="font-bold text-gray-800 text-sm sm:text-base truncate">📋 Riwayat Pesanan</span>
            </div>
            <a href="/logout" class="text-xs sm:text-sm text-gray-400 hover:text-gray-600 shrink-0">Keluar</a>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
        <div class="flex items-center justify-between mb-6 gap-2 flex-wrap">
            <h1 class="text-lg sm:text-xl font-bold text-gray-800">Halo, {{ session('mhs_nama') }}! 👋</h1>
            <span class="bg-green-100 text-green-700 font-semibold px-3 sm:px-4 py-1.5 rounded-xl text-xs sm:text-sm whitespace-nowrap">
                {{ count($pesanans) }} pesanan
            </span>
        </div>

        @if($pesanans->isEmpty())
        <div class="text-center py-20">
            <div class="text-5xl mb-3">📋</div>
            <p class="text-gray-400">Belum ada pesanan</p>
            <a href="/stand" class="mt-4 inline-block bg-green-700 text-white px-6 py-2.5 rounded-xl font-medium text-sm hover:bg-green-800 transition-colors">
                Pesan Sekarang →
            </a>
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
                $statusIcon = match($p->status) {
                    'pending'    => '⏳',
                    'diproses'   => '👨‍🍳',
                    'siap'       => '✅',
                    'selesai'    => '🎉',
                    'dibatalkan' => '❌',
                    default      => '❓'
                };
            @endphp
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden" data-status="{{ $p->status }}">
                <div class="flex items-center justify-between p-4 border-b border-gray-50">
                    <div>
                        <p class="font-bold text-gray-800">{{ $p->kode_pesanan }}</p>
                        <p class="text-gray-400 text-xs mt-0.5">
                            {{ $p->stand->nama }} · {{ $p->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="{{ $p->tipe === 'dine-in' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }} text-xs font-medium px-3 py-1 rounded-full">
                            {{ $p->tipe === 'dine-in' ? '🪑 Dine In' : '🛍️ Take Away' }}
                        </span>
                        <span class="{{ $statusColor }} text-xs font-medium px-3 py-1 rounded-full">
                            {{ $statusIcon }} {{ ucfirst($p->status) }}
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
                <div class="bg-gray-50 px-4 py-3 flex justify-between items-center">
                    <span class="text-gray-400 text-sm">{{ count($p->details) }} item</span>
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-green-700">Rp {{ number_format($p->total, 0, ',', '.') }}</span>
                        @if($p->status === 'selesai')
                        @php
                            $sudahReview = $p->details->first() && \App\Models\Review::where('pesanan_id', $p->id)->exists();
                        @endphp
                        @if($sudahReview)
                            <span class="text-xs text-gray-400 bg-gray-100 px-3 py-1.5 rounded-xl">✅ Diulas</span>
                        @else
                            <a href="/review/{{ $p->id }}"
                               class="text-xs bg-yellow-400 text-yellow-900 font-semibold px-3 py-1.5 rounded-xl hover:bg-yellow-500 transition-colors">
                                ⭐ Beri Review
                            </a>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>
@section('scripts')
<script>
// Auto refresh setiap 10 detik untuk update status pesanan
setInterval(function() {
    // Hanya refresh kalau ada pesanan yang masih aktif (pending/diproses/siap)
    const activeStatus = document.querySelectorAll('[data-status="pending"], [data-status="diproses"], [data-status="siap"]');
    if (activeStatus.length > 0) {
        location.reload();
    }
}, 10000);
</script>
@endsection

@endsection