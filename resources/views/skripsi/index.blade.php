@extends('layouts.app')

@section('title', 'Repository Skripsi')

@section('content')

{{-- Top Loader --}}
<div id="loading-bar"
    class="fixed top-0 left-0 z-[9999] h-1 w-0 bg-blue-600 opacity-0 transition-all duration-300 ease-out">
</div>

<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Header --}}
    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between mb-8">

        <div>

            <h1 class="text-3xl font-bold text-slate-800">
                Repository Skripsi
            </h1>

            <p id="result-info" class="mt-2 text-slate-500">

                Menampilkan

                <span class="font-semibold text-blue-600">

                    {{ number_format($skripsis->total(),0,',','.') }}

                </span>

                skripsi

            </p>

        </div>

        <div class="w-full lg:w-96">

            <div class="relative">

                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"
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
                    placeholder="Cari judul atau nama mahasiswa..."
                    class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4
                           focus:border-blue-500 focus:ring-4 focus:ring-blue-100
                           transition">

            </div>

        </div>

    </div>

    {{-- Result --}}
    {{-- Result --}}
<div id="top"></div>

<div id="skripsi-result">
    @include('skripsi._result')
</div>

</div>

@endsection