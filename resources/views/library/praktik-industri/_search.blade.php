{{-- =========================================================
    SEARCH KELOLA PRAKTIK INDUSTRI
========================================================= --}}

<div
    class="mb-6 rounded-2xl
           border border-slate-200
           bg-white
           p-5
           shadow-sm"
>

    <form
        action="{{ route('library.praktik-industri') }}"
        method="GET"
        class="flex items-center gap-3"
    >

        {{-- =================================================
            SEARCH INPUT
        ================================================== --}}

        <div class="relative flex-1">

            <span
                class="material-symbols-outlined
                       pointer-events-none
                       absolute left-4 top-1/2
                       -translate-y-1/2
                       text-[21px]
                       text-slate-400"
            >
                search
            </span>


            <input
                type="search"
                name="search"
                value="{{ $search ?? request('search') }}"
                autocomplete="off"
                placeholder="Cari nama mahasiswa, industri, atau judul laporan..."
                class="w-full
                       rounded-xl
                       border border-slate-200
                       bg-slate-50
                       py-3.5
                       pl-12
                       pr-4
                       text-sm
                       text-slate-700
                       outline-none
                       transition-all
                       duration-200
                       placeholder:text-slate-400
                       focus:border-[#212A37]
                       focus:bg-white
                       focus:ring-4
                       focus:ring-[#212A37]/10"
            >

        </div>


        {{-- =================================================
            SEARCH
        ================================================== --}}
        
        <button
            type="submit"
            class="inline-flex shrink-0
                   items-center justify-center
                   gap-2
                   rounded-xl
                   bg-[#212A37]
                   px-6 py-3.5
                   text-sm font-semibold
                   text-white
                   shadow-sm
                   transition-all duration-200
                   hover:bg-[#2b3747]
                   hover:shadow-md
                   active:scale-[0.98]"
        >

            <span class="material-symbols-outlined text-[19px]">
                search
            </span>

            Cari

        </button>


        {{-- =================================================
            RESET
        ================================================== --}}

        @if (!empty($search) || request()->filled('search'))

            <a
                href="{{ route('library.praktik-industri') }}"
                class="inline-flex shrink-0
                       items-center justify-center
                       gap-2
                       rounded-xl
                       border border-slate-200
                       bg-white
                       px-5 py-3.5
                       text-sm font-medium
                       text-slate-600
                       transition-all duration-200
                       hover:border-red-200
                       hover:bg-red-50
                       hover:text-red-600"
            >

                <span class="material-symbols-outlined text-[18px]">
                    close
                </span>

                Reset

            </a>

        @endif

    </form>

</div>