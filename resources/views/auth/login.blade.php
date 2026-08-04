<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPERPUS DTEI UM</title>
    @vite(['resources/css/app.css'])
    <style>
        /* CAPTCHA styles: modern, rounded, subtle shadow, SIPERPUS color accents */
        .captcha-box {
            border-radius: 12px;
            padding: 6px;
        }

        /* New premium CAPTCHA styles */
        .captcha-card {
            background: #ffffff;
            border: 1px solid rgba(226,232,240,0.8);
            border-radius: 12px;
            padding: 10px 12px;
            box-shadow: 0 10px 24px rgba(17,24,39,0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 200px;
        }

        .captcha-canvas {
            border-radius: 8px;
            background: transparent;
            display: block;
        }

        .captcha-refresh {
            width: 46px;
            height: 46px;
            min-width: 46px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #111827; /* dominant black */
            border: none;
            box-shadow: 0 10px 24px rgba(17,24,39,0.12);
            cursor: pointer;
            transition: transform .18s ease, filter .18s ease;
        }

        .captcha-refresh:hover {
            transform: translateY(-2px) scale(1.02);
            filter: brightness(1.06);
        }

        .captcha-refresh .icon {
            color: #ffffff;
            font-size: 18px;
            line-height: 1;
        }

        .captcha-input {
            border-radius: 20px;
            background: #ffffff;
            border: 1px solid #D1D5DB;
            padding: 16px 16px 12px;
            outline: none;
            color: #111827;
            box-shadow: none;
            font-family: Inter, Poppins, sans-serif;
            font-size: 0.96rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .captcha-input:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.12);
            background: #ffffff;
        }

        .captcha-input + label {
            pointer-events: none;
            position: absolute;
            left: 18px;
            top: 16px;
            color: #6b7280;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background: white;
            padding: 0 6px;
        }

        .captcha-input:focus + label,
        .captcha-input:not(:placeholder-shown) + label {
            top: 5px;
            left: 16px;
            font-size: 0.75rem;
            color: #2563EB;
        }

        .captcha-row { gap: 12px; align-items: center; }

        /* Sign-in button & helper styles */
        .btn-primary {
            width: 100%;
            height: 50px;
            border-radius: 14px;
            background: linear-gradient(180deg, #212A37 0%, #2F3D52 100%);
            color: #ffffff;
            border: none;
            box-shadow: 0 10px 24px rgba(47,61,82,0.12);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-weight: 600;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .btn-primary:hover {
            transform: scale(1.03);
            filter: brightness(1.06);
        }

        .btn-press {
            transform: scale(0.98) !important;
            box-shadow: 0 6px 18px rgba(33,42,55,0.08) !important;
        }

        .signin-helper {
            margin-top: 12px;
            text-align: center;
            color: #94a3b8; /* slate gray */
            font-size: 0.875rem;
        }

        .signin-link {
            color: #2563eb; /* blue */
            text-decoration: none;
            font-weight: 600;
            margin-left: 6px;
        }

        .signin-link:hover {
            text-decoration: underline;
        }

        footer.login-footer {
            margin-top: 18px;
            text-align: center;
            color: #94a3b8;
            font-size: 0.85rem;
        }
    </style>
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
                // Server-side initial captcha values (used for first render)
                    $angka1 = rand(1,20);
                    $angka2 = rand(1,30);
                $ops = ['+', '-'];
                $op = $ops[array_rand($ops)];
                $hasil = 0;
                if ($op === '+') $hasil = $angka1 + $angka2;
                else $hasil = $angka1 - $angka2;
                session(['captcha_hasil' => $hasil]);
                $expr = "$angka1 $op $angka2";
                @endphp

                {{-- Captcha (canvas image + refresh + input) --}}
                <div class="captcha-box">
                        <div class="flex items-center captcha-row">
                            <div class="captcha-card">
                                <canvas id="captchaCanvas" width="220" height="72" class="captcha-canvas"></canvas>
                            </div>

                            <button type="button" id="captchaRefresh" class="captcha-refresh" aria-label="Refresh Captcha">
                                <span class="icon">↻</span>
                            </button>
                        </div>

                        <div class="relative mt-4 captcha-field">
                            <input id="captcha" name="captcha" type="text" required inputmode="text" autocomplete="off" placeholder=" " class="w-full captcha-input">
                            <label for="captcha" class="captcha-label">Masukkan Jawaban</label>
                            <input id="captchaExpected" type="hidden" value="{{ session('captcha_hasil') }}" data-expr="{{ $expr }}">
                        </div>
                </div>

                {{-- Button --}}
                <div class="pt-6">
                    <button id="loginButton" type="submit" class="btn-primary" aria-label="Sign In">
                        <span>Sign In</span>
                        <svg id="loginArrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
            </form>
        </div>
    </main>

    <footer class="login-footer">© 2026 SIPERPUS - Sistem Informasi Perpustakaan</footer>

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
                // add pressed/active visual state
                button.classList.add('btn-press');
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
                button.classList.remove('btn-press');
                arrow.classList.remove('translate-x-1');
            });

            const captcha = document.getElementById('captcha');

            captcha.addEventListener('input', function() {
                // Allow digits, minus, and basic math characters
                this.value = this.value.replace(/[^0-9+\-*/xX]/g, '');
            });

            captcha.addEventListener('keypress', function(e) {
                // Allow digit, minus, plus, slash, asterisk, x, X, or Enter
                if (!/[0-9+\-*/xX]/.test(e.key) && e.key !== 'Enter') {
                    e.preventDefault();
                }
            });

            captcha.addEventListener('paste', function(e) {
                e.preventDefault();
                const text = (e.clipboardData || window.clipboardData)
                    .getData('text')
                    .replace(/[^0-9+\-*/xX]/g, '');
                document.execCommand('insertText', false, text);
            });
        });
    </script>
    <script>
        // CAPTCHA canvas rendering and refresh logic
        (function() {
            const canvas = document.getElementById('captchaCanvas');
            const refresh = document.getElementById('captchaRefresh');
            const expected = document.getElementById('captchaExpected');
            const input = document.getElementById('captcha');

            if (!canvas || !expected || !input) return;

            const ctx = canvas.getContext('2d');

            function rand(min, max) { return Math.floor(Math.random() * (max - min + 1)) + min; }

            function drawBackground() {
                // keep canvas transparent; card provides white background
                ctx.clearRect(0,0,canvas.width,canvas.height);
            }

            function drawNoise() {
                // subtle gray lines/dots to make OCR harder but keep premium look
                for (let i = 0; i < 4; i++) {
                    ctx.beginPath();
                    ctx.strokeStyle = `rgba(17,24,39,${(Math.random()*0.06+0.02).toFixed(3)})`;
                    ctx.lineWidth = rand(1,1.5);
                    ctx.moveTo(rand(0, canvas.width), rand(0, canvas.height));
                    ctx.lineTo(rand(0, canvas.width), rand(0, canvas.height));
                    ctx.stroke();
                }

                for (let i = 0; i < 24; i++) {
                    ctx.fillStyle = `rgba(17,24,39,${(Math.random()*0.06+0.02).toFixed(3)})`;
                    ctx.beginPath();
                    ctx.arc(rand(0, canvas.width), rand(0, canvas.height), Math.random()*1.2, 0, Math.PI*2);
                    ctx.fill();
                }
            }

            function drawText(expr) {
                const fontSize = 30;
                ctx.save();
                ctx.textBaseline = 'middle';
                ctx.textAlign = 'center';

                // Slight letter jitter & rotation for premium look
                const text = expr + ' = ?';
                const centerX = canvas.width / 2;
                const centerY = canvas.height / 2;

                for (let i = 0; i < text.length; i++) {
                    const ch = text[i];
                    const offset = (i - text.length/2) * (fontSize * 0.55);
                    ctx.save();
                    const x = centerX + offset + rand(-4,4);
                    const y = centerY + rand(-3,3);
                    ctx.translate(x, y);
                    ctx.rotate((rand(-8,8) * Math.PI) / 180);
                    ctx.font = `600 ${fontSize + rand(-2,2)}px Inter, Arial, sans-serif`;
                    ctx.fillStyle = '#111827';
                    ctx.fillText(ch, 0, 0);
                    ctx.restore();
                }

                ctx.restore();
            }

            function render(expr) {
                ctx.clearRect(0,0,canvas.width,canvas.height);
                drawBackground();
                drawNoise();
                drawText(expr);
            }

            function computeAnswer(expr) {
                // expr like '15 + 5' or '20 - 4'
                const m = expr.match(/(-?\d+)\s*([+\-xX*])\s*(-?\d+)/);
                if (!m) return 0;
                let a = parseInt(m[1], 10);
                const op = m[2];
                const b = parseInt(m[3], 10);
                if (op === '+' ) return a + b;
                if (op === '-' ) return a - b;
                return a * b;
            }

            // initial draw from server-provided data-expr
            const initialExpr = expected.getAttribute('data-expr') || '';
            if (initialExpr) render(initialExpr);

            refresh.addEventListener('click', () => {
                // generate new expression client-side (ranges: 1-20 and 1-30)
                const a = rand(1,20);
                const b = rand(1,30);
                const ops = ['+', '-'];
                const op = ops[rand(0, ops.length-1)];
                const expr = `${a} ${op} ${b}`;
                const ans = computeAnswer(expr);
                expected.value = ans;
                expected.setAttribute('data-expr', expr);
                render(expr);
                input.value = '';
                input.focus();
                // subtle pulse animation on refresh
                try { refresh.animate([{ transform: 'scale(0.96)' }, { transform: 'scale(1)' }], { duration: 220, easing: 'ease-out' }); } catch(e){}
            });
        })();
    </script>
</body>

</html>