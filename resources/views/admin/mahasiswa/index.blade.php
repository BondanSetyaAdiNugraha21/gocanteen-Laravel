@extends('admin.layout')

@section('title', 'Mahasiswa — Go.Canteen')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">🎓 Data Mahasiswa</h1>
        <p class="text-gray-400 text-sm mt-1">{{ count($mahasiswas) }} mahasiswa terdaftar</p>
    </div>
    <a href="/admin/mahasiswa/create"
       class="bg-green-700 text-white px-4 py-2 md:px-5 md:py-2.5 rounded-xl font-medium text-sm hover:bg-green-800 transition-colors">
        + Tambah
    </a>
</div>

@if(session('success'))
<div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
    {{ session('success') }}
</div>
@endif

{{-- Tampilan MOBILE: Card --}}
<div class="md:hidden space-y-3">
    @forelse($mahasiswas as $i => $m)
    <div class="bg-white rounded-2xl border border-gray-100 p-4">
        <div class="flex items-start justify-between mb-2">
            <div>
                <p class="font-bold text-gray-800 text-sm">{{ $m->nama }}</p>
                <p class="text-green-700 font-semibold text-xs mt-0.5">{{ $m->nim }}</p>
                <p class="text-gray-400 text-xs mt-0.5">{{ $m->email }}</p>
            </div>
            <span class="{{ $m->aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }} text-xs font-medium px-2.5 py-1 rounded-full">
                {{ $m->aktif ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
        <div class="flex gap-2 mt-3 pt-3 border-t border-gray-50">
            <a href="/admin/mahasiswa/{{ $m->id }}/edit"
               class="flex-1 text-center bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                ✏️ Edit
            </a>
            <form action="/admin/mahasiswa/{{ $m->id }}" method="POST"
                  class="flex-1" onsubmit="return confirm('Hapus mahasiswa ini?')">
                @csrf
                @method('DELETE')
                <button class="w-full bg-red-50 text-red-500 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                    🗑️ Hapus
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="text-center py-12 text-gray-400 bg-white rounded-2xl border border-gray-100">
        Belum ada mahasiswa
    </div>
    @endforelse
</div>

{{-- Tampilan DESKTOP: Tabel --}}
<div class="hidden md:block bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    @foreach(['No', 'NIM', 'Nama', 'Email', 'Status', 'Aksi'] as $h)
                    <th class="text-left px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($mahasiswas as $i => $m)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-5 py-4 text-sm text-gray-400">{{ $i+1 }}</td>
                    <td class="px-5 py-4 font-bold text-green-700 text-sm">{{ $m->nim }}</td>
                    <td class="px-5 py-4 font-semibold text-gray-800 text-sm">{{ $m->nama }}</td>
                    <td class="px-5 py-4 text-gray-500 text-sm">{{ $m->email }}</td>
                    <td class="px-5 py-4">
                        <span class="{{ $m->aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }} text-xs font-medium px-3 py-1 rounded-full">
                            {{ $m->aktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex gap-2">
                            <a href="/admin/mahasiswa/{{ $m->id }}/edit"
                               class="bg-blue-50 text-blue-600 hover:bg-blue-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                ✏️ Edit
                            </a>
                            <form action="/admin/mahasiswa/{{ $m->id }}" method="POST"
                                  onsubmit="return confirm('Hapus mahasiswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-50 text-red-500 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-gray-400">Belum ada mahasiswa</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection