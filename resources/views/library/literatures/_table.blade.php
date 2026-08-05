{{-- Daftar Literatur --}}
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50/80 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    <th class="px-5 py-4 w-[80px]">Cover</th>
                    <th class="px-5 py-4 min-w-[240px]">Judul</th>
                    <th class="px-5 py-4">Penulis</th>
                    <th class="px-5 py-4">Penerbit</th>
                    <th class="px-5 py-4 text-center">Tahun</th>
                    <th class="px-5 py-4">Kategori</th>
                    <th class="px-5 py-4 text-right w-[150px]">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse ($literatures as $literature)
                <tr class="group transition-colors duration-150 hover:bg-slate-50/70">
                    {{-- Cover --}}
                    <td class="px-5 py-4 align-middle">
                        <img
                            src="{{ $literature->cover_url ?: asset('asset/cover.jpg') }}"
                            alt="Cover {{ $literature->title }}"
                            onerror="this.onerror=null; this.src='{{ asset('asset/cover.jpg') }}';"
                            class="h-[72px] w-[52px] rounded-lg border border-slate-200 object-cover shadow-sm transition group-hover:shadow-md">
                    </td>

                    {{-- Judul + Deskripsi --}}
                    <td class="px-5 py-4 align-middle">
                        <div class="max-w-[280px]">
                            <div class="text-[15px] font-semibold leading-snug text-slate-900 line-clamp-2">
                                {{ $literature->title }}
                            </div>
                            <p class="mt-1 text-xs leading-relaxed text-slate-500 line-clamp-2">
                                {{ $literature->description ? Str::limit($literature->description, 90) : 'Literatur digital yang tersedia untuk dipelajari.' }}
                            </p>
                        </div>
                    </td>

                    {{-- Penulis --}}
                    <td class="px-5 py-4 align-middle text-slate-600">
                        {{ $literature->author ?: '-' }}
                    </td>

                    {{-- Penerbit --}}
                    <td class="px-5 py-4 align-middle text-slate-600">
                        {{ $literature->publisher ?? '-' }}
                    </td>

                    {{-- Tahun --}}
                    <td class="px-5 py-4 text-center align-middle text-slate-600">
                        {{ $literature->year ?? '-' }}
                    </td>

                    {{-- Kategori --}}
                    <td class="px-5 py-4 align-middle">
                        <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700">
                            {{ $literature->category->name ?? 'E-Book' }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-5 py-4 align-middle">
                        <div class="flex items-center justify-end gap-2">

                            {{-- Lihat --}}
                            <a href="{{ $literature->file_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-transparent px-2.5 py-1.5 text-xs font-medium text-slate-600 transition-all duration-200 hover:border-slate-600 hover:bg-slate-600 hover:text-white">
                                <span class="material-symbols-outlined text-[16px]"
                                    style="font-variation-settings: 'wght' 300;">
                                    visibility
                                </span>
                                Lihat
                            </a>

                            {{-- Edit --}}
                            <button type="button"
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
                                class="inline-flex items-center gap-1.5 rounded-lg border border-transparent px-2.5 py-1.5 text-xs font-medium text-blue-600 transition-all duration-200 hover:border-blue-600 hover:bg-blue-600 hover:text-white">
                                <span class="material-symbols-outlined text-[16px]"
                                    style="font-variation-settings: 'wght' 300;">
                                    edit
                                </span>
                                Edit
                            </button>

                            {{-- Hapus --}}
                            <form action="{{ route('library.destroyLiterature', $literature->id) }}"
                                method="POST"
                                class="delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-transparent px-2.5 py-1.5 text-xs font-medium text-red-600 transition-all duration-200 hover:border-red-600 hover:bg-red-600 hover:text-white">
                                    <span class="material-symbols-outlined text-[16px]"
                                        style="font-variation-settings: 'wght' 300;">
                                        delete
                                    </span>
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-16 text-center">
                        <div class="mx-auto flex max-w-sm flex-col items-center gap-3">
                            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                <span class="material-symbols-outlined text-[28px]">menu_book</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700">Belum ada data literatur</p>
                                <p class="mt-1 text-xs text-slate-400">Tambahkan literatur baru untuk mulai mengelola koleksi.</p>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Literatur?',
                text: 'Data yang sudah dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true,
                background: '#ffffff',
                borderRadius: '16px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@include('library.literatures._pagination')