@extends('admin.layout')

@section('title', 'Laporan Penjualan — Go.Canteen')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">📈 Laporan Penjualan</h1>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-gray-100 p-4 mb-6">
    <form method="GET" action="/admin/laporan" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase mb-1.5">Periode</label>
            <select name="periode" onchange="this.form.submit()" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none">
                <option value="hari"   {{ $periode === 'hari'   ? 'selected' : '' }}>Hari Ini</option>
                <option value="minggu" {{ $periode === 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="bulan"  {{ $periode === 'bulan'  ? 'selected' : '' }}>Bulan Ini</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase mb-1.5">Stand</label>
            <select name="stand_id" onchange="this.form.submit()" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none">
                <option value="">Semua Stand</option>
                @foreach($stands as $s)
                <option value="{{ $s->id }}" {{ $standId == $s->id ? 'selected' : '' }}>{{ $s->emoji }} {{ $s->nama }}</option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<!-- Ringkasan -->
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center">
        <p class="text-xs text-gray-400 mb-1">Total Pendapatan</p>
        <p class="text-3xl font-bold text-green-700">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center">
        <p class="text-xs text-gray-400 mb-1">Total Pesanan Selesai</p>
        <p class="text-3xl font-bold text-gray-800">{{ $totalPesanan }}</p>
    </div>
</div>

<!-- Grafik 7 hari -->
<div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-bold text-gray-800">📊 Tren Pendapatan 7 Hari Terakhir</h2>
        <span class="text-xs text-gray-400">Hover titik untuk detail</span>
    </div>
    <div style="height: 280px;">
        <canvas id="grafikPendapatan"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const labels = {!! json_encode($grafik->pluck('label')) !!};
    const totals = {!! json_encode($grafik->pluck('total')) !!};
    const counts = {!! json_encode($grafik->pluck('count')) !!};

    const ctx = document.getElementById('grafikPendapatan').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(21, 128, 61, 0.35)');
    gradient.addColorStop(1, 'rgba(21, 128, 61, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan',
                data: totals,
                borderColor: '#15803d',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#15803d',
                pointBorderWidth: 2,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#15803d',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1200,
                easing: 'easeOutQuart'
            },
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#15803d',
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        title: function(items) { return items[0].label; },
                        label: function(item) {
                            const total = item.raw;
                            const count = counts[item.dataIndex];
                            return ['Rp ' + total.toLocaleString('id-ID'), count + ' pesanan'];
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#9ca3af', font: { size: 11 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' },
                    ticks: {
                        color: '#9ca3af',
                        font: { size: 11 },
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'jt';
                            if (value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'rb';
                            return 'Rp ' + value;
                        }
                    }
                }
            }
        }
    });
})();
</script>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Pendapatan per Stand -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-bold text-gray-800 mb-4">🏪 Pendapatan per Stand</h2>
        @if($perStand->isEmpty())
        <p class="text-gray-400 text-sm text-center py-8">Belum ada data</p>
        @else
        <div class="space-y-3">
            @foreach($perStand as $s)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">{{ $s['emoji'] }}</span>
                    <div>
                        <p class="font-medium text-sm text-gray-800">{{ $s['nama'] }}</p>
                        <p class="text-xs text-gray-400">{{ $s['count'] }} pesanan</p>
                    </div>
                </div>
                <span class="font-bold text-green-700 text-sm">Rp {{ number_format($s['total'], 0, ',', '.') }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Menu Terlaris -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-bold text-gray-800 mb-4">🏆 Menu Terlaris</h2>
        @if($menuTerlaris->isEmpty())
        <p class="text-gray-400 text-sm text-center py-8">Belum ada data</p>
        @else
        <div class="space-y-3">
            @foreach($menuTerlaris as $i => $m)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 rounded-full {{ $i === 0 ? 'bg-yellow-400' : ($i === 1 ? 'bg-gray-300' : ($i === 2 ? 'bg-orange-400' : 'bg-gray-100')) }} flex items-center justify-center text-xs font-bold">
                        {{ $i + 1 }}
                    </span>
                    <p class="font-medium text-sm text-gray-800">{{ $m['nama'] }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-sm text-gray-800">{{ $m['qty'] }}x</p>
                    <p class="text-xs text-gray-400">Rp {{ number_format($m['total'], 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection