@extends('layout')

@section('title', 'Pilih Stand — Go.Canteen')

@section('content')
<div class="min-h-screen bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 px-4 sm:px-6 py-3 sm:py-4">
        <div class="max-w-4xl mx-auto flex items-center justify-between gap-2">
            <div class="flex items-center gap-2 shrink-0">
                <span class="text-xl">🍽️</span>
                <span class="font-bold text-gray-800 text-sm sm:text-base">Go<span class="text-green-700">.</span>Canteen</span>
            </div>
            <div class="flex items-center gap-2 sm:gap-4 min-w-0">
                <span class="text-xs sm:text-sm text-gray-500 truncate hidden sm:inline">👋 {{ session('mhs_nama') }}</span>
                <a href="/riwayat" class="text-xs sm:text-sm text-green-700 font-medium hover:text-green-800 whitespace-nowrap">📋 <span class="hidden sm:inline">Riwayat</span></a>
                <a href="/logout" class="text-xs sm:text-sm text-gray-400 hover:text-gray-600 whitespace-nowrap">Keluar</a>
            </div>
        </div>
    </nav>

    <!-- Sapaan untuk mobile -->
    <div class="sm:hidden bg-white border-b border-gray-100 px-4 py-2">
        <p class="text-xs text-gray-500 truncate">👋 Hai, {{ session('mhs_nama') }}</p>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-6 sm:py-10">
        <div class="text-center mb-6 sm:mb-10">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">Pilih Stand</h1>
            <p class="text-gray-500 text-sm">Pilih stand yang ingin kamu pesan</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
            @foreach($stands as $stand)
            <a href="/menu/{{ $stand->id }}"
               class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6 hover:border-green-300 hover:shadow-md transition-all group">
                <div class="text-4xl mb-3 sm:mb-4">{{ $stand->emoji }}</div>
                <h3 class="font-bold text-gray-800 mb-1">{{ $stand->nama }}</h3>
                <p class="text-gray-400 text-sm mb-4">{{ $stand->deskripsi }}</p>
                <span class="text-xs text-green-600 font-medium flex items-center gap-1">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span> Buka
                </span>
            </a>
            @endforeach
        </div>
    </div>

</div>
@endsection