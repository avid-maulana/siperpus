@extends('layouts.app')

@section('title', 'Kelola Literatur')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800">

    @php
        $availableYears = collect($literatures->items())
            ->pluck('year')
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();
    @endphp

    {{-- Hero --}}
    <section class="relative -mt-20 overflow-hidden">
        <img
            src="{{ asset('gambar/rak 4.png') }}"
            alt="Koleksi Literatur"
            class="absolute inset-0 h-full w-full object-cover"
        >

        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-900/85 to-slate-800/70"></div>

        <div class="relative mx-auto flex min-h-[380px] max-w-7xl items-center px-4 py-20 sm:px-6 lg:px-8">
            <div class="max-w-2xl">

                <h1 class="text-4xl font-bold leading-tight text-white sm:text-5xl">
                    Kelola Literatur
                </h1>

                <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-300 sm:text-lg">
                    Tambahkan, perbarui, atau hapus koleksi literatur digital.
                </p>

            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <div class="relative z-20 mx-auto -mt-12 max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700 shadow-sm"
                role="alert"
            >
                <span class="material-symbols-outlined text-[20px] text-emerald-600">
                    check_circle
                </span>

                <span>
                    {{ session('success') }}
                </span>
            </div>
        @endif

        <div class="flex flex-col gap-6">


            {{-- =================================================
                TAMBAH LITERATUR
            ================================================== --}}
            <section
                id="add-literature-form"
                class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_16px_45px_rgba(15,23,42,0.08)] transition-all duration-300 hover:border-blue-300 hover:shadow-[0_20px_50px_rgba(37,99,235,0.10)]"
            >

                {{-- Toggle --}}
                <button
                    type="button"
                    id="add-literature-toggle"
                    aria-expanded="false"
                    aria-controls="add-literature-panel"
                    onclick="toggleAddLiteratureForm()"
                    class="flex w-full cursor-pointer items-start gap-4 p-6 text-left transition-colors duration-300 hover:bg-blue-50/30 focus:outline-none focus-visible:ring-4 focus-visible:ring-inset focus-visible:ring-blue-500/20 sm:p-8"
                >

                    {{-- Icon --}}
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 transition-all duration-300 group-hover:bg-blue-600 group-hover:text-white"
                    >
                        <span
                            class="material-symbols-outlined text-[24px]"
                            style="font-variation-settings: 'wght' 400;"
                        >
                            library_add
                        </span>
                    </div>


                    {{-- Text --}}
                    <div class="min-w-0 flex-1">

                        <h2
                            class="text-xl font-semibold text-slate-900 transition-colors duration-300 group-hover:text-blue-600 sm:text-2xl"
                        >
                            Tambah Literatur
                        </h2>

                        <p class="mt-1 text-sm leading-relaxed text-slate-500">
                            Klik untuk membuka formulir dan menambahkan literatur baru ke koleksi.
                        </p>

                    </div>


                    {{-- Chevron --}}
                    <span
                        id="add-literature-chevron"
                        class="mt-2 shrink-0 text-slate-400 transition-all duration-300 group-hover:text-blue-600"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </span>

                </button>


                {{-- Collapsible Panel --}}
                <div
                    id="add-literature-panel"
                    class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-in-out"
                >
                    <div class="overflow-hidden">

                        <div
                            class="border-t border-slate-200 px-6 pb-8 pt-6 sm:px-8"
                        >
                            @include('library.literatures._form')
                        </div>

                    </div>
                </div>

            </section>


            {{-- =================================================
                DAFTAR LITERATUR
            ================================================== --}}
            <section
                class="rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_16px_45px_rgba(15,23,42,0.05)] sm:p-8"
            >

                {{-- Header --}}
                <div class="mb-6 flex items-start gap-4">

                    {{-- Icon --}}
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600"
                    >
                        <span
                            class="material-symbols-outlined text-[24px]"
                            style="font-variation-settings: 'wght' 400;"
                        >
                            library_books
                        </span>
                    </div>


                    {{-- Text --}}
                    <div class="min-w-0">

                        <h2 class="text-xl font-semibold text-slate-900 sm:text-2xl">
                            Daftar Literatur
                        </h2>

                        <p class="mt-1 text-sm leading-relaxed text-slate-500">
                            Kelola koleksi literatur yang sudah tersedia.
                        </p>

                    </div>

                </div>


                {{-- Table --}}
                @include('library.literatures._table')

            </section>

        </div>

    </main>

</div>


{{-- =============================================================
    EDIT LITERATURE MODAL
============================================================== --}}
@include('library.literatures._edit-modal')


{{-- =============================================================
    SCRIPT
============================================================== --}}
<script>
    function toggleAddLiteratureForm() {
        const toggle = document.getElementById('add-literature-toggle');
        const panel = document.getElementById('add-literature-panel');
        const chevron = document.getElementById('add-literature-chevron');

        if (!toggle || !panel || !chevron) {
            return;
        }

        const isOpen = toggle.getAttribute('aria-expanded') === 'true';

        // Update state
        toggle.setAttribute('aria-expanded', String(!isOpen));

        // Buka / tutup panel
        panel.classList.toggle('grid-rows-[0fr]', isOpen);
        panel.classList.toggle('grid-rows-[1fr]', !isOpen);

        // Putar chevron
        chevron.classList.toggle('rotate-180', !isOpen);

        // Fokus ke input pertama saat form dibuka
        if (!isOpen) {
            const firstField = panel.querySelector(
                'input, select, textarea'
            );

            if (firstField) {
                window.requestAnimationFrame(() => {
                    firstField.focus({
                        preventScroll: true
                    });
                });
            }
        }
    }


    function closeAddLiteratureForm() {
        const toggle = document.getElementById('add-literature-toggle');
        const panel = document.getElementById('add-literature-panel');
        const chevron = document.getElementById('add-literature-chevron');

        if (!toggle || !panel || !chevron) {
            return;
        }

        // Jika form sudah tertutup
        if (toggle.getAttribute('aria-expanded') !== 'true') {
            return;
        }

        // Update state
        toggle.setAttribute('aria-expanded', 'false');

        // Tutup panel
        panel.classList.remove('grid-rows-[1fr]');
        panel.classList.add('grid-rows-[0fr]');

        // Reset chevron
        chevron.classList.remove('rotate-180');
    }


    {{-- Buka form otomatis jika validasi gagal --}}
    @if ($errors->any() || old())
        document.addEventListener('DOMContentLoaded', () => {
            toggleAddLiteratureForm();
        });
    @endif
</script>

@endsection