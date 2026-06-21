@extends('admin.layout')

@section('title', 'Tambah Mahasiswa — Go.Canteen')

@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="/admin/mahasiswa" class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200 transition-colors">←</a>
    <h1 class="text-2xl font-bold text-gray-800">➕ Tambah Mahasiswa</h1>
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
    <form action="/admin/mahasiswa" method="POST" autocomplete="off">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">NIM *</label>
                <input type="text" name="nim" autocomplete="off" value="{{ old('nim') }}" placeholder="NIM mahasiswa"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Nama Lengkap *</label>
                <input type="text" name="nama" autocomplete="off" value="{{ old('nama') }}" placeholder="Nama lengkap"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Email *</label>
                <input type="email" name="email" autocomplete="off" value="{{ old('email') }}" placeholder="email@student.com"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            </div>
            <div>
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Password *</label>
            <div style="position:relative">
                <input type="password" name="password" id="passwordInput" autocomplete="new-password" placeholder="Minimal 6 karakter"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
                <button type="button" onclick="togglePassword()"
                        style="position:absolute; right:14px; top:50%; transform:translateY(-50%); font-size:16px; line-height:1; background:none; border:none; cursor:pointer; padding:0; color:#9ca3af;">
                    <span id="eyeIcon">👁</span>
                </button>
            </div>
        </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="aktif" id="aktif" checked class="w-4 h-4 accent-green-700"/>
                <label for="aktif" class="text-sm text-gray-600 cursor-pointer">Akun aktif</label>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="/admin/mahasiswa" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl font-medium text-sm text-center hover:bg-gray-200">Batal</a>
                <button type="submit" class="flex-1 py-3 bg-green-700 text-white rounded-xl font-semibold text-sm hover:bg-green-800 transition-colors">💾 Simpan</button>
            </div>
        </div>
    </form>
</div>


<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = '🙈';
    } else {
        input.type = 'password';
        icon.textContent = '👁';
    }
}
</script>
@endsection