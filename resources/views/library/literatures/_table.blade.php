{{-- Daftar Literatur --}}
<div class="space-y-6 rounded-lg bg-white p-6 shadow-md">

    <h3 class="text-xl font-semibold text-gray-700">
        Daftar Literatur
    </h3>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">

            {{-- Header --}}
            <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                <tr>
                    <th class="px-4 py-3 text-left">
                        Cover
                    </th>

                    <th class="px-4 py-3 text-left">
                        Judul
                    </th>

                    <th class="px-4 py-3 text-left">
                        Penulis
                    </th>

                    <th class="px-4 py-3 text-left">
                        Penerbit
                    </th>

                    <th class="px-4 py-3 text-left">
                        Tahun
                    </th>

                    <th class="px-4 py-3 text-left">
                        Link
                    </th>

                    <th class="px-4 py-3 text-left">
                        Kategori
                    </th>

                    <th class="px-4 py-3 text-left">
                        Aksi
                    </th>
                </tr>
            </thead>

            {{-- Body --}}
            <tbody class="divide-y divide-gray-200 bg-white">

                @forelse ($literatures as $literature)

                <tr>

                    {{-- Cover --}}
                    <td class="px-4 py-3">
                        <img
                            src="{{ $literature->cover_url }}"
                            alt="Cover {{ $literature->title }}"
                            class="h-20 w-20 rounded object-cover">
                    </td>

                    {{-- Judul --}}
                    <td class="px-4 py-3">
                        {{ $literature->title }}
                    </td>

                    {{-- Penulis --}}
                    <td class="px-4 py-3">
                        {{ $literature->author }}
                    </td>

                    {{-- Penerbit --}}
                    <td class="px-4 py-3">
                        {{ $literature->publisher ?? '-' }}
                    </td>

                    {{-- Tahun --}}
                    <td class="px-4 py-3">
                        {{ $literature->year }}
                    </td>

                    {{-- Link --}}
                    <td class="px-4 py-3">
                        <a
                            href="{{ $literature->file_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-indigo-600 hover:underline">
                            Lihat
                        </a>
                    </td>

                    {{-- Kategori --}}
                    <td class="px-4 py-3">
                        {{ $literature->category->name ?? '-' }}
                    </td>

                    {{-- Aksi --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">

                            {{-- Edit --}}
                            <button
                                type="button"
                                onclick="showEditModal(this)"

                                data-id="{{ $literature->id }}"
                                data-cover_url="{{ $literature->cover_url }}"
                                data-title="{{ $literature->title }}"
                                data-author="{{ $literature->author }}"
                                data-publisher="{{ $literature->publisher ?? '' }}"
                                data-year="{{ $literature->year }}"
                                data-file_url="{{ $literature->file_url }}"
                                data-category_id="{{ $literature->category_id }}"
                                data-detail="{{ $literature->detail }}"
                                data-description="{{ $literature->description }}"

                                class="rounded bg-sky-600 px-3 py-1 text-white transition hover:bg-sky-700">
                                Edit
                            </button>

                            {{-- Hapus --}}
                            <form
                                action="{{ route('library.destroyLiterature', $literature->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus literatur ini?')"
                                class="contents">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="rounded bg-red-600 px-3 py-1 text-white transition hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>

                @empty

                {{-- Data Kosong --}}
                <tr>
                    <td
                        colspan="8"
                        class="px-4 py-10 text-center text-gray-500">
                        Belum ada data literatur.
                    </td>
                </tr>

                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @include('library.literatures._pagination')

</div>