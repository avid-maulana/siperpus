@extends('layouts.app')

@section('title', 'Dashboard Admin')

{{-- =========================================================
    ADMIN DASHBOARD JAVASCRIPT
========================================================== --}}
@push('scripts')
@vite('resources/js/home/admin.js')
@endpush


@section('content')

<div class="min-h-screen bg-slate-50 text-slate-800">

    <main class="mx-auto max-w-7xl px-4 pb-12 pt-10 sm:px-6 lg:px-8">

        {{-- =========================================================
            HEADER
        ========================================================== --}}
        <section class="mb-8">

            <div
                class="flex flex-col gap-4
                       sm:flex-row sm:items-end sm:justify-between">

                {{-- Welcome --}}
                <div>

                    <h1
                        class="mt-2 text-3xl font-bold
                               tracking-tight text-slate-950
                               sm:text-4xl">
                        Dashboard Admin
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">

                        Selamat datang,

                        <span class="font-semibold text-slate-700">
                            {{ ucwords(strtolower(Auth::user()->nama_lengkap)) }}
                        </span>

                    </p>

                </div>


                {{-- Date --}}
                <div
                    class="flex items-center gap-3
                           rounded-xl border border-slate-200
                           bg-white px-4 py-3 shadow-sm">

                    <div
                        class="flex h-9 w-9 items-center justify-center
                               rounded-lg bg-slate-100 text-slate-600">

                        <span class="material-symbols-outlined text-[19px]">
                            calendar_today
                        </span>

                    </div>

                    <div>

                        <p
                            class="text-[10px] font-semibold uppercase
                                   tracking-wider text-slate-400">
                            Hari ini
                        </p>

                        <p class="mt-0.5 text-sm font-semibold text-slate-700">
                            {{ now()->translatedFormat('d F Y') }}
                        </p>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
            STATISTICS
        ========================================================== --}}
        @include('home.admin._statistics')


        {{-- =========================================================
            DISTRIBUTION CHARTS
        ========================================================== --}}
        @include('home.admin._charts')


        {{-- =========================================================
            ACTIVITY & LATEST LITERATURE
        ========================================================== --}}
        <section class="mt-8">

            <div class="grid gap-6 lg:grid-cols-5">

                {{-- Login Activity --}}
                <div class="lg:col-span-3">

                    @include('home.admin._login-activity')

                </div>


                {{-- Latest Literatures --}}
                <div class="lg:col-span-2">

                    @include('home.admin._latest-literatures')

                </div>

            </div>

        </section>

    </main>

</div>

@endsection