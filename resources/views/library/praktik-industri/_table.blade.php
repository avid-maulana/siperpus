{{-- =========================================================
    DAFTAR LAPORAN PRAKTIK INDUSTRI
    ADMIN DESKTOP
    1 KELOMPOK = 1 LAPORAN TERBARU
========================================================= --}}

@php

    /*
    |--------------------------------------------------------------------------
    | SORT STATE
    |--------------------------------------------------------------------------
    */

    $currentSort =
        $sort ?? request('sort', 'diperbarui');

    $currentDirection =
        $direction ?? request('direction', 'desc');


    /*
    |--------------------------------------------------------------------------
    | DEFAULT SORT
    |--------------------------------------------------------------------------
    |
    | Dipakai untuk menandai opsi mana yang merupakan
    | urutan bawaan (default) sistem.
    |
    */

    $defaultSort      = 'diperbarui';
    $defaultDirection = 'desc';


    /*
    |--------------------------------------------------------------------------
    | LABEL PILIHAN SORT PER KOLOM
    |--------------------------------------------------------------------------
    |
    | Setiap kolom mempunyai 2 pilihan arah, dengan label
    | yang sesuai dengan jenis datanya (angka, teks, tanggal).
    |
    */

    $sortOptions = [

        'kelompok' => [
            'label' => 'Kelompok',
            'asc'   => 'Terkecil ke Terbesar',
            'desc'  => 'Terbesar ke Terkecil',
        ],

        'judul' => [
            'label' => 'Laporan Terbaru',
            'asc'   => 'A ke Z',
            'desc'  => 'Z ke A',
        ],

        'ketua' => [
            'label' => 'Ketua',
            'asc'   => 'A ke Z',
            'desc'  => 'Z ke A',
        ],

        'industri' => [
            'label' => 'Industri',
            'asc'   => 'A ke Z',
            'desc'  => 'Z ke A',
        ],

        'diperbarui' => [
            'label' => 'Diperbarui',
            'asc'   => 'Terlama Dulu',
            'desc'  => 'Terbaru Dulu',
        ],

    ];


    /*
    |--------------------------------------------------------------------------
    | URL SORT
    |--------------------------------------------------------------------------
    |
    | Berbeda dengan sebelumnya, sekarang arah TIDAK di-toggle
    | otomatis. Admin memilih arah secara eksplisit lewat dropdown.
    |
    | Selalu kembali ke halaman 1 karena urutan berubah total.
    |
    */

    $sortUrl = function ($column, $dir) {

        return request()->fullUrlWithQuery([
            'sort'      => $column,
            'direction' => $dir,
            'page'      => 1,
        ]);

    };

@endphp


{{-- =========================================================
    HINT: TABEL BISA DIURUTKAN
========================================================= --}}

<div
    class="mb-3 flex items-center gap-2
           text-xs text-slate-400"
>

    <span class="material-symbols-outlined text-[16px]">
        info
    </span>

    <span>
        Klik nama kolom pada tabel untuk mengurutkan data.
        Urutan bawaan:
        <span class="font-semibold text-slate-500">
            {{ $sortOptions[$defaultSort]['label'] }}
            &middot;
            {{ $sortOptions[$defaultSort][$defaultDirection] }}
        </span>
    </span>

</div>


<div
    class="overflow-hidden
           rounded-2xl
           border border-slate-200/80
           bg-white
           shadow-[0_3px_18px_rgba(15,23,42,0.035)]"
>

    {{-- =====================================================
        TABLE HEADER
    ====================================================== --}}

    <div
        class="grid
               grid-cols-[95px_minmax(0,1.8fr)_minmax(0,1.1fr)_minmax(0,1.1fr)_125px_190px]
               items-center
               gap-4
               border-b border-slate-200
               bg-slate-50/80
               px-5
               py-3.5"
    >

        @foreach ($sortOptions as $column => $option)

            @php
                $isActive = $currentSort === $column;
            @endphp

            {{-- =============================================
                KOLOM SORTABLE
            ============================================== --}}

            <div class="relative">

                <button
                    type="button"
                    data-sort-toggle
                    data-column="{{ $column }}"
                    title="Klik untuk memilih urutan {{ $option['label'] }}"
                    class="inline-flex items-center gap-1
                           text-[10px]
                           font-bold
                           uppercase
                           tracking-[0.12em]
                           transition-colors
                           duration-200
                           {{ $isActive ? 'text-[#212A37]' : 'text-slate-400 hover:text-[#212A37]' }}"
                >
                    {{ $option['label'] }}

                    <span
                        class="material-symbols-outlined text-[14px]
                               {{ $isActive ? 'text-[#212A37]' : 'text-slate-300' }}"
                    >
                        @if ($isActive)
                            {{ $currentDirection === 'asc' ? 'arrow_upward' : 'arrow_downward' }}
                        @else
                            unfold_more
                        @endif
                    </span>
                </button>


                {{-- =========================================
                    DROPDOWN PILIHAN ARAH
                ========================================== --}}

                <div
                    data-sort-menu="{{ $column }}"
                    class="hidden absolute left-0 top-full z-20 mt-2
                           w-48
                           overflow-hidden
                           rounded-xl
                           border border-slate-200
                           bg-white
                           py-1.5
                           text-left
                           normal-case
                           tracking-normal
                           shadow-lg"
                >

                    @foreach (['asc', 'desc'] as $dir)

                        @php
                            $isSelected =
                                $isActive && $currentDirection === $dir;

                            $isDefault =
                                $column === $defaultSort && $dir === $defaultDirection;
                        @endphp

                        <a
                            href="{{ $sortUrl($column, $dir) }}"
                            data-sort-link
                            class="flex items-center justify-between gap-2
                                   px-3.5 py-2.5
                                   text-xs
                                   transition-colors
                                   duration-150
                                   {{ $isSelected
                                        ? 'bg-slate-50 font-semibold text-[#212A37]'
                                        : 'text-slate-600 hover:bg-slate-50' }}"
                        >
                            <span class="flex items-center gap-1.5">
                                {{ $option[$dir] }}

                                @if ($isDefault)
                                    <span
                                        class="rounded-full
                                               bg-slate-100
                                               px-1.5 py-0.5
                                               text-[9px]
                                               font-semibold
                                               text-slate-400"
                                    >
                                        Default
                                    </span>
                                @endif
                            </span>

                            @if ($isSelected)
                                <span class="material-symbols-outlined text-[15px] text-[#212A37]">
                                    check
                                </span>
                            @endif
                        </a>

                    @endforeach

                </div>

            </div>

        @endforeach


        {{-- AKSI (tidak bisa di-sort) --}}

        <div
            class="text-right
                   text-[10px]
                   font-bold
                   uppercase
                   tracking-[0.12em]
                   text-slate-400"
        >
            Aksi
        </div>

    </div>


    {{-- =====================================================
        TABLE DATA
    ====================================================== --}}

    <div class="divide-y divide-slate-100">

        @forelse ($laporan as $item)

            @php

                $utama = $item['utama'] ?? null;

                $kelompokId =
                    $item['kelompok_id'] ?? '-';

                $jumlahRevisi =
                    (int) ($item['jumlah_riwayat'] ?? 0);

                $detailTim =
                    $utama?->detailTim;

                $tim =
                    $detailTim?->tim;

                $ketua =
                    $tim?->ketua;

                    $anggota = $tim?->detailTims
                        ?->filter(fn ($detail) => $detail->user)
                        ->map(fn ($detail) => $detail->user)
                        ->filter(
                            fn ($member) =>
                                !$ketua ||
                                $member->user_id !== $ketua->user_id
                        )
                        ->unique('user_id')
                        ->values();

                $industri =
                    $tim?->industri;

                $revisiTerbaru =
                    $utama?->fileTerbaru;


                /*
                |--------------------------------------------------------------------------
                | URL FILE AKTIF
                |--------------------------------------------------------------------------
                |
                | URL dibuat oleh Model PraktikIndustri
                | berdasarkan konfigurasi path dari .env.
                |
                */

                $pdfUrl = $utama?->file_aktif_url;


                /*
                |--------------------------------------------------------------------------
                | TANGGAL TERAKHIR DIPERBARUI
                |--------------------------------------------------------------------------
                */

                $tanggalAktif =
                    $revisiTerbaru?->updated_at
                    ?? $utama?->updated_at
                    ?? $utama?->created_at;


                /*
                |--------------------------------------------------------------------------
                | URL HISTORY
                |--------------------------------------------------------------------------
                */

                $historyUrl =
                    route(
                        'library.praktik-industri.history',
                        [
                            'tim' => $kelompokId
                        ]
                    );

            @endphp


            {{-- =================================================
                ROW
            ================================================== --}}

            <div
                class="group
                       grid
                       grid-cols-[95px_minmax(0,1.8fr)_minmax(0,1.1fr)_minmax(0,1.1fr)_125px_190px]
                       items-center
                       gap-4
                       px-5
                       py-4
                       transition-colors
                       duration-200
                       hover:bg-slate-50/70"
                data-praktik-row
                data-id="{{ $utama?->id }}"
                data-group="{{ $kelompokId }}"
                data-title="{{ $utama?->judul }}"
                data-ketua="{{ $ketua?->nama_lengkap }}"
                data-anggota='@json(
                    $anggota->map(fn ($member) => [
                        "user_id" => $member->user_id,
                        "nama" => $member->nama_lengkap,
                    ])->values()
                )'
                data-industri="{{ $industri?->nama }}"
                data-date="{{ $tanggalAktif?->translatedFormat('d F Y') }}"
                data-time="{{ $tanggalAktif?->format('H:i') }}"
                data-pdf="{{ $pdfUrl }}"
                data-revisions="{{ $jumlahRevisi }}"
            >

                {{-- =================================================
                    KELOMPOK
                ================================================== --}}

                <div>

                    <div
                        class="inline-flex
                               items-center
                               gap-2"
                    >

                        <div
                            class="flex
                                   h-9
                                   w-9
                                   shrink-0
                                   items-center
                                   justify-center
                                   rounded-xl
                                   bg-[#212A37]
                                   text-white"
                        >

                            <span
                                class="material-symbols-outlined
                                       text-[18px]"
                            >
                                groups
                            </span>

                        </div>


                        <div>

                            <div
                                class="text-[9px]
                                       font-semibold
                                       uppercase
                                       tracking-wider
                                       text-slate-400"
                            >
                                Kelompok
                            </div>


                            <div
                                class="mt-0.5
                                       text-sm
                                       font-bold
                                       text-[#212A37]"
                            >
                                {{ $kelompokId }}
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    LAPORAN TERBARU
                ================================================== --}}

                <div class="min-w-0">

                    <div
                        class="flex
                               items-center
                               gap-2"
                    >

                        <span
                            class="material-symbols-outlined
                                   shrink-0
                                   text-[17px]
                                   text-slate-400"
                        >
                            description
                        </span>


                        <span
                            class="text-[9px]
                                   font-bold
                                   uppercase
                                   tracking-wider
                                   text-slate-400"
                        >
                            Laporan terbaru
                        </span>

                    </div>


                    <div
                        class="mt-1.5
                               truncate
                               text-sm
                               font-semibold
                               text-slate-700"
                        title="{{ $utama?->judul }}"
                    >
                        {{ $utama?->judul ?: '-' }}
                    </div>


                    <div
                        class="mt-1.5
                               flex
                               items-center
                               gap-2"
                    >

                        {{-- STATUS --}}

                        <span
                            class="inline-flex
                                   items-center
                                   gap-1.5
                                   rounded-full
                                   bg-emerald-50
                                   px-2
                                   py-1
                                   text-[9px]
                                   font-semibold
                                   text-emerald-600"
                        >

                            <span
                                class="h-1.5
                                       w-1.5
                                       rounded-full
                                       bg-emerald-500"
                            ></span>

                            Terbaru

                        </span>


                        {{-- JUMLAH RIWAYAT --}}

                        @if ($jumlahRevisi > 0)

                            <span
                                class="inline-flex
                                       items-center
                                       gap-1
                                       rounded-full
                                       border
                                       border-amber-200
                                       bg-amber-50
                                       px-2
                                       py-1
                                       text-[9px]
                                       font-semibold
                                       text-amber-700"
                            >

                                <span
                                    class="material-symbols-outlined
                                           text-[12px]"
                                >
                                    history
                                </span>

                                {{ $jumlahRevisi }} riwayat

                            </span>

                        @else

                            <span
                                class="text-[9px]
                                       text-slate-400"
                            >
                                Belum ada revisi
                            </span>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    KETUA
                ================================================== --}}

                <div class="min-w-0">

                    @if ($ketua)

                        <div
                            class="flex
                                   min-w-0
                                   items-center
                                   gap-2.5"
                        >

                            <div
                                class="flex
                                       h-9
                                       w-9
                                       shrink-0
                                       items-center
                                       justify-center
                                       rounded-xl
                                       bg-slate-100
                                       text-slate-500"
                            >

                                <span
                                    class="material-symbols-outlined
                                           text-[18px]"
                                >
                                    person
                                </span>

                            </div>


                            <div class="min-w-0">

                                <div
                                    class="truncate
                                           text-xs
                                           font-semibold
                                           text-slate-700"
                                    title="{{ $ketua->nama_lengkap }}"
                                >
                                    {{ $ketua->nama_lengkap }}
                                </div>


                                <div
                                    class="mt-0.5
                                           text-[9px]
                                           text-slate-400"
                                >
                                    Ketua kelompok
                                </div>

                            </div>

                        </div>

                    @else

                        <span
                            class="text-xs
                                   text-slate-400"
                        >
                            Belum tersedia
                        </span>

                    @endif

                </div>


                {{-- =================================================
                    INDUSTRI
                ================================================== --}}

                <div class="min-w-0">

                    @if ($industri)

                        <div
                            class="flex
                                   min-w-0
                                   items-center
                                   gap-2.5"
                        >

                            <div
                                class="flex
                                       h-9
                                       w-9
                                       shrink-0
                                       items-center
                                       justify-center
                                       rounded-xl
                                       bg-slate-100
                                       text-slate-500"
                            >

                                <span
                                    class="material-symbols-outlined
                                           text-[18px]"
                                >
                                    business
                                </span>

                            </div>


                            <div class="min-w-0">

                                <div
                                    class="truncate
                                           text-xs
                                           font-semibold
                                           text-slate-700"
                                    title="{{ $industri->nama }}"
                                >
                                    {{ $industri->nama }}
                                </div>


                                <div
                                    class="mt-0.5
                                           text-[9px]
                                           text-slate-400"
                                >
                                    Tempat praktik
                                </div>

                            </div>

                        </div>

                    @else

                        <span
                            class="text-xs
                                   text-slate-400"
                        >
                            Belum tersedia
                        </span>

                    @endif

                </div>


                {{-- =================================================
                    DIPERBARUI
                ================================================== --}}

                <div>

                    @if ($tanggalAktif)

                        <div
                            class="flex
                                   items-start
                                   gap-2"
                        >

                            <span
                                class="material-symbols-outlined
                                       mt-0.5
                                       text-[16px]
                                       text-slate-400"
                            >
                                schedule
                            </span>


                            <div>

                                <div
                                    class="text-xs
                                           font-semibold
                                           text-slate-700"
                                >
                                    {{
                                        $tanggalAktif
                                            ->translatedFormat('d M Y')
                                    }}
                                </div>


                                <div
                                    class="mt-0.5
                                           text-[9px]
                                           text-slate-400"
                                >
                                    {{
                                        $tanggalAktif
                                            ->format('H:i')
                                    }}
                                    WIB
                                </div>

                            </div>

                        </div>

                    @else

                        <span
                            class="text-xs
                                   text-slate-400"
                        >
                            Belum tersedia
                        </span>

                    @endif

                </div>


                {{-- =================================================
                    AKSI
                ================================================== --}}

                <div
                    class="flex
                           items-center
                           justify-end
                           gap-1.5"
                >

                    {{-- =================================================
                        DETAIL
                    ================================================== --}}

                    <button
                        type="button"
                        data-detail
                        class="inline-flex
                               h-9
                               items-center
                               justify-center
                               gap-1.5
                               rounded-xl
                               border
                               border-slate-200
                               bg-white
                               px-3
                               text-xs
                               font-semibold
                               text-slate-600
                               shadow-sm
                               transition-all
                               duration-200
                               hover:border-[#212A37]
                               hover:bg-[#212A37]
                               hover:text-white
                               hover:shadow-md"
                        title="Lihat detail laporan"
                        aria-label="Lihat detail laporan"
                    >

                        <span
                            class="material-symbols-outlined
                                   text-[17px]"
                        >
                            visibility
                        </span>

                        Detail

                    </button>


                    {{-- =================================================
                        PDF
                    ================================================== --}}

                    @if ($pdfUrl)

                        <a
                            href="{{ $pdfUrl }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex
                                   h-9
                                   w-9
                                   items-center
                                   justify-center
                                   rounded-xl
                                   border
                                   border-slate-200
                                   bg-white
                                   text-slate-500
                                   shadow-sm
                                   transition-all
                                   duration-200
                                   hover:border-red-200
                                   hover:bg-red-50
                                   hover:text-red-500
                                   hover:shadow-md"
                            title="Buka laporan PDF"
                            aria-label="Buka laporan PDF"
                        >

                            <span
                                class="material-symbols-outlined
                                       text-[18px]"
                            >
                                picture_as_pdf
                            </span>

                        </a>

                    @else

                        <span
                            class="inline-flex
                                   h-9
                                   w-9
                                   cursor-not-allowed
                                   items-center
                                   justify-center
                                   rounded-xl
                                   border
                                   border-slate-200
                                   bg-slate-50
                                   text-slate-300"
                            title="File PDF belum tersedia"
                        >

                            <span
                                class="material-symbols-outlined
                                       text-[18px]"
                            >
                                picture_as_pdf
                            </span>

                        </span>

                    @endif


                    {{-- =================================================
                        RIWAYAT
                    ================================================== --}}

                    @if ($jumlahRevisi > 0)

                        <button
                            type="button"
                            data-history
                            data-group="{{ $kelompokId }}"
                            data-history-url="{{ $historyUrl }}"
                            class="inline-flex
                                   h-9
                                   w-9
                                   items-center
                                   justify-center
                                   rounded-xl
                                   border
                                   border-amber-200
                                   bg-amber-50
                                   text-amber-700
                                   transition-all
                                   duration-200
                                   hover:border-amber-300
                                   hover:bg-amber-100
                                   hover:shadow-sm"
                            title="Lihat {{ $jumlahRevisi }} riwayat revisi"
                            aria-label="Lihat riwayat revisi"
                        >

                            <span
                                class="material-symbols-outlined
                                       text-[18px]"
                            >
                                history
                            </span>

                        </button>

                    @else

                        <button
                            type="button"
                            disabled
                            class="inline-flex
                                   h-9
                                   w-9
                                   cursor-not-allowed
                                   items-center
                                   justify-center
                                   rounded-xl
                                   border
                                   border-slate-200
                                   bg-slate-50
                                   text-slate-300"
                            title="Belum ada riwayat revisi"
                            aria-label="Belum ada riwayat revisi"
                        >

                            <span
                                class="material-symbols-outlined
                                       text-[18px]"
                            >
                                history
                            </span>

                        </button>

                    @endif

                </div>

            </div>

        @empty

            {{-- =================================================
                EMPTY
            ================================================== --}}

            <div
                class="flex
                       min-h-[320px]
                       items-center
                       justify-center
                       px-6
                       py-12"
            >

                <div
                    class="max-w-md
                           text-center"
                >

                    <div
                        class="mx-auto
                               flex
                               h-16
                               w-16
                               items-center
                               justify-center
                               rounded-2xl
                               bg-slate-100
                               text-slate-400"
                    >

                        <span
                            class="material-symbols-outlined
                                   text-[30px]"
                        >
                            folder_off
                        </span>

                    </div>


                    <h3
                        class="mt-4
                               text-sm
                               font-bold
                               text-slate-700"
                    >
                        Tidak ada laporan
                    </h3>


                    <p
                        class="mt-1
                               text-xs
                               leading-5
                               text-slate-400"
                    >
                        Tidak ditemukan laporan Praktik Industri
                        yang sesuai dengan pencarian atau filter
                        yang digunakan.
                    </p>

                </div>

            </div>

        @endforelse

    </div>

</div>