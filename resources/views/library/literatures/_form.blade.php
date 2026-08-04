{{-- Form Tambah Literatur --}}
<div class="mx-auto mb-10 max-w-5xl rounded-3xl bg-white shadow-xl ring-1 ring-gray-100">
    <div class="border-b border-gray-100 px-8 py-6">
        <div class="flex items-center gap-4">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h3 class="text-2xl font-bold tracking-tight text-gray-900">
                    Tambah Literatur
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Lengkapi detail literatur baru di bawah ini
                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('library.storeLiterature') }}" method="POST" class="px-8 py-7">
        @csrf

        <div class="grid gap-6 md:grid-cols-2">
            {{-- Cover --}}
            <label class="block">
                <span class="mb-2 block text-sm font-semibold text-gray-700">
                    Cover (URL Gambar) <span class="text-red-500">*</span>
                </span>
                <input
                    type="text"
                    name="cover_url"
                    value="{{ old('cover_url') }}"
                    required
                    placeholder="https://..."
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-800 shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:outline-none">
                @error('cover_url')
                    <span class="mt-2 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </label>

            {{-- Judul --}}
            <label class="block">
                <span class="mb-2 block text-sm font-semibold text-gray-700">
                    Judul <span class="text-red-500">*</span>
                </span>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    required
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-800 shadow-sm transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:outline-none">
                @error('title')
                    <span class="mt-2 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </label>

            {{-- Penulis --}}
            <label class="block">
                <span class="mb-2 block text-sm font-semibold text-gray-700">
                    Penulis <span class="text-red-500">*</span>
                </span>
                <input
                    type="text"
                    name="author"
                    value="{{ old('author') }}"
                    required
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-800 shadow-sm transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:outline-none">
                @error('author')
                    <span class="mt-2 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </label>

            {{-- Penerbit --}}
            <label class="block">
                <span class="mb-2 block text-sm font-semibold text-gray-700">
                    Penerbit
                </span>
                <input
                    type="text"
                    name="publisher"
                    value="{{ old('publisher') }}"
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-800 shadow-sm transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:outline-none">
            </label>

            {{-- Tahun --}}
            <label class="block">
                <span class="mb-2 block text-sm font-semibold text-gray-700">
                    Tahun <span class="text-red-500">*</span>
                </span>
                <input
                    type="number"
                    name="year"
                    value="{{ old('year') }}"
                    required
                    min="1900"
                    max="{{ date('Y') }}"
                    placeholder="Contoh: 2023"
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-800 shadow-sm transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:outline-none">
                @error('year')
                    <span class="mt-2 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </label>

            {{-- Link Literatur --}}
            <label class="block">
                <span class="mb-2 block text-sm font-semibold text-gray-700">
                    Link Literatur <span class="text-red-500">*</span>
                </span>
                <input
                    type="url"
                    name="file_url"
                    value="{{ old('file_url') }}"
                    required
                    placeholder="https://..."
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-800 shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:outline-none">
                @error('file_url')
                    <span class="mt-2 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </label>

            {{-- Kategori --}}
            <label class="block">
                <span class="mb-2 block text-sm font-semibold text-gray-700">
                    Kategori <span class="text-red-500">*</span>
                </span>
                <select
                    name="category_id"
                    required
                    class="w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-800 shadow-sm transition focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:outline-none">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="mt-2 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </label>

            {{-- Detail --}}
            <label class="block md:col-span-2">
                <span class="mb-2 block text-sm font-semibold text-gray-700">
                    Detail <span class="text-red-500">*</span>
                </span>
                <textarea
                    name="detail"
                    rows="4"
                    required
                    placeholder="Isi detail tentang literatur"
                    class="w-full resize-none rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-800 shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:outline-none">{{ old('detail') }}</textarea>
                @error('detail')
                    <span class="mt-2 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </label>

            {{-- Deskripsi --}}
            <label class="block md:col-span-2">
                <span class="mb-2 block text-sm font-semibold text-gray-700">
                    Deskripsi <span class="text-red-500">*</span>
                </span>
                <textarea
                    name="description"
                    rows="4"
                    required
                    placeholder="Deskripsi singkat literatur"
                    class="w-full resize-none rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-800 shadow-sm transition placeholder:text-gray-400 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:outline-none">{{ old('description') }}</textarea>
                @error('description')
                    <span class="mt-2 block text-xs font-medium text-red-500">{{ $message }}</span>
                @enderror
            </label>
        </div>

        {{-- Submit --}}
        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
            <button
                type="reset"
                class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-medium text-gray-600 transition hover:bg-gray-50 hover:text-gray-800">
                Batal
            </button>
            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-indigo-700 hover:shadow-lg active:scale-[0.98]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Literatur
            </button>
        </div>
    </form>
</div>