@extends('penjual.layout')

@section('title', 'Tambah Menu — Go.Canteen')

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="/penjual/menu" class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center hover:bg-gray-200">←</a>
    <h1 class="text-2xl font-bold text-gray-800">➕ Tambah Menu</h1>
</div>

<div class="bg-white rounded-2xl border border-gray-100 p-6 max-w-lg">
    <form action="/penjual/menu" method="POST" autocomplete="off">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Nama Menu *</label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Contoh: Nasi Goreng Spesial"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Kategori *</label>
                <select name="kategori_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none">
                    <option value="">Pilih kategori</option>
                    @foreach($kategoris as $k)
                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                        {{ $k->emoji }} {{ $k->nama }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="2" placeholder="Deskripsi menu..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none resize-none">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Harga *</label>
                    <input type="number" name="harga" value="{{ old('harga') }}" placeholder="15000" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Stok *</label>
                    <input type="number" name="stok" value="{{ old('stok') }}" placeholder="50" min="0"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none"/>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Emoji Menu</label>
                <input type="hidden" name="emoji" id="emojiInput" value="{{ old('emoji', '🍽️') }}"/>
                <div class="relative">
                    <button type="button" onclick="toggleEmojiPicker()"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-left bg-white flex items-center gap-3 hover:border-green-400 transition-all">
                        <span id="emojiPreview" class="text-2xl">{{ old('emoji', '🍽️') }}</span>
                        <span class="text-sm text-gray-400">Klik untuk pilih emoji</span>
                    </button>
                    <div id="emojiPicker" class="hidden absolute top-full left-0 mt-2 bg-white border border-gray-200 rounded-2xl p-3 shadow-lg z-50 w-full">
                        <div class="flex flex-wrap gap-1">
                            @foreach(['🍽️','🍛','🍜','🍝','🍲','🥘','🍱','🍣','🍔','🌮','🌯','🥗','🍕','🥪','🍟','🍗','🥩','🍖','🥚','🧆','🥙','🫔','🍘','🧁','🍩','🍰','🎂','🍦','🍧','🥤','🧃','🧋','☕','🫖','🍵','🥛','🍿','🧇','🥞','🧈'] as $e)
                            <button type="button" onclick="pilihEmoji('{{ $e }}')"
                                    class="text-2xl p-2 hover:bg-gray-100 rounded-xl transition-all">{{ $e }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <input type="checkbox" name="tersedia" id="tersedia" checked class="w-4 h-4 accent-green-700"/>
                <label for="tersedia" class="text-sm text-gray-600 cursor-pointer">Menu tersedia</label>
            </div>
            <div class="flex gap-3 pt-2">
                <a href="/penjual/menu" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl font-medium text-sm text-center hover:bg-gray-200">Batal</a>
                <button type="submit" class="flex-1 py-3 bg-green-700 text-white rounded-xl font-semibold text-sm hover:bg-green-800">💾 Simpan</button>
            </div>
        </div>
    </form>
</div>
<script>
function toggleEmojiPicker() {
    document.getElementById('emojiPicker').classList.toggle('hidden');
}
function pilihEmoji(emoji) {
    document.getElementById('emojiInput').value = emoji;
    document.getElementById('emojiPreview').textContent = emoji;
    document.getElementById('emojiPicker').classList.add('hidden');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('#emojiPicker') && !e.target.closest('button[onclick="toggleEmojiPicker()"]')) {
        document.getElementById('emojiPicker').classList.add('hidden');
    }
});
</script>
@endsection