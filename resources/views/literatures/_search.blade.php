<form id="filterForm" action="{{ route('literatures.index') }}" method="GET"
    class="mb-6 space-y-3">

    {{-- Search --}}
    <div class="relative">
        <svg class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>

        <input
            id="searchInput"
            name="search"
            type="search"
            autocomplete="off"
            spellcheck="false"
            class="w-full pl-11 pr-11 py-3 text-sm bg-slate-50 border border-slate-200 rounded-xl
                   placeholder:text-slate-400 outline-none transition-all duration-150
                   focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:shadow-sm"
            placeholder="Cari judul, penulis, atau kata kunci..."
            value="{{ request('search') }}">

        <button
            type="button"
            id="clearSearch"
            aria-label="Hapus pencarian"
            class="absolute right-3 top-1/2 -translate-y-1/2 p-1 rounded-full text-slate-300
                   hover:text-slate-500 hover:bg-slate-100 transition-colors
                   {{ request('search') ? '' : 'hidden' }}">

            <svg class="w-4 h-4"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>

        </button>
    </div>

    {{-- Filter --}}
    <div class="flex flex-col sm:flex-row gap-3">

        {{-- Select Asli --}}
        <select name="type_id" id="typeSelect" class="hidden">
            <option value="">Semua Tipe</option>

            @foreach($types as $type)
                <option value="{{ $type->id }}"
                    {{ request('type_id') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                </option>
            @endforeach

        </select>

        <select name="category_id" id="categorySelect" class="hidden">
            <option value="">Semua Kategori</option>

            @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    data-type="{{ $category->type_id }}"
                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach

        </select>

        {{-- Custom Dropdown Tipe --}}
        <div class="relative w-full sm:w-48 dropdown-container"
            id="customTypeDropdown">

            <button
                type="button"
                class="dropdown-trigger w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-700 flex items-center justify-between outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">

                <span class="selected-text">
                    Semua Tipe
                </span>

                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"/>

                </svg>

            </button>

            <div class="dropdown-menu absolute z-50 left-0 mt-1 w-full bg-white border border-slate-200 rounded-lg shadow-lg opacity-0 invisible scale-95 origin-top pointer-events-none transition-all duration-200 ease-out max-h-60 overflow-y-auto">

                <div class="p-1">

                    <div
                        class="dropdown-item px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md cursor-pointer"
                        data-value="">
                        Semua Tipe
                    </div>

                    @foreach($types as $type)

                        <div
                            class="dropdown-item px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md cursor-pointer"
                            data-value="{{ $type->id }}">
                            {{ $type->name }}
                        </div>

                    @endforeach

                </div>

            </div>

        </div>

        {{-- Custom Dropdown Kategori --}}
        <div class="relative w-full sm:w-52 dropdown-container"
            id="customCategoryDropdown">

            <button
                type="button"
                class="dropdown-trigger w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-700 flex items-center justify-between outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all">

                <span class="selected-text">
                    Semua Kategori
                </span>

                <svg class="w-4 h-4 text-slate-400 transition-transform duration-200"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"/>

                </svg>

            </button>

            <div class="dropdown-menu absolute z-50 left-0 mt-1 w-full bg-white border border-slate-200 rounded-lg shadow-lg opacity-0 invisible scale-95 origin-top pointer-events-none transition-all duration-200 ease-out max-h-60 overflow-y-auto">

                <div class="p-1">

                    <div
                        class="dropdown-item px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md cursor-pointer"
                        data-value="">
                        Semua Kategori
                    </div>

                    @foreach($categories as $category)

                        <div
                            class="dropdown-item px-3 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md cursor-pointer"
                            data-value="{{ $category->id }}"
                            data-type="{{ $category->type_id }}">
                            {{ $category->name }}
                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</form>