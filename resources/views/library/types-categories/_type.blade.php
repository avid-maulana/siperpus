{{-- =================================================
    TIPE LITERATUR
================================================== --}}

<section>

    <div class="mb-6">

        <h2 class="text-xl font-semibold text-slate-900">
            Tipe Literatur
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Jenis utama literatur yang tersedia di sistem.
        </p>

    </div>


    {{-- =================================================
        FORM TAMBAH TIPE
    ================================================== --}}

    <form
        action="{{ route('library.storeType') }}"
        method="POST"
        class="mb-6 flex flex-col gap-3 rounded-2xl border border-slate-200 bg-slate-50/80 p-4 sm:flex-row sm:items-center"
    >

        @csrf

        <div class="flex-1">

            <input
                type="text"
                name="name"
                placeholder="Contoh: Buku, Jurnal, Skripsi..."
                required
                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >

        </div>


        <button
            type="submit"
            class="action-button inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200"
        >

            <svg
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4.5v15m7.5-7.5h-15"
                />

            </svg>

            Tambah Tipe

        </button>

    </form>


    {{-- =================================================
        DAFTAR TIPE
    ================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200">

        <div class="border-b border-slate-200 bg-slate-50/80 px-5 py-3.5">

            <h3 class="text-sm font-semibold text-slate-700">
                Daftar Tipe
            </h3>

        </div>


        <div class="overflow-x-auto">

            <table class="literature-table min-w-full text-sm">

                <colgroup>

                    <col class="col-name">
                    <col class="col-type">
                    <col class="col-action">

                </colgroup>


                <thead>

                    <tr class="border-b border-slate-100 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">

                        <th class="px-5 py-3.5">
                            ID
                        </th>

                        <th class="px-5 py-3.5">
                            Nama
                        </th>

                        <th class="px-5 py-3.5 text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($types as $type)

                        <tr
                            id="type-row-{{ $type->id }}"
                            class="literature-row"
                        >

                            {{-- =================================================
                                ID
                            ================================================== --}}

                            <td class="px-5 py-4 align-middle text-slate-500">

                                {{ $type->id }}

                            </td>


                            {{-- =================================================
                                NAMA
                            ================================================== --}}

                            <td class="px-5 py-4 align-middle">

                                {{-- NORMAL --}}

                                <div
                                    id="type-display-{{ $type->id }}"
                                    class="edit-content edit-visible"
                                >

                                    <span class="font-medium text-slate-800">
                                        {{ $type->name }}
                                    </span>

                                </div>


                                {{-- EDIT INPUT --}}

                                <form
                                    id="type-form-{{ $type->id }}"
                                    action="{{ route('library.updateType', $type->id) }}"
                                    method="POST"
                                    class="edit-content edit-hidden"
                                >

                                    @csrf

                                    @method('PUT')

                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ $type->name }}"
                                        required
                                        class="edit-input w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-blue-500"
                                    >

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
                                        id="type-normal-actions-{{ $type->id }}"
                                        class="flex items-center gap-2"
                                    >

                                        {{-- EDIT --}}

                                        <button
                                            type="button"
                                            onclick="openTypeEdit({{ $type->id }})"
                                            class="action-button inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-blue-600 hover:border-blue-600 hover:bg-blue-600 hover:text-white"
                                        >

                                            <span class="material-symbols-outlined text-[17px]">
                                                edit
                                            </span>

                                            Edit

                                        </button>


                                        {{-- HAPUS --}}

                                        <form
                                            action="{{ route('library.destroyType', $type->id) }}"
                                            method="POST"
                                            class="delete-form"
                                            data-item-name="tipe literatur ini"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="action-button inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-red-600 hover:border-red-600 hover:bg-red-600 hover:text-white"
                                            >

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
                                        id="type-edit-actions-{{ $type->id }}"
                                        class="hidden items-center gap-2"
                                    >

                                        {{-- SIMPAN --}}

                                        <button
                                            type="button"
                                            onclick="submitTypeEdit({{ $type->id }})"
                                            class="save-button inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-emerald-600 hover:border-emerald-600 hover:bg-emerald-600 hover:text-white"
                                        >

                                            <span class="material-symbols-outlined text-[17px]">
                                                check
                                            </span>

                                            Simpan

                                        </button>


                                        {{-- BATAL --}}

                                        <button
                                            type="button"
                                            onclick="cancelTypeEdit({{ $type->id }})"
                                            class="cancel-button inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-slate-500 hover:border-slate-500 hover:bg-slate-500 hover:text-white"
                                        >

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
                                class="px-5 py-12 text-center"
                            >

                                <p class="text-sm font-medium text-slate-600">
                                    Belum ada tipe literatur
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    Tambahkan tipe pertama di form di atas.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</section>