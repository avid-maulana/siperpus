@extends('layouts.app')

@section('title', 'Repository Tesis')

@section('content')

{{-- =========================================================
    HERO
========================================================= --}}
<section class="relative -mt-20 overflow-hidden">

    {{-- Background --}}
    <img
        src="{{ asset('gambar/rak 2.png') }}"
        alt="Repository Tesis"
        class="absolute inset-0 h-full w-full object-cover">

    {{-- Overlay --}}
    <div
        class="absolute inset-0
               bg-gradient-to-r
               from-[#212A37]/95
               via-[#212A37]/85
               to-[#212A37]/65">
    </div>


    {{-- Hero Content --}}
    <div
        class="relative mx-auto flex min-h-[500px]
               max-w-7xl items-center
               px-4 pb-24 pt-28
               sm:px-6 lg:px-8">

        <div
            class="grid w-full items-center gap-12
                   lg:grid-cols-[minmax(0,1fr)_300px]">

            {{-- =====================================================
                LEFT CONTENT
            ====================================================== --}}
            <div class="max-w-3xl">

                {{-- Label --}}
                <div
                    class="mb-6 inline-flex items-center gap-2
                           rounded-full
                           border border-white/10
                           bg-white/10
                           px-4 py-2
                           text-sm font-medium
                           text-white
                           shadow-sm
                           backdrop-blur-md">

                    <span
                        class="material-symbols-outlined text-[18px]">
                        school
                    </span>

                    Pascasarjana

                </div>


                {{-- Title --}}
                <h1
                    class="text-4xl font-bold leading-tight
                           tracking-tight text-white
                           sm:text-5xl lg:text-6xl">

                    Temukan Koleksi

                    <span class="block">
                        Tesis Akademik.
                    </span>

                </h1>


                {{-- Description --}}
                <p
                    class="mt-5 max-w-2xl
                           text-base leading-8
                           text-slate-300
                           sm:text-lg">

                    Jelajahi koleksi tesis akademik yang telah
                    tersedia di repository perpustakaan untuk
                    mendukung kebutuhan pembelajaran dan penelitian.

                </p>

            </div>


            {{-- =====================================================
                REPOSITORY STICKY NOTE
            ====================================================== --}}
            <div class="hidden justify-end lg:flex">

                <div
                    class="group relative w-full max-w-[270px]
                           rotate-[2deg]
                           bg-[#fffdf4]
                           px-7 pb-7 pt-9
                           shadow-[0_18px_45px_rgba(0,0,0,0.28)]
                           transition-all duration-300
                           hover:-translate-y-1
                           hover:rotate-0
                           hover:shadow-[0_24px_55px_rgba(0,0,0,0.32)]">

                    {{-- Tape --}}
                    <div
                        class="absolute -top-4 left-1/2
                               h-8 w-24
                               -translate-x-1/2 -rotate-2
                               bg-white/60
                               shadow-sm
                               backdrop-blur-[2px]">
                    </div>


                    {{-- Fold --}}
                    <div
                        class="absolute bottom-0 right-0
                               h-8 w-8
                               bg-gradient-to-tl
                               from-[#e8e4d5]
                               to-[#fffdf4]
                               shadow-[-3px_-3px_6px_rgba(0,0,0,0.06)]">
                    </div>


                    <div class="relative">

                        {{-- Icon --}}
                        <div
                            class="flex h-11 w-11
                                   items-center justify-center
                                   rounded-xl
                                   bg-[#212A37]
                                   text-white
                                   shadow-sm">

                            <span
                                class="material-symbols-outlined text-[22px]">
                                school
                            </span>

                        </div>


                        {{-- Label --}}
                        <p
                            class="mt-6
                                   text-[11px]
                                   font-bold
                                   uppercase
                                   tracking-wide
                                   text-slate-500">

                            Total Repository

                        </p>


                        {{-- Total --}}
                        <div class="mt-2 flex items-end gap-2">

                            <h2
                                class="text-5xl
                                       font-bold
                                       tracking-tight
                                       text-[#212A37]">

                                @if ($total >= 1000000)
                                    {{ rtrim(rtrim(number_format($total / 1000000, 1, ',', ''), '0'), ',') }}M+
                                @elseif ($total >= 1000)
                                    {{ rtrim(rtrim(number_format($total / 1000, 1, ',', ''), '0'), ',') }}K+
                                @else
                                    {{ $total }}
                                @endif

                            </h2>

                            <span
                                class="mb-1.5
                                       text-sm
                                       font-semibold
                                       text-slate-500">

                                Tesis

                            </span>

                        </div>


                        {{-- Divider --}}
                        <div
                            class="my-4
                                   border-t
                                   border-dashed
                                   border-slate-300">
                        </div>


                        {{-- Description --}}
                        <p
                            class="text-sm
                                   leading-6
                                   text-slate-500">

                            Total koleksi tesis akademik
                            yang tersedia di repository.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
    SEARCH CARD
========================================================= --}}
<div
    class="relative z-20 mx-auto -mt-12
           max-w-7xl
           px-4
           sm:px-6
           lg:px-8">

    <div
        class="rounded-[24px]
               border border-slate-200
               bg-white
               px-6 py-5
               shadow-[0_20px_50px_-20px_rgba(15,23,42,0.22)]
               sm:px-7">

        @include('theses._filter')

    </div>

</div>


{{-- =========================================================
    RESULT
========================================================= --}}
<section
    id="thesisResult"
    class="mx-auto mt-8
           max-w-7xl
           px-4 pb-12
           sm:px-6 lg:px-8">

    @include(
        'theses._result',
        [
            'theses' => $theses,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'total' => $total,
        ]
    )

</section>

@endsection