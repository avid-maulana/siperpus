<form id="filterForm" action="{{ route('literatures.index') }}" method="GET" class="mt-8">
    <div class="flex flex-col gap-3 xl:flex-row xl:items-center">

        {{-- Search --}}
        <label class="relative flex-1">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-lg text-slate-400">
                search
            </span>

            <input
                id="searchInput"
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari judul, penulis, atau kata kunci..."
                class="w-full rounded-2xl border border-slate-200 bg-white py-3 pl-12 pr-10 text-sm text-slate-700 placeholder:text-slate-400 outline-none transition-all duration-200 focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
            >

            <button
                type="button"
                id="clearSearch"
                class="hidden absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-slate-100 p-1 text-slate-500 transition hover:bg-slate-200"
                aria-label="Bersihkan pencarian"
            >
                <span class="material-symbols-outlined text-base">
                    close
                </span>
            </button>
        </label>

        {{-- Type --}}
        <div class="relative min-w-[180px]">
            <select
                id="typeSelect"
                name="type"
                class="w-full appearance-none rounded-2xl border border-slate-200 bg-white py-3 pl-4 pr-10 text-sm text-slate-700 outline-none transition-all duration-200 focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
            >
                <option value="">Semua Tipe</option>

                @foreach ($types as $type)
                    <option
                        value="{{ $type }}"
                        @selected(request('type') == $type)
                    >
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>

            <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                keyboard_arrow_down
            </span>
        </div>

        {{-- Category --}}
        <div class="relative min-w-[220px]">
            <select
                id="categorySelect"
                name="category_id"
                class="w-full appearance-none rounded-2xl border border-slate-200 bg-white py-3 pl-4 pr-10 text-sm text-slate-700 outline-none transition-all duration-200 focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
            >
                <option value="">Semua Kategori</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        data-type="{{ $category->type }}"
                        @selected(request('category_id') == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                keyboard_arrow_down
            </span>
        </div>

        {{-- Reset --}}
        <button
            type="button"
            id="resetSearch"
            class="flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3 text-sm font-medium text-slate-700 transition-all duration-200 hover:border-slate-300 hover:bg-slate-100 active:scale-95"
        >
            <span class="material-symbols-outlined text-[18px]">
                restart_alt
            </span>
            Reset
        </button>

    </div>
</form>