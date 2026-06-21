@extends('admin.layout')

@section('title', 'Edit Mahasiswa — Go.Canteen')

@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="/admin/mahasiswa" class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors">←</a>
    <h1 class="text-2xl font-bold text-gray-800">✏️ Edit Mahasiswa</h1>
</div>

@if($errors->any())
<div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-5 text-sm">
    <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-2xl border border-gray-100 p-6 max-w-lg">
    <form action="/admin/mahasiswa/{{ $mahasiswa->id }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">NIM *</label>
                <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Nama Lengkap *</label>
                <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama) }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Email *</label>
                <input type="email" name="email" value="{{ old('email', $mahasiswa->email) }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Password <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" placeholder="Minimal 6 karakter"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="aktif" id="aktif"
                       {{ old('aktif', $mahasiswa->aktif) ? 'checked' : '' }}
                       class="w-4 h-4 accent-green-700"/>
                <label for="aktif" class="text-sm text-gray-600 cursor-pointer">Akun aktif</label>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="/admin/mahasiswa" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl font-medium text-sm text-center hover:bg-gray-200">Batal</a>
                <button type="submit" class="flex-1 py-3 bg-green-700 text-white rounded-xl font-semibold text-sm hover:bg-green-800 transition-colors">💾 Update</button>
            </div>
        </div>
    </form>
</div>

@endsection