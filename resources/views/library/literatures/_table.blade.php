{{-- Daftar Literatur --}}
<div class="overflow-hidden rounded-2xl border border-slate-200">

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">

            <thead class="bg-slate-50 text-xs uppercase tracking-[0.24em] text-slate-500">
                <tr>
                    <th class="px-5 py-4 text-left align-middle">Cover</th>
                    <th class="px-5 py-4 text-left align-middle">Judul</th>
                    <th class="px-5 py-4 text-left align-middle">Penulis</th>
                    <th class="px-5 py-4 text-left align-middle">Penerbit</th>
                    <th class="px-5 py-4 text-center align-middle">Tahun</th>
                    <th class="px-5 py-4 text-left align-middle">Kategori</th>
                    <th class="w-[140px] px-5 py-4 text-center align-middle">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($literatures as $literature)
                <tr class="h-[96px] align-middle transition-colors duration-200 hover:bg-slate-50">
                    <td class="px-5 py-4 align-middle">
                        <img
                            src="{{ $literature->cover_url ?: asset('asset/cover.jpg') }}"
                            alt="Cover {{ $literature->title }}"
                            class="h-[72px] w-[52px] rounded-lg border border-slate-200 object-cover shadow-sm">
                    </td>

                    <td class="px-5 py-4 align-middle">
                        <div class="flex max-w-[280px] flex-col justify-center gap-1">
                            <div class="text-[15px] font-semibold leading-snug text-slate-900">
                                {{ $literature->title }}
                            </div>
                            <div class="text-xs leading-relaxed text-slate-500">
                                {{ $literature->description ? Str::limit($literature->description, 80) : 'Literatur digital yang tersedia untuk dipelajari.' }}
                            </div>
                        </div>
                    </td>

                    <td class="px-5 py-4 align-middle text-slate-600">
                        {{ $literature->author }}
                    </td>

                    <td class="px-5 py-4 align-middle text-slate-600">
                        {{ $literature->publisher ?? '-' }}
                    </td>

                    <td class="px-5 py-4 text-center align-middle text-slate-600">
                        {{ $literature->year }}
                    </td>

                    <td class="px-5 py-4 align-middle">
                        <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                            {{ $literature->category->name ?? 'E-Book' }}
                        </span>
                    </td>

                    <td class="px-5 py-4 align-middle">
                        <div class="flex flex-col items-stretch gap-2">

                            <a
                                href="{{ $literature->file_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl
                                           border border-slate-200 px-3 text-xs font-medium
                                           text-slate-600 transition hover:border-slate-300 hover:bg-slate-50">
                                <span class="material-symbols-outlined text-[16px]">visibility</span>
                                Lihat
                            </a>

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
                                class="inline-flex h-9 items-center justify-center gap-1.5 rounded-xl
                                           bg-blue-50 px-3 text-xs font-medium
                                           text-blue-700 transition hover:bg-blue-100">
                                <span class="material-symbols-outlined text-[16px]">edit</span>
                                Edit
                            </button>

                            <form
                                action="{{ route('library.destroyLiterature', $literature->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus literatur ini?')">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex h-9 w-full items-center justify-center gap-1.5 rounded-xl
                                               bg-red-50 px-3 text-xs font-medium
                                               text-red-600 transition hover:bg-red-100">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center text-sm text-slate-500">
                        Belum ada data literatur.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('library.literatures._pagination')