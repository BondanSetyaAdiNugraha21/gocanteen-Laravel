@extends('admin.layout')

@section('title', 'Kelola Penjual — Go.Canteen')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl md:text-2xl font-bold text-gray-800">🧑‍🍳 Kelola Penjual</h1>
    <a href="/admin/penjual/create"
       class="bg-green-700 text-white px-4 py-2 md:px-5 md:py-2.5 rounded-xl text-sm font-semibold hover:bg-green-800 transition-colors">
        + Tambah
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">{{ session('success') }}</div>
@endif

@if($penjuals->isEmpty())
<div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
    <div class="text-5xl mb-3">🧑‍🍳</div>
    <p class="text-gray-400 mb-4">Belum ada akun penjual</p>
    <a href="/admin/penjual/create" class="bg-green-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-800">
        + Tambah Penjual
    </a>
</div>
@else

{{-- Tampilan MOBILE: Card --}}
<div class="md:hidden space-y-3">
    @foreach($penjuals as $p)
    <div class="bg-white rounded-2xl border border-gray-100 p-4">
        <div class="flex items-start justify-between mb-2">
            <div>
                <p class="font-bold text-gray-800 text-sm">{{ $p->name }}</p>
                <p class="text-gray-400 text-xs mt-0.5">{{ $p->email }}</p>
            </div>
            <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                {{ $p->stand->nama ?? 'Belum dikaitkan' }}
            </span>
        </div>
        <div class="flex gap-2 mt-3 pt-3 border-t border-gray-50">
            <a href="/admin/penjual/{{ $p->id }}/edit"
               class="flex-1 text-center px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium hover:bg-blue-100">
               ✏️ Edit
            </a>
            <form action="/admin/penjual/{{ $p->id }}" method="POST"
                  class="flex-1" onsubmit="return confirm('Hapus akun penjual ini?')">
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
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase">Nama</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase">Email</th>
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase">Stand</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($penjuals as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-medium text-gray-800">{{ $p->name }}</td>
                <td class="px-5 py-3 text-gray-500">{{ $p->email }}</td>
                <td class="px-5 py-3">
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-medium">
                        {{ $p->stand->nama ?? 'Belum dikaitkan' }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-2 justify-end">
                        <a href="/admin/penjual/{{ $p->id }}/edit"
                           class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-medium hover:bg-blue-100">Edit</a>
                        <form action="/admin/penjual/{{ $p->id }}" method="POST"
                              onsubmit="return confirm('Hapus akun penjual ini?')">
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