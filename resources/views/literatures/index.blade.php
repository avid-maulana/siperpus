@extends('layouts.app')

@section('title', 'Daftar Literatur')

@section('content')

<div class="min-h-screen bg-slate-50 text-slate-800">
    <section class="relative -mt-20 overflow-hidden">
        <img
            src="{{ asset('asset/rak 2.jpg') }}"
            alt="Universitas Negeri Malang"
            class="absolute inset-0 h-full w-full object-cover">

        <div class="absolute inset-0 bg-gradient-to-r from-[#212A37]/95 via-[#212A37]/80 to-[#212A37]/60"></div>

        <div class="relative mx-auto flex min-h-[520px] max-w-7xl items-center px-4 py-24 sm:px-6 lg:px-8">
            <div class="max-w-3xl text-white">
                <p class="text-sm font-semibold uppercase tracking-[0.35em] text-slate-300">
                    Temukan Referensi Akademik
                </p>
                <h1 class="mt-4 text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Temukan Referensi Terbaik untuk Penelitianmu.
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-relaxed text-slate-300 sm:text-lg">
                    Cari buku, jurnal, skripsi, dan berbagai literatur akademik untuk mendukung pembelajaran maupun penelitian.
                </p>
            </div>
        </div>

        <div class="relative z-20 mx-auto -mt-16 max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">
            <div class="relative overflow-hidden rounded-[28px] border border-slate-200 bg-white/95 p-6 shadow-[0_25px_80px_-25px_rgba(15,23,42,0.25)] ring-1 ring-slate-100 sm:p-8 lg:p-10 backdrop-blur-sm">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(255,255,255,0.18),_transparent_42%)]"></div>
                <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between lg:gap-8">
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#212A37] text-white shadow-lg shadow-slate-950/20">
                            <span class="material-symbols-outlined text-3xl leading-none">
                                menu_book
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-500">
                                Total Repository
                            </p>
                            <h2 id="result-info" class="mt-2 text-3xl font-bold text-slate-900">
                                {{ number_format($literatures->total(),0,',','.') }}
                                <span class="text-lg font-medium text-slate-500">
                                    Literatur
                                </span>
                            </h2>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3 lg:auto-cols-fr lg:grid-flow-col lg:items-center">
                        <div class="rounded-3xl bg-slate-50 p-4 text-center shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Literatur</p>
                            <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $literatures->total() }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-4 text-center shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Tipe</p>
                            <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $types->count() }}</p>
                        </div>
                        <div class="rounded-3xl bg-slate-50 p-4 text-center shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500">Kategori</p>
                            <p class="mt-3 text-2xl font-semibold text-slate-900">{{ $categories->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 relative">
                    <div class="absolute inset-x-0 top-0 h-px bg-slate-200 opacity-50"></div>
                    <div class="relative">
                        @include('literatures._search')
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="resultsContainer" class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        @include('literatures._result')
    </section>
</div>

@endsection