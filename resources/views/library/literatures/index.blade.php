@extends('layouts.app')

@section('title', 'Manajemen Literatur')

@section('content')
<div class="min-h-screen bg-[#F5F7FB]">
    <div class="mx-auto max-w-[1400px] px-4 py-8 sm:px-6 lg:px-8">

        <div class="mb-6 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#2563EB]">
                    Library
                </p>
                <h2 class="mt-1 text-3xl font-semibold text-[#1F2937]">
                    Manajemen Literatur
                </h2>
            </div>
        </div>

        <div class="rounded-[24px] border border-[#E5E7EB] bg-white p-6 shadow-[0_16px_45px_rgba(15,23,42,0.05)] sm:p-8">

            <div class="mb-8 flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-[#2563EB]">
                        <span class="material-symbols-outlined text-[24px]">library_books</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-[#1F2937]">
                            Daftar Literatur
                        </h3>
                        <p class="mt-1 text-sm text-slate-500">
                            Kelola koleksi literatur dengan tampilan yang lebih modern dan rapi.
                        </p>
                    </div>
                </div>

                <a
                    href="#add-literature-form"
                    class="inline-flex items-center justify-center rounded-xl bg-[#2563EB] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700"
                >
                    + Tambah Literatur
                </a>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 shadow-sm"
                    role="alert"
                >
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-8 rounded-[20px] border border-[#E5E7EB] bg-[#FCFDFF] p-5 shadow-sm">
                @include('library.literatures._form')
            </div>

            @php
                $availableYears = collect($literatures->items())
                    ->pluck('year')
                    ->filter()
                    ->unique()
                    ->sortDesc()
                    ->values();
            @endphp

            @include('library.literatures._table')
        </div>
    </div>
</div>
@endsection

<script>
    function showEditModal(button) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');

        if (!modal || !form) {
            return;
        }

        const actionTemplate = form.dataset.actionTemplate;

        form.action = actionTemplate.replace(
            '__ID__',
            button.dataset.id
        );

        form.elements['cover_url'].value =
            button.dataset.cover_url || '';

        form.elements['title'].value =
            button.dataset.title || '';

        form.elements['author'].value =
            button.dataset.author || '';

        form.elements['publisher'].value =
            button.dataset.publisher || '';

        form.elements['year'].value =
            button.dataset.year || '';

        form.elements['file_url'].value =
            button.dataset.file_url || '';

        form.elements['category_id'].value =
            button.dataset.category_id || '';

        form.elements['detail'].value =
            button.dataset.detail || '';

        form.elements['description'].value =
            button.dataset.description || '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideEditModal() {
        const modal = document.getElementById('editModal');

        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

<style>
    .input-field {
        @apply rounded-xl border border-[#E5E7EB] bg-white px-4 py-3 text-sm text-slate-700 shadow-sm outline-none transition focus:border-[#2563EB] focus:ring-2 focus:ring-blue-100;
    }

    .btn-primary {
        @apply rounded-xl bg-[#2563EB] px-4 py-3 text-sm font-semibold text-white transition hover:bg-blue-700;
    }
</style>