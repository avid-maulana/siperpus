@extends('layouts.app')

@section('title', 'Manajemen Literatur')

@section('content')
<div class="min-h-screen bg-[#F5F7FB]">
    <div class="mx-auto max-w-[1400px] px-4 py-8 sm:px-6 lg:px-8">

        @php
            $availableYears = collect($literatures->items())
                ->pluck('year')
                ->filter()
                ->unique()
                ->sortDesc()
                ->values();
        @endphp

        {{-- Page Header --}}
        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-600">
                Library
            </p>
            <h1 class="mt-1 text-3xl font-semibold text-slate-900">
                Manajemen Literatur
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Tambahkan, perbarui, atau hapus koleksi literatur digital.
            </p>
        </div>

        @if (session('success'))
            <div
                class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm"
                role="alert"
            >
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col gap-6">

            {{-- Section: Tambah Literatur (collapsible) --}}
            <section
                id="add-literature-form"
                class="rounded-3xl border border-slate-200 bg-white shadow-[0_16px_45px_rgba(15,23,42,0.05)]"
            >
                <button
                    type="button"
                    id="add-literature-toggle"
                    aria-expanded="false"
                    aria-controls="add-literature-panel"
                    onclick="toggleAddLiteratureForm()"
                    class="flex w-full items-start gap-4 rounded-3xl p-6 text-left transition hover:bg-slate-50 focus:outline-none focus-visible:ring-4 focus-visible:ring-blue-500/20 sm:p-8"
                >
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                        <span class="material-symbols-outlined text-[24px]">library_add</span>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-slate-900 sm:text-2xl">
                            Tambah Literatur
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Klik untuk membuka formulir dan menambahkan literatur baru ke koleksi.
                        </p>
                    </div>
                    <span id="add-literature-chevron" class="mt-2 shrink-0 text-slate-400 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>

                <div id="add-literature-panel" class="grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-in-out">
                    <div class="overflow-hidden">
                        <div class="border-t border-slate-200 px-6 pb-8 pt-6 sm:px-8">
                            @include('library.literatures._form')
                        </div>
                    </div>
                </div>
            </section>

            {{-- Section: Daftar Literatur --}}
            <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_16px_45px_rgba(15,23,42,0.05)] sm:p-8">
                <div class="mb-6 flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                        <span class="material-symbols-outlined text-[24px]">library_books</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900 sm:text-2xl">
                            Daftar Literatur
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Kelola koleksi literatur yang sudah tersedia.
                        </p>
                    </div>
                </div>

                @include('library.literatures._table')
            </section>

        </div>
    </div>
</div>

<script>
    function toggleAddLiteratureForm() {
        const toggle = document.getElementById('add-literature-toggle');
        const panel = document.getElementById('add-literature-panel');
        const chevron = document.getElementById('add-literature-chevron');
        if (!toggle || !panel || !chevron) return;

        const isOpen = toggle.getAttribute('aria-expanded') === 'true';

        toggle.setAttribute('aria-expanded', String(!isOpen));
        panel.classList.toggle('grid-rows-[0fr]', isOpen);
        panel.classList.toggle('grid-rows-[1fr]', !isOpen);
        chevron.classList.toggle('rotate-180', !isOpen);

        if (!isOpen) {
            const firstField = panel.querySelector('input, select, textarea');
            if (firstField) {
                window.requestAnimationFrame(() => firstField.focus({ preventScroll: true }));
            }
        }
    }

    @if ($errors->any() || old())
        // Form sempat disubmit dan gagal validasi di server, jadi panel
        // dibuka otomatis supaya pesan error langsung terlihat.
        document.addEventListener('DOMContentLoaded', () => {
            toggleAddLiteratureForm();
        });
    @endif
</script>
@endsection