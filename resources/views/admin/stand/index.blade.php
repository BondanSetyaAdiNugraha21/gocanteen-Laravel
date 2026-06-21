@extends('admin.layout')

@section('title', 'Kelola Stand — Go.Canteen')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">🏪 Kelola Stand</h1>
    <a href="/admin/stand/create"
       class="bg-green-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-800 transition-colors">
        + Tambah Stand
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">{{ session('success') }}</div>
@endif

@if($stands->isEmpty())
<div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
    <div class="text-5xl mb-3">🏪</div>
    <p class="text-gray-400 mb-4">Belum ada stand</p>
    <a href="/admin/stand/create" class="bg-green-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-800">
        + Tambah Stand Pertama
    </a>
</div>
@else
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($stands as $stand)
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-4xl">{{ $stand->emoji }}</span>
            <span class="text-xs px-2 py-1 rounded-full font-medium {{ $stand->aktif ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                {{ $stand->aktif ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
        <h3 class="font-bold text-gray-800 mb-1">{{ $stand->nama }}</h3>
        <p class="text-xs text-gray-400 mb-3">{{ $stand->deskripsi ?? '-' }}</p>
        <p class="text-xs text-gray-400 mb-4">{{ $stand->menus_count }} menu</p>
        <div class="flex gap-2">
            <a href="/admin/stand/{{ $stand->id }}/edit"
               class="flex-1 py-2 text-center bg-blue-50 text-blue-600 rounded-xl text-xs font-medium hover:bg-blue-100">
                ✏️ Edit
            </a>
            <form action="/admin/stand/{{ $stand->id }}" method="POST"
                  onsubmit="return confirm('Hapus stand {{ $stand->nama }}? Semua menu di stand ini juga akan terhapus!')">
                @csrf @method('DELETE')
                <button class="px-4 py-2 bg-red-50 text-red-600 rounded-xl text-xs font-medium hover:bg-red-100">
                    🗑️
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif
@endsection