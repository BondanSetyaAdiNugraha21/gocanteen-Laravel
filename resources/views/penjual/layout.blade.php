<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Penjual — Go.Canteen')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
    <style>
        body { font-family: 'Segoe UI', sans-serif; }
        #sidebar { transition: transform 0.3s ease; }
        #overlay { transition: opacity 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 flex min-h-screen">

    <!-- Overlay (mobile) -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-white border-r border-gray-100 fixed top-0 left-0 bottom-0 flex flex-col z-50 transform -translate-x-full md:translate-x-0">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-xl">🍽️</span>
                <div>
                    <p class="font-bold text-gray-800">Go<span class="text-green-700">.</span>Canteen</p>
                    <p class="text-xs text-gray-400">Panel Penjual</p>
                </div>
            </div>
            <!-- Tombol tutup sidebar (mobile) -->
            <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            @php $cur = request()->path(); @endphp
            @foreach([
                ['penjual/dashboard','📊', 'Dashboard'],
                ['penjual/pesanan', '📋', 'Pesanan Masuk'],
                ['penjual/menu',    '🍽️', 'Kelola Menu'],
                ['penjual/stok',    '📦', 'Kelola Stok'],
                ['penjual/laporan', '📈', 'Laporan'],
            ] as [$path, $icon, $label])
            <a href="/{{ $path }}"
               onclick="closeSidebarOnMobile()"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all
                      {{ str_starts_with($cur, $path) ? 'bg-green-700 text-white' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                <span>{{ $icon }}</span> {{ $label }}
            </a>
            @endforeach
            <div class="border-t border-gray-100 my-2"></div>
            <a href="/logout"
               class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-800 transition-all">
                <span>🚪</span> Keluar
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3">
                <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center font-bold text-white text-sm">
                    {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ Auth::user()->name ?? 'Penjual' }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->stand->nama ?? 'Stand' }}</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col md:ml-64">
        <!-- Top navbar (mobile) -->
        <header class="md:hidden bg-white border-b border-gray-100 px-4 py-3 flex items-center justify-between sticky top-0 z-30">
            <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                <span class="text-lg">🍽️</span>
                <p class="font-bold text-gray-800 text-sm">Go<span class="text-green-700">.</span>Canteen</p>
            </div>
            <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center font-bold text-white text-sm">
                {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
            </div>
        </header>

        <main class="flex-1 p-4 md:p-8 overflow-y-auto">
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
                {{ session('success') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }
        }
        function closeSidebarOnMobile() {
            if (window.innerWidth < 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('overlay');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>

    @yield('scripts')
</body>
</html>