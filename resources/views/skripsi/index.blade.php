@extends('layouts.app')

@section('title', 'Repository Skripsi')

@section('content')

{{-- Top Loader --}}
<div id="loading-bar"
    class="fixed left-0 top-0 z-[9999] h-1 w-0 bg-blue-600 opacity-0 transition-all duration-300 ease-out">
</div>

<div class="min-h-screen bg-slate-50">

    {{-- Hero --}}
    <section class="relative -mt-20 overflow-hidden">
        <img
            src="{{ asset('asset/rak 1.jpg') }}"
            alt="Universitas Negeri Malang"
            class="absolute inset-0 h-full w-full object-cover">

        <div class="absolute inset-0 bg-gradient-to-r from-[#212A37]/95 via-[#212A37]/80 to-[#212A37]/60"></div>

        <div class="relative mx-auto flex min-h-[500px] max-w-7xl items-center px-4 py-24 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">
                    Temukan Referensi Skripsi Terbaik.
                </h1>

                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
                    Jelajahi koleksi skripsi mahasiswa berdasarkan judul,
                    nama penulis, maupun NIM untuk mendukung penelitian,
                    pembelajaran, dan pengembangan karya ilmiah.
                </p>
            </div>
        </div>
    </section>

    {{-- Search Card --}}
    <div class="relative z-20 mx-auto -mt-14 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-[28px] border border-slate-200/80 bg-gradient-to-br from-white via-slate-50 to-[#f8fafc] p-6 shadow-[0_25px_80px_-25px_rgba(15,23,42,0.35)] ring-1 ring-slate-100 sm:p-8">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(33,42,55,0.10),_transparent_45%)]"></div>

            <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between lg:gap-8">
                {{-- Statistik --}}
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#212A37] text-white shadow-lg shadow-slate-900/20">
                        <span class="material-symbols-outlined text-3xl leading-none">
                            menu_book
                        </span>
                    </div>

                    <div class="shrink-0">
                        <p class="text-sm font-semibold text-slate-500">
                            Total Repository
                        </p>

                        <h2 id="result-info" class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($skripsis->total(),0,',','.') }}
                            <span class="text-lg font-medium text-slate-500">
                                Skripsi
                            </span>
                        </h2>
                    </div>
                </div>

                {{-- Search --}}
                <div class="w-full lg:max-w-[30rem]">
                    <div class="group relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg
                                class="h-5 w-5 text-slate-400 transition-colors duration-300 group-focus-within:text-[#212A37]"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-4.35-4.35m1.1-5.15a6.5 6.5 0 11-13 0a6.5 6.5 0 0113 0z"/>
                            </svg>
                        </div>

                        <input
                            id="search"
                            name="search"
                            type="text"
                            autocomplete="off"
                            spellcheck="false"
                            value="{{ request('search') }}"
                            placeholder="Cari judul, nama mahasiswa, atau NIM..."
                            class="w-full rounded-2xl border border-slate-300 bg-white/90 py-3.5 pl-12 pr-28 text-slate-700 shadow-sm transition-all duration-300 placeholder:text-slate-400 focus:border-[#212A37] focus:bg-white focus:shadow-[0_0_0_4px_rgba(33,42,55,0.08)] focus:outline-none">

                        <button
                            id="search-button"
                            type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-slate-950 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-slate-950/20 transition hover:bg-slate-800">
                            Search
                        </button>
                    </div>

                    <p class="mt-3 text-sm text-slate-500">
                        Cari referensi dengan cepat dan temukan karya yang paling relevan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Result --}}
    <section
        id="skripsi-result"
        class="mx-auto mt-10 max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
        @include('skripsi._result')
    </section>

</div>
@endsection