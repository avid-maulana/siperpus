@extends('layouts.app')

@section('title', 'Daftar Literatur')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6 text-indigo-700">Manajemen Literatur</h2>

    {{-- Flash Message --}}
    @if (session('success'))
    <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded shadow mb-4">
        {{ session('success') }}
    </div>
    @endif

    {{-- Form Tambah --}}
    <div class="bg-white p-6 rounded-lg shadow-md space-y-6 mb-10">
        <h3 class="text-xl font-semibold text-gray-700">Tambah Literatur</h3>
        <form action="{{ route('library.storeLiterature') }}" method="POST" class="grid md:grid-cols-2 gap-4">
            @csrf

            <label class="block">
                <span class="text-sm text-gray-700">Cover (URL Gambar)</span>
                <input type="text" name="cover_url" required class="input-field w-full" placeholder="https://...">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Judul</span>
                <input type="text" name="title" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Penulis</span>
                <input type="text" name="author" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Penerbit</span>
                <input type="text" name="publisher" class="input-field w-full">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Tahun</span>
                <input type="number" name="year" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Link Literatur</span>
                <input type="url" name="file_url" required class="input-field w-full" placeholder="https://...">
            </label>

            <label class="block md:col-span-2">
                <span class="text-sm text-gray-700">Detail</span>
                <textarea name="detail" required class="input-field w-full" rows="3" placeholder="Isi detail tentang literatur"></textarea>
            </label>

            <label class="block md:col-span-2">
                <span class="text-sm text-gray-700">Deskripsi</span>
                <textarea name="description" required class="input-field w-full" rows="3" placeholder="Deskripsi singkat literatur"></textarea>
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Kategori</span>
                <select name="category_id" required class="input-field w-full">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>

            <div class="md:col-span-2 flex justify-end">
                <button type="submit" class="btn-primary">Tambah</button>
            </div>
        </form>
    </div>


    {{-- Tabel --}}
    <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
        <h3 class="text-xl font-semibold text-gray-700">Daftar Literatur</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">Cover</th>
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Penulis</th>
                        <th class="px-4 py-3">Penerbit</th>
                        <th class="px-4 py-3">Tahun</th>
                        <th class="px-4 py-3">Link</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($literatures as $literature)
                    <tr>
                        <td class="px-4 py-3">
                            <img src="{{ $literature->cover_url }}" alt="Cover" class="w-20 h-20 object-cover rounded">
                        </td>
                        <td class="px-4 py-3">{{ $literature->title }}</td>
                        <td class="px-4 py-3">{{ $literature->author }}</td>
                        <td class="px-4 py-3">{{ $literature->publisher ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $literature->year }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ $literature->file_url }}" target="_blank" class="text-indigo-600 hover:underline">Lihat</a>
                        </td>
                        <td class="px-4 py-3">{{ $literature->category->name }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                <button onclick="showEditModal(this)"
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
                                    class="px-3 py-1 bg-sky-600 text-white rounded hover:bg-sky-700">Edit</button>
                                <form action="{{ route('library.destroyLiterature', $literature->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus literatur ini?')" class="contents">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6 flex items-center justify-between text-sm text-gray-700">
            @if ($literatures->onFirstPage())
            <span class="opacity-50">← Previous</span>
            @else
            <a href="{{ $literatures->previousPageUrl() }}" class="text-indigo-600 hover:underline">← Previous</a>
            @endif

            <span>Halaman {{ $literatures->currentPage() }} dari {{ $literatures->lastPage() }}</span>

            @if ($literatures->hasMorePages())
            <a href="{{ $literatures->nextPageUrl() }}" class="text-indigo-600 hover:underline">Next →</a>
            @else
            <span class="opacity-50">Next →</span>
            @endif
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Literatur</h3>
        <form id="editForm" method="POST" data-action-template="{{ url('/library/literature') }}/__ID__" class="space-y-4">
            @csrf @method('PUT')

            <label class="block">
                <span class="text-sm text-gray-700">Cover URL</span>
                <input type="text" name="cover_url" placeholder="Link Cover" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Judul</span>
                <input type="text" name="title" placeholder="Judul" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Penulis</span>
                <input type="text" name="author" placeholder="Penulis" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Penerbit</span>
                <input type="text" name="publisher" placeholder="Penerbit" class="input-field w-full">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Tahun</span>
                <input type="number" name="year" placeholder="Tahun" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Link Literatur</span>
                <input type="url" name="file_url" placeholder="Link" required class="input-field w-full">
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Detail</span>
                <textarea name="detail" placeholder="Detail" required class="input-field w-full"></textarea>
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Deskripsi</span>
                <textarea name="description" placeholder="Deskripsi" required class="input-field w-full"></textarea>
            </label>

            <label class="block">
                <span class="text-sm text-gray-700">Kategori</span>
                <select name="category_id" required class="input-field w-full">
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </label>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="hideEditModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>

    </div>
</div>


<script>
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
    }

    function hideEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>

{{-- Utility Styles --}}
<style>
    .input-field {
        @apply border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:ring focus:ring-indigo-200;
    }

    .btn-primary {
        @apply px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition;
    }
</style>
@endsection
