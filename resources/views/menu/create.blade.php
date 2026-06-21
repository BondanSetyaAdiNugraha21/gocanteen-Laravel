<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu — Go.Canteen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-lg mx-auto">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('menu.index') }}"
               class="bg-gray-200 text-gray-600 px-3 py-2 rounded-xl hover:bg-gray-300">←</a>
            <h1 class="text-2xl font-bold text-gray-800">➕ Tambah Menu</h1>
        </div>

        @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded-xl mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow p-6">
            <form action="{{ route('menu.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Menu *</label>
                        <input type="text" name="nama" value="{{ old('nama') }}"
                               placeholder="cth: Nasi Goreng Spesial"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:border-purple-500 focus:outline-none"/>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Emoji</label>
                        <input type="text" name="emoji" value="{{ old('emoji', '🍽️') }}"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:border-purple-500 focus:outline-none"/>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="2"
                                  placeholder="Deskripsi singkat menu..."
                                  class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:border-purple-500 focus:outline-none resize-none">{{ old('deskripsi') }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Harga (Rp) *</label>
                            <input type="number" name="harga" value="{{ old('harga') }}"
                                   placeholder="15000" min="0"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:border-purple-500 focus:outline-none"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Stok *</label>
                            <input type="number" name="stok" value="{{ old('stok', 0) }}"
                                   min="0"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:border-purple-500 focus:outline-none"/>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kategori *</label>
                        <select name="kategori_id"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:border-purple-500 focus:outline-none">
                            <option value=""> Pilih Kategori</option>
                            @foreach($kategoris as $kat)
                            <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->emoji }} {{ $kat->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="tersedia" id="tersedia"
                               {{ old('tersedia', true) ? 'checked' : '' }}
                               class="w-4 h-4 accent-purple-500"/>
                        <label for="tersedia" class="text-sm text-gray-600 cursor-pointer"> Tersedia</label>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <a href="{{ route('menu.index') }}"
                           class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl font-semibold text-sm text-center hover:bg-gray-200">
                            Batal
                        </a>
                        <button type="submit"
                                class="flex-1 py-3 bg-purple-600 text-white rounded-xl font-bold text-sm hover:bg-purple-700">
                            💾 Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>