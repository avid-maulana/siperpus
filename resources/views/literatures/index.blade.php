@extends('layouts.app')

@section('title', 'Daftar Literatur')

@section('content')

<div class="min-h-screen bg-slate-50 text-slate-800">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 lg:py-10">
       
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8 lg:p-10">
            
            <div class="flex flex-col gap-8 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                        Temukan Referensi Terbaik untuk Penelitianmu.
                    </h1>
                    <p class="mt-3 text-base leading-relaxed text-slate-600 sm:text-lg">
                        Cari buku, jurnal, skripsi, dan berbagai literatur akademik untuk mendukung pembelajaran maupun penelitian.
                    </p>
                </div>

              
                <div class="flex items-center divide-x divide-slate-200 border-t border-slate-100 pt-6 lg:border-t-0 lg:pt-0">
                    <div class="pr-5 sm:pr-8">
                        <p class="text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">{{ $literatures->total() }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500 sm:text-sm sm:normal-case sm:tracking-normal">Literatur</p>
                    </div>
                    <div class="px-5 sm:px-8">
                        <p class="text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">{{ $types->count() }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500 sm:text-sm sm:normal-case sm:tracking-normal">Tipe</p>
                    </div>
                    <div class="pl-5 sm:pl-8">
                        <p class="text-2xl font-semibold tracking-tight text-slate-900 sm:text-3xl">{{ $categories->count() }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-slate-500 sm:text-sm sm:normal-case sm:tracking-normal">Kategori</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-8">
                @include('literatures._search')
            </div>
        </div>
    </div>

    <section id="resultsContainer" class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        @include('literatures._result')
    </section>
</div>

@endsection