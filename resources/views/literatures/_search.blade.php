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
    id="filterForm"
    action="{{ route('literatures.index') }}"
    method="GET"
    class="w-full">

    <div class="grid grid-cols-1 gap-3
            lg:grid-cols-[minmax(0,1fr)_190px_230px_54px]
            lg:items-end">

        {{-- SEARCH --}}
        <div>

            <label
                for="searchInput"
                class="mb-1.5 block text-xs font-semibold
                   uppercase tracking-wider text-slate-500">
                Pencarian
            </label>

            <div class="group relative">

                <div class="pointer-events-none absolute inset-y-0 left-0
                        flex items-center pl-4">

                    <span class="material-symbols-outlined
                             text-[21px] text-slate-400
                             transition-colors
                             group-focus-within:text-[#212A37]">
                        search
                    </span>

                </div>

                <input
                    id="searchInput"
                    type="search"
                    name="search"
                    autocomplete="off"
                    spellcheck="false"
                    value="{{ request('search') }}"
                    placeholder="Cari judul, penulis, atau kata kunci..."
                    class="h-[52px] w-full
                       rounded-xl
                       border border-slate-300
                       bg-white
                       pl-12 pr-28
                       text-sm text-slate-700
                       shadow-sm
                       outline-none
                       transition-all duration-200
                       placeholder:text-slate-400
                       focus:border-[#212A37]
                       focus:ring-4
                       focus:ring-slate-100">

                <button
                    id="clearSearch"
                    type="button"
                    title="Hapus pencarian"
                    class="absolute right-[102px] top-1/2
                       hidden -translate-y-1/2
                       rounded-full p-1
                       text-slate-400
                       transition
                       hover:bg-slate-100
                       hover:text-slate-700">

                    <span class="material-symbols-outlined text-[18px]">
                        close
                    </span>

                </button>

                <button
                    type="submit"
                    class="absolute right-1.5 top-1/2
                       h-10 -translate-y-1/2
                       rounded-lg
                       bg-[#212A37]
                       px-5
                       text-sm font-semibold text-white
                       transition-all duration-200
                       hover:bg-[#18202b]">
                    Cari
                </button>

            </div>
        </div>


        {{-- TYPE --}}
        <div>

            <label
                for="typeSelect"
                class="mb-1.5 block text-xs font-semibold
                   uppercase tracking-wider text-slate-500">
                Tipe
            </label>

            <div class="relative">

                <select
                    id="typeSelect"
                    name="type"
                    class="h-[52px] w-full
                       appearance-none
                       rounded-xl
                       border border-slate-300
                       bg-white
                       pl-4 pr-10
                       text-sm text-slate-700
                       shadow-sm
                       outline-none
                       transition-all duration-200
                       focus:border-[#212A37]
                       focus:ring-4
                       focus:ring-slate-100">

                    <option value="">Semua Tipe</option>

                    @foreach($types as $type)
                    <option
                        value="{{ $type }}"
                        @selected(request('type')==$type)>
                        {{ ucfirst($type) }}
                    </option>
                    @endforeach

                </select>

                <span class="material-symbols-outlined
                         pointer-events-none
                         absolute right-3 top-1/2
                         -translate-y-1/2
                         text-[20px] text-slate-400">
                    keyboard_arrow_down
                </span>

            </div>
        </div>


        {{-- CATEGORY --}}
        <div>

            <label
                for="categorySelect"
                class="mb-1.5 block text-xs font-semibold
                   uppercase tracking-wider text-slate-500">
                Kategori
            </label>

            <div class="relative">

                <select
                    id="categorySelect"
                    name="category_id"
                    class="h-[52px] w-full
                       appearance-none
                       rounded-xl
                       border border-slate-300
                       bg-white
                       pl-4 pr-10
                       text-sm text-slate-700
                       shadow-sm
                       outline-none
                       transition-all duration-200
                       focus:border-[#212A37]
                       focus:ring-4
                       focus:ring-slate-100">

                    <option value="">Semua Kategori</option>

                    @foreach($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        data-type="{{ $category->type->name ?? '' }}"
                        @selected(request('category_id')==$category->id)>
                        {{ $category->name }}
                    </option>
                    @endforeach

                </select>

                <span class="material-symbols-outlined
                         pointer-events-none
                         absolute right-3 top-1/2
                         -translate-y-1/2
                         text-[20px] text-slate-400">
                    keyboard_arrow_down
                </span>

            </div>
        </div>


        {{-- RESET --}}
        <div>

            <span class="mb-1.5 block text-center
                     text-xs font-semibold
                     uppercase tracking-wider text-slate-500">
                Reset
            </span>

            <button
                type="button"
                id="resetSearch"
                title="Reset Filter"
                class="flex h-[52px] w-[54px]
                   items-center justify-center
                   rounded-xl
                   border border-slate-300
                   bg-white
                   text-slate-600
                   shadow-sm
                   transition-all duration-200
                   hover:border-[#212A37]
                   hover:bg-[#212A37]
                   hover:text-white">

                <span class="material-symbols-outlined text-[22px]">
                    restart_alt
                </span>

            </button>

        </div>

    </div>

    <p class="mt-3 text-xs leading-5 text-slate-500">
        Cari referensi berdasarkan judul, penulis, tipe, maupun kategori.
    </p>

</form>