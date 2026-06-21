@extends('layout')

@section('title', 'Menu — Go.Canteen')

@section('styles')
<style>
    .menu-card { transition: all .2s; }
    .menu-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.08); }
    .cart-slide { transition: right .3s cubic-bezier(.4,0,.2,1); }
</style>
@endsection

@section('content')
<div class="min-h-screen bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 px-4 sm:px-6 py-3 sm:py-4 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto flex items-center justify-between gap-2">
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <a href="/stand" class="w-8 h-8 shrink-0 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-colors">←</a>
                <div class="min-w-0">
                    <span class="font-bold text-gray-800 text-sm sm:text-base truncate block">{{ $stand->emoji }} {{ $stand->nama }}</span>
                    <p class="text-xs text-gray-400 hidden sm:block">Go.Canteen</p>
                </div>
            </div>
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <a href="/riwayat" class="text-xs sm:text-sm text-green-700 font-medium whitespace-nowrap">📋 <span class="hidden sm:inline">Riwayat</span></a>
                <button onclick="toggleCart()"
                        class="relative bg-green-700 text-white px-3 sm:px-4 py-2 rounded-xl text-xs sm:text-sm font-medium hover:bg-green-800 transition-colors whitespace-nowrap">
                    🛒 <span class="hidden sm:inline">Keranjang</span>
                    <span id="cartCount" class="absolute -top-1 -right-1 bg-yellow-400 text-yellow-900 text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">0</span>
                </button>
                <a href="/logout" class="text-xs sm:text-sm text-gray-400 hover:text-gray-600 hidden sm:inline">Keluar</a>
            </div>
        </div>
    </nav>

    <!-- Tipe Pesanan -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 sm:py-4">
            <div class="flex gap-2 sm:gap-3">
                <button onclick="setTipe('dine-in')" id="btnDineIn"
                        class="flex-1 sm:flex-initial flex items-center justify-center gap-2 px-3 sm:px-4 py-2 rounded-xl border-2 border-green-700 bg-green-700 text-white font-medium text-xs sm:text-sm transition-all">
                    🪑 Dine In
                </button>
                <button onclick="setTipe('takeaway')" id="btnTakeaway"
                        class="flex-1 sm:flex-initial flex items-center justify-center gap-2 px-3 sm:px-4 py-2 rounded-xl border-2 border-gray-200 text-gray-500 font-medium text-xs sm:text-sm hover:border-green-300 transition-all">
                    🛍️ Take Away
                </button>
            </div>
            <div id="takeawayBox" class="hidden mt-3">
                <input type="text" id="namaPemesan" placeholder="Masukkan nama pemesan..."
                       class="border border-gray-200 rounded-xl px-4 py-2 text-sm focus:border-green-500 focus:outline-none w-full sm:max-w-xs"/>
            </div>
            <div id="mejaBox" class="mt-3">
                <p class="text-sm text-gray-500 mb-2">Pilih Meja:</p>
                <div id="mejaGrid" class="grid grid-cols-3 sm:flex sm:flex-wrap gap-2">
                    <span class="text-xs text-gray-400 col-span-3">Memuat meja...</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Kategori -->
    <div class="bg-white border-b border-gray-100 sticky top-[57px] sm:top-16 z-30">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex gap-2 overflow-x-auto">
            <button onclick="filterKat('0', this)"
                    class="kat-btn whitespace-nowrap px-4 py-2 rounded-xl text-sm font-medium bg-green-700 text-white transition-all">
                Semua
            </button>
            @foreach($kategoris as $kat)
            <button onclick="filterKat('{{ $kat->id }}', this)"
                    class="kat-btn whitespace-nowrap px-4 py-2 rounded-xl text-sm font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all"
                    data-kat="{{ $kat->id }}">
                {{ $kat->emoji }} {{ $kat->nama }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-6">
        @if($menus->isEmpty())
        <div class="text-center py-20">
            <div class="text-5xl mb-3">🍽️</div>
            <p class="text-gray-400">Belum ada menu tersedia</p>
        </div>
        @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4" id="menuGrid">
            @foreach($menus as $menu)
            <div class="menu-card bg-white rounded-2xl border border-gray-100 overflow-hidden"
                 data-kat="{{ $menu->kategori_id }}">
                <div class="bg-gray-50 h-28 flex items-center justify-center">
                    <span class="text-5xl">{{ $menu->emoji }}</span>
                </div>
                <div class="p-3">
                    <h4 class="font-semibold text-gray-800 text-sm mb-1">{{ $menu->nama }}</h4>
                    <p class="text-xs text-gray-400 mb-2">{{ $menu->deskripsi }}</p>
                    <p class="text-xs text-green-600 mb-1">Stok: {{ $menu->stok }}</p>
                    @php
                        $avgRating = \App\Models\Review::where('menu_id', $menu->id)->avg('rating');
                        $countRating = \App\Models\Review::where('menu_id', $menu->id)->count();
                    @endphp
                    @if($countRating > 0)
                    <button onclick="lihatUlasan({{ $menu->id }}, '{{ addslashes($menu->nama) }}')"
                            class="text-xs text-yellow-600 hover:text-yellow-700 mb-2 flex items-center gap-1">
                        <span class="text-yellow-400">★</span>
                        {{ number_format($avgRating, 1) }} ({{ $countRating }} ulasan)
                    </button>
                    @else
                    <p class="text-xs text-gray-300 mb-2">Belum ada ulasan</p>
                    @endif
                    <div class="flex flex-col gap-2">
                        <span class="font-bold text-green-700 text-sm">
                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </span>
                        <div class="flex items-center justify-end gap-1">
                            <button onclick="decreaseFromCard({{ $menu->id }})"
                                    id="btn-minus-{{ $menu->id }}"
                                    style="display:none"
                                    class="bg-gray-100 text-gray-600 w-7 h-7 rounded-lg shrink-0 flex items-center justify-center active:bg-red-100 font-bold text-sm transition-all">
                                −
                            </button>
                            <span id="badge-{{ $menu->id }}"
                                  style="display:none"
                                  class="bg-green-700 text-white text-xs font-bold w-7 h-7 rounded-lg shrink-0 flex items-center justify-center">
                                0
                            </span>
                            <button onclick="addToCart({{ $menu->id }}, '{{ addslashes($menu->nama) }}', {{ $menu->harga }}, {{ $menu->stok }})"
                                    id="btn-add-{{ $menu->id }}"
                                    class="bg-green-700 text-white w-7 h-7 rounded-lg shrink-0 flex items-center justify-center active:bg-green-800 transition-colors font-bold text-base">
                                +
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>

<!-- Cart Sidebar -->
<div id="cartSidebar" style="right:-420px" class="fixed top-0 bottom-0 w-[400px] max-w-[95vw] bg-white shadow-2xl z-50 cart-slide flex flex-col">
    <div class="bg-green-700 text-white p-5 flex items-center justify-between">
        <h3 class="font-bold text-lg">🛒 Keranjang</h3>
        <button onclick="closeCart()" class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30">✕</button>
    </div>
    <div id="cartItems" class="flex-1 overflow-y-auto p-4 space-y-3">
        <div class="text-center py-16 text-gray-400">
            <div class="text-4xl mb-2">🛒</div>
            <p class="text-sm">Keranjang kosong</p>
        </div>
    </div>
    <div id="cartFooter" class="hidden border-t p-4 space-y-3">
        <div class="flex justify-between text-sm text-gray-500">
            <span>Subtotal</span>
            <span id="subtotalEl">Rp 0</span>
        </div>
        <div id="packRow" class="hidden flex justify-between text-sm text-gray-500">
            <span>Biaya kemasan</span>
            <span>Rp 2.000</span>
        </div>
        <div class="flex justify-between font-bold border-t pt-3">
            <span>Total</span>
            <span id="totalEl" class="text-green-700">Rp 0</span>
        </div>
        <!-- Metode Pembayaran -->
        <div>
            <p class="text-sm font-semibold text-gray-700 mb-2">💳 Metode Pembayaran</p>
            <div class="flex gap-2">
                <button onclick="setMetodeBayar('cash', this)" id="btnCash"
                        class="metode-btn flex-1 py-2.5 rounded-xl border-2 border-green-700 bg-green-700 text-white text-sm font-medium transition-all">
                    💵 Cash
                </button>
                <button onclick="setMetodeBayar('qris', this)" id="btnQris"
                        class="metode-btn flex-1 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 text-sm font-medium transition-all">
                    📱 QRIS
                </button>
            </div>
            <div id="infoCash" class="mt-2 bg-yellow-50 border border-yellow-200 rounded-xl px-3 py-2 text-xs text-yellow-700">
                💡 Bayar langsung di kasir saat pesanan siap
            </div>
            <div id="infoQris" class="hidden mt-2 bg-blue-50 border border-blue-200 rounded-xl px-3 py-2 text-xs text-blue-700">
                📲 Scan QRIS penjual, lalu tunjukkan bukti bayar ke penjual
            </div>
        </div>
        <button onclick="submitOrder()"
                class="w-full py-3 bg-green-700 text-white rounded-xl font-semibold hover:bg-green-800 transition-colors">
            Konfirmasi Pesanan →
        </button>
    </div>
</div>
<div id="overlay" onclick="closeCart()" class="hidden fixed inset-0 bg-black/40 z-40"></div>

<!-- Success Modal -->
<!-- Modal Ulasan -->
<div id="ulasanModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4" style="z-index:9999">
    <div class="bg-white rounded-2xl w-full max-w-sm shadow-2xl flex flex-col" style="max-height:85vh">
        <div class="p-5 border-b border-gray-100 flex justify-between items-center">
            <div>
                <h3 class="font-bold text-gray-800" id="ulasanMenuNama"></h3>
                <p class="text-xs text-gray-400 mt-0.5" id="ulasanRatingSummary"></p>
            </div>
            <button onclick="document.getElementById('ulasanModal').classList.add('hidden')"
                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-200">✕</button>
        </div>
        <div id="ulasanList" class="overflow-y-auto p-4 space-y-3 flex-1">
            <p class="text-center text-gray-400 text-sm py-8">Memuat ulasan...</p>
        </div>
    </div>
</div>

<!-- QRIS Modal -->
<div id="qrisModal" class="hidden fixed inset-0 bg-black/60 flex items-center justify-center p-4" style="z-index:9999">
    <div class="bg-white rounded-3xl w-full max-w-sm shadow-2xl flex flex-col" style="max-height:90vh">
        <!-- Header -->
        <div class="p-5 text-center border-b border-gray-100">
            <div class="text-xl font-bold text-gray-800">Scan QRIS</div>
            <p class="text-sm text-gray-400 mt-1">Scan QR code di bawah untuk membayar</p>
        </div>
        <!-- Scrollable body -->
        <div class="overflow-y-auto p-5 flex flex-col items-center gap-4">
            <!-- QR Code Image -->
            <div class="bg-gray-50 rounded-2xl p-3 flex items-center justify-center w-full">
                <img src="/images/qris.png" alt="QRIS" class="w-48 h-48 object-contain"
                     onerror="this.style.display='none';document.getElementById('qrisPlaceholder').style.display='flex'"/>
                <div id="qrisPlaceholder" style="display:none"
                     class="w-48 h-48 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center text-gray-400">
                    <div class="text-4xl mb-2">📱</div>
                    <p class="text-xs">Gambar QRIS belum dipasang</p>
                </div>
            </div>
            <div class="bg-green-50 rounded-xl px-4 py-3 w-full text-center">
                <p class="text-xs text-gray-500 mb-1">Total Pembayaran</p>
                <p class="text-2xl font-bold text-green-700" id="qrisNominal"></p>
            </div>
            <div class="bg-blue-50 rounded-xl px-4 py-2.5 w-full text-xs text-blue-700">
                📋 Setelah bayar, <strong>tunjukkan bukti transfer</strong> ke penjual
            </div>
        </div>
        <!-- Footer button -->
        <div class="p-4 border-t border-gray-100">
            <button onclick="document.getElementById('qrisModal').classList.add('hidden');document.getElementById('successModal').classList.remove('hidden')"
                    class="w-full bg-green-700 text-white font-bold py-3.5 rounded-xl hover:bg-green-800 transition-all">
                ✅ Sudah Bayar
            </button>
        </div>
    </div>
</div>

<div id="successModal" class="hidden fixed inset-0 bg-black/40 flex items-center justify-center p-4" style="z-index:9999">
    <div class="bg-white rounded-2xl p-8 w-full max-w-sm text-center">
        <div class="text-5xl mb-3">🎉</div>
        <h3 class="font-bold text-xl mb-2">Pesanan Berhasil!</h3>
        <p class="text-gray-500 text-sm mb-1">Kode Pesanan:</p>
        <p class="font-bold text-green-700 text-xl mb-1" id="successKode"></p>
        <p class="font-semibold text-gray-700 mb-5" id="successTotal"></p>
        <div class="flex gap-3">
            <button onclick="closeSuccess()" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl font-medium text-sm">Pesan Lagi</button>
            <a href="/riwayat" class="flex-1 py-3 bg-green-700 text-white rounded-xl font-semibold text-sm text-center">Riwayat</a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
let cart = [];
let tipe = 'dine-in';
let mejaId = null;
let metodeBayar = 'cash';
const standId = {{ $stand->id }};

function setMetodeBayar(metode, el) {
    metodeBayar = metode;
    document.querySelectorAll('.metode-btn').forEach(b => {
        b.className = 'metode-btn flex-1 py-2.5 rounded-xl border-2 border-gray-200 text-gray-600 text-sm font-medium transition-all';
    });
    el.className = 'metode-btn flex-1 py-2.5 rounded-xl border-2 border-green-700 bg-green-700 text-white text-sm font-medium transition-all';
    document.getElementById('infoCash').classList.toggle('hidden', metode !== 'cash');
    document.getElementById('infoQris').classList.toggle('hidden', metode !== 'qris');
}

async function lihatUlasan(menuId, menuNama) {
    document.getElementById('ulasanMenuNama').textContent = menuNama;
    document.getElementById('ulasanRatingSummary').textContent = 'Memuat...';
    document.getElementById('ulasanList').innerHTML = '<p class="text-center text-gray-400 text-sm py-8">Memuat ulasan...</p>';
    document.getElementById('ulasanModal').classList.remove('hidden');

    const res = await fetch('/review/menu/' + menuId);
    const d   = await res.json();

    document.getElementById('ulasanRatingSummary').textContent =
        d.count > 0 ? '★ ' + d.avg + ' · ' + d.count + ' ulasan' : 'Belum ada ulasan';

    if (d.reviews.length === 0) {
        document.getElementById('ulasanList').innerHTML =
            '<p class="text-center text-gray-400 text-sm py-8">Belum ada ulasan untuk menu ini</p>';
        return;
    }

    document.getElementById('ulasanList').innerHTML = d.reviews.map(r => `
        <div class="bg-gray-50 rounded-xl p-3">
            <div class="flex justify-between items-center mb-1">
                <span class="font-medium text-sm text-gray-800">${r.nama}</span>
                <span class="text-yellow-400 text-sm">${'★'.repeat(r.rating)}${'☆'.repeat(5-r.rating)}</span>
            </div>
            ${r.komentar ? `<p class="text-xs text-gray-500">${r.komentar}</p>` : ''}
            <p class="text-xs text-gray-300 mt-1">${r.tanggal}</p>
        </div>
    `).join('');
}

async function loadMeja() {
    const res = await fetch('/pesanan/meja');
    const mejas = await res.json();
    const grid = document.getElementById('mejaGrid');
    if (mejas.length === 0) {
        grid.innerHTML = '<span class="text-xs text-red-400 col-span-3">Semua meja sedang terpakai</span>';
        return;
    }
    grid.innerHTML = mejas.map(m => `
        <button onclick="pilihMeja(${m.id}, this)"
                class="meja-btn px-2 sm:px-4 py-2 rounded-xl border-2 border-gray-200 text-xs sm:text-sm font-medium text-gray-600 hover:border-green-400 transition-all text-center truncate">
            🪑 ${m.nomor}
        </button>
    `).join('');
}

function pilihMeja(id, el) {
    mejaId = id;
    document.querySelectorAll('.meja-btn').forEach(b => {
        b.className = 'meja-btn px-2 sm:px-4 py-2 rounded-xl border-2 border-gray-200 text-xs sm:text-sm font-medium text-gray-600 hover:border-green-400 transition-all text-center truncate';
    });
    el.className = 'meja-btn px-2 sm:px-4 py-2 rounded-xl border-2 border-green-700 bg-green-700 text-white text-xs sm:text-sm font-medium transition-all text-center truncate';
}

function setTipe(t) {
    tipe = t;
    const dine = document.getElementById('btnDineIn');
    const take = document.getElementById('btnTakeaway');
    const box  = document.getElementById('takeawayBox');
    const pack = document.getElementById('packRow');

    if (t === 'dine-in') {
        dine.className = 'flex items-center gap-2 px-4 py-2 rounded-xl border-2 border-green-700 bg-green-700 text-white font-medium text-sm transition-all';
        take.className = 'flex items-center gap-2 px-4 py-2 rounded-xl border-2 border-gray-200 text-gray-500 font-medium text-sm hover:border-green-300 transition-all';
        box.classList.add('hidden');
        if(pack) pack.classList.add('hidden');
        document.getElementById('mejaBox').classList.remove('hidden');
    } else {
        take.className = 'flex items-center gap-2 px-4 py-2 rounded-xl border-2 border-green-700 bg-green-700 text-white font-medium text-sm transition-all';
        dine.className = 'flex items-center gap-2 px-4 py-2 rounded-xl border-2 border-gray-200 text-gray-500 font-medium text-sm hover:border-green-300 transition-all';
        box.classList.remove('hidden');
        if(pack) pack.classList.remove('hidden');
        document.getElementById('mejaBox').classList.add('hidden');
        mejaId = null;
    }
    renderCart();
}

function addToCart(id, nama, harga, stok) {
    const ex = cart.find(c => c.id === id);
    if (ex) {
        if (ex.qty >= stok) { alert('Stok tidak cukup!'); return; }
        ex.qty++;
    } else {
        cart.push({id, nama, harga, stok, qty: 1});
    }
    updateCardBadge(id);
    renderCart();
}

function decreaseFromCard(id) {
    const idx = cart.findIndex(c => c.id === id);
    if (idx < 0) return;
    cart[idx].qty--;
    if (cart[idx].qty <= 0) cart.splice(idx, 1);
    updateCardBadge(id);
    renderCart();
}

function updateCardBadge(id) {
    const item = cart.find(c => c.id === id);
    const badge = document.getElementById('badge-' + id);
    const btnMinus = document.getElementById('btn-minus-' + id);
    if (item && item.qty > 0) {
        badge.textContent = item.qty;
        badge.style.display = 'flex';
        btnMinus.style.display = 'flex';
    } else {
        if (badge) badge.style.display = 'none';
        if (btnMinus) btnMinus.style.display = 'none';
    }
}

function openCart() {
    const s = document.getElementById('cartSidebar');
    s.style.right = '0px';
    s.setAttribute('data-open','1');
    document.getElementById('overlay').classList.remove('hidden');
}

function closeCart() {
    const s = document.getElementById('cartSidebar');
    s.style.right = '-420px';
    s.setAttribute('data-open','0');
    document.getElementById('overlay').classList.add('hidden');
}

function changeQty(id, d) {
    const idx = cart.findIndex(c => c.id === id);
    if (idx < 0) return;
    cart[idx].qty += d;
    if (cart[idx].qty <= 0) cart.splice(idx, 1);
    renderCart();
}

function renderCart() {
    const count = cart.reduce((s, c) => s + c.qty, 0);
    document.getElementById('cartCount').textContent = count;

    const items  = document.getElementById('cartItems');
    const footer = document.getElementById('cartFooter');

    if (cart.length === 0) {
        items.innerHTML = '<div class="text-center py-16 text-gray-400"><div class="text-4xl mb-2">🛒</div><p class="text-sm">Keranjang kosong</p></div>';
        footer.classList.add('hidden');
        closeCart();
        return;
    }

    footer.classList.remove('hidden');
    const sub   = cart.reduce((s, c) => s + c.harga * c.qty, 0);
    const pack  = tipe === 'takeaway' ? 2000 : 0;
    const total = sub + pack;

    document.getElementById('subtotalEl').textContent = fmt(sub);
    document.getElementById('totalEl').textContent    = fmt(total);

    items.innerHTML = cart.map(c => `
        <div class="flex items-center gap-3 bg-gray-50 rounded-xl p-3">
            <div class="flex-1">
                <p class="font-medium text-sm text-gray-800">${c.nama}</p>
                <p class="text-green-700 text-xs font-bold">${fmt(c.harga)} × ${c.qty}</p>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="changeQty(${c.id},-1)" class="w-7 h-7 rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-red-50 font-bold text-sm flex items-center justify-center">−</button>
                <span class="w-6 text-center font-bold text-sm">${c.qty}</span>
                <button onclick="changeQty(${c.id},1)" class="w-7 h-7 rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-green-50 font-bold text-sm flex items-center justify-center">+</button>
            </div>
        </div>
    `).join('');
}

function fmt(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

function toggleCart() {
    const s = document.getElementById('cartSidebar');
    if (s.getAttribute('data-open') === '1') { closeCart(); } else { openCart(); }
}

async function submitOrder() {
    if (cart.length === 0) { alert('Keranjang kosong!'); return; }
    if (tipe === 'dine-in' && !mejaId) { alert('Pilih meja terlebih dahulu!'); return; }
    if (tipe === 'takeaway') {
        const nm = document.getElementById('namaPemesan')?.value.trim();
        if (!nm) { alert('Masukkan nama pemesan!'); return; }
    }

    const info = tipe === 'dine-in' ? 'Dine In' : document.getElementById('namaPemesan').value.trim();
    const fd   = new FormData();
    fd.append('cart', JSON.stringify(cart));
    fd.append('tipe', tipe);
    fd.append('info', info);
    fd.append('stand_id', standId);
    if (mejaId) fd.append('meja_id', mejaId);
    fd.append('metode_bayar', metodeBayar);
    fd.append('_token', '{{ csrf_token() }}');

    const r = await fetch('/pesanan/proses', {method: 'POST', body: fd});
    const d = await r.json();

    if (d.success) {
        cart = []; renderCart(); closeCart();
        document.getElementById('successKode').textContent  = d.kode;
        document.getElementById('successTotal').textContent = d.total;
        if (metodeBayar === 'qris') {
            document.getElementById('qrisNominal').textContent = d.total;
            document.getElementById('qrisModal').classList.remove('hidden');
        } else {
            document.getElementById('successModal').classList.remove('hidden');
        }
    } else {
        alert('❌ ' + d.message);
    }
}

function closeSuccess() {
    document.getElementById('successModal').classList.add('hidden');
}

loadMeja();

function filterKat(id, el) {
    document.querySelectorAll('.kat-btn').forEach(b => {
        b.className = 'kat-btn whitespace-nowrap px-4 py-2 rounded-xl text-sm font-medium bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all';
    });
    el.className = 'kat-btn whitespace-nowrap px-4 py-2 rounded-xl text-sm font-medium bg-green-700 text-white transition-all';
    document.querySelectorAll('.menu-card').forEach(c => {
        c.style.display = (id === '0' || c.dataset.kat === id) ? 'block' : 'none';
    });
}
</script>
@endsection