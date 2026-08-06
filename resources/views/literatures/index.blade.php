@extends('layouts.app')

@section('title', 'Daftar Literatur')

@section('content')

{{-- Top Loader --}}
<div
    id="loading-bar"
    class="fixed left-0 top-0 z-[9999] h-1 w-0 bg-blue-600 opacity-0 transition-all duration-300 ease-out">
</div>

<div class="min-h-screen bg-slate-50 text-slate-800">

    {{-- Hero --}}
    <section class="relative -mt-20 overflow-hidden">

        {{-- Background --}}
        <img
            src="{{ asset('gambar/rak 4.png') }}"
            alt="Universitas Negeri Malang"
            class="absolute inset-0 h-full w-full object-cover">

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-r from-[#212A37]/95 via-[#212A37]/85 to-[#212A37]/65"></div>

        {{-- Hero Content --}}
        <div class="relative mx-auto flex min-h-[500px] max-w-7xl items-center px-4 py-24 sm:px-6 lg:px-8">

            <div class="grid w-full items-center gap-12 lg:grid-cols-[minmax(0,1fr)_320px]">

                {{-- Left Content --}}
                <div class="max-w-3xl">

                    <h1 class="text-4xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">
                        Temukan Literatur
                        <span class="block">
                            Akademik Terbaik.
                        </span>
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
                        Jelajahi koleksi buku, jurnal, modul, dan berbagai referensi akademik
                        berdasarkan judul, penulis, tipe, maupun kategori untuk mendukung
                        pembelajaran dan penelitian.
                    </p>

                </div>


                {{-- Repository Statistic --}}
                <div class="hidden justify-end lg:flex">

                    <div class="group relative w-full max-w-[300px] overflow-hidden
                                rounded-3xl border border-white/15
                                bg-white/10 p-7
                                shadow-2xl shadow-black/10
                                backdrop-blur-md
                                transition-all duration-300
                                hover:border-white/25
                                hover:bg-white/[0.13]">

                        {{-- Decoration --}}
                        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/[0.06]"></div>

                        <div class="relative">

                            {{-- Icon --}}
                            <div class="flex h-12 w-12 items-center justify-center
                                        rounded-2xl border border-white/10
                                        bg-white/10 text-white">

                                <span class="material-symbols-outlined text-2xl">
                                    menu_book
                                </span>

                            </div>


                            {{-- Label --}}
                            <p class="mt-6 text-xs font-semibold uppercase tracking-[0.18em] text-white/60">
                                Total Repository
                            </p>


                            {{-- Total --}}
                            <h2
                                id="result-info"
                                class="mt-2 whitespace-nowrap text-4xl font-bold tracking-tight text-white">

                                {{ number_format($literatures->total(),0,',','.') }}

                                <span class="text-base font-medium text-white/60">
                                    Literatur
                                </span>

                            </h2>


                            {{-- Description --}}
                            <p class="mt-3 text-sm leading-6 text-white/50">
                                Koleksi literatur akademik yang tersedia.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- Search Card --}}
    <div class="relative z-20 mx-auto -mt-14 max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="relative overflow-hidden
                    rounded-[28px]
                    border border-slate-200/80
                    bg-gradient-to-br from-white via-slate-50 to-[#f8fafc]
                    p-6
                    shadow-[0_25px_80px_-25px_rgba(15,23,42,0.35)]
                    ring-1 ring-slate-100
                    sm:p-8">

            {{-- Decoration --}}
            <div class="pointer-events-none absolute inset-0
                        bg-[radial-gradient(circle_at_top_left,_rgba(33,42,55,0.08),_transparent_45%)]">
            </div>


            {{-- Search --}}
            <div class="relative w-full">

                @include('literatures._search')

            </div>

        </div>

    </div>


    {{-- Result --}}
    <section
        id="resultsContainer"
        class="mx-auto mt-8 max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">

        @include('literatures._result')

    </section>

</div>

@endsection