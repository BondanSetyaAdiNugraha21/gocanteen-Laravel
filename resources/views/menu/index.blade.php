<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu — Go.Canteen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">🍛 Kelola Menu</h1>
            <a href="/menu/create"
               class="bg-purple-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-purple-700">
                + Tambah Menu
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="text-left px-5 py-3 text-sm font-bold text-gray-500">No</th>
                        <th class="text-left px-5 py-3 text-sm font-bold text-gray-500">Menu</th>
                        <th class="text-left px-5 py-3 text-sm font-bold text-gray-500">Harga</th>
                        <th class="text-left px-5 py-3 text-sm font-bold text-gray-500">Stok</th>
                        <th class="text-left px-5 py-3 text-sm font-bold text-gray-500">Status</th>
                        <th class="text-left px-5 py-3 text-sm font-bold text="gray-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($menus as $i => $menu)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3 text-sm text-gray-500">{{ $i+1 }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xl mr-2">{{ $menu->emoji }}</span>
                            <span class="font-semibold text-gray-800">{{ $menu->nama }}</span>
                            <p class="text-xs text-gray-400">{{ $menu->deskripsi }}</p>
                        </td>
                        <td class="px-5 py-3 text-purple-600 font-bold text-sm">
                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3 text-sm">{{ $menu->stok }}</td>
                        <td class="px-5 py-3">
                            <span class="text-xs font-bold px-3 py-1 rounded-full
                                {{ $menu->tersedia ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $menu->tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </td>
                        <td class="px-5 py-3">
                            <div class="flex gap-2">
                                <a href="/menu/{{ $menu->id }}/edit"
                                   class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg text-xs font-bold hover:bg-blue-200">
                                    ✏️ Edit
                                </a>
                                <form action="/menu/{{ $menu->id }}" method="POST"
                                      onsubmit="return confirm('Hapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs font-bold hover:bg-red-200">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>