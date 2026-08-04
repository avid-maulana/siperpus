<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SIPERPUS DTEI UM</title>

    {{-- CSS & JavaScript --}}
    @vite([
        'resources/css/app.css',
        'resources/js/auth/login.js',
        'resources/js/auth/captcha.js',
    ])

    {{-- Style khusus halaman login --}}
    @include('auth._style')
</head>

<body class="min-h-screen overflow-hidden">

    {{-- Loading Overlay --}}
    <div
        id="loadingOverlay"
        class="fixed inset-0 z-[60] hidden items-center justify-center
               bg-slate-950/70 backdrop-blur-sm opacity-0
               transition-opacity duration-300"
    >
        <div
            class="flex flex-col items-center rounded-3xl border border-white/10
                   bg-white/95 px-8 py-7 shadow-2xl"
        >
            <div
                class="h-12 w-12 animate-spin rounded-full
                       border-4 border-slate-200 border-t-blue-600"
            ></div>

            <p class="mt-4 text-sm font-semibold text-slate-700">
                Sedang masuk...
            </p>
        </div>
    </div>


    {{-- Background --}}
    <div class="fixed inset-0 overflow-hidden">

        {{-- Background Image --}}
        <img
            src="{{ asset('asset/um.jpg') }}"
            alt="Gedung Universitas Negeri Malang"
            class="absolute inset-0 h-full w-full
                   scale-110 object-cover opacity-25"
        >

        {{-- Gradient Overlay --}}
        <div
            class="absolute inset-0 bg-gradient-to-br
                   from-black/70 via-slate-950/80 to-black/75"
        ></div>

    </div>


    {{-- Main Content --}}
    <main
        class="relative z-10 flex min-h-screen
               items-center justify-center px-6"
    >

        {{-- Login Card --}}
        <div
            class="w-full max-w-[430px]
                   rounded-[28px] bg-white p-10 shadow-2xl"
        >

            {{-- Header --}}
            <div class="mb-10 text-center">

                <img
                    src="{{ asset('asset/logo.png') }}"
                    alt="Logo SIPERPUS"
                    class="mx-auto mb-5 w-16"
                >

                <h1 class="text-3xl font-bold tracking-wide">
                    SIPERPUS
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Sistem Informasi Perpustakaan<br>
                    Departemen Teknik Elektro dan Informatika
                </p>

            </div>


            {{-- Validation Errors --}}
            @if ($errors->any())

                <div
                    class="mb-6 rounded-xl border
                           border-red-200 bg-red-50 p-4"
                >

                    @foreach ($errors->all() as $error)

                        <p class="text-sm text-red-600">
                            {{ $error }}
                        </p>

                    @endforeach

                </div>

            @endif


            {{-- Login Form --}}
            <form
                id="loginForm"
                method="POST"
                action="{{ route('login') }}"
                class="space-y-6"
            >

                @csrf


                {{-- Username --}}
                <div class="relative">

                    <input
                        id="username"
                        name="username"
                        type="text"
                        value="{{ old('username') }}"
                        required
                        placeholder=" "
                        autocomplete="username"
                        class="peer w-full rounded-2xl bg-slate-100
                               px-5 pb-2 pt-6 outline-none transition
                               focus:bg-white focus:ring-2
                               focus:ring-blue-600"
                    >

                    <label
                        for="username"
                        class="absolute left-5 top-1/2
                               -translate-y-1/2 text-slate-500
                               transition-all duration-200

                               peer-placeholder-shown:text-base

                               peer-focus:top-2
                               peer-focus:-translate-y-0
                               peer-focus:text-xs
                               peer-focus:text-blue-600

                               peer-not-placeholder-shown:top-2
                               peer-not-placeholder-shown:-translate-y-0
                               peer-not-placeholder-shown:text-xs"
                    >
                        Username
                    </label>

                </div>


                {{-- Password --}}
                <div class="relative">

                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        placeholder=" "
                        autocomplete="current-password"
                        class="peer w-full rounded-2xl bg-slate-100
                               px-5 pb-2 pt-6 outline-none transition
                               focus:bg-white focus:ring-2
                               focus:ring-blue-600"
                    >

                    <label
                        for="password"
                        class="absolute left-5 top-1/2
                               -translate-y-1/2 text-slate-500
                               transition-all duration-200

                               peer-placeholder-shown:text-base

                               peer-focus:top-2
                               peer-focus:-translate-y-0
                               peer-focus:text-xs
                               peer-focus:text-blue-600

                               peer-not-placeholder-shown:top-2
                               peer-not-placeholder-shown:-translate-y-0
                               peer-not-placeholder-shown:text-xs"
                    >
                        Password
                    </label>

                </div>


                {{-- CAPTCHA --}}
                @include('auth._captcha')


                {{-- Sign In Button --}}
                <div class="pt-6">

                    <button
                        id="loginButton"
                        type="submit"
                        class="btn-primary group"
                        aria-label="Sign In"
                    >

                        <span>
                            Login
                        </span>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2.5"
                            stroke="currentColor"
                            class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"
                            />
                        </svg>

                    </button>

                </div>

            </form>

        </div>

    </main>


    {{-- Footer --}}
    <footer class="login-footer">
        © 2026 SIPERPUS - Sistem Informasi Perpustakaan
    </footer>

</body>

</html>