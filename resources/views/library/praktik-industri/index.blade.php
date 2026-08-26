@extends('layouts.app')

@section('title', 'Kelola Praktik Industri')

@section('content')

<div class="min-h-screen bg-slate-50">

    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <section class="border-b border-slate-200 bg-white">

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

            <div
                class="flex flex-col gap-6
                       lg:flex-row
                       lg:items-end
                       lg:justify-between"
            >

                {{-- =================================================
                    TITLE
                ================================================== --}}

                <div>

                    <div
                        class="mb-3 inline-flex items-center gap-2
                               rounded-full
                               border border-slate-200
                               bg-slate-50
                               px-3 py-1.5
                               text-xs font-semibold
                               uppercase tracking-wider
                               text-slate-500"
                    >

                        <span
                            class="material-symbols-outlined
                                   text-[16px]
                                   text-[#212A37]"
                        >
                            business_center
                        </span>

                        Administrasi Repository

                    </div>


                    <h1
                        class="text-3xl font-bold
                               tracking-tight
                               text-[#212A37]
                               sm:text-4xl"
                    >
                        Kelola Praktik Industri
                    </h1>


                    <p
                        class="mt-2 max-w-2xl
                               text-sm leading-6
                               text-slate-500
                               sm:text-base"
                    >
                        Kelola laporan Praktik Industri berdasarkan
                        kelompok. Sistem menampilkan laporan terbaru
                        dan menyediakan riwayat revisi apabila tersedia.
                    </p>

                </div>


                {{-- =================================================
                    TOTAL KELOMPOK
                ================================================== --}}

                <div
                    class="flex shrink-0 items-center gap-3
                           rounded-2xl
                           border border-slate-200
                           bg-white
                           px-5 py-4
                           shadow-sm"
                >

                    <div
                        class="flex h-11 w-11
                               items-center
                               justify-center
                               rounded-xl
                               bg-[#212A37]
                               text-white"
                    >

                        <span class="material-symbols-outlined">
                            groups
                        </span>

                    </div>


                    <div>

                        <div
                            class="text-[10px]
                                   font-semibold
                                   uppercase
                                   tracking-widest
                                   text-slate-400"
                        >
                            Total Kelompok
                        </div>


                        <div
                            class="mt-0.5
                                   text-2xl
                                   font-bold
                                   text-[#212A37]"
                        >
                            {{ $laporan->total() }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- =========================================================
        MAIN
    ========================================================== --}}

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- SEARCH --}}

        @include(
            'library.praktik-industri._search'
        )


        {{-- RESULT --}}

        <div
            id="praktikIndustriAdminResult"
        >

            @include(
                'library.praktik-industri._result'
            )

        </div>


        {{-- PAGINATION --}}

<div id="praktikIndustriAdminPagination">
    @include('library.praktik-industri._pagination')
</div>
    </main>

</div>


{{-- =========================================================
    MODAL
========================================================= --}}

@include(
    'library.praktik-industri._modal'
)

@endsection