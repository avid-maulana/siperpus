<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-gray-600/60 p-4">
    <div class="w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-[24px] border border-slate-200 bg-white p-6 shadow-xl">
        <h3 class="text-lg font-semibold text-slate-900">Edit Literatur</h3>
        <form id="editForm" method="POST" data-action-template="{{ url('/library/literature') }}/__ID__" class="mt-4 grid gap-4 sm:grid-cols-2">
            @csrf @method('PUT')

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-700">Cover URL</span>
                <input type="text" name="cover_url" placeholder="Link Cover" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-700">Judul</span>
                <input type="text" name="title" placeholder="Judul" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-700">Penulis</span>
                <input type="text" name="author" placeholder="Penulis" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-700">Penerbit</span>
                <input type="text" name="publisher" placeholder="Penerbit" class="input-field w-full">
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-700">Tahun</span>
                <input type="number" name="year" placeholder="Tahun" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-700">Link Literatur</span>
                <input type="url" name="file_url" placeholder="Link" required class="input-field w-full">
            </label>

            <label class="block sm:col-span-2">
                <span class="mb-2 block text-sm font-medium text-slate-700">Detail</span>
                <textarea name="detail" placeholder="Detail" required class="input-field w-full"></textarea>
            </label>

            <label class="block sm:col-span-2">
                <span class="mb-2 block text-sm font-medium text-slate-700">Deskripsi</span>
                <textarea name="description" placeholder="Deskripsi" required class="input-field w-full"></textarea>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-medium text-slate-700">Kategori</span>
                <select name="category_id" required class="input-field w-full">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>

            <div class="flex justify-end gap-2 sm:col-span-2">
                <button type="button" onclick="hideEditModal()" class="rounded bg-slate-200 px-4 py-2 text-sm font-medium text-slate-800 transition hover:bg-slate-300">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.body.appendChild(document.getElementById('editModal'));

    function showEditModal(button) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        const actionTemplate = form.dataset.actionTemplate;
        form.action = actionTemplate.replace('__ID__', button.dataset.id);

        form.elements['cover_url'].value = button.dataset.cover_url;
        form.elements['title'].value = button.dataset.title;
        form.elements['author'].value = button.dataset.author;
        form.elements['publisher'].value = button.dataset.publisher || '';
        form.elements['year'].value = button.dataset.year;
        form.elements['file_url'].value = button.dataset.file_url;
        form.elements['category_id'].value = button.dataset.category_id;
        form.elements['detail'].value = button.dataset.detail || '';
        form.elements['description'].value = button.dataset.description || '';

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideEditModal() {
        const modal = document.getElementById('editModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>