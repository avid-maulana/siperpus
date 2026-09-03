{{-- ================================================================ --}}
{{-- HELPER DATA --}}
{{-- ================================================================ --}}

@php

    /*
    |--------------------------------------------------------------------------
    | Helper untuk mengambil nilai repository
    |--------------------------------------------------------------------------
    */

    $getRepositoryId = function ($item) {
        return $item->repository_id
            ?? $item->repo_id
            ?? $item->id_repository
            ?? $item->repository?->id
            ?? null;
    };


    $getRepositoryUrl = function ($item) {
        return trim(
            $item->repository_url
            ?? $item->repository?->repository_url
            ?? ''
        );
    };


    $getRepositoryType = function ($item) {
        return $item->repository_type
            ?? $item->repository?->repository_type
            ?? 'file';
    };


    $getRepositoryStatus = function ($item) {
        return $item->repository_status
            ?? $item->status_repository
            ?? $item->repository?->status
            ?? null;
    };


    $getJenisKarya = function ($item) {

        $jenis =
            $item->jenis_karya
            ?? $item->jenis
            ?? $item->repository_jenis_karya
            ?? $item->repository?->jenis_karya
            ?? null;

        return $jenis;
    };


    $getJudul = function ($item) {

        return trim(
            preg_replace(
                '/\s+/',
                ' ',
                strip_tags(
                    $item->judul_karya
                    ?? $item->judul
                    ?? ''
                )
            )
        );
    };


    $getSourceUrl = function ($item) {

        return trim(
            $item->lampiran_produk
            ?? $item->repository_sumber
            ?? $item->source_url
            ?? ''
        );
    };

@endphp


{{-- ================================================================ --}}
{{-- EMPTY STATE --}}
{{-- ================================================================ --}}

@if(
        $needsAction->count() === 0 &&
        $withoutRepository->count() === 0 &&
        $active->count() === 0
    )

    <div class="rounded-3xl
               border border-slate-200
               bg-white
               py-20
               text-center
               shadow-sm">

        <div class="mx-auto
                   flex h-20 w-20
                   items-center justify-center
                   rounded-full
                   bg-slate-100">

            <span class="material-symbols-outlined
                       text-[40px]
                       text-slate-400">

                search_off

            </span>

        </div>


        <h3 class="mt-6
                   text-xl
                   font-semibold
                   text-slate-800">

            Repository tidak ditemukan

        </h3>


        <p class="mt-2
                   text-sm
                   text-slate-500">

            Belum ada data yang sesuai dengan pencarian.

        </p>

    </div>

@else


    {{-- ================================================================ --}}
    {{-- 1. BELUM ADA REPOSITORY --}}
    {{-- ================================================================ --}}

    @if($withoutRepository->count() > 0)

        <div class="mb-8
                   overflow-hidden
                   rounded-3xl
                   border border-slate-200
                   bg-white
                   shadow-sm" data-repository-section="without">


            {{-- ============================================================ --}}
            {{-- SECTION HEADER --}}
            {{-- ============================================================ --}}

            <button type="button" class="flex w-full
                       items-center justify-between
                       border-b border-slate-200
                       bg-slate-50
                       px-6 py-5
                       text-left
                       transition-colors
                       duration-200
                       hover:bg-slate-100" data-repository-toggle>


                <div class="flex items-center gap-3">


                    {{-- ICON --}}

                    <div class="flex h-10 w-10
                               items-center justify-center
                               rounded-xl
                               bg-slate-100">

                        <span class="material-symbols-outlined
                                   text-[21px]
                                   text-slate-600">

                            link_off

                        </span>

                    </div>


                    {{-- TITLE --}}

                    <div>

                        <h3 class="text-base
                                   font-semibold
                                   text-slate-800">

                            Belum Ada Repository

                        </h3>


                        <p class="mt-0.5
                                   text-xs
                                   text-slate-500">

                            {{ $withoutRepository->count() }}
                            data belum memiliki repository

                        </p>

                    </div>

                </div>


                {{-- CHEVRON + BADGE --}}

                <div class="flex items-center gap-3">

                    <span class="inline-flex h-6 min-w-[24px]
                               items-center justify-center
                               rounded-full
                               bg-slate-600
                               px-2
                               text-xs
                               font-bold
                               text-white">

                        {{ $withoutRepository->count() }}

                    </span>

                    <span class="material-symbols-outlined
                               text-[24px]
                               text-slate-500" data-repository-icon>

                        expand_less

                    </span>

                </div>

            </button>


            {{-- ============================================================ --}}
            {{-- SECTION CONTENT --}}
            {{-- ============================================================ --}}

            <div class="overflow-hidden
                       transition-all
                       duration-300" data-repository-content>


                <div class="overflow-x-auto">

                    <table class="w-full
                               min-w-[1250px]
                               text-left">


                        {{-- ================================================= --}}
                        {{-- HEADER --}}
                        {{-- ================================================= --}}

                        <thead class="border-b
                                   border-slate-200
                                   bg-white">

                            <tr>

                                <th class="w-16
                                           px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    No

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Judul Karya

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Mahasiswa

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Tanggal Sidang

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Jenis

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Status

                                </th>


                                <th class="px-6 py-4
                                           text-right
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Aksi

                                </th>

                            </tr>

                        </thead>


                        {{-- ================================================= --}}
                        {{-- BODY --}}
                        {{-- ================================================= --}}

                        <tbody class="divide-y
                                   divide-slate-100">


                            @foreach($withoutRepository as $index => $item)

                                @php

                                    $judul =
                                        $getJudul($item);

                                    $sourceUrl =
                                        $getSourceUrl($item);

                                    $jenisKarya =
                                        $getJenisKarya($item);

                                @endphp


                                <tr class="transition-colors
                                               duration-200
                                               hover:bg-slate-50">


                                    {{-- NO --}}

                                    <td class="whitespace-nowrap
                                                   px-6 py-5
                                                   text-sm
                                                   font-medium
                                                   text-slate-500">

                                        {{ $index + 1 }}

                                    </td>


                                    {{-- JUDUL --}}

                                    <td class="max-w-md px-6 py-5">

                                        <div class="line-clamp-2
                                                       text-sm
                                                       font-semibold
                                                       leading-6
                                                       text-slate-700" title="{{ $judul }}">

                                            {{ $judul ?: '-' }}

                                        </div>

                                    </td>


                                    {{-- MAHASISWA --}}

                                    <td class="px-6 py-5">

                                        <div class="flex
                                                       flex-col
                                                       gap-1">

                                            <span class="text-sm
                                                           font-semibold
                                                           text-slate-700">

                                                {{ $item->nama ?? '-' }}

                                            </span>


                                            <span class="text-xs
                                                           font-medium
                                                           text-slate-400">

                                                {{ $item->nim ?? '-' }}

                                            </span>

                                        </div>

                                    </td>


                                    {{-- TANGGAL SIDANG --}}

                                    <td class="whitespace-nowrap
                                                   px-6 py-5
                                                   text-sm
                                                   text-slate-600">

                                        @if($item->tgl_sidang)

                                                        {{ \Carbon\Carbon::parse(
                                                $item->tgl_sidang
                                            )
                                                ->locale('id')
                                                ->translatedFormat('d F Y') }}

                                        @else

                                            -

                                        @endif

                                    </td>


                                    {{-- JENIS --}}

                                    <td class="px-6 py-5">

                                        <span class="text-xs
                                                       font-medium
                                                       text-slate-400">

                                            Belum ditentukan

                                        </span>

                                    </td>


                                    {{-- STATUS --}}

                                    <td class="px-6 py-5">

                                        <span class="inline-flex
                                                       items-center
                                                       gap-1.5
                                                       rounded-full
                                                       bg-slate-100
                                                       px-3 py-1.5
                                                       text-xs
                                                       font-semibold
                                                       text-slate-600">

                                            <span class="material-symbols-outlined
                                                           text-[15px]">

                                                link_off

                                            </span>

                                            Belum Ada

                                        </span>

                                    </td>


                                    {{-- AKSI --}}

                                    <td class="px-6 py-5">

                                        <div class="flex
                                                       justify-end">

                                            @if($sourceUrl)

                                                <button type="button" class="repository-add-btn
                                                                   inline-flex
                                                                   items-center
                                                                   gap-2
                                                                   rounded-xl
                                                                   bg-[#212A37]
                                                                   px-3.5 py-2
                                                                   text-xs
                                                                   font-semibold
                                                                   text-white
                                                                   transition
                                                                   hover:bg-slate-700"
                                                    data-id-pengajuan="{{ $item->id_pengajuan ?? '' }}" data-judul="{{ $judul }}"
                                                    data-nama="{{ $item->nama ?? '-' }}" data-nim="{{ $item->nim ?? '-' }}"
                                                    data-source-url="{{ $sourceUrl }}">

                                                    <span class="material-symbols-outlined
                                                                       text-[17px]">

                                                        add_link

                                                    </span>

                                                    Atur Repository

                                                </button>

                                            @else

                                                <span class="text-xs
                                                                   font-medium
                                                                   text-slate-400">

                                                    Sumber tidak tersedia

                                                </span>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif



    {{-- ================================================================ --}}
    {{-- 2. PERLU DITANGANI --}}
    {{-- ================================================================ --}}

    @if($needsAction->count() > 0)

        <div class="mb-8
                   overflow-hidden
                   rounded-3xl
                   border border-orange-200
                   bg-white
                   shadow-sm" data-repository-section="needs-action">


            {{-- ============================================================ --}}
            {{-- SECTION HEADER --}}
            {{-- ============================================================ --}}

            <button type="button" class="flex w-full
                       items-center justify-between
                       border-b border-orange-100
                       bg-orange-50/50
                       px-6 py-5
                       text-left
                       transition-colors
                       duration-200
                       hover:bg-orange-50" data-repository-toggle>


                <div class="flex items-center gap-3">


                    {{-- ICON --}}

                    <div class="flex h-10 w-10
                               items-center justify-center
                               rounded-xl
                               bg-orange-100">

                        <span class="material-symbols-outlined
                                   text-[21px]
                                   text-orange-600">

                            pending

                        </span>

                    </div>


                    {{-- TITLE --}}

                    <div>

                        <h3 class="text-base
                                   font-semibold
                                   text-slate-800">

                            Perlu Ditangani

                        </h3>


                        <p class="mt-0.5
                                   text-xs
                                   text-slate-500">

                            {{ $needsAction->count() }}
                            repository membutuhkan penanganan

                        </p>

                    </div>

                </div>


                {{-- CHEVRON + BADGE --}}

                <div class="flex items-center gap-3">

                    <span class="inline-flex h-6 min-w-[24px]
                               items-center justify-center
                               rounded-full
                               bg-orange-500
                               px-2
                               text-xs
                               font-bold
                               text-white">

                        {{ $needsAction->count() }}

                    </span>

                    <span class="material-symbols-outlined
                               text-[24px]
                               text-orange-500" data-repository-icon>

                        expand_less

                    </span>

                </div>

            </button>


            {{-- ============================================================ --}}
            {{-- SECTION CONTENT --}}
            {{-- ============================================================ --}}

            <div class="overflow-hidden
                       transition-all
                       duration-300" data-repository-content>


                <div class="overflow-x-auto">

                    <table class="w-full
                               min-w-[1250px]
                               text-left">


                        {{-- HEADER --}}

                        <thead class="border-b
                                   border-slate-200
                                   bg-white">

                            <tr>

                                <th class="w-16
                                           px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    No

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Judul Karya

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Mahasiswa

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Tanggal Sidang

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Jenis

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Status

                                </th>


                                <th class="px-6 py-4
                                           text-right
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Aksi

                                </th>

                            </tr>

                        </thead>


                        {{-- BODY --}}

                        <tbody class="divide-y
                                   divide-slate-100">


                            @foreach($needsAction as $index => $item)

                                @php

                                    $judul =
                                        $getJudul($item);

                                    $repositoryId =
                                        $getRepositoryId($item);

                                    $repositoryUrl =
                                        $getRepositoryUrl($item);

                                    $repositoryType =
                                        $getRepositoryType($item);

                                    $repositoryStatus =
                                        $getRepositoryStatus($item)
                                        ?: 'needs_action';

                                    $jenisKarya =
                                        $getJenisKarya($item);

                                    $sourceUrl =
                                        $getSourceUrl($item);

                                @endphp


                                <tr class="transition-colors
                                               duration-200
                                               hover:bg-orange-50/40">


                                    {{-- NO --}}

                                    <td class="whitespace-nowrap
                                                   px-6 py-5
                                                   text-sm
                                                   font-medium
                                                   text-slate-500">

                                        {{ $index + 1 }}

                                    </td>


                                    {{-- JUDUL --}}

                                    <td class="max-w-md px-6 py-5">

                                        <div class="line-clamp-2
                                                       text-sm
                                                       font-semibold
                                                       leading-6
                                                       text-slate-700" title="{{ $judul }}">

                                            {{ $judul ?: '-' }}

                                        </div>

                                    </td>


                                    {{-- MAHASISWA --}}

                                    <td class="px-6 py-5">

                                        <div class="flex
                                                       flex-col
                                                       gap-1">

                                            <span class="text-sm
                                                           font-semibold
                                                           text-slate-700">

                                                {{ $item->nama ?? '-' }}

                                            </span>


                                            <span class="text-xs
                                                           font-medium
                                                           text-slate-400">

                                                {{ $item->nim ?? '-' }}

                                            </span>

                                        </div>

                                    </td>


                                    {{-- TANGGAL SIDANG --}}

                                    <td class="whitespace-nowrap
                                                   px-6 py-5
                                                   text-sm
                                                   text-slate-600">

                                        @if($item->tgl_sidang)

                                                        {{ \Carbon\Carbon::parse(
                                                $item->tgl_sidang
                                            )
                                                ->locale('id')
                                                ->translatedFormat('d F Y') }}

                                        @else

                                            -

                                        @endif

                                    </td>


                                    {{-- JENIS --}}

                                    <td class="px-6 py-5">

                                        @if($jenisKarya === 'thesis')

                                            <span class="inline-flex
                                                               items-center
                                                               gap-1.5
                                                               rounded-full
                                                               bg-blue-50
                                                               px-3 py-1.5
                                                               text-xs
                                                               font-semibold
                                                               text-blue-700">

                                                <span class="material-symbols-outlined
                                                                   text-[15px]">

                                                    description

                                                </span>

                                                Tesis

                                            </span>

                                        @elseif($jenisKarya === 'dissertation')

                                            <span class="inline-flex
                                                               items-center
                                                               gap-1.5
                                                               rounded-full
                                                               bg-violet-50
                                                               px-3 py-1.5
                                                               text-xs
                                                               font-semibold
                                                               text-violet-700">

                                                <span class="material-symbols-outlined
                                                                   text-[15px]">

                                                    school

                                                </span>

                                                Disertasi

                                            </span>

                                        @else

                                            <span class="text-xs
                                                               text-slate-400">

                                                Belum ditentukan

                                            </span>

                                        @endif

                                    </td>


                                    {{-- STATUS --}}

                                    <td class="px-6 py-5">

                                        <span class="inline-flex
                                                       items-center
                                                       gap-1.5
                                                       rounded-full
                                                       bg-orange-50
                                                       px-3 py-1.5
                                                       text-xs
                                                       font-semibold
                                                       text-orange-700">

                                            <span class="material-symbols-outlined
                                                           text-[15px]">

                                                pending

                                            </span>

                                            Perlu Ditangani

                                        </span>

                                    </td>


                                    {{-- AKSI --}}

                                    <td class="px-6 py-5">

                                        <div class="flex
                                                       justify-end
                                                       gap-2">


                                            @if($repositoryUrl)

                                                <a href="{{ $repositoryUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex
                                                                   items-center
                                                                   gap-2
                                                                   rounded-xl
                                                                   bg-slate-100
                                                                   px-3.5 py-2
                                                                   text-xs
                                                                   font-semibold
                                                                   text-slate-700
                                                                   transition
                                                                   hover:bg-slate-200">

                                                    <span class="material-symbols-outlined
                                                                       text-[17px]">

                                                        visibility

                                                    </span>

                                                    Lihat

                                                </a>

                                            @endif


                                            <button type="button" class="repository-edit-btn
                                                           inline-flex
                                                           items-center
                                                           gap-2
                                                           rounded-xl
                                                           bg-[#212A37]
                                                           px-3.5 py-2
                                                           text-xs
                                                           font-semibold
                                                           text-white
                                                           transition
                                                           hover:bg-slate-700" data-id="{{ $repositoryId }}"
                                                data-status="{{ $repositoryStatus }}" data-jenis-karya="{{ $jenisKarya }}"
                                                data-id-pengajuan="{{ $item->id_pengajuan ?? '' }}" data-judul="{{ $judul }}"
                                                data-nama="{{ $item->nama ?? '-' }}" data-nim="{{ $item->nim ?? '-' }}"
                                                data-source-url="{{ $sourceUrl }}" data-repository-url="{{ $repositoryUrl }}"
                                                data-repository-type="{{ $repositoryType }}">

                                                <span class="material-symbols-outlined
                                                               text-[17px]">

                                                    edit

                                                </span>

                                                Kelola

                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif



    {{-- ================================================================ --}}
    {{-- 3. REPOSITORY AKTIF --}}
    {{-- ================================================================ --}}

    @if($active->count() > 0)

        <div class="mb-8
                   overflow-hidden
                   rounded-3xl
                   border border-emerald-200
                   bg-white
                   shadow-sm" data-repository-section="active">


            {{-- ============================================================ --}}
            {{-- SECTION HEADER --}}
            {{-- ============================================================ --}}

            <button type="button" class="flex w-full
                       items-center justify-between
                       border-b border-emerald-100
                       bg-emerald-50/50
                       px-6 py-5
                       text-left
                       transition-colors
                       duration-200
                       hover:bg-emerald-50" data-repository-toggle>


                <div class="flex items-center gap-3">


                    {{-- ICON --}}

                    <div class="flex h-10 w-10
                               items-center justify-center
                               rounded-xl
                               bg-emerald-100">

                        <span class="material-symbols-outlined
                                   text-[21px]
                                   text-emerald-600">

                            check_circle

                        </span>

                    </div>


                    {{-- TITLE --}}

                    <div>

                        <h3 class="text-base
                                   font-semibold
                                   text-slate-800">

                            Aktif

                        </h3>


                        <p class="mt-0.5
                                   text-xs
                                   text-slate-500">

                            {{ $active->count() }}
                            repository aktif

                        </p>

                    </div>

                </div>


                {{-- CHEVRON + BADGE --}}

                <div class="flex items-center gap-3">

                    <span class="inline-flex h-6 min-w-[24px]
                               items-center justify-center
                               rounded-full
                               bg-emerald-500
                               px-2
                               text-xs
                               font-bold
                               text-white">

                        {{ $active->count() }}

                    </span>

                    <span class="material-symbols-outlined
                               text-[24px]
                               text-emerald-500" data-repository-icon>

                        expand_more

                    </span>

                </div>

            </button>


            {{-- ============================================================ --}}
            {{-- SECTION CONTENT --}}
            {{-- ============================================================ --}}

            <div class="overflow-hidden
                       transition-all
                       duration-300" data-repository-content>


                <div class="overflow-x-auto">

                    <table class="w-full
                               min-w-[1250px]
                               text-left">


                        {{-- HEADER --}}

                        <thead class="border-b
                                   border-slate-200
                                   bg-white">

                            <tr>

                                <th class="w-16
                                           px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    No

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Judul Karya

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Mahasiswa

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Tanggal Sidang

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Jenis

                                </th>


                                <th class="px-6 py-4
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Status

                                </th>


                                <th class="px-6 py-4
                                           text-right
                                           text-xs
                                           font-semibold
                                           uppercase
                                           tracking-wider
                                           text-slate-500">

                                    Aksi

                                </th>

                            </tr>

                        </thead>


                        {{-- BODY --}}

                        <tbody class="divide-y
                                   divide-slate-100">


                            @foreach($active as $index => $item)

                                @php

                                    $judul =
                                        $getJudul($item);

                                    $repositoryId =
                                        $getRepositoryId($item);

                                    $repositoryUrl =
                                        $getRepositoryUrl($item);

                                    $repositoryType =
                                        $getRepositoryType($item);

                                    $repositoryStatus =
                                        $getRepositoryStatus($item)
                                        ?: 'active';

                                    $jenisKarya =
                                        $getJenisKarya($item);

                                    $sourceUrl =
                                        $getSourceUrl($item);

                                @endphp


                                <tr class="transition-colors
                                               duration-200
                                               hover:bg-emerald-50/30">


                                    {{-- NO --}}

                                    <td class="whitespace-nowrap
                                                   px-6 py-5
                                                   text-sm
                                                   font-medium
                                                   text-slate-500">

                                        {{ $index + 1 }}

                                    </td>


                                    {{-- JUDUL --}}

                                    <td class="max-w-md px-6 py-5">

                                        <div class="line-clamp-2
                                                       text-sm
                                                       font-semibold
                                                       leading-6
                                                       text-slate-700" title="{{ $judul }}">

                                            {{ $judul ?: '-' }}

                                        </div>

                                    </td>


                                    {{-- MAHASISWA --}}

                                    <td class="px-6 py-5">

                                        <div class="flex
                                                       flex-col
                                                       gap-1">

                                            <span class="text-sm
                                                           font-semibold
                                                           text-slate-700">

                                                {{ $item->nama ?? '-' }}

                                            </span>


                                            <span class="text-xs
                                                           font-medium
                                                           text-slate-400">

                                                {{ $item->nim ?? '-' }}

                                            </span>

                                        </div>

                                    </td>


                                    {{-- TANGGAL SIDANG --}}

                                    <td class="whitespace-nowrap
                                                   px-6 py-5
                                                   text-sm
                                                   text-slate-600">

                                        @if($item->tgl_sidang)

                                                        {{ \Carbon\Carbon::parse(
                                                $item->tgl_sidang
                                            )
                                                ->locale('id')
                                                ->translatedFormat('d F Y') }}

                                        @else

                                            -

                                        @endif

                                    </td>


                                    {{-- JENIS --}}

                                    <td class="px-6 py-5">

                                        @if($jenisKarya === 'thesis')

                                            <span class="inline-flex
                                                               items-center
                                                               gap-1.5
                                                               rounded-full
                                                               bg-blue-50
                                                               px-3 py-1.5
                                                               text-xs
                                                               font-semibold
                                                               text-blue-700">

                                                <span class="material-symbols-outlined
                                                                   text-[15px]">

                                                    description

                                                </span>

                                                Tesis

                                            </span>

                                        @elseif($jenisKarya === 'dissertation')

                                            <span class="inline-flex
                                                               items-center
                                                               gap-1.5
                                                               rounded-full
                                                               bg-violet-50
                                                               px-3 py-1.5
                                                               text-xs
                                                               font-semibold
                                                               text-violet-700">

                                                <span class="material-symbols-outlined
                                                                   text-[15px]">

                                                    school

                                                </span>

                                                Disertasi

                                            </span>

                                        @else

                                            <span class="text-xs
                                                               text-slate-400">

                                                -

                                            </span>

                                        @endif

                                    </td>


                                    {{-- STATUS --}}

                                    <td class="px-6 py-5">

                                        <span class="inline-flex
                                                       items-center
                                                       gap-1.5
                                                       rounded-full
                                                       bg-emerald-50
                                                       px-3 py-1.5
                                                       text-xs
                                                       font-semibold
                                                       text-emerald-700">

                                            <span class="material-symbols-outlined
                                                           text-[15px]">

                                                check_circle

                                            </span>

                                            Aktif

                                        </span>

                                    </td>


                                    {{-- AKSI --}}

                                    <td class="px-6 py-5">

                                        <div class="flex
                                                       justify-end
                                                       gap-2">


                                            @if($repositoryUrl)

                                                <a href="{{ $repositoryUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex
                                                                   items-center
                                                                   gap-2
                                                                   rounded-xl
                                                                   bg-slate-100
                                                                   px-3.5 py-2
                                                                   text-xs
                                                                   font-semibold
                                                                   text-slate-700
                                                                   transition
                                                                   hover:bg-slate-200">

                                                    <span class="material-symbols-outlined
                                                                       text-[17px]">

                                                        open_in_new

                                                    </span>

                                                    Buka

                                                </a>

                                            @endif


                                            <button type="button" class="repository-edit-btn
                                                           inline-flex items-center gap-2
                                                           rounded-xl bg-[#212A37] px-3.5 py-2
                                                           text-xs font-semibold text-white
                                                           transition-all duration-150
                                                           hover:bg-slate-700
                                                           active:scale-95" data-id="{{ $repositoryId }}"
                                                data-status="{{ $repositoryStatus }}" data-jenis-karya="{{ $jenisKarya }}"
                                                data-id-pengajuan="{{ $item->id_pengajuan ?? '' }}" data-judul="{{ $judul }}"
                                                data-nama="{{ $item->nama ?? '-' }}" data-nim="{{ $item->nim ?? '-' }}"
                                                data-source-url="{{ $sourceUrl }}" data-repository-url="{{ $repositoryUrl }}"
                                                data-repository-type="{{ $repositoryType }}">

                                                <span class="material-symbols-outlined
                                                               text-[17px]">

                                                    edit

                                                </span>

                                                Kelola

                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif



    {{-- ================================================================ --}}
    {{-- INFO --}}
    {{-- ================================================================ --}}

    <div class="mt-4
               flex
               items-center
               gap-2
               text-xs
               text-slate-400">

        <span class="material-symbols-outlined
                   text-[16px]">

            info

        </span>


        <span>

            Data karya berasal dari SIADMIN.
            Repository dikelola melalui SIPERPUS.

        </span>

    </div>

@endif