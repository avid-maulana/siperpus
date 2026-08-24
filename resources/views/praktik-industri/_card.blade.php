@php
    /*
    |--------------------------------------------------------------------------
    | DATA TIM
    |--------------------------------------------------------------------------
    */

    $tim = $laporan->detailTim?->tim;


    /*
    |--------------------------------------------------------------------------
    | DATA INDUSTRI
    |--------------------------------------------------------------------------
    */

    $industri = $tim?->industri;


    /*
    |--------------------------------------------------------------------------
    | KETUA TIM
    |--------------------------------------------------------------------------
    */

    $ketua = $tim?->ketua;


    /*
    |--------------------------------------------------------------------------
    | ANGGOTA TIM
    |--------------------------------------------------------------------------
    |
    | Ambil seluruh anggota dari detail_tims.
    | Ketua dikeluarkan agar tidak muncul dua kali.
    |
    */

    $anggota = $tim?->detailTims
        ?->filter(fn($detail) => $detail->user)
        ->map(fn($detail) => $detail->user)
        ->unique('user_id');

    $anggota = $anggota?->filter(
        fn($member) => !$ketua || $member->user_id !== $ketua->user_id
    );


    /*
    |--------------------------------------------------------------------------
    | FILE LAPORAN
    |--------------------------------------------------------------------------
    |
    | Prioritas:
    |
    | 1. Revisi terbaru jika tersedia
    | 2. File laporan utama jika tidak ada revisi
    |
    */

    $fileLaporan = $laporan->fileTerbaru?->file
        ?: $laporan->file_laporan;


    /*
    |--------------------------------------------------------------------------
    | TANGGAL TERAKHIR DIPERBARUI
    |--------------------------------------------------------------------------
    */

    $tanggalTerakhirDiperbarui = $laporan->tanggal_terakhir_diperbarui;
@endphp


<style>
    /*
    |--------------------------------------------------------------------------
    | CARD HEADER
    |--------------------------------------------------------------------------
    */

    .pi-card-header {
        display: flex;
        flex-direction: column;
        transition:
            all 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }


    /*
    |--------------------------------------------------------------------------
    | HEADER CONTENT
    |--------------------------------------------------------------------------
    */

    .pi-header-content {
        display: flex;
        min-height: 100%;
        flex: 1;
        flex-direction: column;
    }


    /*
    |--------------------------------------------------------------------------
    | TITLE WRAPPER
    |--------------------------------------------------------------------------
    */

    .pi-title-wrapper {
        position: relative;
        min-height: 72px;
        max-height: 72px;
        overflow: hidden;
        transition:
            max-height 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }


    /*
    |--------------------------------------------------------------------------
    | TITLE CONTENT
    |--------------------------------------------------------------------------
    */

    .pi-title-content {
        transition:
            all 0.45s cubic-bezier(0.4, 0, 0.2, 1);
    }


    /*
    |--------------------------------------------------------------------------
    | TITLE FADE
    |--------------------------------------------------------------------------
    */

    .pi-title-fade {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        height: 28px;
        pointer-events: none;
        background: linear-gradient(
            to bottom,
            transparent,
            #212A37
        );
        opacity: 1;
        transition:
            opacity 0.25s ease;
    }


    /*
    |--------------------------------------------------------------------------
    | HOVER TITLE EXPANSION
    |--------------------------------------------------------------------------
    */

    .pi-card:hover .pi-title-wrapper,
    .pi-card:focus-within .pi-title-wrapper {
        max-height: 300px;
    }

    .pi-card:hover .pi-title-fade,
    .pi-card:focus-within .pi-title-fade {
        opacity: 0;
    }
</style>


<article
    class="pi-card group flex h-full flex-col
           overflow-hidden
           rounded-3xl
           border border-slate-200
           bg-white
           shadow-sm
           transition-all duration-300
           hover:border-slate-300
           hover:shadow-xl">


    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <div
        class="pi-card-header relative overflow-hidden
               border-b border-slate-200
               bg-[#1b2330]
               px-6 py-6">


        {{-- =====================================================
            BACKGROUND
        ====================================================== --}}

        <div
            class="pointer-events-none absolute inset-0
                   bg-gradient-to-br
                   from-[#263241]
                   via-[#212A37]
                   to-[#1b2430]">
        </div>


        {{-- =====================================================
            GLOW
        ====================================================== --}}

        <div
            class="pointer-events-none absolute
                   -right-16 -top-16
                   h-48 w-48
                   rounded-full
                   bg-white/[0.04]
                   blur-3xl">
        </div>


        {{-- =====================================================
            HEADER CONTENT
        ====================================================== --}}

        <div class="pi-header-content relative z-10">


            {{-- =================================================
                LABEL
            ================================================== --}}

            <div class="inline-flex items-center gap-2 text-white/60">

                <span class="material-symbols-outlined text-[16px]">
                    description
                </span>

                <span
                    class="text-[10px]
                           font-semibold
                           uppercase
                           tracking-[0.18em]">
                    Laporan
                </span>

            </div>


            {{-- =================================================
                TITLE
            ================================================== --}}

            <div class="pi-title-wrapper mt-4">

                <div class="pi-title-content">

                    <h3
                        class="text-[16px]
                               font-semibold
                               leading-[1.5]
                               text-white"
                        title="{{ $laporan->judul }}">

                        {{ $laporan->judul ?: 'Judul tidak tersedia' }}

                    </h3>

                </div>


                {{-- Fade --}}

                <div class="pi-title-fade"></div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        CONTENT BODY
    ========================================================== --}}

    <div class="flex flex-1 flex-col p-6">

        <div class="space-y-5">


            {{-- =================================================
                INDUSTRI
            ================================================== --}}

            @if ($industri)

                <div class="flex items-start gap-3">

                    <div
                        class="mt-0.5
                               flex h-9 w-9
                               shrink-0
                               items-center
                               justify-center
                               rounded-2xl
                               bg-slate-100
                               text-slate-500
                               ring-1
                               ring-inset
                               ring-slate-200">

                        <span class="material-symbols-outlined text-[20px]">
                            business
                        </span>

                    </div>


                    <div class="min-w-0 flex-1">

                        <div
                            class="text-[10px]
                                   font-medium
                                   uppercase
                                   tracking-widest
                                   text-slate-400">
                            Industri
                        </div>

                        <div
                            class="break-words
                                   text-sm
                                   font-semibold
                                   text-slate-700"
                            title="{{ $industri->nama }}">

                            {{ $industri->nama }}

                        </div>

                    </div>

                </div>

            @endif


            {{-- =================================================
                KETUA
            ================================================== --}}

            @if ($ketua)

                <div class="flex items-start gap-3">

                    <div
                        class="mt-0.5
                               flex h-9 w-9
                               shrink-0
                               items-center
                               justify-center
                               rounded-2xl
                               bg-slate-100
                               text-slate-500
                               ring-1
                               ring-inset
                               ring-slate-200">

                        <span class="material-symbols-outlined text-[20px]">
                            person
                        </span>

                    </div>


                    <div class="min-w-0 flex-1">

                        <div
                            class="text-[10px]
                                   font-medium
                                   uppercase
                                   tracking-widest
                                   text-slate-400">
                            Ketua
                        </div>

                        <div
                            class="break-words
                                   text-sm
                                   font-semibold
                                   text-slate-700">

                            {{ $ketua->nama_lengkap }}

                        </div>

                    </div>

                </div>

            @endif


            {{-- =================================================
                ANGGOTA
            ================================================== --}}

            @if ($anggota?->count())

                <div class="flex items-start gap-3">

                    <div
                        class="mt-0.5
                               flex h-9 w-9
                               shrink-0
                               items-center
                               justify-center
                               rounded-2xl
                               bg-slate-100
                               text-slate-500
                               ring-1
                               ring-inset
                               ring-slate-200">

                        <span class="material-symbols-outlined text-[20px]">
                            diversity_3
                        </span>

                    </div>


                    <div class="min-w-0 flex-1">

                        <div
                            class="mb-1
                                   text-[10px]
                                   font-medium
                                   uppercase
                                   tracking-widest
                                   text-slate-400">

                            Anggota ({{ $anggota->count() }})

                        </div>


                        <ul class="flex flex-col gap-1.5 pl-0.5">

                            @foreach ($anggota as $member)

                                <li class="flex items-start gap-3">

                                    <span
                                        class="mt-[7px]
                                               h-[5px]
                                               w-[5px]
                                               shrink-0
                                               rounded-full
                                               bg-slate-400">
                                    </span>

                                    <span
                                        class="break-words
                                               text-sm
                                               font-semibold
                                               text-slate-700">

                                        {{ $member->nama_lengkap }}

                                    </span>

                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            @endif


            {{-- =================================================
                TERAKHIR DIPERBARUI
            ================================================== --}}

            @if ($tanggalTerakhirDiperbarui)

                <div class="mt-6 flex items-start gap-3">

                    <div
                        class="mt-0.5
                               flex h-9 w-9
                               shrink-0
                               items-center
                               justify-center
                               rounded-2xl
                               bg-slate-100
                               text-slate-500
                               ring-1
                               ring-inset
                               ring-slate-200">

                        <span class="material-symbols-outlined text-[20px]">
                            schedule
                        </span>

                    </div>


                    <div class="min-w-0 flex-1">

                        <div
                            class="text-[10px]
                                   font-medium
                                   uppercase
                                   tracking-widest
                                   text-slate-400">

                            Terakhir Diperbarui

                        </div>

                        <div
                            class="mt-0.5
                                   text-sm
                                   font-semibold
                                   text-slate-700">

                            {{ $tanggalTerakhirDiperbarui->translatedFormat('d F Y') }}

                        </div>

                    </div>

                </div>

            @endif

        </div>


        {{-- =====================================================
            ACTION DOCUMENT
        ====================================================== --}}

        <div class="mt-auto pt-8">

            {{-- =================================================
                FILE LAPORAN
            ================================================== --}}

            @if ($fileLaporan)

                <a
                    href="{{ $laporan->file_aktif_url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="group/link
                           flex
                           items-center
                           justify-between
                           rounded-2xl
                           border border-slate-200
                           bg-white
                           px-4 py-3
                           text-sm
                           font-medium
                           text-slate-700
                           shadow-sm
                           transition-all
                           duration-300
                           hover:border-[#212A37]
                           hover:bg-[#212A37]
                           hover:text-white
                           hover:shadow-lg">

                    <span class="flex min-w-0 items-center gap-3">

                        <span
                            class="material-symbols-outlined
                                   text-[18px]
                                   text-slate-400
                                   transition-colors
                                   duration-300
                                   group-hover/link:text-white">
                            picture_as_pdf
                        </span>

                        <span class="truncate">
                            Lihat File Laporan
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined
                               text-[18px]
                               text-slate-300
                               transition-colors
                               duration-300
                               group-hover/link:text-white">
                        open_in_new
                    </span>

                </a>

            @else

                <div
                    class="flex
                           items-center
                           justify-between
                           rounded-2xl
                           border border-slate-100
                           bg-slate-50
                           px-4 py-3
                           text-sm
                           font-medium
                           text-slate-400">

                    <span class="flex min-w-0 items-center gap-3">

                        <span
                            class="material-symbols-outlined
                                   text-[18px]
                                   text-slate-300">
                            description_off
                        </span>

                        <span class="truncate">
                            File Laporan
                        </span>

                    </span>

                    <span class="text-[10px] font-medium">
                        Belum ada
                    </span>

                </div>

            @endif

        </div>

    </div>

</article>