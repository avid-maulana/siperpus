
@extends('layouts.app')

@section('title', 'Repository Skripsi')

@section('content')

{{-- =========================================================
    SISINTA FILE URL
========================================================= --}}

<script>
    window.SISINTA_FILE_URL = @json(
        rtrim(env('SISINTA_FILE_URL'), '/')
    );
</script>


{{-- =========================================================
    TOP LOADER
========================================================= --}}

<div
    id="loading-bar"
    class="fixed
           left-0
           top-0
           z-[9999]
           h-1
           w-0
           bg-blue-600
           opacity-0
           transition-all
           duration-300
           ease-out"
></div>


{{-- =========================================================
    PAGE
========================================================= --}}

<div class="min-h-screen bg-slate-50">


    {{-- =====================================================
        HERO
    ====================================================== --}}

    <section
        class="relative
               -mt-20
               overflow-hidden"
    >

        {{-- Background --}}

        <img
            src="{{ asset('gambar/rak 3.png') }}"
            alt="Universitas Negeri Malang"
            class="absolute
                   inset-0
                   h-full
                   w-full
                   object-cover"
        >


        {{-- Overlay --}}

        <div
            class="absolute
                   inset-0
                   bg-gradient-to-r
                   from-[#212A37]/95
                   via-[#212A37]/80
                   to-[#212A37]/60"
        ></div>


        {{-- =================================================
            HERO CONTENT
        ================================================== --}}

        <div
            class="relative
                   mx-auto
                   flex
                   min-h-[500px]
                   max-w-7xl
                   items-center
                   px-4
                   py-24
                   sm:px-6
                   lg:px-8"
        >

            <div
                class="grid
                       w-full
                       items-center
                       gap-12
                       lg:grid-cols-[minmax(0,1fr)_300px]"
            >


                {{-- =================================================
                    LEFT CONTENT
                ================================================== --}}

                <div class="max-w-3xl">

                    <h1
                        class="text-4xl
                               font-bold
                               leading-tight
                               text-white
                               sm:text-5xl
                               lg:text-6xl"
                    >
                        Temukan Referensi Skripsi Terbaik.
                    </h1>


                    <p
                        class="mt-5
                               max-w-2xl
                               text-base
                               leading-8
                               text-slate-300
                               sm:text-lg"
                    >
                        Jelajahi koleksi skripsi mahasiswa berdasarkan judul,
                        nama penulis, maupun NIM untuk mendukung penelitian,
                        pembelajaran, dan pengembangan karya ilmiah.
                    </p>

                </div>


                {{-- =================================================
                    STICKY NOTE TOTAL REPOSITORY
                ================================================== --}}

                <div
                    class="hidden
                           justify-end
                           lg:flex"
                >

                    <div
                        class="group
                               relative
                               w-full
                               max-w-[280px]
                               rotate-[2deg]
                               rounded-sm
                               bg-[#fffdf4]
                               px-7
                               pb-7
                               pt-9
                               shadow-[0_18px_45px_rgba(0,0,0,0.28)]
                               transition-all
                               duration-300
                               hover:-translate-y-1
                               hover:rotate-0
                               hover:shadow-[0_24px_55px_rgba(0,0,0,0.32)]"
                    >

                        {{-- Tape --}}

                        <div
                            class="absolute
                                   -top-4
                                   left-1/2
                                   h-8
                                   w-24
                                   -translate-x-1/2
                                   -rotate-2
                                   bg-white/60
                                   shadow-sm
                                   backdrop-blur-[2px]"
                        ></div>


                        {{-- Fold Corner --}}

                        <div
                            class="absolute
                                   bottom-0
                                   right-0
                                   h-8
                                   w-8
                                   bg-gradient-to-tl
                                   from-[#e8e4d5]
                                   to-[#fffdf4]
                                   shadow-[-3px_-3px_6px_rgba(0,0,0,0.06)]"
                        ></div>


                        <div class="relative">

                            {{-- Icon --}}

                            <div
                                class="flex
                                       items-center
                                       justify-between"
                            >

                                <div
                                    class="flex
                                           h-11
                                           w-11
                                           items-center
                                           justify-center
                                           rounded-xl
                                           bg-[#212A37]
                                           text-white
                                           shadow-sm
                                           transition-transform
                                           duration-300"
                                >

                                    <span
                                        class="material-symbols-outlined text-[22px]"
                                    >
                                        menu_book
                                    </span>

                                </div>

                            </div>


                            {{-- Label --}}

                            <p
                                class="mt-6
                                       text-[11px]
                                       font-bold
                                       uppercase
                                       text-slate-500"
                            >
                                Total Repository
                            </p>


                            {{-- Total --}}

                            <div
                                class="mt-2
                                       flex
                                       items-end
                                       gap-2"
                            >

                                <h2
                                    class="text-5xl
                                           font-bold
                                           tracking-tight
                                           text-[#212A37]"
                                >

                                    @if ($totalSkripsis >= 1000000)

                                        {{ rtrim(
                                            rtrim(
                                                number_format(
                                                    $totalSkripsis / 1000000,
                                                    1,
                                                    ',',
                                                    ''
                                                ),
                                                '0'
                                            ),
                                            ','
                                        ) }}M+

                                    @elseif ($totalSkripsis >= 1000)

                                        {{ rtrim(
                                            rtrim(
                                                number_format(
                                                    $totalSkripsis / 1000,
                                                    1,
                                                    ',',
                                                    ''
                                                ),
                                                '0'
                                            ),
                                            ','
                                        ) }}K+

                                    @else

                                        {{ $totalSkripsis }}

                                    @endif

                                </h2>


                                <span
                                    class="mb-1.5
                                           text-sm
                                           font-semibold
                                           text-slate-500"
                                >
                                    Skripsi
                                </span>

                            </div>


                            {{-- Divider --}}

                            <div
                                class="my-4
                                       border-t
                                       border-dashed
                                       border-slate-300"
                            ></div>


                            {{-- Description --}}

                            <p
                                class="text-sm
                                       leading-6
                                       text-slate-500"
                            >
                                Total koleksi skripsi mahasiswa yang tersedia
                                di repository.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
        SEARCH & FILTER
    ====================================================== --}}

    <div
        class="relative
               z-20
               mx-auto
               -mt-8
               max-w-7xl
               px-4
               sm:px-6
               lg:px-8"
    >

        @include('skripsi._filter')

    </div>


    {{-- =====================================================
        RESULT
    ====================================================== --}}

    <div
        class="mx-auto
               mt-8
               max-w-7xl
               px-4
               sm:px-6
               lg:px-8"
    >

        {{-- =================================================
            RESULT INFO
        ================================================== --}}

        <div class="mb-6">

            <p
                class="text-sm
                       font-semibold
                       text-slate-500"
            >
                Menampilkan
            </p>


            <h2
                id="result-info"
                class="mt-1
                       text-2xl
                       font-bold
                       tracking-tight
                       text-slate-900"
            >

                {{ number_format(
                    $skripsis->total(),
                    0,
                    ',',
                    '.'
                ) }}

                <span class="font-semibold">
                    skripsi tersedia
                </span>

            </h2>

        </div>


        {{-- =================================================
            CARDS / AJAX RESULT
        ================================================== --}}

        <section
            id="skripsi-result"
            class="pb-16"
        >

            @include('skripsi._result')

        </section>

    </div>

</div>


{{-- =========================================================
    PDF VIEWER MODAL
========================================================= --}}

@include('skripsi._pdf-viewer')


{{-- =========================================================
    SKRIPSI SCRIPTS
========================================================= --}}

@vite([
    'resources/js/skripsi/skripsi.js',
    'resources/js/skripsi/pdf-viewer.js',
])

@endsection

