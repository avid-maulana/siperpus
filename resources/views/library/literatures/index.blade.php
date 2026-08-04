@extends('layouts.app')

@section('title', 'Manajemen Literatur')

@section('content')
<div class="container mx-auto p-6">

    {{-- Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-indigo-700">
            Manajemen Literatur
        </h2>
    </div>

    {{-- Flash Message --}}
    @if (session('success'))
    <div
        class="mb-4 rounded border border-green-300 bg-green-100 px-4 py-2 text-green-800 shadow"
        role="alert">
        {{ session('success') }}
    </div>
    @endif

    {{-- Form Tambah Literatur --}}
    @include('library.literatures._form')

    {{-- Daftar Literatur --}}
    @include('library.literatures._table')

    {{-- Modal Edit Literatur --}}
    @include('library.literatures._edit-modal')

</div>
@endsection


{{-- Temporary Script --}}
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


{{-- Temporary Styles --}}
<style>
    .input-field {
        @apply rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:ring focus:ring-indigo-200;
    }

    .btn-primary {
        @apply rounded bg-indigo-600 px-4 py-2 text-white transition hover:bg-indigo-700;
    }
</style>