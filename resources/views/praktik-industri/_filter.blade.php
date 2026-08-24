{{-- =========================================================
    SEARCH PRAKTIK INDUSTRI
========================================================= --}}

<style>
    /* Hilangkan tombol X bawaan input type="search" */
    input[type="search"]::-webkit-search-decoration,
    input[type="search"]::-webkit-search-cancel-button,
    input[type="search"]::-webkit-search-results-button,
    input[type="search"]::-webkit-search-results-decoration {
        -webkit-appearance: none;
        appearance: none;
    }

    input[type="search"]::-ms-clear,
    input[type="search"]::-ms-reveal {
        display: none;
        width: 0;
        height: 0;
    }
</style>


<form
    id="praktikIndustriFilterForm"
    action="{{ route('praktik-industri.index') }}"
    method="GET"
    class="w-full"
>

    <div
        class="grid grid-cols-1 gap-3
               lg:grid-cols-[190px_minmax(0,1fr)_54px]
               lg:items-end"
    >

        {{-- =================================================
            FILTER
        ================================================== --}}

        <div>

            <label
                for="praktikIndustriFilter"
                class="mb-1.5 block
                       text-xs
                       font-semibold
                       uppercase
                       tracking-wider
                       text-slate-500"
            >
                Filter Berdasarkan
            </label>


            <div class="relative">

                <select
                    id="praktikIndustriFilter"
                    name="filter"
                    class="h-[52px]
                           w-full
                           appearance-none
                           rounded-xl
                           border border-slate-300
                           bg-white
                           pl-4
                           pr-10
                           text-sm
                           text-slate-700
                           shadow-sm
                           outline-none
                           transition-all
                           duration-200
                           focus:border-[#212A37]
                           focus:ring-4
                           focus:ring-slate-100"
                >

                    <option
                        value="nama"
                        {{ ($filter ?? 'nama') === 'nama' ? 'selected' : '' }}
                    >
                        Nama Mahasiswa
                    </option>

                    <option
                        value="industri"
                        {{ ($filter ?? '') === 'industri' ? 'selected' : '' }}
                    >
                        Industri
                    </option>

                    <option
                        value="judul"
                        {{ ($filter ?? '') === 'judul' ? 'selected' : '' }}
                    >
                        Judul Laporan
                    </option>

                </select>


                <span
                    class="material-symbols-outlined
                           pointer-events-none
                           absolute
                           right-3
                           top-1/2
                           -translate-y-1/2
                           text-[20px]
                           text-slate-400"
                >
                    keyboard_arrow_down
                </span>

            </div>

        </div>


        {{-- =================================================
            SEARCH
        ================================================== --}}

        <div>

            <label
                for="praktikIndustriSearch"
                class="mb-1.5 block
                       text-xs
                       font-semibold
                       uppercase
                       tracking-wider
                       text-slate-500"
            >
                Pencarian
            </label>


            <div class="group relative">

                {{-- SEARCH ICON --}}

                <div
                    class="pointer-events-none
                           absolute
                           inset-y-0
                           left-0
                           flex
                           items-center
                           pl-4"
                >

                    <span
                        class="material-symbols-outlined
                               text-[21px]
                               text-slate-400
                               transition-colors
                               group-focus-within:text-[#212A37]"
                    >
                        search
                    </span>

                </div>


                {{-- INPUT --}}

                <input
                    id="praktikIndustriSearch"
                    type="search"
                    name="search"
                    value="{{ $search ?? request('search') }}"
                    autocomplete="off"
                    spellcheck="false"
                    placeholder="Cari nama mahasiswa, industri, atau judul laporan..."
                    class="h-[52px]
                           w-full
                           rounded-xl
                           border border-slate-300
                           bg-white
                           pl-12
                           pr-28
                           text-sm
                           text-slate-700
                           shadow-sm
                           outline-none
                           transition-all
                           duration-200
                           placeholder:text-slate-400
                           focus:border-[#212A37]
                           focus:ring-4
                           focus:ring-slate-100"
                >


                {{-- =================================================
                    CLEAR SEARCH
                ================================================== --}}

                <button
                    id="clearPraktikIndustriSearch"
                    type="button"
                    title="Hapus pencarian"
                    class="absolute
                           right-[102px]
                           top-1/2
                           hidden
                           -translate-y-1/2
                           rounded-full
                           p-1
                           text-slate-400
                           transition
                           hover:bg-slate-100
                           hover:text-slate-700"
                >

                    <span
                        class="material-symbols-outlined text-[18px]"
                    >
                        close
                    </span>

                </button>


                {{-- =================================================
                    SEARCH BUTTON
                ================================================== --}}

                <button
                    type="submit"
                    class="absolute
                           right-1.5
                           top-1/2
                           h-10
                           -translate-y-1/2
                           rounded-lg
                           bg-[#212A37]
                           px-5
                           text-sm
                           font-semibold
                           text-white
                           transition-all
                           duration-200
                           hover:bg-[#18202b]
                           active:scale-[0.98]"
                >
                    Cari
                </button>

            </div>

        </div>


        {{-- =================================================
            RESET
        ================================================== --}}

        <div>

            <span
                class="mb-1.5 block
                       text-center
                       text-xs
                       font-semibold
                       uppercase
                       tracking-wider
                       text-slate-500"
            >
                Reset
            </span>


            <button
                type="button"
                id="resetPraktikIndustriFilter"
                title="Reset Filter"
                class="flex
                       h-[52px]
                       w-[54px]
                       items-center
                       justify-center
                       rounded-xl
                       border border-slate-300
                       bg-white
                       text-slate-600
                       shadow-sm
                       transition-all
                       duration-200
                       hover:border-[#212A37]
                       hover:bg-[#212A37]
                       hover:text-white
                       active:scale-[0.98]"
            >

                <span
                    class="material-symbols-outlined text-[22px]"
                >
                    restart_alt
                </span>

            </button>

        </div>

    </div>


    {{-- =================================================
        DESCRIPTION
    ================================================== --}}

    <p
        class="mt-3
               text-xs
               leading-5
               text-slate-500"
    >
        Cari data praktik industri berdasarkan nama mahasiswa,
        industri, atau judul laporan.
    </p>

</form>


<script>
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById(
        'praktikIndustriFilterForm'
    );

    const searchInput = document.getElementById(
        'praktikIndustriSearch'
    );

    const clearButton = document.getElementById(
        'clearPraktikIndustriSearch'
    );

    const resetButton = document.getElementById(
        'resetPraktikIndustriFilter'
    );


    if (!form || !searchInput) {
        return;
    }


    /* =========================================================
       UPDATE CLEAR BUTTON
    ========================================================= */

    const updateClearButton = () => {

        if (searchInput.value.trim() !== '') {

            clearButton?.classList.remove('hidden');

        } else {

            clearButton?.classList.add('hidden');

        }

    };


    /* =========================================================
       SEARCH INPUT
    ========================================================= */

    searchInput.addEventListener('input', () => {

        updateClearButton();

    });


    /* =========================================================
       CLEAR SEARCH
    ========================================================= */

    clearButton?.addEventListener('click', () => {

        searchInput.value = '';

        updateClearButton();

        searchInput.focus();

    });


    /* =========================================================
       RESET ALL FILTER
    ========================================================= */

    resetButton?.addEventListener('click', () => {

        window.location.href = @json(
            route('praktik-industri.index')
        );

    });


    /* =========================================================
       INITIAL STATE
    ========================================================= */

    updateClearButton();

});
</script>