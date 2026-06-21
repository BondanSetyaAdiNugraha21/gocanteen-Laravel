@extends('admin.layout')

@section('title', 'Kelola Meja — Go.Canteen')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">🪑 Kelola Meja</h1>
    <span class="bg-green-100 text-green-700 font-semibold px-4 py-1.5 rounded-xl text-sm">
        {{ $mejas->count() }} meja
    </span>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Form Tambah Meja -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-bold text-gray-800 mb-4">➕ Tambah Meja</h2>
        <form action="/admin/meja" method="POST" class="flex gap-3">
            @csrf
            <input type="text" name="nomor" placeholder="Contoh: Meja 11" autocomplete="off"
                   class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            <button type="submit"
                    class="bg-green-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-800 transition-colors">
                Tambah
            </button>
        </form>
        @if($errors->has('nomor'))
        <p class="text-red-500 text-xs mt-2">{{ $errors->first('nomor') }}</p>
        @endif
    </div>

    <!-- Statistik -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-bold text-gray-800 mb-4">📊 Status Meja</h2>
        <div class="flex gap-4">
            <div class="flex-1 bg-green-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-green-700">{{ $mejas->where('tersedia', true)->count() }}</p>
                <p class="text-xs text-gray-500 mt-1">Tersedia</p>
            </div>
            <div class="flex-1 bg-red-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $mejas->where('tersedia', false)->count() }}</p>
                <p class="text-xs text-gray-500 mt-1">Terpakai</p>
            </div>
            <div class="flex-1 bg-gray-50 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-gray-700">{{ $mejas->count() }}</p>
                <p class="text-xs text-gray-500 mt-1">Total</p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Meja -->
<div class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
    @foreach($mejas as $meja)
    <div class="bg-white rounded-2xl border {{ $meja->tersedia ? 'border-gray-100' : 'border-red-200' }} p-4 text-center">
        <div class="text-3xl mb-2">🪑</div>
        <p class="font-semibold text-gray-800 text-sm mb-1">{{ $meja->nomor }}</p>
        <span class="text-xs px-2 py-1 rounded-full font-medium {{ $meja->tersedia ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
            {{ $meja->tersedia ? 'Tersedia' : 'Terpakai' }}
        </span>
        <div class="flex gap-2 mt-3 justify-center">
            <form action="/admin/meja/{{ $meja->id }}/toggle" method="POST">
                @csrf
                <button type="submit"
                        class="px-2 py-1 text-xs rounded-lg {{ $meja->tersedia ? 'bg-yellow-50 text-yellow-600 hover:bg-yellow-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                    {{ $meja->tersedia ? '🔒 Kunci' : '🔓 Bebaskan' }}
                </button>
            </form>
            <form action="/admin/meja/{{ $meja->id }}" method="POST"
                  onsubmit="return confirm('Hapus {{ $meja->nomor }}?')">
                @csrf @method('DELETE')
                <button class="px-2 py-1 text-xs bg-red-50 text-red-600 rounded-lg hover:bg-red-100">🗑️</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection