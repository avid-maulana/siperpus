{{-- =================================================
    KATEGORI LITERATUR
================================================== --}}

<section>

    <div class="mb-6">

        <h2 class="text-xl font-semibold text-slate-900">
            Kategori Literatur
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Hubungkan kategori dengan tipe yang sesuai.
        </p>

    </div>


    {{-- =================================================
        FORM TAMBAH KATEGORI
    ================================================== --}}

    <form
        action="{{ route('library.storeCategory') }}"
        method="POST"
        class="mb-6 grid gap-3 rounded-2xl border border-slate-200 bg-slate-50/80 p-4 sm:grid-cols-3">

        @csrf


        {{-- NAMA KATEGORI --}}

        <div>

            <input
                type="text"
                name="name"
                placeholder="Nama kategori..."
                required
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

        </div>


        {{-- TIPE --}}

        <div>

            <select
                name="type_id"
                required
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                <option value="">
                    Pilih Tipe
                </option>

                @foreach ($types as $type)

                    <option value="{{ $type->id }}">
                        {{ $type->name }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- SUBMIT --}}

        <button
            type="submit"
            class="action-button inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">

            <svg
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4.5v15m7.5-7.5h-15" />

            </svg>

            Tambah Kategori

        </button>

    </form>


    {{-- =================================================
        DAFTAR KATEGORI
    ================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200">

        <div class="border-b border-slate-200 bg-slate-50/80 px-5 py-3.5">

            <h3 class="text-sm font-semibold text-slate-700">
                Daftar Kategori
            </h3>

        </div>


        <div class="overflow-x-auto">

            <table class="literature-table min-w-full text-sm">

                {{-- Kolom dibuat tetap agar sejajar --}}

                <colgroup>

                    <col class="col-name">
                    <col class="col-type">
                    <col class="col-action">

                </colgroup>


                <thead>

                    <tr class="border-b border-slate-100 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">

                        <th class="px-5 py-3.5">
                            ID & NAMA
                        </th>

                        <th class="px-5 py-3.5">
                            TIPE
                        </th>

                        <th class="px-5 py-3.5 text-right">
                            AKSI
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($categories as $category)

                        <tr
                            id="category-row-{{ $category->id }}"
                            class="literature-row">


                            {{-- =================================================
                                NAMA KATEGORI
                            ================================================== --}}

                            <td class="px-5 py-4 align-middle">


                                {{-- NORMAL --}}

                                <div
                                    id="category-name-display-{{ $category->id }}"
                                    class="edit-content edit-visible">

                                    <div class="font-medium text-slate-800">

                                        <span class="mr-1.5 text-slate-400">
                                            #{{ $category->id }}
                                        </span>

                                        {{ $category->name }}

                                    </div>

                                </div>


                                {{-- EDIT INPUT --}}

                                <div
                                    id="category-name-edit-{{ $category->id }}"
                                    class="edit-content edit-hidden">

                                    <div class="flex items-center">

                                        <span class="mr-3 shrink-0 text-sm font-medium text-slate-400">
                                            #{{ $category->id }}
                                        </span>

                                        <input
                                            id="category-input-{{ $category->id }}"
                                            type="text"
                                            name="name"
                                            value="{{ $category->name }}"
                                            form="category-form-{{ $category->id }}"
                                            required
                                            class="edit-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-blue-500">

                                    </div>

                                </div>

                            </td>


                            {{-- =================================================
                                TIPE
                            ================================================== --}}

                            <td class="px-5 py-4 align-middle">


                                {{-- NORMAL TYPE --}}

                                <div
                                    id="category-type-display-{{ $category->id }}"
                                    class="edit-content edit-visible">

                                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">

                                        {{ $category->type->name }}

                                    </span>

                                </div>


                                {{-- EDIT TYPE --}}

                                <div
                                    id="category-type-edit-{{ $category->id }}"
                                    class="edit-content edit-hidden">

                                    <select
                                        name="type_id"
                                        form="category-form-{{ $category->id }}"
                                        required
                                        class="edit-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-blue-500">

                                        @foreach ($types as $type)

                                            <option
                                                value="{{ $type->id }}"
                                                @selected($type->id == $category->type_id)>

                                                {{ $type->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- =================================================
                                    FORM UPDATE
                                    Sengaja ditempatkan di luar visual kolom
                                ================================================== --}}

                                <form
                                    id="category-form-{{ $category->id }}"
                                    action="{{ route('library.updateCategory', $category->id) }}"
                                    method="POST"
                                    class="hidden">

                                    @csrf

                                    @method('PUT')

                                </form>

                            </td>


                            {{-- =================================================
                                AKSI
                            ================================================== --}}

                            <td class="px-5 py-4 align-middle">

                                <div class="flex items-center justify-end">


                                    {{-- =================================================
                                        NORMAL ACTION
                                    ================================================== --}}

                                    <div
                                        id="category-normal-actions-{{ $category->id }}"
                                        class="flex items-center gap-2">


                                        {{-- EDIT --}}

                                        <button
                                            type="button"
                                            onclick="openCategoryEdit({{ $category->id }})"
                                            class="action-button inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-blue-600 hover:border-blue-600 hover:bg-blue-600 hover:text-white">

                                            <span class="material-symbols-outlined text-[17px]">
                                                edit
                                            </span>

                                            Edit

                                        </button>


                                        {{-- HAPUS --}}

                                        <form
                                            action="{{ route('library.destroyCategory', $category->id) }}"
                                            method="POST"
                                            class="delete-form"
                                            data-item-name="kategori ini">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-button inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-red-600 hover:border-red-600 hover:bg-red-600 hover:text-white">

                                                <span class="material-symbols-outlined text-[17px]">
                                                    delete
                                                </span>

                                                Hapus

                                            </button>

                                        </form>

                                    </div>


                                    {{-- =================================================
                                        EDIT ACTION
                                    ================================================== --}}

                                    <div
                                        id="category-edit-actions-{{ $category->id }}"
                                        class="hidden items-center gap-2">


                                        {{-- SIMPAN --}}

                                        <button
                                            type="button"
                                            onclick="submitCategoryEdit({{ $category->id }})"
                                            class="save-button inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-emerald-600 hover:border-emerald-600 hover:bg-emerald-600 hover:text-white">

                                            <span class="material-symbols-outlined text-[17px]">
                                                check
                                            </span>

                                            Simpan

                                        </button>


                                        {{-- BATAL --}}

                                        <button
                                            type="button"
                                            onclick="cancelCategoryEdit({{ $category->id }})"
                                            class="cancel-button inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-slate-500 hover:border-slate-500 hover:bg-slate-500 hover:text-white">

                                            <span class="material-symbols-outlined text-[17px]">
                                                close
                                            </span>

                                            Batal

                                        </button>

                                    </div>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="3"
                                class="px-5 py-12 text-center">

                                <div class="mx-auto flex max-w-xs flex-col items-center gap-2">


                                    {{-- ICON --}}

                                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">

                                        <svg
                                            class="h-6 w-6"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.5">

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 6h.008v.008H6V6z" />

                                        </svg>

                                    </div>


                                    <p class="text-sm font-medium text-slate-600">
                                        Belum ada kategori
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        Tambahkan kategori pertama di form di atas.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</section>