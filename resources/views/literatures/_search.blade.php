<form id="filterForm" action="{{ route('literatures.index') }}" method="GET" class="mb-6">

    <div class="grid gap-3 md:grid-cols-3">

        {{-- Search --}}
        <input
            id="searchInput"
            type="search"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari judul, penulis, atau kata kunci..."
            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">

        {{-- Tipe --}}
        <select
            id="typeSelect"
            name="type_id"
            class="rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">

            <option value="">Semua Tipe</option>

            @foreach($types as $type)
                <option
                    value="{{ $type->id }}"
                    @selected(request('type_id') == $type->id)>
                    {{ $type->name }}
                </option>
            @endforeach

        </select>

        {{-- Kategori --}}
        <select
            id="categorySelect"
            name="category_id"
            class="rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">

            <option value="">Semua Kategori</option>

            @foreach($categories as $category)
                <option
                    value="{{ $category->id }}"
                    data-type="{{ $category->type_id }}"
                    @selected(request('category_id') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach

        </select>

    </div>

</form>