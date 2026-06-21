@extends('layout')

@section('title', 'Beri Review — Go.Canteen')

@section('content')
<div class="min-h-screen bg-gray-50">
    <nav class="bg-white border-b border-gray-100 px-6 py-4">
        <div class="max-w-2xl mx-auto flex items-center gap-3">
            <a href="/riwayat" class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center hover:bg-gray-200">←</a>
            <span class="font-bold text-gray-800">⭐ Beri Review</span>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-6 py-8">
        <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-5">
            <p class="text-xs text-gray-400 mb-1">Pesanan dari {{ $pesanan->stand->nama }}</p>
            <p class="font-bold text-gray-800">{{ $pesanan->kode_pesanan }}</p>
        </div>

        <form action="/review/{{ $pesanan->id }}" method="POST">
            @csrf
            <div class="space-y-4">
                @foreach($pesanan->details as $detail)
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-3xl">{{ $detail->menu->emoji ?? '🍽️' }}</span>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $detail->nama_menu }}</p>
                            <p class="text-xs text-gray-400">{{ $detail->qty }}x · Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Bintang -->
                    <p class="text-sm text-gray-500 mb-2">Rating:</p>
                    <div class="flex gap-2 mb-4" id="stars-{{ $detail->menu_id }}">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button"
                                onclick="setRating({{ $detail->menu_id }}, {{ $i }})"
                                class="star-btn text-3xl text-gray-300 hover:text-yellow-400 transition-all"
                                data-menu="{{ $detail->menu_id }}" data-val="{{ $i }}">
                            ★
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating[{{ $detail->menu_id }}]" id="rating-{{ $detail->menu_id }}" value="">

                    <!-- Komentar -->
                    <textarea name="komentar[{{ $detail->menu_id }}]"
                              placeholder="Tulis komentarmu (opsional)..."
                              rows="2"
                              class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-green-500 focus:outline-none resize-none"></textarea>
                </div>
                @endforeach
            </div>

            <button type="submit"
                    class="w-full mt-5 py-3.5 bg-green-700 text-white rounded-xl font-bold text-sm hover:bg-green-800 transition-colors">
                ⭐ Kirim Review
            </button>
        </form>
    </div>
</div>

<script>
function setRating(menuId, val) {
    document.getElementById('rating-' + menuId).value = val;
    document.querySelectorAll(`[data-menu="${menuId}"]`).forEach(btn => {
        btn.style.color = parseInt(btn.dataset.val) <= val ? '#FBBF24' : '#D1D5DB';
    });
}
</script>
@endsection