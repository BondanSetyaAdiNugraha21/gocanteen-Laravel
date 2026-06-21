@extends('penjual.layout')

@section('title', 'Kelola Stok — Go.Canteen')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">📦 Kelola Stok</h1>
        <p class="text-gray-400 text-sm mt-1">{{ $stand->emoji }} {{ $stand->nama }}</p>
    </div>
</div>

@if($stand->menus->isEmpty())
<div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
    <div class="text-5xl mb-3">📦</div>
    <p class="text-gray-400">Belum ada menu — tambah menu dulu</p>
</div>
@else
<div class="space-y-3">
    @foreach($stand->menus as $m)
    @php
        $habis = $m->stok == 0;
        $low   = $m->stok > 0 && $m->stok <= 5;
    @endphp
    <div class="bg-white rounded-2xl border {{ $habis ? 'border-red-200' : ($low ? 'border-yellow-200' : 'border-gray-100') }} p-4 flex items-center gap-4 flex-wrap">
        <span class="text-3xl">{{ $m->emoji }}</span>
        <div class="flex-1 min-w-0">
            <p class="font-semibold text-gray-800">{{ $m->nama }}</p>
            <p class="text-gray-400 text-xs">{{ $m->kategori->nama ?? '-' }}</p>
        </div>
        <span class="{{ $habis ? 'bg-red-100 text-red-600' : ($low ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-700') }} text-xs font-medium px-3 py-1 rounded-full">
            {{ $habis ? 'HABIS' : ($low ? "TIPIS: {$m->stok}" : "OK: {$m->stok}") }}
        </span>
        <form action="/penjual/stok/{{ $m->id }}" method="POST" class="flex items-center gap-2">
            @csrf
            <button type="button" onclick="adj(this,-5)" class="w-9 h-9 bg-gray-100 rounded-xl text-gray-600 hover:bg-gray-200 font-bold text-xs">−5</button>
            <button type="button" onclick="adj(this,-1)" class="w-9 h-9 bg-gray-100 rounded-xl text-gray-600 hover:bg-gray-200 font-bold text-lg">−</button>
            <input type="number" name="stok" value="{{ $m->stok }}" min="0"
                   class="w-20 border border-gray-200 text-center py-2 rounded-xl text-sm font-bold focus:border-green-500 focus:outline-none stok-inp"/>
            <button type="button" onclick="adj(this,1)" class="w-9 h-9 bg-gray-100 rounded-xl text-gray-600 hover:bg-gray-200 font-bold text-lg">+</button>
            <button type="button" onclick="adj(this,5)" class="w-9 h-9 bg-gray-100 rounded-xl text-gray-600 hover:bg-gray-200 font-bold text-xs">+5</button>
            <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-green-800">💾</button>
        </form>
    </div>
    @endforeach
</div>
@endif
@endsection

@section('scripts')
<script>
function adj(btn, d) {
    const inp = btn.closest('form').querySelector('.stok-inp');
    inp.value = Math.max(0, parseInt(inp.value || 0) + d);
}
</script>
@endsection