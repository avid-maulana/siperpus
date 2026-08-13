@extends('layouts.app')

@section('title', 'Kelola Repository')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-10">

    {{-- ============================================================ --}}
    {{-- HEADER --}}
    {{-- ============================================================ --}}

    <div class="mb-8">

        <div class="flex items-center gap-3">

            <div
                class="flex h-12 w-12 items-center justify-center
                       rounded-2xl bg-slate-100 text-slate-600">

                <span class="material-symbols-outlined text-[26px]">
                    library_books
                </span>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-slate-800">
                    Kelola Repository
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Kelola repository tesis dan disertasi dari sumber data SIADMIN.
                </p>

            </div>

        </div>

    </div>


    {{-- ============================================================ --}}
    {{-- SEARCH + FILTER --}}
    {{-- ============================================================ --}}

    <div class="mb-8">

        <form
            id="repositoryManageSearchForm"
            method="GET"
            action="{{ route('library.repositories') }}">

            <div class="flex flex-col gap-3 lg:flex-row">

                {{-- SEARCH --}}

                <div class="relative flex-1">

                    <span
                        class="material-symbols-outlined
                               absolute left-4 top-1/2
                               -translate-y-1/2
                               text-[20px] text-slate-400">

                        search

                    </span>

                    <input
                        id="repositoryManageSearchInput"
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari judul karya, NIM, atau nama mahasiswa..."
                        autocomplete="off"
                        class="w-full rounded-2xl border border-slate-200
                               bg-white py-3.5 pl-12 pr-4
                               text-sm text-slate-700
                               shadow-sm outline-none transition
                               focus:border-slate-400
                               focus:ring-2 focus:ring-slate-200">

                </div>


                {{-- FILTER JENIS --}}

                <div class="relative lg:w-52">

                    <span
                        class="material-symbols-outlined
                               absolute left-4 top-1/2
                               -translate-y-1/2
                               text-[20px] text-slate-400">

                        filter_list

                    </span>

                    <select
                        id="repositoryJenisFilter"
                        name="jenis"
                        class="w-full appearance-none rounded-2xl
                               border border-slate-200
                               bg-white py-3.5 pl-12 pr-10
                               text-sm text-slate-700
                               shadow-sm outline-none transition
                               focus:border-slate-400
                               focus:ring-2 focus:ring-slate-200">

                        <option value="">
                            Semua Jenis
                        </option>

                        <option
                            value="thesis"
                            @selected(request('jenis')==='thesis' )>

                            Tesis

                        </option>

                        <option
                            value="dissertation"
                            @selected(request('jenis')==='dissertation' )>

                            Disertasi

                        </option>

                    </select>


                    <span
                        class="material-symbols-outlined
                               pointer-events-none
                               absolute right-4 top-1/2
                               -translate-y-1/2
                               text-[20px] text-slate-400">

                        expand_more

                    </span>

                </div>

            </div>

        </form>

    </div>


    {{-- ============================================================ --}}
    {{-- SUMMARY --}}
    {{-- ============================================================ --}}

    <div class="mb-8 grid grid-cols-1 gap-4 md:grid-cols-3">


        {{-- PERLU PENANGANAN --}}

        <div
            class="rounded-2xl border border-amber-100
                   bg-amber-50 p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-amber-600">
                        Perlu Penanganan
                    </p>

                    <p
                        id="repositoryNeedsActionCount"
                        class="mt-1 text-2xl font-bold text-amber-900">

                        {{ $totalNeedsAction }}

                    </p>

                </div>


                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-white text-amber-600 shadow-sm">

                    <span class="material-symbols-outlined">
                        warning
                    </span>

                </div>

            </div>

            <p class="mt-3 text-xs text-amber-700">
                Repository sudah tersedia tetapi masih membutuhkan penanganan.
            </p>

        </div>


        {{-- BELUM ADA --}}

        <div
            class="rounded-2xl border border-slate-200
                   bg-white p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Belum Ada Repository
                    </p>

                    <p
                        id="repositoryWithoutCount"
                        class="mt-1 text-2xl font-bold text-slate-800">

                        {{ $totalWithoutRepository }}

                    </p>

                </div>


                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-slate-100 text-slate-500">

                    <span class="material-symbols-outlined">
                        link_off
                    </span>

                </div>

            </div>

            <p class="mt-3 text-xs text-slate-500">
                Data karya yang belum memiliki repository SIPERPUS.
            </p>

        </div>


        {{-- AKTIF --}}

        <div
            class="rounded-2xl border border-emerald-100
                   bg-emerald-50 p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600">
                        Repository Aktif
                    </p>

                    <p
                        id="repositoryActiveCount"
                        class="mt-1 text-2xl font-bold text-emerald-900">

                        {{ $totalActive }}

                    </p>

                </div>


                <div
                    class="flex h-11 w-11 items-center justify-center
                           rounded-xl bg-white text-emerald-600 shadow-sm">

                    <span class="material-symbols-outlined">
                        check_circle
                    </span>

                </div>

            </div>

            <p class="mt-3 text-xs text-emerald-700">
                Repository yang sudah aktif dan siap digunakan.
            </p>

        </div>

    </div>


    {{-- ============================================================ --}}
    {{-- TABLE RESULT --}}
    {{-- ============================================================ --}}

    <div id="repositoryManageResult">

        @include(
        'library.repositories._table',
        [
        'needsAction' => $needsAction,
        'withoutRepository' => $withoutRepository,
        'active' => $active,
        ]
        )

    </div>

</div>



{{-- ================================================================= --}}
{{-- MODAL REPOSITORY --}}
{{-- ================================================================= --}}

<div
    id="repositoryModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center p-4">

    {{-- BACKDROP --}}

    <div
        id="repositoryModalBackdrop"
        class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm">
    </div>


    {{-- MODAL --}}

    <div
        id="repositoryModalPanel"
        class="relative z-10 flex max-h-[90vh] w-full max-w-2xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">


        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <div
            class="flex shrink-0 items-start justify-between border-b border-slate-100 px-6 py-5">

            <div class="flex min-w-0 items-center gap-3">

                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600">

                    <span
                        class="material-symbols-outlined text-[22px]">
                        folder_managed
                    </span>

                </div>

                <div class="min-w-0">

                    <h2
                        id="repositoryModalTitle"
                        class="text-lg font-bold text-slate-800">

                        Atur Repository

                    </h2>

                    <p
                        id="repositoryModalSubtitle"
                        class="mt-0.5 text-sm text-slate-500">

                        Kelola repository tesis atau disertasi SIPERPUS.

                    </p>

                </div>

            </div>


            <button
                type="button"
                id="repositoryModalClose"
                class="ml-4 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">

                <span class="material-symbols-outlined text-[22px]">
                    close
                </span>

            </button>

        </div>



        {{-- ========================================================= --}}
        {{-- CONTENT --}}
        {{-- ========================================================= --}}

        <div class="min-h-0 flex-1 overflow-y-auto">

            <div class="space-y-6 px-6 py-6">


                {{-- ================================================= --}}
                {{-- INFORMASI SUMBER --}}
                {{-- ================================================= --}}

                <div>

                    <div class="mb-3">

                        <h3 class="text-sm font-bold text-slate-800">
                            Informasi Karya
                        </h3>

                        <p class="mt-1 text-xs text-slate-400">
                            Data karya berasal dari SIADMIN dan tidak diubah oleh SIPERPUS.
                        </p>

                    </div>


                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">

                        <div class="space-y-4">


                            {{-- JUDUL --}}

                            <div>

                                <p
                                    class="mb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">

                                    Judul Karya

                                </p>

                                <p
                                    id="repositoryModalJudul"
                                    class="text-sm font-semibold leading-6 text-slate-800">

                                    -

                                </p>

                            </div>


                            {{-- JENIS + NIM --}}

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                                <div>

                                    <p
                                        class="mb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">

                                        Jenis Karya Tersimpan

                                    </p>

                                    <p
                                        id="repositoryModalJenis"
                                        class="text-sm font-semibold text-slate-700">

                                        Belum Ditentukan

                                    </p>

                                </div>


                                <div>

                                    <p
                                        class="mb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">

                                        NIM

                                    </p>

                                    <p
                                        id="repositoryModalNim"
                                        class="text-sm font-medium text-slate-700">

                                        -

                                    </p>

                                </div>

                            </div>


                            {{-- NAMA --}}

                            <div>

                                <p
                                    class="mb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">

                                    Nama

                                </p>

                                <p
                                    id="repositoryModalNama"
                                    class="text-sm font-medium text-slate-700">

                                    -

                                </p>

                            </div>


                            {{-- ID PENGAJUAN --}}

                            <div>

                                <p
                                    class="mb-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">

                                    ID Pengajuan

                                </p>

                                <p
                                    id="repositoryModalIdPengajuan"
                                    class="font-mono text-xs text-slate-500">

                                    -

                                </p>

                            </div>


                            {{-- SUMBER ASLI --}}

                            <div>

                                <p
                                    class="mb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">

                                    Sumber Data SIADMIN

                                </p>

                                <a
                                    id="repositorySourceLink"
                                    href="#"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">

                                    <span class="material-symbols-outlined text-[17px]">
                                        open_in_new
                                    </span>

                                    Buka Sumber Data

                                </a>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- REPOSITORY SIPERPUS --}}
                {{-- ================================================= --}}

                <div>

                    <div class="mb-4">

                        <h3 class="text-sm font-bold text-slate-800">
                            Repository SIPERPUS
                        </h3>

                        <p class="mt-1 text-xs text-slate-400">
                            Jenis karya dan repository ditentukan serta dikelola oleh admin SIPERPUS.
                        </p>

                    </div>


                    <form
                        id="repositoryForm"
                        method="POST"
                        action="">

                        @csrf

                        <input
                            type="hidden"
                            name="_method"
                            id="repositoryFormMethod"
                            value="POST">

                        <input
                            type="hidden"
                            name="id_pengajuan"
                            id="repositoryIdPengajuan">


                        {{-- ================================================= --}}
                        {{-- JENIS KARYA --}}
                        {{-- ================================================= --}}

                        <div class="mb-5">

                            <label
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                Jenis Karya

                            </label>

                            <p class="mb-3 text-xs text-slate-400">
                                Tentukan apakah karya ini merupakan tesis atau disertasi.
                            </p>


                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">


                                {{-- TESIS --}}

                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="jenis_karya"
                                        value="thesis"
                                        id="repositoryJenisThesis"
                                        class="peer sr-only">

                                    <div
                                        class="rounded-2xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-100">

                                        <div class="flex items-start gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500 peer-checked:bg-blue-100 peer-checked:text-blue-600">

                                                <span class="material-symbols-outlined text-[21px]">
                                                    description
                                                </span>

                                            </div>

                                            <div>

                                                <p class="text-sm font-semibold text-slate-800">
                                                    Tesis
                                                </p>

                                                <p class="mt-0.5 text-xs leading-5 text-slate-400">
                                                    Tandai karya sebagai tesis.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </label>


                                {{-- DISERTASI --}}

                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="jenis_karya"
                                        value="dissertation"
                                        id="repositoryJenisDissertation"
                                        class="peer sr-only">

                                    <div
                                        class="rounded-2xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-100">

                                        <div class="flex items-start gap-3">

                                            <div
                                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">

                                                <span class="material-symbols-outlined text-[21px]">
                                                    school
                                                </span>

                                            </div>

                                            <div>

                                                <p class="text-sm font-semibold text-slate-800">
                                                    Disertasi
                                                </p>

                                                <p class="mt-0.5 text-xs leading-5 text-slate-400">
                                                    Tandai karya sebagai disertasi.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </label>

                            </div>


                            <p
                                id="repositoryJenisError"
                                class="mt-2 hidden text-xs font-medium text-red-600">

                                Silakan pilih jenis karya terlebih dahulu.

                            </p>

                        </div>



                        {{-- ================================================= --}}
                        {{-- TIPE REPOSITORY --}}
                        {{-- ================================================= --}}

                        <div class="mb-5">

                            <label
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                Tipe Repository

                            </label>

                            <p class="mb-3 text-xs text-slate-400">
                                Tentukan apakah URL mengarah langsung ke file atau folder.
                            </p>


                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">


                                {{-- FILE --}}

                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="repository_type"
                                        value="file"
                                        id="repositoryTypeFile"
                                        class="peer sr-only">

                                    <div
                                        class="rounded-2xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-100">

                                        <div class="flex items-center gap-3">

                                            <span
                                                class="material-symbols-outlined text-[21px] text-slate-500">

                                                draft

                                            </span>

                                            <div>

                                                <p class="text-sm font-semibold text-slate-800">
                                                    File
                                                </p>

                                                <p class="mt-0.5 text-xs text-slate-400">
                                                    Langsung menuju file repository.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </label>


                                {{-- FOLDER --}}

                                <label class="cursor-pointer">

                                    <input
                                        type="radio"
                                        name="repository_type"
                                        value="folder"
                                        id="repositoryTypeFolder"
                                        class="peer sr-only">

                                    <div
                                        class="rounded-2xl border border-slate-200 bg-white p-4 transition hover:border-slate-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:ring-2 peer-checked:ring-blue-100">

                                        <div class="flex items-center gap-3">

                                            <span
                                                class="material-symbols-outlined text-[21px] text-slate-500">

                                                folder

                                            </span>

                                            <div>

                                                <p class="text-sm font-semibold text-slate-800">
                                                    Folder
                                                </p>

                                                <p class="mt-0.5 text-xs text-slate-400">
                                                    Menuju folder yang berisi repository.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </label>

                            </div>

                        </div>



                        {{-- ================================================= --}}
                        {{-- URL REPOSITORY --}}
                        {{-- ================================================= --}}

                        <div class="mb-5">

                            <label
                                for="repositoryUrl"
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                URL Repository

                            </label>

                            <div class="relative">

                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-[19px] text-slate-400">

                                    link

                                </span>

                                <input
                                    type="url"
                                    name="repository_url"
                                    id="repositoryUrl"
                                    placeholder="https://..."
                                    autocomplete="off"
                                    class="w-full rounded-2xl border border-slate-200 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-100">

                            </div>

                            <p class="mt-2 text-xs text-slate-400">
                                Kosongkan URL jika repository ingin dihapus.
                            </p>

                        </div>



                        {{-- ================================================= --}}
                        {{-- STATUS INFO --}}
                        {{-- ================================================= --}}

                        <div
                            id="repositoryStatusInfo"
                            class="rounded-2xl border border-amber-100 bg-amber-50 p-4">

                            <div class="flex items-start gap-3">

                                <span
                                    id="repositoryStatusIcon"
                                    class="material-symbols-outlined mt-0.5 text-[20px] text-amber-500">

                                    link_off

                                </span>

                                <div>

                                    <p
                                        id="repositoryStatusTitle"
                                        class="text-sm font-semibold text-amber-800">

                                        Belum Ada Repository

                                    </p>

                                    <p
                                        id="repositoryStatusDescription"
                                        class="mt-1 text-xs leading-5 text-amber-700">

                                        Repository belum tersedia. Tambahkan URL repository untuk memulai proses penanganan.

                                    </p>

                                </div>

                            </div>

                        </div>


                    </form>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- FOOTER --}}
        {{-- ========================================================= --}}

        <div
            class="flex shrink-0 items-center justify-between gap-3 border-t border-slate-100 bg-white px-6 py-4">


            {{-- DELETE --}}

            <div>

                <button
                    type="button"
                    id="repositoryDeleteBtn"
                    class="hidden inline-flex items-center gap-2 rounded-xl px-3.5 py-2.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">

                    <span class="material-symbols-outlined text-[18px]">
                        delete
                    </span>

                    Hapus Repository

                </button>

            </div>


            {{-- RIGHT --}}

            <div class="flex items-center gap-2">

                <button
                    type="button"
                    id="repositoryCancelBtn"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50">

                    Batal

                </button>


                {{-- ACTIVATE --}}

                <button
                    type="button"
                    id="repositoryActivateBtn"
                    class="hidden inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-emerald-700">

                    <span class="material-symbols-outlined text-[18px]">
                        check_circle
                    </span>

                    Aktifkan Repository

                </button>


                {{-- SAVE --}}

                <button
                    type="button"
                    id="repositorySaveBtn"
                    class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-slate-700">

                    <span class="material-symbols-outlined text-[18px]">
                        save
                    </span>

                    <span id="repositorySaveText">
                        Simpan Repository
                    </span>

                </button>

            </div>

        </div>

    </div>

</div>



{{-- ================================================================= --}}
{{-- DELETE CONFIRMATION --}}
{{-- ================================================================= --}}

<div
    id="repositoryDeleteModal"
    class="fixed inset-0 z-[10000] hidden items-center justify-center p-4">

    <div
        id="repositoryDeleteBackdrop"
        class="absolute inset-0 bg-slate-950/50 backdrop-blur-sm">
    </div>


    <div
        class="relative z-10 w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">

        <div class="flex items-start gap-4">

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">

                <span class="material-symbols-outlined text-[23px]">
                    delete
                </span>

            </div>

            <div>

                <h3 class="text-base font-bold text-slate-800">
                    Hapus Repository?
                </h3>

                <p class="mt-1.5 text-sm leading-6 text-slate-500">

                    Repository SIPERPUS akan dihapus dari data.
                    Data karya dan sumber asli SIADMIN tetap aman.

                </p>

            </div>

        </div>


        <div class="mt-6 flex justify-end gap-2">

            <button
                type="button"
                id="repositoryDeleteCancelBtn"
                class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50">

                Batal

            </button>


            <button
                type="button"
                id="repositoryDeleteConfirmBtn"
                class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-red-700">

                <span class="material-symbols-outlined text-[17px]">
                    delete
                </span>

                Hapus

            </button>

        </div>

    </div>

</div>


@endsection