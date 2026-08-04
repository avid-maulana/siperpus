{{-- Modal Edit Literatur --}}
<div
    id="editModal"
    class="fixed inset-0 z-50 hidden flex items-start sm:items-center justify-center bg-slate-950/60 p-4 sm:pt-0 pt-6 opacity-0 backdrop-blur-md transition-opacity duration-300"
    role="dialog"
    aria-modal="true"
    aria-labelledby="editModalTitle"
    onclick="hideEditModal(event)"
>
    {{-- Modal Content --}}
    <div
        class="modal-content mx-auto flex max-h-[90vh] w-full max-w-3xl scale-95 transform flex-col overflow-hidden rounded-3xl bg-white shadow-[0_20px_80px_rgba(15,23,42,0.25)] ring-1 ring-slate-200 transition-all duration-300"
        onclick="event.stopPropagation()"
    >
        {{-- Header --}}
        <div class="flex items-start justify-between border-b border-slate-200 px-6 py-5 sm:px-8">
            <div>
                <h3 id="editModalTitle" class="text-xl font-bold tracking-tight text-slate-900">
                    Edit Literatur
                </h3>
                <p class="mt-1 text-sm text-slate-500">
                    Perbarui informasi literatur yang dipilih.
                </p>
            </div>

            <button
                type="button"
                onclick="hideEditModal()"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                aria-label="Tutup modal"
            >
                <svg
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18 18 6M6 6l12 12"
                    />
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form
            id="editForm"
            method="POST"
            data-action-template="{{ url('/library/literature') }}/__ID__"
            class="flex min-h-0 flex-1 flex-col"
        >
            @csrf
            @method('PUT')

            {{-- Scrollable Content --}}
            <div class="min-h-0 flex-1 overflow-y-auto overscroll-contain px-6 py-6 sm:px-8">
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="edit_cover_url" class="mb-2 block text-sm font-semibold text-slate-700">
                            Cover URL
                        </label>
                        <input
                            id="edit_cover_url"
                            type="url"
                            name="cover_url"
                            required
                            placeholder="https://example.com/cover.jpg"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label for="edit_title" class="mb-2 block text-sm font-semibold text-slate-700">
                            Judul
                        </label>
                        <input
                            id="edit_title"
                            type="text"
                            name="title"
                            required
                            placeholder="Masukkan judul literatur"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                        >
                    </div>

                    <div>
                        <label for="edit_author" class="mb-2 block text-sm font-semibold text-slate-700">
                            Penulis
                        </label>
                        <input
                            id="edit_author"
                            type="text"
                            name="author"
                            required
                            placeholder="Nama penulis"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                        >
                    </div>

                    <div>
                        <label for="edit_publisher" class="mb-2 block text-sm font-semibold text-slate-700">
                            Penerbit
                        </label>
                        <input
                            id="edit_publisher"
                            type="text"
                            name="publisher"
                            placeholder="Nama penerbit"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                        >
                    </div>

                    <div>
                        <label for="edit_year" class="mb-2 block text-sm font-semibold text-slate-700">
                            Tahun
                        </label>
                        <input
                            id="edit_year"
                            type="number"
                            name="year"
                            required
                            placeholder="2026"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                        >
                    </div>

                    <div>
                        <label for="edit_category_id" class="mb-2 block text-sm font-semibold text-slate-700">
                            Kategori
                        </label>
                        <select
                            id="edit_category_id"
                            name="category_id"
                            required
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                        >
                            <option value="">
                                Pilih kategori
                            </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="edit_file_url" class="mb-2 block text-sm font-semibold text-slate-700">
                            Link Literatur
                        </label>
                        <input
                            id="edit_file_url"
                            type="url"
                            name="file_url"
                            required
                            placeholder="https://example.com/literatur"
                            class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label for="edit_detail" class="mb-2 block text-sm font-semibold text-slate-700">
                            Detail
                        </label>
                        <textarea
                            id="edit_detail"
                            name="detail"
                            rows="3"
                            required
                            placeholder="Masukkan detail literatur"
                            class="w-full resize-none rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                        ></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label for="edit_description" class="mb-2 block text-sm font-semibold text-slate-700">
                            Deskripsi
                        </label>
                        <textarea
                            id="edit_description"
                            name="description"
                            rows="4"
                            required
                            placeholder="Masukkan deskripsi singkat literatur"
                            class="w-full resize-none rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10"
                        ></textarea>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex shrink-0 items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:px-8">
                <button
                    type="button"
                    onclick="hideEditModal()"
                    class="inline-flex h-11 items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 active:scale-[0.98]"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="inline-flex h-11 items-center justify-center rounded-2xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-blue-500/20"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    function showEditModal() {
        const modal = document.getElementById('editModal');
        const content = modal.querySelector('.modal-content');

        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        });
    }

    function hideEditModal(event) {
        if (event) event.stopPropagation();

        const modal = document.getElementById('editModal');
        const content = modal.querySelector('.modal-content');

        modal.classList.remove('opacity-100');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>