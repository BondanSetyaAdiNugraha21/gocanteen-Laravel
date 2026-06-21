@extends('penjual.layout')

@section('title', 'Kelola Menu — Go.Canteen')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl md:text-2xl font-bold text-gray-800">🍽️ Kelola Menu</h1>
    <a href="/penjual/menu/create"
       class="bg-green-700 text-white px-4 py-2 md:px-5 md:py-2.5 rounded-xl text-sm font-semibold hover:bg-green-800 transition-colors">
        + Tambah
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
    {{ session('success') }}
</div>
@endif

@if($menus->isEmpty())
<div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
    <div class="text-5xl mb-3">🍽️</div>
    <p class="text-gray-400 mb-4">Belum ada menu</p>
    <a href="/penjual/menu/create" class="bg-green-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-800">
        + Tambah Menu Pertama
    </a>
</div>
@else

{{-- Tampilan MOBILE: Card --}}
<div class="md:hidden space-y-3">
    @foreach($menus as $menu)
    <div class="bg-white rounded-2xl border border-gray-100 p-4">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-3">
                <span class="text-3xl">{{ $menu->emoji }}</span>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">{{ $menu->nama }}</p>
                    <p class="text-xs text-gray-400">{{ $menu->kategori->nama ?? '-' }}</p>
                </div>
            </div>
            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $menu->tersedia ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $menu->tersedia ? 'Tersedia' : 'Nonaktif' }}
            </span>
        </div>
        <div class="flex items-center justify-between mb-3">
            <p class="font-bold text-green-700 text-sm">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $menu->stok > 5 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                Stok: {{ $menu->stok }}
            </span>
        </div>
        <div class="flex gap-2 pt-3 border-t border-gray-50">
            <a href="/penjual/menu/{{ $menu->id }}/edit"
               class="flex-1 text-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium hover:bg-blue-100">
                ✏️ Edit
            </a>
            <form action="/penjual/menu/{{ $menu->id }}" method="POST"
                  class="flex-1" onsubmit="return confirm('Hapus menu ini?')">
                @csrf @method('DELETE')
                <button class="w-full px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium hover:bg-red-100">
                    🗑️ Hapus
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

{{-- Tampilan DESKTOP: Tabel --}}
<div class="hidden md:block bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase">Menu</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase">Kategori</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase">Harga</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase">Stok</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase">Status</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($menus as $menu)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">{{ $menu->emoji }}</span>
                        <span class="font-medium text-gray-800">{{ $menu->nama }}</span>
                    </div>
                </td>
                <td class="px-5 py-3 text-gray-500">{{ $menu->kategori->nama ?? '-' }}</td>
                <td class="px-5 py-3 font-semibold text-green-700">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                <td class="px-5 py-3">
                    <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $menu->stok > 5 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                        {{ $menu->stok }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $menu->tersedia ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $menu->tersedia ? 'Tersedia' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-2 justify-end">
                        <a href="/penjual/menu/{{ $menu->id }}/edit"
                           class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium hover:bg-blue-100">Edit</a>
                        <form action="/penjual/menu/{{ $menu->id }}" method="POST"
                              onsubmit="return confirm('Hapus menu ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium hover:bg-red-100">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection