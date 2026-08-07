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
                {{-- Repository Statistic --}}
                <div class="hidden justify-end lg:flex">

                    <div
                        class="group relative w-full max-w-[280px]
               rotate-[2deg]
               rounded-sm
               bg-[#fffdf4]
               px-7 pb-7 pt-9
               shadow-[0_18px_45px_rgba(0,0,0,0.28)]
               transition-all duration-300
               hover:rotate-0
               hover:-translate-y-1
               hover:shadow-[0_24px_55px_rgba(0,0,0,0.32)]">

                        {{-- Tape --}}
                        <div
                            class="absolute -top-4 left-1/2
                   h-8 w-24
                   -translate-x-1/2
                   -rotate-2
                   bg-white/60
                   shadow-sm
                   backdrop-blur-[2px]">
                        </div>


                        {{-- Fold Corner --}}
                        <div
                            class="absolute bottom-0 right-0
                   h-8 w-8
                   bg-gradient-to-tl
                   from-[#e8e4d5]
                   to-[#fffdf4]
                   shadow-[-3px_-3px_6px_rgba(0,0,0,0.06)]">
                        </div>


                        {{-- Content --}}
                        <div class="relative">

                            {{-- Header --}}
                            <div class="flex items-center justify-between">

                                {{-- Icon --}}
                                <div
                                    class="flex h-11 w-11 items-center justify-center
                                    rounded-xl
                                    bg-[#212A37]
                                    text-white
                                    shadow-sm
                                    transition-transform duration-300">

                                    <span class="material-symbols-outlined text-[22px]">
                                        menu_book
                                    </span>

                                </div>



                            </div>


                            {{-- Label --}}
                            <p
                                class="mt-6 text-[11px] font-bold uppercase
                                text-slate-500">

                                Total Repository

                            </p>


                            {{-- Total --}}
                            <div class="mt-2 flex items-end gap-2">

                                <h2
                                    class="text-5xl font-bold
                                    tracking-tight
                                    text-[#212A37]">

                                    {{ number_format($totalLiteratures, 0, ',', '.') }}

                                </h2>

                                <span
                                    class="mb-1.5 text-sm font-semibold
                                    text-slate-500">

                                    Literatur

                                </span>

                            </div>


                            {{-- Divider --}}
                            <div class="my-4 border-t border-dashed border-slate-300"></div>


                            {{-- Description --}}
                            <p
                                class="text-sm leading-6
                                text-slate-500">

                                Total koleksi literatur akademik
                                yang tersedia di repository.

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