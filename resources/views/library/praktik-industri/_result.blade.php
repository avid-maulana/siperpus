{{-- =========================================================
    HASIL KELOLA PRAKTIK INDUSTRI
========================================================= --}}

<div>

    {{-- =====================================================
        HEADER HASIL
    ====================================================== --}}

    <div
        class="mb-5 flex items-end justify-between"
    >

        <div>

            <h2
                class="text-lg font-bold
                       tracking-tight
                       text-[#212A37]"
            >
                Daftar Laporan Praktik Industri
            </h2>


            <p
                class="mt-1 text-sm
                       text-slate-500"
            >
                Laporan terbaru setiap kelompok ditampilkan
                sebagai data utama.

            </p>
            <p
                class="mt-1 text-sm
                       text-slate-500"
            >
                Klik tombol header kolom untuk memfilter mengurutkan data berdasarkan nama mahasiswa, industri, atau judul laporan.
                
            </p>

        </div>


        <div
            class="rounded-xl
                   border border-slate-200
                   bg-white
                   px-4 py-2.5
                   text-sm
                   text-slate-500"
        >

            <span class="font-bold text-[#212A37]">
                {{ $laporan->total() }}
            </span>

            kelompok

        </div>

    </div>


    {{-- =====================================================
        DATA
    ====================================================== --}}

    @if ($laporan->isEmpty())

        @include(
            'library.praktik-industri._empty'
        )

    @else

        @include(
            'library.praktik-industri._table'
        )

    @endif

</div>