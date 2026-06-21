@extends('admin.layout')

@section('title', 'Tambah Penjual — Go.Canteen')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="/admin/penjual" class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200">←</a>
    <h1 class="text-2xl font-bold text-gray-800">➕ Tambah Penjual</h1>
</div>

<div class="bg-white rounded-2xl border border-gray-100 p-6 max-w-lg">
    <form action="/admin/penjual" method="POST" autocomplete="off">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Nama *</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama penjual"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@stand.com"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Stand *</label>
                <select name="stand_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none">
                    <option value="">Pilih stand</option>
                    @foreach($stands as $s)
                    <option value="{{ $s->id }}" {{ old('stand_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->emoji }} {{ $s->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Password *</label>
                <div style="position:relative">
                    <input type="password" name="password" id="passwordInput" placeholder="Minimal 6 karakter" autocomplete="new-password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
                    <button type="button" onclick="togglePassword()"
                            style="position:absolute;right:14px;top:50%;transform:translateY(-50%);font-size:16px;line-height:1;background:none;border:none;cursor:pointer;padding:0;color:#9ca3af;">
                        <span id="eyeIcon">👁</span>
                    </button>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="/admin/penjual" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl font-medium text-sm text-center hover:bg-gray-200">Batal</a>
                <button type="submit" class="flex-1 py-3 bg-green-700 text-white rounded-xl font-semibold text-sm hover:bg-green-800">💾 Simpan</button>
            </div>
        </div>
    </form>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    input.type  = input.type === 'password' ? 'text' : 'password';
    icon.textContent = input.type === 'password' ? '👁' : '🙈';
}
</script>
@endsection