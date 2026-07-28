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
            src="{{ asset('gambar/rak 3.png') }}"
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

    {{-- Search & Filter --}}
    @include('skripsi._filter')

    {{-- Result --}}
    <section
        id="skripsi-result"
        class="mx-auto mt-10 max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">

        @include('skripsi._result')

    </section>

</div>

@endsection