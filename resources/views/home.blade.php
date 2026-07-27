@extends('layouts.app')

@section('title', 'Home')

@section('content')

<div class="relative -mt-20 min-h-screen overflow-hidden">

    <!-- Background Slider -->
    <div class="absolute inset-0 -z-20">
        <div class="hero-slide active"
            style="background-image: url('{{ asset('asset/lobi.jpg') }}')"></div>

        <div class="hero-slide"
            style="background-image: url('{{ asset('asset/sign ruangan.jpg') }}')"></div>

        <div class="hero-slide"
            style="background-image: url('{{ asset('asset/rak 3.jpg') }}')"></div>

        <div class="hero-slide"
            style="background-image: url('{{ asset('asset/rak 4.jpg') }}')"></div>
    </div>

    <!-- Overlay -->
    <div class="absolute inset-0 -z-10 bg-slate-700/75"></div>

    <!-- Gradient -->
    <div class="absolute inset-0 -z-10 bg-gradient-to-b from-slate-950/15 via-slate-950/30 to-slate-950/90"></div>

    <!-- Content -->
        <div class="relative mx-auto max-w-7xl px-6 pt-32 pb-12 lg:px-8 lg:pt-40 lg:pb-16 text-white">
            <!-- Statistics Cards -->
            <div class="grid gap-4 sm:grid-cols-3 mb-12 lg:mb-16">
                <!-- Total Koleksi Card -->
                <div class="group rounded-xl bg-white/10 backdrop-blur-sm p-5 sm:p-6 shadow-lg border border-white/20 transition-all hover:bg-white/15">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/80">Total Koleksi</p>
                            <p class="mt-3 text-3xl font-bold text-white">{{ number_format($literatureCount) }}</p>
                            <p class="mt-2 text-xs text-white/70">Literatur dan skripsi tersedia</p>
                        </div>
                        <div class="flex-shrink-0 ml-3">
                            <div class="inline-flex items-center justify-center rounded-lg bg-white/10 p-2 group-hover:bg-white/20 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
                                    <polyline points="13 2 13 9 20 9"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori Card -->
                <div class="group rounded-xl bg-white/10 backdrop-blur-sm p-5 sm:p-6 shadow-lg border border-white/20 transition-all hover:bg-white/15">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/80">Kategori</p>
                            <p class="mt-3 text-3xl font-bold text-white">{{ number_format($categoryCount) }}</p>
                            <p class="mt-2 text-xs text-white/70">Jenis bidang dan topik</p>
                        </div>
                        <div class="flex-shrink-0 ml-3">
                            <div class="inline-flex items-center justify-center rounded-lg bg-white/10 p-2 group-hover:bg-white/20 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Anggota Aktif Card -->
                <div class="group rounded-xl bg-white/10 backdrop-blur-sm p-5 sm:p-6 shadow-lg border border-white/20 transition-all hover:bg-white/15">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-white/80">Anggota Aktif</p>
                            <p class="mt-3 text-3xl font-bold text-white">{{ number_format($userCount) }}</p>
                            <p class="mt-2 text-xs text-white/70">Pengguna terdaftar</p>
                        </div>
                        <div class="flex-shrink-0 ml-3">
                            <div class="inline-flex items-center justify-center rounded-lg bg-white/10 p-2 group-hover:bg-white/20 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Welcome Section -->
            <div class="mt-8 lg:mt-12">
                <p class="text-xs sm:text-sm font-semibold text-white">
                    Halo {{ ucwords(strtolower(Auth::user()->nama_lengkap)) }},
                </p>

                <h1 class="mt-4 max-w-3xl text-3xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-white">
                    Selamat datang di Perpustakaan Digital Universitas Negeri Malang
                </h1>

                <p class="mt-4 max-w-2xl text-sm sm:text-base text-white/85">
                    Departemen Teknik Elektro dan Informatika. Akses koleksi karya ilmiah, skripsi, dan disertasi mahasiswa secara digital.
                </p>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center">
                    <button
                        type="button"
                        id="filterLiteratureBtn"
                        data-filter="literature"
                        data-route="{{ route('literatures.index') }}"
                        class="inline-flex items-center justify-center rounded-full bg-white px-5 py-2 text-xs sm:text-sm font-semibold text-slate-950 shadow-lg shadow-slate-950/15 transition hover:bg-slate-100">
                        Cari Literatur
                    </button>
                    <button
                        type="button"
                        id="filterSkripsiBtn"
                        data-filter="skripsi"
                        data-route="{{ route('skripsi.index') }}"
                        class="inline-flex items-center justify-center rounded-full border border-white/30 bg-white/10 px-5 py-2 text-xs sm:text-sm font-semibold text-white transition hover:bg-white/15">
                        Cari Skripsi
                    </button>
                </div>

                <form id="heroSearchForm" action="{{ route('literatures.index') }}" method="GET" class="mt-8">
                    <input type="hidden" id="filterTarget" name="filter_target" value="literature">
                    <div class="relative max-w-2xl">
                        <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.387a1 1 0 01-1.414 1.414l-4.387-4.387zm-1.4-6.82a5 5 0 11-10 0 5 5 0 0110 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <input id="search" name="search" type="search" placeholder="Cari judul skripsi, penulis, atau kata kunci..."
                            class="w-full rounded-full border border-white/20 bg-white/95 py-3 pl-12 pr-32 text-xs sm:text-sm text-slate-900 shadow-2xl shadow-slate-950/10 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-400/20">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-slate-950 px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-slate-950/30 transition hover:bg-slate-800">
                            Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection