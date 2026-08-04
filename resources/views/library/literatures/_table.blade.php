{{-- Daftar Literatur --}}
<div class="overflow-hidden rounded-[20px] border border-[#E5E7EB] bg-white shadow-sm">

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-[#E5E7EB] text-sm">

            <thead class="sticky top-0 z-10 bg-[#F8FAFC] text-xs uppercase tracking-[0.24em] text-slate-500">
                <tr>
                    <th class="px-5 py-4 align-middle text-left">Cover</th>
                    <th class="px-5 py-4 align-middle text-left">Judul</th>
                    <th class="px-5 py-4 align-middle text-left">Penulis</th>
                    <th class="px-5 py-4 align-middle text-left">Penerbit</th>
                    <th class="px-5 py-4 align-middle text-center">Tahun</th>
                    <th class="px-5 py-4 align-middle text-left">Kategori</th>
                    <th class="w-[140px] px-5 py-4 align-middle text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-[#F1F5F9] bg-white">
                @forelse ($literatures as $literature)
                    <tr class="h-[95px] align-middle transition-colors duration-200 hover:bg-[#F8FAFC]">
                        <td class="px-5 py-5 align-middle">
                            <img
                                src="{{ $literature->cover_url }}"
                                alt="Cover {{ $literature->title }}"
                                class="h-[100px] w-[70px] rounded-lg border border-[#E5E7EB] object-cover shadow-sm"
                            >
                        </td>

                        <td class="px-5 py-5 align-middle">
                            <div class="flex max-w-[280px] flex-col justify-center space-y-1">
                                <div class="text-[17px] font-semibold leading-snug text-[#1F2937]">
                                    {{ $literature->title }}
                                </div>
                                <div class="text-sm leading-relaxed text-slate-500">
                                    {{ $literature->description ? Str::limit($literature->description, 80) : 'Literatur digital yang tersedia untuk dipelajari.' }}
                                </div>
                            </div>
                        </td>

                        <td class="px-5 py-5 align-middle text-slate-600">
                            {{ $literature->author }}
                        </td>

                        <td class="px-5 py-5 align-middle text-slate-600">
                            {{ $literature->publisher ?? '-' }}
                        </td>

                        <td class="px-5 py-5 align-middle text-center text-slate-600">
                            {{ $literature->year }}
                        </td>

                        <td class="px-5 py-5 align-middle">
                            <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                {{ $literature->category->name ?? 'E-Book' }}
                            </span>
                        </td>

                        <td class="px-5 py-5 align-middle">
                            <div class="flex min-w-[110px] flex-col items-stretch gap-2">

                                <a
                                    href="{{ $literature->file_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center gap-1.5 rounded-lg
                                           border border-slate-200 px-3 py-2 text-xs font-medium
                                           text-slate-600 transition hover:border-slate-300 hover:bg-slate-50"
                                >
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
                                    class="inline-flex items-center justify-center gap-1.5 rounded-lg
                                           bg-blue-50 px-3 py-2 text-xs font-medium
                                           text-blue-700 transition hover:bg-blue-100"
                                >
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                    Edit
                                </button>

                                <form
                                    action="{{ route('library.destroyLiterature', $literature->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus literatur ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex w-full items-center justify-center gap-1.5 rounded-lg
                                               bg-red-50 px-3 py-2 text-xs font-medium
                                               text-red-600 transition hover:bg-red-100"
                                    >
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-slate-500">
                            Belum ada data literatur.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('library.literatures._pagination')
</div>