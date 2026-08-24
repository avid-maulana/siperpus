{{-- =========================================================
    EMPTY STATE
========================================================= --}}

<div
    class="rounded-2xl
           border border-slate-200
           bg-white
           px-6 py-16
           text-center
           shadow-sm"
>

    {{-- ICON --}}

    <div
        class="mx-auto flex h-16 w-16
               items-center justify-center
               rounded-2xl
               bg-slate-100
               text-slate-400"
    >

        <span
            class="material-symbols-outlined text-[30px]"
        >
            folder_off
        </span>

    </div>


    {{-- TITLE --}}

    <h3
        class="mt-5 text-base
               font-bold text-[#212A37]"
    >
        Tidak ada laporan
    </h3>


    {{-- DESCRIPTION --}}

    <p
        class="mx-auto mt-1
               max-w-md
               text-sm
               leading-6
               text-slate-400"
    >
        @if (!empty($search))

            Tidak ditemukan laporan Praktik Industri
            yang sesuai dengan pencarian
            <span class="font-semibold text-slate-500">
                "{{ $search }}"
            </span>.

        @else

            Belum terdapat data laporan
            Praktik Industri yang tersedia.

        @endif
    </p>


    {{-- RESET --}}

    @if (!empty($search))

        <a
            href="{{ route('library.praktik-industri') }}"
            class="mt-5 inline-flex
                   items-center gap-2
                   rounded-xl
                   bg-[#212A37]
                   px-5 py-3
                   text-sm font-semibold
                   text-white
                   transition
                   hover:bg-[#2b3747]"
        >

            <span
                class="material-symbols-outlined text-[18px]"
            >
                refresh
            </span>

            Tampilkan Semua

        </a>

    @endif

</div>