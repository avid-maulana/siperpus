<div class="min-h-screen bg-slate-50">

    <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <p class="text-sm font-medium text-slate-500">
                SIPERPUS DTEI
            </p>

            <div class="mt-1 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                        Dashboard Admin
                    </h1>

                    <p class="mt-2 text-sm text-slate-500">
                        Selamat datang,
                        <span class="font-medium text-slate-700">
                            {{ ucwords(strtolower(Auth::user()->nama_lengkap)) }}
                        </span>
                    </p>
                </div>

                <p class="text-sm text-slate-400">
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
            </div>
        </div>


        {{-- Statistics --}}
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Literatur --}}
            <div
                class="group rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm
                       transition-all duration-300
                       hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Literatur
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                            {{ number_format($literatureCount) }}
                        </p>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center
                               rounded-xl bg-slate-100 text-slate-700
                               transition-colors duration-300
                               group-hover:bg-slate-900
                               group-hover:text-white">
                        <span class="material-symbols-outlined">
                            library_books
                        </span>
                    </div>

                </div>

                <p class="mt-5 text-xs text-slate-400">
                    Seluruh koleksi literatur
                </p>
            </div>


            {{-- Kategori --}}
            <div
                class="group rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm
                       transition-all duration-300
                       hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Kategori
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                            {{ number_format($categoryCount) }}
                        </p>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center
                               rounded-xl bg-slate-100 text-slate-700
                               transition-colors duration-300
                               group-hover:bg-slate-900
                               group-hover:text-white">
                        <span class="material-symbols-outlined">
                            category
                        </span>
                    </div>

                </div>

                <p class="mt-5 text-xs text-slate-400">
                    Kategori literatur tersedia
                </p>
            </div>


            {{-- KBK --}}
            <div
                class="group rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm
                       transition-all duration-300
                       hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total KBK
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                            {{ number_format($kbkCount) }}
                        </p>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center
                               rounded-xl bg-slate-100 text-slate-700
                               transition-colors duration-300
                               group-hover:bg-slate-900
                               group-hover:text-white">
                        <span class="material-symbols-outlined">
                            school
                        </span>
                    </div>

                </div>

                <p class="mt-5 text-xs text-slate-400">
                    Kompetensi Bidang Keahlian
                </p>
            </div>


            {{-- Anggota --}}
            <div
                class="group rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm
                       transition-all duration-300
                       hover:-translate-y-1 hover:shadow-lg">
                <div class="flex items-start justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Anggota Terdaftar
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                            {{ number_format($userCount) }}
                        </p>
                    </div>

                    <div
                        class="flex h-11 w-11 items-center justify-center
                               rounded-xl bg-slate-100 text-slate-700
                               transition-colors duration-300
                               group-hover:bg-slate-900
                               group-hover:text-white">
                        <span class="material-symbols-outlined">
                            group
                        </span>
                    </div>

                </div>

                <p class="mt-5 text-xs text-slate-400">
                    Pengguna SIPERPUS
                </p>
            </div>

        </div>


        {{-- Main Content --}}
        <div class="mt-8 grid gap-6 lg:grid-cols-3">

            {{-- Latest Literature --}}
            <div
                class="overflow-hidden rounded-2xl
                       border border-slate-200
                       bg-white shadow-sm
                       lg:col-span-2">

                {{-- Header --}}
                <div
                    class="flex items-center justify-between
                           border-b border-slate-100
                           px-6 py-5">
                    <div>
                        <h2 class="font-semibold text-slate-900">
                            Literatur Terbaru
                        </h2>

                        <p class="mt-1 text-xs text-slate-400">
                            Koleksi literatur yang baru ditambahkan
                        </p>
                    </div>

                    <a
                        href="{{ route('library.indexLiterature') }}"
                        class="text-sm font-medium text-slate-600
                               transition hover:text-slate-950">
                        Lihat Semua
                    </a>
                </div>


                {{-- Literature List --}}
                <div class="divide-y divide-slate-100">

                    @forelse($latestLiteratures as $literature)

                    <div
                        class="flex items-center gap-4 px-6 py-4
                                   transition-colors
                                   hover:bg-slate-50">

                        <div
                            class="flex h-10 w-10 shrink-0
                                       items-center justify-center
                                       rounded-xl bg-slate-100
                                       text-slate-600">
                            <span class="material-symbols-outlined text-[20px]">
                                description
                            </span>
                        </div>


                        <div class="min-w-0 flex-1">

                            <p
                                class="truncate text-sm
                                           font-medium text-slate-800">
                                {{ $literature->title }}
                            </p>

                            <div
                                class="mt-1 flex items-center
                                           gap-2 text-xs text-slate-400">
                                <span>
                                    {{ $literature->author ?? 'Penulis tidak tersedia' }}
                                </span>

                                <span>•</span>

                                <span>
                                    {{ $literature->category->name ?? 'Tanpa kategori' }}
                                </span>
                            </div>

                        </div>


                        <div class="hidden shrink-0 sm:block">
                            <span
                                class="text-xs text-slate-400">
                                {{ optional($literature->created_at)->diffForHumans() }}
                            </span>
                        </div>

                    </div>

                    @empty

                    <div class="px-6 py-12 text-center">

                        <span
                            class="material-symbols-outlined
                                       text-4xl text-slate-300">
                            library_books
                        </span>

                        <p class="mt-2 text-sm text-slate-400">
                            Belum ada literatur.
                        </p>

                    </div>

                    @endforelse

                </div>

            </div>


            {{-- System Summary --}}
            <div
                class="rounded-2xl
                       border border-slate-200
                       bg-white p-6 shadow-sm">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Ringkasan Koleksi
                    </h2>

                    <p class="mt-1 text-xs text-slate-400">
                        Informasi data SIPERPUS
                    </p>
                </div>


                <div class="mt-6 space-y-5">

                    {{-- Literatur --}}
                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 items-center
                                       justify-center rounded-lg
                                       bg-slate-100 text-slate-600">
                                <span class="material-symbols-outlined text-[19px]">
                                    library_books
                                </span>
                            </div>

                            <span class="text-sm text-slate-600">
                                Literatur
                            </span>
                        </div>

                        <span class="text-sm font-semibold text-slate-900">
                            {{ number_format($literatureCount) }}
                        </span>

                    </div>


                    {{-- Tipe --}}
                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 items-center
                                       justify-center rounded-lg
                                       bg-slate-100 text-slate-600">
                                <span class="material-symbols-outlined text-[19px]">
                                    sell
                                </span>
                            </div>

                            <span class="text-sm text-slate-600">
                                Tipe Literatur
                            </span>
                        </div>

                        <span class="text-sm font-semibold text-slate-900">
                            {{ number_format($typeCount) }}
                        </span>

                    </div>


                    {{-- Kategori --}}
                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 items-center
                                       justify-center rounded-lg
                                       bg-slate-100 text-slate-600">
                                <span class="material-symbols-outlined text-[19px]">
                                    category
                                </span>
                            </div>

                            <span class="text-sm text-slate-600">
                                Kategori
                            </span>
                        </div>

                        <span class="text-sm font-semibold text-slate-900">
                            {{ number_format($categoryCount) }}
                        </span>

                    </div>


                    {{-- KBK --}}
                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 items-center
                                       justify-center rounded-lg
                                       bg-slate-100 text-slate-600">
                                <span class="material-symbols-outlined text-[19px]">
                                    school
                                </span>
                            </div>

                            <span class="text-sm text-slate-600">
                                KBK
                            </span>
                        </div>

                        <span class="text-sm font-semibold text-slate-900">
                            {{ number_format($kbkCount) }}
                        </span>

                    </div>


                    {{-- Anggota --}}
                    <div class="flex items-center justify-between">

                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-9 w-9 items-center
                                       justify-center rounded-lg
                                       bg-slate-100 text-slate-600">
                                <span class="material-symbols-outlined text-[19px]">
                                    group
                                </span>
                            </div>

                            <span class="text-sm text-slate-600">
                                Anggota
                            </span>
                        </div>

                        <span class="text-sm font-semibold text-slate-900">
                            {{ number_format($userCount) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>