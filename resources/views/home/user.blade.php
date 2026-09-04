@extends('layouts.app')

@section('title', 'Home')

@section('content')

    <div id="userHomepage" class="relative -mt-20 min-h-screen overflow-hidden">

        {{-- =========================================================
        Background Slider
        ========================================================== --}}
        <div class="pointer-events-none absolute inset-0 z-0" aria-hidden="true">

            <div class="hero-slide active" style="background-image: url('{{ asset('gambar/departmen.png') }}')"></div>

            <div class="hero-slide" style="background-image: url('{{ asset('gambar/ruang.png') }}')"></div>

            <div class="hero-slide" style="background-image: url('{{ asset('gambar/rak 3.png') }}')"></div>

            <div class="hero-slide" style="background-image: url('{{ asset('gambar/rak 4.png') }}')"></div>

        </div>


        {{-- =========================================================
        Overlay
        ========================================================== --}}
        <div class="pointer-events-none absolute inset-0 z-10 bg-slate-700/75" aria-hidden="true"></div>

        <div class="pointer-events-none absolute inset-0 z-10
               bg-gradient-to-b
               from-slate-950/15
               via-slate-950/30
               to-slate-950/90"
            aria-hidden="true"></div>


        {{-- =========================================================
        Main Content
        ========================================================== --}}
        <div
            class="relative z-20 mx-auto flex min-h-screen max-w-7xl
               flex-col justify-center
               px-6 pt-28 pb-40
               text-white
               lg:px-8 lg:pb-52">

            {{-- =====================================================
            Statistics
            ====================================================== --}}
            <div class="mb-8 grid gap-4
                   sm:grid-cols-2
                   lg:mb-10 lg:grid-cols-4">


                {{-- Total Koleksi --}}
                {{-- =========================================================
Total Koleksi
========================================================== --}}
                <div
                    class="group relative z-20 flex h-full flex-col
           justify-between rounded-xl
           border border-white/20
           bg-white/10
           p-5
           shadow-lg
           backdrop-blur-sm
           transition-all
           hover:bg-white/15
           sm:p-6">

                    {{-- =====================================================
                    Header Card
                    ====================================================== --}}
                    <div class="flex items-start justify-between">

                        {{-- Text --}}
                        <div class="min-w-0 flex-1">

                            <p class="text-xs font-semibold uppercase
                                tracking-wide text-white/80">
                                Total Koleksi
                            </p>

                            <p class="mt-3 text-3xl font-bold
                                tracking-tight text-white">
                                {{ number_format($totalCollection) }}
                            </p>

                        </div>


                        {{-- Icon --}}
                        <div class="ml-3 shrink-0">

                            <div
                                class="inline-flex h-10 w-10
                                    items-center justify-center
                                    rounded-xl
                                    bg-white/10
                                    transition-all duration-300
                                    group-hover:bg-white/20
                                    group-hover:scale-105">

                                <span
                                    class="material-symbols-outlined
                                    text-[23px]
                                    leading-none
                                    text-white">
                                    library_books
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                    Description
                    ====================================================== --}}
                    <div class="mt-4">

                        <p class="text-xs leading-relaxed text-white/70">
                            Seluruh koleksi repository tersedia
                        </p>

                    </div>

                </div>


                {{-- Kategori --}}
                <div
                    class="group relative z-20 flex h-full flex-col
                       justify-between rounded-xl
                       border border-white/20
                       bg-white/10
                       p-5
                       shadow-lg
                       backdrop-blur-sm
                       transition-all
                       hover:bg-white/15
                       sm:p-6">

                    <div class="flex items-start justify-between">

                        <div class="flex-1">

                            <p class="text-xs font-semibold uppercase text-white/80">
                                Kategori
                            </p>

                            <p class="mt-3 text-3xl font-bold text-white">
                                {{ number_format($categoryCount) }}
                            </p>

                        </div>

                        <div class="ml-3 flex-shrink-0">

                            <div
                                class="inline-flex h-9 w-9 items-center
                                   justify-center rounded-lg
                                   bg-white/10
                                   transition
                                   group-hover:bg-white/20">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12
                                               5.16-1.26 9-6.45 9-12V7l-10-5z" />
                                </svg>

                            </div>

                        </div>

                    </div>

                    <p class="mt-2 text-xs text-white/70">
                        Jenis bidang dan topik
                    </p>

                </div>


                {{-- Kompetensi Bidang Keahlian --}}
                <div
                    class="group relative z-20 flex h-full flex-col
                       justify-between rounded-xl
                       border border-white/20
                       bg-white/10
                       p-5
                       shadow-lg
                       backdrop-blur-sm
                       transition-all
                       hover:bg-white/15
                       sm:p-6">

                    <div class="flex items-start justify-between">

                        <div class="flex-1">

                            <p class="text-xs font-semibold uppercase text-white/80">
                                Kompetensi Bidang Keahlian
                            </p>

                            <p class="mt-3 text-3xl font-bold text-white">
                                {{ number_format($kbkCount) }}
                            </p>

                        </div>

                        <div class="ml-3 flex-shrink-0">

                            <div
                                class="inline-flex h-9 w-9 items-center
                                   justify-center rounded-lg
                                   bg-white/10
                                   transition
                                   group-hover:bg-white/20">

                                <span
                                    class="material-symbols-outlined
                                       text-[20px]
                                       leading-none
                                       text-white">
                                    school
                                </span>

                            </div>

                        </div>

                    </div>

                    <p class="mt-2 text-xs text-white/70">
                        KBK terdaftar
                    </p>

                </div>


                {{-- Anggota Aktif --}}
                <div
                    class="group relative z-20 flex h-full flex-col
                       justify-between rounded-xl
                       border border-white/20
                       bg-white/10
                       p-5
                       shadow-lg
                       backdrop-blur-sm
                       transition-all
                       hover:bg-white/15
                       sm:p-6">

                    <div class="flex items-start justify-between">

                        <div class="flex-1">

                            <p class="text-xs font-semibold uppercase text-white/80">
                                Anggota Aktif
                            </p>

                            <p class="mt-3 text-3xl font-bold text-white">
                                {{ number_format($userCount) }}
                            </p>

                        </div>

                        <div class="ml-3 flex-shrink-0">

                            <div
                                class="inline-flex h-9 w-9 items-center
                                   justify-center rounded-lg
                                   bg-white/10
                                   transition
                                   group-hover:bg-white/20">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>

                            </div>

                        </div>

                    </div>

                    <p class="mt-2 text-xs text-white/70">
                        Pengguna terdaftar
                    </p>

                </div>

            </div>


            {{-- =====================================================
            Welcome Section
            ====================================================== --}}
            <div class="relative z-30">

                <p class="text-xs font-semibold text-white sm:text-sm">
                    Halo {{ ucwords(strtolower(Auth::user()->nama_lengkap)) }},
                </p>


                <h1
                    class="mt-4 max-w-3xl
                       text-3xl font-bold tracking-tight text-white
                       sm:text-4xl
                       lg:text-6xl">
                    Selamat datang di SIPERPUS Departemen Teknik Elektro dan Informatika
                </h1>


                <p class="mt-4 max-w-2xl text-sm text-white/85 sm:text-base">
                    Akses koleksi buku, karya ilmiah, dan skripsi mahasiswa secara digital.
                </p>


                {{-- =================================================
                Search
                ================================================== --}}
                <form id="heroSearchForm" action="{{ route('literatures.index') }}" method="GET"
                    class="relative z-40 mt-8">

                    {{-- Search Target --}}
                    <input type="hidden" id="filterTarget" name="filter_target" value="literature">


                    <div
                        class="flex w-full max-w-3xl items-center
                           rounded-full
                           border border-white/15
                           bg-slate-900/70
                           p-1.5
                           shadow-2xl shadow-slate-950/30
                           backdrop-blur-md
                           transition-all duration-300
                           focus-within:border-blue-400/40
                           focus-within:ring-4
                           focus-within:ring-blue-400/10">

                        {{-- =================================================
                        Category Dropdown
                        ================================================== --}}
                        <div class="relative shrink-0">

                            <button type="button" id="searchCategoryButton"
                                class="flex h-11 items-center gap-3
                                   rounded-full
                                   px-4
                                   text-sm font-medium text-white
                                   transition
                                   hover:bg-white/5"
                                aria-haspopup="listbox" aria-expanded="false" aria-controls="searchCategoryDropdown">

                                <span id="searchCategoryIcon"
                                    class="material-symbols-outlined
                                       text-[22px]
                                       text-white"
                                    aria-hidden="true">
                                    menu_book
                                </span>

                                
                                <span id="searchCategoryLabel">
                                    Literatur
                                </span>

                                <span id="searchCategoryArrow"
                                    class="material-symbols-outlined
                                       text-[19px]
                                       text-white/50
                                       transition-transform duration-200"
                                    aria-hidden="true">
                                    expand_more
                                </span>

                            </button>


                            {{-- =================================================
                            Dropdown Menu
                            ================================================== --}}
                            <div id="searchCategoryDropdown"
                                class="absolute left-0 top-[calc(100%+10px)] z-[999]
                                   hidden
                                   w-56
                                   overflow-hidden
                                   rounded-2xl
                                   border border-white/10
                                   bg-slate-900/95
                                   p-1.5
                                   shadow-2xl shadow-black/40
                                   backdrop-blur-xl"
                                role="listbox">

                                {{-- =================================================
                                Literatur
                                ================================================== --}}
                                <button type="button"
                                    class="search-category-option
                                       flex w-full items-center gap-3
                                       rounded-xl
                                       px-3 py-2.5
                                       text-left text-sm
                                       text-white
                                       transition
                                       hover:bg-white/10"
                                    data-filter="literature" data-label="Literatur" data-icon="menu_book"
                                    data-route="{{ route('literatures.index') }}"
                                    data-placeholder="Cari judul literatur, penulis, atau kata kunci..." role="option">

                                    <span
                                        class="material-symbols-outlined
                                           text-[25px]
                                           text-white"
                                        aria-hidden="true">
                                        menu_book
                                    </span>

                                    <span>
                                        Literatur
                                    </span>

                                </button>


                                {{-- =================================================
                                Praktik Industri
                                ================================================== --}}
                                <button type="button"
                                    class="search-category-option
                                       flex w-full items-center gap-3
                                       rounded-xl
                                       px-3 py-2.5
                                       text-left text-sm
                                       text-white
                                       transition
                                       hover:bg-white/10"
                                    data-filter="praktik_industri" data-label="Praktik Industri" data-icon="engineering"
                                    data-route="{{ route('praktik-industri.index') }}"
                                    data-placeholder="Cari judul laporan praktik industri, penulis, atau kata kunci..." role="option">

                                    <span
                                        class="material-symbols-outlined
                                           text-[25px]
                                           text-white"
                                        aria-hidden="true">
                                        engineering
                                    </span>

                                    <span>
                                        Praktik Industri
                                    </span>

                                </button>


                                {{-- =================================================
                                Skripsi
                                ================================================== --}}
                                <button type="button"
                                    class="search-category-option
                                       flex w-full items-center gap-3
                                       rounded-xl
                                       px-3 py-2.5
                                       text-left text-sm
                                       text-white
                                       transition
                                       hover:bg-white/10"
                                    data-filter="skripsi" data-label="Skripsi" data-icon="article"
                                    data-route="{{ route('skripsi.index') }}"
                                    data-placeholder="Cari judul skripsi, penulis, atau kata kunci..." role="option">

                                    <span
                                        class="material-symbols-outlined
                                           text-[25px]
                                           text-white"
                                        aria-hidden="true">
                                        article
                                    </span>

                                    <span>
                                        Skripsi
                                    </span>

                                </button>


                                {{-- =================================================
                                Tesis
                                ================================================== --}}
                                <button type="button"
                                    class="search-category-option
                                       flex w-full items-center gap-3
                                       rounded-xl
                                       px-3 py-2.5
                                       text-left text-sm
                                       text-white
                                       transition
                                       hover:bg-white/10"
                                    data-filter="tesis" data-label="Tesis" data-icon="description"
                                    data-route="{{ route('tesis.index') }}"
                                    data-placeholder="Cari judul tesis, penulis, atau kata kunci..." role="option">

                                    <span
                                        class="material-symbols-outlined
                                           text-[25px]
                                           text-white"
                                        aria-hidden="true">
                                        description
                                    </span>

                                    <span>
                                        Tesis
                                    </span>

                                </button>


                                {{-- =================================================
                                Disertasi
                                ================================================== --}}
                                <button type="button"
                                    class="search-category-option
                                       flex w-full items-center gap-3
                                       rounded-xl
                                       px-3 py-2.5
                                       text-left text-sm
                                       text-white
                                       transition
                                       hover:bg-white/10"
                                    data-filter="disertasi" data-label="Disertasi" data-icon="school"
                                    data-route="{{ route('disertasi.index') }}"
                                    data-placeholder="Cari judul disertasi, penulis, atau kata kunci..." role="option">

                                    <span
                                        class="material-symbols-outlined
                                           text-[25px]
                                           text-white"
                                        aria-hidden="true">
                                        school
                                    </span>

                                    <span>
                                        Disertasi
                                    </span>

                                </button>

                            </div>

                        </div>


                        {{-- =================================================
                        Separator
                        ================================================== --}}
                        <div class="mx-1 h-8 w-px shrink-0 bg-white/10" aria-hidden="true"></div>


                        {{-- =================================================
                        Search Input
                        ================================================== --}}
                        <div class="flex min-w-0 flex-1 items-center">

                            <span
                                class="material-symbols-outlined
                                   ml-3
                                   shrink-0
                                   text-[22px]
                                   text-slate-400"
                                aria-hidden="true">
                                search
                            </span>

                            <input id="search" name="search" type="search" autocomplete="off"
                                placeholder="Cari judul literatur, penulis, atau kata kunci..."
                                class="min-w-0 flex-1
                                   border-0
                                   bg-transparent
                                   px-3 py-3
                                   text-sm
                                   text-white
                                   placeholder:text-slate-400
                                   outline-none
                                   focus:border-0
                                   focus:outline-none
                                   focus:ring-0">

                        </div>


                        {{-- =================================================
                        Search Button
                        ================================================== --}}
                        <button type="submit"
                            class="shrink-0
                               rounded-full
                               bg-blue-400
                               px-6 py-2.5
                               text-sm font-semibold
                               text-slate-950
                               shadow-lg shadow-blue-400/20
                               transition-all duration-200
                               hover:bg-blue-300
                               active:scale-95">
                            Cari 
                        </button>

                    </div>


                    {{-- =================================================
                    Search Error
                    ================================================== --}}
                    <p id="search-error"
                        class="relative z-40 mt-3 hidden
                           text-sm font-medium
                           text-red-300"
                        role="alert">
                        Silakan masukkan kata kunci pencarian.
                    </p>

                </form>

                {{-- =================================================
                Petunjuk Penggunaan
                ================================================== --}}
                <div class="mt-5 max-w-3xl">
                    <div
                        class="rounded-2xl
                                border border-white/10
                                bg-white/5
                                px-5 py-4
                                backdrop-blur-md">

                        {{-- Header --}}
                        <div class="mb-4 flex items-center gap-2">

                            <span
                                class="material-symbols-outlined
                                        text-[20px]
                                        text-blue-300">
                                info
                            </span>

                            <p class="text-sm font-semibold text-white">
                                Petunjuk Penggunaan
                            </p>

                        </div>


                        {{-- Steps --}}
                        <div class="grid gap-4
                                    sm:grid-cols-3">

                            {{-- Step 1 --}}
                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-7 w-7 shrink-0 items-center
                                            justify-center rounded-full
                                            bg-white/10
                                            text-xs font-bold text-white">
                                    1
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-white">
                                        Pilih koleksi
                                    </p>

                                    <p class="mt-1 text-xs leading-relaxed text-white/60">
                                        Pilih Literatur, Skripsi, Tesis, atau Disertasi.
                                    </p>
                                </div>

                            </div>


                            {{-- Step 2 --}}
                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-7 w-7 shrink-0 items-center
                                            justify-center rounded-full
                                            bg-white/10
                                            text-xs font-bold text-white">
                                    2
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-white">
                                        Masukkan kata kunci
                                    </p>

                                    <p class="mt-1 text-xs leading-relaxed text-white/60">
                                        Ketik judul, penulis, atau kata kunci.
                                    </p>
                                </div>

                            </div>


                            {{-- Step 3 --}}
                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-7 w-7 shrink-0 items-center
                                            justify-center rounded-full
                                            bg-white/10
                                            text-xs font-bold text-white">
                                    3
                                </div>

                                <div>
                                    <p class="text-xs font-semibold text-white">
                                        Mulai pencarian
                                    </p>

                                    <p class="mt-1 text-xs leading-relaxed text-white/60">
                                        Klik tombol Search untuk melihat hasil.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

@endsection