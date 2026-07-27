@extends('layouts.app')

@section('title', 'Daftar Literatur')

@section('content')

<div class="min-h-screen bg-slate-50 text-slate-800">
    {{-- Hero --}}
<section class="relative -mt-20 overflow-hidden">
    <img
        src="{{ asset('asset/rak 2.jpg') }}"
        alt="Universitas Negeri Malang"
        class="absolute inset-0 h-full w-full object-cover">

    <div class="absolute inset-0 bg-gradient-to-r from-[#212A37]/95 via-[#212A37]/80 to-[#212A37]/60"></div>

    <div class="relative mx-auto flex min-h-[500px] max-w-7xl items-center px-4 py-24 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <h1 class="text-4xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">
                Temukan Literatur Akademik Terbaik.
            </h1>

            <p class="mt-5 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
                Jelajahi koleksi buku, jurnal, modul, dan berbagai referensi akademik
                berdasarkan judul, penulis, tipe, maupun kategori untuk mendukung
                pembelajaran dan penelitian.
            </p>
        </div>
    </div>
</section>

{{-- Search Card --}}
{{-- Search Card --}}
<div class="relative z-20 mx-auto -mt-14 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="relative overflow-hidden rounded-[28px] border border-slate-200/80 bg-gradient-to-br from-white via-slate-50 to-[#f8fafc] p-6 shadow-[0_25px_80px_-25px_rgba(15,23,42,0.35)] ring-1 ring-slate-100 sm:p-8">

        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(33,42,55,0.10),_transparent_45%)]"></div>

        <div class="relative grid gap-8 lg:grid-cols-[280px_1px_minmax(0,1fr)] lg:items-center">

            {{-- Statistik --}}
            <div class="flex items-center gap-5">

                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-[#212A37] text-white shadow-lg shadow-slate-900/20">
                    <span class="material-symbols-outlined text-3xl">
                        menu_book
                    </span>
                </div>

                <div>
                    <p class="text-sm font-semibold text-slate-500">
                        Total Repository
                    </p>

                    <h2 id="result-info" class="mt-2 whitespace-nowrap text-3xl font-bold text-slate-900">
                        {{ number_format($literatures->total(),0,',','.') }}

                        <span class="text-lg font-medium text-slate-500">
                            Literatur
                        </span>
                    </h2>
                </div>

            </div>

            {{-- Divider --}}
            <div class="hidden h-20 w-px bg-slate-200 lg:block"></div>

            {{-- Search --}}
            <div class="w-full">
                @include('literatures._search')
            </div>

        </div>

    </div>
</div>

    <section id="resultsContainer" class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        @include('literatures._result')
    </section>
</div>

@endsection