<form id="filterForm" action="{{ route('literatures.index') }}" method="GET">

    <div class="space-y-3">

        <div class="grid grid-cols-1 gap-3 lg:grid-cols-[minmax(0,4fr)_180px_220px_56px] lg:items-center">

            {{-- Search --}}
            <div class="group relative">

                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                    <span class="material-symbols-outlined text-slate-400">
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
                    class="w-full rounded-2xl border border-slate-300 bg-white py-3.5 pl-12 pr-28 text-slate-700 shadow-sm transition duration-300 placeholder:text-slate-400 focus:border-[#212A37] focus:shadow-[0_0_0_4px_rgba(33,42,55,.08)] focus:outline-none">

                <button
                    id="clearSearch"
                    type="button"
                    class="hidden absolute right-24 top-1/2 -translate-y-1/2 rounded-full bg-slate-100 p-1 text-slate-500 hover:bg-slate-200">

                    <span class="material-symbols-outlined text-base">
                        close
                    </span>

                </button>

                <button
                    type="submit"
                    class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-slate-950 px-5 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">

                    Search

                </button>

            </div>

            {{-- Type --}}
            <div class="relative">

                <select
                    id="typeSelect"
                    name="type"
                    class="w-full appearance-none rounded-2xl border border-slate-300 bg-white py-3.5 pl-4 pr-10 shadow-sm focus:border-[#212A37] focus:outline-none">

                    <option value="">Semua Tipe</option>

                    @foreach($types as $type)
                        <option value="{{ $type }}" @selected(request('type')==$type)>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach

                </select>

                <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                    keyboard_arrow_down
                </span>

            </div>

            {{-- Category --}}
            <div class="relative">

                <select
                    id="categorySelect"
                    name="category_id"
                    class="w-full appearance-none rounded-2xl border border-slate-300 bg-white py-3.5 pl-4 pr-10 shadow-sm focus:border-[#212A37] focus:outline-none">

                    <option value="">Semua Kategori</option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            data-type="{{ $category->type }}"
                            @selected(request('category_id')==$category->id)>

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
                title="Reset Filter"
                class="flex h-14 w-14 items-center justify-center rounded-2xl border border-slate-300 bg-white shadow-sm transition hover:bg-slate-50 hover:border-slate-400">

                <span class="material-symbols-outlined">
                    restart_alt
                </span>

            </button>

        </div>

        <p class="text-sm text-slate-500">
            Cari referensi dengan cepat berdasarkan judul, penulis, tipe, maupun kategori.
        </p>

    </div>

</form>