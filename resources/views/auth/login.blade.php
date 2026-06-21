@extends('layout')

@section('title', 'Login — Go.Canteen')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">

        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-700 rounded-2xl mb-4">
                <span class="text-3xl">🍽️</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Go<span class="text-green-700">.</span>Canteen</h1>
            <p class="text-gray-500 text-sm mt-1">Sistem Pemesanan Kantin Digital</p>
        </div>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-5 text-sm">
                {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="/login" autocomplete="off">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                            NIM
                        </label>
                        <input type="text" name="identity" placeholder="Masukkan NIM kamu"
                               value="{{ old('identity') }}" autocomplete="off"
                               class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-100"/>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                            Password
                        </label>
                        <div style="position:relative;">
                            <input type="password" name="password" id="passwordInput" placeholder="••••••••"
                                   autocomplete="new-password"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-100"
                                   style="padding-right:3rem;"/>
                            <button type="button" onclick="togglePassword()"
                                    style="position:absolute; right:14px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; padding:0; font-size:16px; color:#9ca3af; display:flex; align-items:center; justify-content:center;">
                                <span id="eyeIcon">👁</span>
                            </button>
                        </div>
                    </div>
                    <button type="submit"
                            class="w-full py-3 bg-green-700 text-white rounded-xl font-semibold text-sm hover:bg-green-800 transition-colors mt-2">
                        Masuk →
                    </button>
                </div>
            </form>

            <div class="mt-5 p-3 bg-gray-50 rounded-xl text-center">
                <p class="text-xs text-gray-400">Belum punya akun? Hubungi admin</p>
            </div>
        </div>

    </div>
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