{{-- Modal Edit Literatur --}}
<div
    id="editModal"
    class="fixed inset-0 z-50 hidden items-start sm:items-center justify-center bg-slate-950/60 p-4 sm:pt-0 pt-6 opacity-0 backdrop-blur-md transition-opacity duration-300"
    role="dialog"
    aria-modal="true"
    aria-labelledby="editModalTitle"
    onclick="hideEditModal(event)">
    {{-- Modal Content --}}
    <div
        class="modal-content mx-auto flex max-h-[90vh] w-full max-w-2xl scale-95 transform flex-col overflow-hidden rounded-3xl bg-white shadow-[0_20px_80px_rgba(15,23,42,0.25)] ring-1 ring-slate-200 transition-all duration-300"
        onclick="event.stopPropagation()">
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
                aria-label="Tutup modal">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form
            id="editForm"
            method="POST"
            data-action-template="{{ url('/library/literature') }}/__ID__"
            class="flex min-h-0 flex-1 flex-col">
            @csrf
            @method('PUT')

            {{-- Scrollable Content --}}
            <div id="editModalBody" class="min-h-0 flex-1 overflow-y-auto overscroll-contain px-6 py-6 sm:px-8">
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <label class="block sm:col-span-2">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Cover URL</span>
                        <input type="url" name="cover_url" required placeholder="https://example.com/cover.jpg" class="input-field w-full">
                    </label>

                    <label class="block sm:col-span-2">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Judul</span>
                        <input type="text" name="title" required placeholder="Masukkan judul literatur" class="input-field w-full">
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Penulis</span>
                        <input type="text" name="author" required placeholder="Nama penulis" class="input-field w-full">
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Penerbit</span>
                        <input type="text" name="publisher" placeholder="Nama penerbit" class="input-field w-full">
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Tahun</span>
                        <input type="number" name="year" required placeholder="2026" class="input-field w-full">
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Kategori</span>
                        <select name="category_id" required class="input-field w-full">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block sm:col-span-2">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Link Literatur</span>
                        <input type="url" name="file_url" required placeholder="https://example.com/literatur" class="input-field w-full">
                    </label>

                    <label class="block sm:col-span-2">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Detail</span>
                        <textarea name="detail" rows="3" required placeholder="Masukkan detail literatur" class="input-field w-full resize-none"></textarea>
                    </label>

                    <label class="block sm:col-span-2">
                        <span class="mb-2 block text-sm font-semibold text-slate-700">Deskripsi</span>
                        <textarea name="description" rows="4" required placeholder="Masukkan deskripsi singkat literatur" class="input-field w-full resize-none"></textarea>
                    </label>
                </div>
            </div>

            {{-- Footer --}}
            <div class="flex shrink-0 items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4 sm:px-8">
                <button
                    type="button"
                    onclick="hideEditModal()"
                    class="inline-flex h-11 items-center justify-center rounded-2xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 active:scale-[0.98]">
                    Batal
                </button>
                <button
                    type="submit"
                    class="inline-flex h-11 items-center justify-center rounded-2xl bg-blue-600 px-5 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-blue-500/20">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Samakan style input dengan komponen lain di halaman ini.
       Kalau kamu sudah punya utility class sendiri, hapus block ini
       dan pakai class Tailwind langsung seperti pada versi pertama. */
    .input-field {
        border-radius: 1rem;
        border: 1px solid rgb(203 213 225);
        background-color: rgb(248 250 252);
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: rgb(15 23 42);
        outline: none;
        transition: all 0.2s;
    }

    .input-field::placeholder {
        color: rgb(148 163 184);
    }

    .input-field:focus {
        border-color: rgb(59 130 246);
        background-color: white;
        box-shadow: 0 0 0 4px rgb(59 130 246 / 0.1);
    }
</style>

<script>
    // Pindahkan modal ke akhir <body> supaya `position: fixed` tidak
    // terjebak di dalam ancestor yang punya transform/filter (mis. card
    // dengan hover-tilt), yang bisa bikin modal ikut ke-scroll bareng halaman.
    document.body.appendChild(document.getElementById('editModal'));

    let savedScrollY = 0;

    function lockBodyScroll() {
        savedScrollY = window.scrollY;
        document.body.style.position = 'fixed';
        document.body.style.top = `-${savedScrollY}px`;
        document.body.style.left = '0';
        document.body.style.right = '0';
        // Kompensasi lebar scrollbar biar layout tidak "loncat" ke kanan
        document.body.style.paddingRight = `${window.innerWidth - document.documentElement.clientWidth}px`;
    }

    function unlockBodyScroll() {
        document.body.style.position = '';
        document.body.style.top = '';
        document.body.style.left = '';
        document.body.style.right = '';
        document.body.style.paddingRight = '';
        window.scrollTo(0, savedScrollY);
    }

    // make showEditModal available globally and robust to different data-attribute naming
    window.showEditModal = function (button) {
        const modal = document.getElementById('editModal');
        const content = modal ? modal.querySelector('.modal-content') : null;
        const form = document.getElementById('editForm');
        if (!modal || !form) return;

        const actionTemplate = form.getAttribute('data-action-template') || form.dataset.actionTemplate || '';
        const id = button.getAttribute('data-id') || button.dataset.id || '';
        form.action = actionTemplate.replace('__ID__', id);

        // helper to read attribute names that may use underscores or hyphens
        const get = (attr) => {
            return button.getAttribute('data-' + attr) ?? button.getAttribute('data-' + attr.replace('_', '-')) ?? button.dataset[attr] ?? '';
        };

        form.elements['cover_url'].value = get('cover_url');
        form.elements['title'].value = get('title');
        form.elements['author'].value = get('author');
        form.elements['publisher'].value = get('publisher');
        form.elements['year'].value = get('year');
        form.elements['file_url'].value = get('file_url');
        form.elements['category_id'].value = get('category_id');
        form.elements['detail'].value = get('detail');
        form.elements['description'].value = get('description');

        // Reset scroll internal modal ke atas setiap kali dibuka
        const body = document.getElementById('editModalBody');
        if (body) body.scrollTop = 0;

        lockBodyScroll();

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        requestAnimationFrame(() => {
            modal.classList.add('opacity-100');
            if (content) {
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }
        });
    };

    function hideEditModal(event) {
        if (event) event.stopPropagation();

        const modal = document.getElementById('editModal');
        const content = modal.querySelector('.modal-content');

        modal.classList.remove('opacity-100');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        unlockBodyScroll();

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }
</script>