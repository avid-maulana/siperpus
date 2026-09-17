@extends('layouts.app')

@section('title', 'Journal - Ebook & Ejurnal')

@section('content')

    <div class="mx-auto max-w-7xl px-4 pb-16 pt-8 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Journal</h1>
            <p class="mt-1 text-sm text-slate-500">
                Daftar Ebook &amp; Ejurnal yang dilanggan
                <a href="https://lib.um.ac.id/" target="_blank" rel="noopener"
                   class="font-medium text-[#212A37] underline underline-offset-2 hover:text-slate-600">
                    UPT Perpustakaan UM
                </a>. Untuk akses dari luar kampus, gunakan
                <a href="https://eduvpn.um.ac.id/" target="_blank" rel="noopener"
                   class="font-medium text-[#212A37] underline underline-offset-2 hover:text-slate-600">
                    Eduvpn UM
                </a>.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
            @foreach ($journals as $journal)
                <button type="button"
                    class="journal-item group flex flex-col items-center gap-3
                           rounded-2xl border border-slate-200 bg-white
                           p-4 text-center shadow-sm
                           transition-all duration-200
                           hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md"
                    data-name="{{ $journal['name'] }}"
                    data-logo="{{ $journal['logo'] }}"
                    data-url="{{ $journal['url'] }}">

                    <span class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-xl bg-slate-50">
                        <img src="{{ $journal['logo'] }}" alt="{{ $journal['name'] }}"
                             class="h-full w-full object-contain" loading="lazy">
                    </span>

                    <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">
                        {{ $journal['name'] }}
                    </span>
                </button>
            @endforeach
        </div>

    </div>


    {{-- =========================================================
    JOURNAL MODAL
    ========================================================= --}}

    @include('journal._modal')


    {{-- =========================================================
    JOURNAL SCRIPTS
    ========================================================= --}}

    @vite([
        'resources/js/journal.js',
    ])

@endsection