<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPERPUS DTEI UM</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen overflow-hidden">
    <div id="loadingOverlay" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/70 backdrop-blur-sm opacity-0 transition-opacity duration-300">
        <div class="flex flex-col items-center rounded-3xl border border-white/10 bg-white/95 px-8 py-7 shadow-2xl">
            <div class="h-12 w-12 animate-spin rounded-full border-4 border-slate-200 border-t-blue-600"></div>
            <p class="mt-4 text-sm font-semibold text-slate-700">Sedang masuk...</p>
        </div>
    </div>

    {{-- Background --}}
    <div class="fixed inset-0 overflow-hidden">
        {{-- Background Image --}}
        <img src="{{ asset('asset/um.jpg') }}" class="absolute inset-0 w-full h-full object-cover scale-110 opacity-25">

        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-black/70 via-slate-950/80 to-black/75">
        </div>
    </div>

    <main class="relative z-10 flex min-h-screen items-center justify-center px-6">
        <div class="w-full max-w-[430px] rounded-[28px] bg-white p-10 shadow-2xl">

            {{-- Logo --}}
            <div class="text-center mb-10">
                <img src="{{ asset('asset/logo.png') }}" class="mx-auto w-16 mb-5">
                <h1 class="text-3xl font-bold tracking-wide">
                    SIPERPUS
                </h1>
                <p class="mt-2 text-sm text-slate-500">
                    Sistem Informasi Perpustakaan<br>
                    Departemen Teknik Elektro dan Informatika
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">
                    @foreach($errors->all() as $error)
                        <p class="text-sm text-red-600">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                {{-- Username --}}
                <div class="relative">
                    <input id="username" name="username" type="text" value="{{ old('username') }}" required placeholder=" " autocomplete="username" class="peer w-full rounded-2xl bg-slate-100 px-5 pt-6 pb-2 outline-none transition focus:bg-white focus:ring-2 focus:ring-blue-600">
                    <label for="username" class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 transition-all duration-200 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-xs peer-focus:-translate-y-0 peer-focus:text-blue-600 peer-not-placeholder-shown:top-2 peer-not-placeholder-shown:text-xs peer-not-placeholder-shown:-translate-y-0">
                        Username
                    </label>
                </div>

                {{-- Password --}}
                <div class="relative">
                    <input id="password" name="password" type="password" required placeholder=" " autocomplete="current-password" class="peer w-full rounded-2xl bg-slate-100 px-5 pt-6 pb-2 outline-none transition focus:bg-white focus:ring-2 focus:ring-blue-600">
                    <label for="password" class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-500 transition-all duration-200 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-xs peer-focus:-translate-y-0 peer-focus:text-blue-600 peer-not-placeholder-shown:top-2 peer-not-placeholder-shown:text-xs peer-not-placeholder-shown:-translate-y-0">
                        Password
                    </label>
                </div>

                @php
                    $angka1 = rand(1,9);
                    $angka2 = rand(1,9);
                    session(['captcha_hasil' => $angka1 + $angka2]);
                @endphp

                {{-- Captcha --}}
                <div class="flex gap-3">
                    <div class="flex w-28 items-center justify-center rounded-2xl bg-slate-100 font-semibold text-slate-700">
                        {{ $angka1 }} + {{ $angka2 }}
                    </div>

                    <input id="captcha" type="number" name="captcha" required min="0" max="18" inputmode="numeric" autocomplete="off" placeholder="Jawaban" class="flex-1 rounded-2xl bg-slate-100 px-5 py-4 outline-none transition focus:bg-white focus:ring-2 focus:ring-blue-600">
                </div>

                {{-- Button --}}
                <div class="flex justify-center pt-4">
                    <button id="loginButton" type="submit" class="group flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-600 transition-all duration-300 hover:bg-blue-700 hover:text-white hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25 active:scale-95">
                        <svg id="loginArrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-6 w-6 transition-transform duration-300 group-hover:translate-x-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- Script Animasi & Logika Form --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('loginForm');
            const button = document.getElementById('loginButton');
            const arrow = document.getElementById('loginArrow');
            const overlay = document.getElementById('loadingOverlay');
            
            // Array dari input yang ada secara berurutan
            const inputs = [
                document.getElementById('username'),
                document.getElementById('password'),
                document.getElementById('captcha')
            ];

            let overlayTimer = null;

            const showOverlay = () => {
                clearTimeout(overlayTimer);
                overlayTimer = setTimeout(() => {
                    overlay.classList.remove('hidden');
                    overlay.classList.add('flex');
                    requestAnimationFrame(() => {
                        overlay.classList.remove('opacity-0');
                        overlay.classList.add('opacity-100');
                    });
                }, 180);
            };

            const hideOverlay = () => {
                clearTimeout(overlayTimer);
                overlay.classList.remove('opacity-100');
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    overlay.classList.remove('flex');
                }, 300);
            };

            // Fungsi untuk mengubah tampilan tombol seperti di-hover
            const setButtonActive = () => {
                button.classList.remove('bg-slate-100', 'text-slate-600');
                button.classList.add('bg-blue-700', 'text-white', 'scale-105', 'shadow-lg', 'shadow-blue-500/25');
                arrow.classList.add('translate-x-1');
            };

            // Saat pengguna menekan tombol di dalam form
            form.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    // Cari input mana yang sedang aktif (di-focus)
                    const activeIndex = inputs.indexOf(document.activeElement);
                    
                    // Jika yang aktif BUKAN input terakhir (captcha)
                    if (activeIndex > -1 && activeIndex < inputs.length - 1) {
                        e.preventDefault(); // Cegah form submit
                        inputs[activeIndex + 1].focus(); // Pindah fokus ke input berikutnya
                    }
                    // Jika di input terakhir (captcha), biarkan default behavior (submit form)
                }
            });

            // Saat form disubmit (termasuk saat Enter di kolom captcha atau klik tombol)
            form.addEventListener('submit', () => {
                setButtonActive();
                showOverlay();
                
                // Pilihan opsional: menghilangkan fokus dari input (keyboard di HP akan turun)
                document.activeElement.blur(); 
            });

            window.addEventListener('pageshow', () => {
                hideOverlay();
                
                // Reset tombol jika user menekan tombol 'Back' di browser
                button.classList.add('bg-slate-100', 'text-slate-600');
                button.classList.remove('bg-blue-700', 'text-white', 'scale-105', 'shadow-lg', 'shadow-blue-500/25');
                arrow.classList.remove('translate-x-1');
            });
            
            const captcha = document.getElementById('captcha');

            captcha.addEventListener('input', function () {
                // Hanya mengizinkan angka saat copy-paste/ketik cepat
                this.value = this.value.replace(/\D/g, '');
            });

            captcha.addEventListener('keypress', function (e) {
                // Izinkan angka (0-9) ATAU tombol Enter
                if (!/[0-9]/.test(e.key) && e.key !== 'Enter') {
                    e.preventDefault();
                }
            });

            captcha.addEventListener('paste', function (e) {
                e.preventDefault();
                const text = (e.clipboardData || window.clipboardData)
                    .getData('text')
                    .replace(/\D/g, '');
                document.execCommand('insertText', false, text);
            });
        });
    </script>
</body>
</html>