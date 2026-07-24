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
            src="{{ asset('asset/research.jpg') }}"
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
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-2xl sm:p-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between lg:gap-8">

                {{-- Statistik --}}
                <div class="shrink-0">
                    <p class="text-sm font-medium uppercase tracking-wider text-slate-500">
                        Total Repository
                    </p>

                    <h2 id="result-info" class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($skripsis->total(),0,',','.') }}
                        <span class="text-lg font-medium text-slate-500">
                            Skripsi
                        </span>
                    </h2>
                </div>

                {{-- Search --}}
                <div class="w-full lg:max-w-md">
                    <div class="relative">
                        <svg
                            class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
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

                        <input
                            id="search"
                            name="search"
                            type="text"
                            autocomplete="off"
                            spellcheck="false"
                            value="{{ request('search') }}"
                            placeholder="Cari judul, nama mahasiswa, atau NIM..."
                            class="w-full rounded-2xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-slate-700 transition-all duration-300 placeholder:text-slate-400 focus:border-[#212A37] focus:ring-4 focus:ring-slate-200">
                    </div>
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