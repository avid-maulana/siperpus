{{-- Form Tambah Literatur --}}
<div id="add-literature-form" class="space-y-6 rounded-[20px] bg-transparent p-0">

    <h3 class="text-xl font-semibold text-gray-700">
        Tambah Literatur
    </h3>

    <form
        action="{{ route('library.storeLiterature') }}"
        method="POST"
        class="grid gap-4 md:grid-cols-2">
        @csrf

        {{-- Cover --}}
        <label class="block">
            <span class="text-sm text-gray-700">
                Cover (URL Gambar)
            </span>

            <input
                type="text"
                name="cover_url"
                value="{{ old('cover_url') }}"
                required
                placeholder="https://..."
                class="input-field w-full">
        </label>

        {{-- Judul --}}
        <label class="block">
            <span class="text-sm text-gray-700">
                Judul
            </span>

            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                required
                class="input-field w-full">
        </label>

        {{-- Penulis --}}
        <label class="block">
            <span class="text-sm text-gray-700">
                Penulis
            </span>

            <input
                type="text"
                name="author"
                value="{{ old('author') }}"
                required
                class="input-field w-full">
        </label>

        {{-- Penerbit --}}
        <label class="block">
            <span class="text-sm text-gray-700">
                Penerbit
            </span>

            <input
                type="text"
                name="publisher"
                value="{{ old('publisher') }}"
                class="input-field w-full">
        </label>

        {{-- Tahun --}}
        <label class="block">
            <span class="text-sm text-gray-700">
                Tahun
            </span>

            <input
                type="number"
                name="year"
                value="{{ old('year') }}"
                required
                class="input-field w-full">
        </label>

        {{-- Link Literatur --}}
        <label class="block">
            <span class="text-sm text-gray-700">
                Link Literatur
            </span>

            <input
                type="url"
                name="file_url"
                value="{{ old('file_url') }}"
                required
                placeholder="https://..."
                class="input-field w-full">
        </label>

        {{-- Detail --}}
        <label class="block md:col-span-2">
            <span class="text-sm text-gray-700">
                Detail
            </span>

            <textarea
                name="detail"
                rows="3"
                required
                placeholder="Isi detail tentang literatur"
                class="input-field w-full">{{ old('detail') }}</textarea>
        </label>

        {{-- Deskripsi --}}
        <label class="block md:col-span-2">
            <span class="text-sm text-gray-700">
                Deskripsi
            </span>

            <textarea
                name="description"
                rows="3"
                required
                placeholder="Deskripsi singkat literatur"
                class="input-field w-full">{{ old('description') }}</textarea>
        </label>

        {{-- Kategori --}}
        <label class="block">
            <span class="text-sm text-gray-700">
                Kategori
            </span>

            <select
                name="category_id"
                required
                class="input-field w-full">
                <option value="">
                    Pilih Kategori
                </option>

                @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(old('category_id')==$category->id)
                    >
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </label>

        {{-- Submit --}}
        <div class="flex justify-end md:col-span-2">
            <button
                type="submit"
                class="btn-primary">
                Tambah
            </button>
        </div>

    </form>
</div>