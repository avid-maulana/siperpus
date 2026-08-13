{{-- ================================================================ --}}
{{-- FILTER / SEARCH TESIS --}}
{{-- ================================================================ --}}

<div
    class="rounded-2xl
           border border-slate-200
           bg-white
           p-5
           shadow-sm">

    <form
        id="thesisSearchForm"
        action="{{ route('tesis.index') }}"
        method="GET">

        <div
            class="flex flex-col
                   gap-3
                   md:flex-row
                   md:items-center">


            {{-- ==================================================== --}}
            {{-- SEARCH --}}
            {{-- ==================================================== --}}

            <div class="relative flex-1">

                <span
                    class="material-symbols-outlined
                           pointer-events-none
                           absolute left-4 top-1/2
                           -translate-y-1/2
                           text-[21px]
                           text-slate-400">

                    search

                </span>


                <input
                    id="thesisSearchInput"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    autocomplete="off"
                    placeholder="Cari judul tesis, NIM, atau nama mahasiswa..."
                    class="w-full
                           rounded-xl
                           border border-slate-200
                           bg-slate-50
                           py-3.5
                           pl-12
                           pr-11
                           text-sm
                           text-slate-700
                           outline-none
                           transition-all
                           duration-200
                           placeholder:text-slate-400
                           focus:border-slate-300
                           focus:bg-white
                           focus:ring-4
                           focus:ring-slate-100">


                {{-- Loading indicator --}}

                <div
                    id="thesisSearchLoading"
                    class="pointer-events-none
                           absolute right-4 top-1/2
                           hidden
                           -translate-y-1/2">

                    <span
                        class="block h-5 w-5
                               animate-spin
                               rounded-full
                               border-2
                               border-slate-200
                               border-t-slate-700">
                    </span>

                </div>

            </div>


            {{-- ==================================================== --}}
            {{-- RESET --}}
            {{-- ==================================================== --}}

            @if(request('search'))

            <button
                id="thesisClearSearch"
                type="button"
                class="inline-flex shrink-0
                           items-center
                           justify-center
                           gap-2
                           rounded-xl
                           border border-slate-200
                           bg-white
                           px-4 py-3.5
                           text-sm font-semibold
                           text-slate-600
                           transition-all
                           duration-200
                           hover:border-slate-300
                           hover:bg-slate-50
                           hover:text-slate-800">

                <span
                    class="material-symbols-outlined
                               text-[19px]">

                    close

                </span>

                Reset

            </button>

            @endif

        </div>


        {{-- ======================================================== --}}
        {{-- INFO --}}
        {{-- ======================================================== --}}

        <div
            class="mt-4 flex items-center
                   gap-2 text-xs
                   text-slate-400">

            <span
                class="material-symbols-outlined
                       text-[17px]">

                info

            </span>

            <span>
                Pencarian berdasarkan judul,
                NIM, atau nama mahasiswa.
            </span>

        </div>

    </form>

</div>