@extends('layouts.app')

@section('title', 'Manajemen Literatur')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-indigo-50/40">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-100 sm:p-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm font-medium text-indigo-600">Library Dashboard</p>
                    <h2 class="mt-1 text-3xl font-bold tracking-tight text-gray-900">
                        Manajemen Literatur
                    </h2>
                    <p class="mt-2 text-sm text-gray-500">
                        Kelola data literatur, tambah, edit, dan pantau daftar koleksi dengan lebih mudah.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <div class="rounded-2xl bg-indigo-50 px-4 py-3 text-center">
                        <p class="text-xs font-medium text-indigo-500">Total Data</p>
                        <p class="text-lg font-bold text-indigo-700">
                            {{ $literatures->count() ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div
                class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-4 text-green-800 shadow-sm"
                role="alert">
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 rounded-full bg-green-100 p-2 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707a1 1 0 00-1.414-1.414L9 12.172l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">Berhasil</p>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="space-y-8">
            {{-- Form Tambah Literatur --}}
            @include('library.literatures._form')

            {{-- Daftar Literatur --}}
            @include('library.literatures._table')
        </div>

        {{-- Modal Edit Literatur --}}
        @include('library.literatures._edit-modal')

    </div>
</div>
@endsection

@section('scripts')
<script>
    function showEditModal(button) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');

        if (!modal || !form) return;

        const actionTemplate = form.dataset.actionTemplate;

        form.action = actionTemplate.replace('__ID__', button.dataset.id);

        form.elements['cover_url'].value = button.dataset.cover_url || '';
        form.elements['title'].value = button.dataset.title || '';
        form.elements['author'].value = button.dataset.author || '';
        form.elements['publisher'].value = button.dataset.publisher || '';
        form.elements['year'].value = button.dataset.year || '';
        form.elements['file_url'].value = button.dataset.file_url || '';
        form.elements['category_id'].value = button.dataset.category_id || '';
        form.elements['detail'].value = button.dataset.detail || '';
        form.elements['description'].value = button.dataset.description || '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideEditModal() {
        const modal = document.getElementById('editModal');
        if (!modal) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection