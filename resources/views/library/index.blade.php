@extends('layouts.app')

@section('title', 'Manajemen Literatur')

@section('content')

    {{-- =========================================================
        STYLE
    ========================================================== --}}

    @include('library.types-categories._style')


    {{-- =========================================================
        PAGE WRAPPER
    ========================================================== --}}

    <div class="min-h-screen bg-slate-50 text-slate-800">


        {{-- =========================================================
            HERO
        ========================================================== --}}

        <section class="relative -mt-20 overflow-hidden">

            {{-- Background --}}
            <img
                src="{{ asset('gambar/rak 1.png') }}"
                alt="Universitas Negeri Malang"
                class="absolute inset-0 h-full w-full object-cover">

            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-900/85 to-slate-800/70"></div>


            {{-- Hero Content --}}
            <div class="relative mx-auto flex min-h-[380px] max-w-7xl items-center px-4 py-20 sm:px-6 lg:px-8">

                <div class="max-w-2xl">

                    <h1 class="text-4xl font-bold leading-tight text-white sm:text-5xl">
                        Kelola Tipe & Kategori Literatur
                    </h1>

                    <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-300 sm:text-lg">
                        Atur jenis dan kategori literatur agar koleksi tetap terstruktur,
                        mudah dicari, dan siap digunakan.
                    </p>

                </div>

            </div>

        </section>


        {{-- =========================================================
            MAIN CONTENT
        ========================================================== --}}

        <div class="relative z-20 mx-auto -mt-12 max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">

            <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-xl shadow-slate-200/50 ring-1 ring-slate-100 sm:p-8">


                {{-- =================================================
                    FLASH MESSAGE
                ================================================== --}}

                @if (session('success'))

                    <div
                        class="mb-8 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />

                        </svg>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                @endif


                {{-- =================================================
                    TYPE & CATEGORY CONTENT
                ================================================== --}}

                <div class="space-y-10">


                    {{-- =================================================
                        TIPE LITERATUR
                    ================================================== --}}

                    @include('library.types-categories._type')


                    {{-- =================================================
                        DIVIDER
                    ================================================== --}}

                    <div class="border-t border-slate-200"></div>


                    {{-- =================================================
                        KATEGORI LITERATUR
                    ================================================== --}}

                    @include('library.types-categories._category')


                </div>

            </div>

        </div>

    </div>

@endsection


{{-- =============================================================
    JAVASCRIPT
============================================================= --}}

@include('library.types-categories._script')