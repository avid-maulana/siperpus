@extends('layouts.app')

@section('title', 'Manajemen Literatur')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800">

    {{-- Hero --}}
    <section class="relative -mt-20 overflow-hidden">
        <img
            src="{{ asset('gambar/rak 1.png') }}"
            alt="Universitas Negeri Malang"
            class="absolute inset-0 h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-slate-900/85 to-slate-800/70"></div>

        <div class="relative mx-auto flex min-h-[380px] max-w-7xl items-center px-4 py-20 sm:px-6 lg:px-8">
            <div class="max-w-2xl">
                <h1 class="text-4xl font-bold leading-tight text-white sm:text-5xl">
                    Kelola Tipe & Kategori Literatur
                </h1>
                <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-300 sm:text-lg">
                    Atur jenis dan kategori literatur agar koleksi tetap terstruktur, mudah dicari, dan siap digunakan.
                </p>
            </div>
        </div>
    </section>

    <div class="relative z-20 mx-auto -mt-12 max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-200/80 bg-white p-5 shadow-xl shadow-slate-200/50 ring-1 ring-slate-100 sm:p-8">

            {{-- Flash Message --}}
            @if (session('success'))
            <div class="mb-8 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm text-emerald-800">
                <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <div class="space-y-10">

                {{-- ===================== TIPE LITERATUR ===================== --}}
                <section>
                    <div class="mb-6 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">Tipe Literatur</h2>
                            <p class="mt-1 text-sm text-slate-500">Jenis utama literatur yang tersedia di sistem.</p>
                        </div>
                    </div>

                    {{-- Form Tambah Tipe --}}
                    <form action="{{ route('library.storeType') }}" method="POST"
                        class="mb-6 flex flex-col gap-3 rounded-2xl border border-slate-200 bg-slate-50/80 p-4 sm:flex-row sm:items-center">
                        @csrf
                        <div class="flex-1">
                            <label class="sr-only">Nama Tipe</label>
                            <input type="text" name="name" placeholder="Contoh: Buku, Jurnal, Skripsi..." required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                        </div>
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Tipe
                        </button>
                    </form>

                    {{-- Daftar Tipe --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        <div class="border-b border-slate-200 bg-slate-50/80 px-5 py-3.5">
                            <h3 class="text-sm font-semibold text-slate-700">Daftar Tipe</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        <th class="px-5 py-3.5 w-20">ID</th>
                                        <th class="px-5 py-3.5">Nama</th>
                                        <th class="px-5 py-3.5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($types as $type)
                                    <tr class="group transition hover:bg-slate-50/70">
                                        <td class="px-5 py-4 text-slate-500">{{ $type->id }}</td>
                                        <td class="px-5 py-4 font-medium text-slate-800">{{ $type->name }}</td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-end gap-2">
                                                {{-- Inline Update --}}
                                                <form action="{{ route('library.updateType', $type->id) }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" name="name" value="{{ $type->name }}"
                                                        class="w-36 rounded-lg border border-slate-300 px-3 py-1.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:w-44">
                                                    {{-- Simpan --}}
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-blue-600 transition-all duration-200 hover:border-blue-600 hover:bg-blue-600 hover:text-white">
                                                        <span class="material-symbols-outlined text-[16px]"
                                                            style="font-variation-settings: 'wght' 400;">
                                                            check
                                                        </span>
                                                        Simpan
                                                    </button>
                                                </form>

                                                {{-- Delete --}}
                                                <form action="{{ route('library.destroyType', $type->id) }}"
                                                    method="POST"
                                                    class="delete-form"
                                                    data-item-name="tipe literatur ini">
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- Hapus --}}
                                                    <button type="submit"
        class="inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-red-600 transition-all duration-200 hover:border-red-600 hover:bg-red-600 hover:text-white">
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
                                        <td colspan="3" class="px-5 py-12 text-center">
                                            <div class="mx-auto flex max-w-xs flex-col items-center gap-2">
                                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-medium text-slate-600">Belum ada tipe literatur</p>
                                                <p class="text-xs text-slate-400">Tambahkan tipe pertama di form di atas.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{-- Divider --}}
                <div class="border-t border-slate-200"></div>

                {{-- ===================== KATEGORI LITERATUR ===================== --}}
                <section>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-slate-900">Kategori Literatur</h2>
                        <p class="mt-1 text-sm text-slate-500">Hubungkan kategori dengan tipe yang sesuai.</p>
                    </div>

                    {{-- Form Tambah Kategori --}}
                    <form action="{{ route('library.storeCategory') }}" method="POST"
                        class="mb-6 grid gap-3 rounded-2xl border border-slate-200 bg-slate-50/80 p-4 sm:grid-cols-3">
                        @csrf
                        <div>
                            <label class="sr-only">Nama Kategori</label>
                            <input type="text" name="name" placeholder="Nama kategori..." required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                        </div>
                        <div>
                            <label class="sr-only">Tipe</label>
                            <select name="type_id" required
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                <option value="">Pilih Tipe</option>
                                @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Kategori
                        </button>
                    </form>

                    {{-- Daftar Kategori --}}
                    <div class="overflow-hidden rounded-2xl border border-slate-200">
                        <div class="border-b border-slate-200 bg-slate-50/80 px-5 py-3.5">
                            <h3 class="text-sm font-semibold text-slate-700">Daftar Kategori</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        <th class="px-5 py-3.5">ID & Nama</th>
                                        <th class="px-5 py-3.5">Tipe</th>
                                        <th class="px-5 py-3.5 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($categories as $category)
                                    <tr class="group transition hover:bg-slate-50/70">
                                        <td class="px-5 py-4">
                                            <div class="font-medium text-slate-800">
                                                <span class="mr-1.5 text-slate-400">#{{ $category->id }}</span>
                                                {{ $category->name }}
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">
                                                {{ $category->type->name }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex flex-wrap items-center justify-end gap-2">
                                                {{-- Inline Update --}}
                                                <form action="{{ route('library.updateCategory', $category->id) }}" method="POST"
                                                    class="flex flex-wrap items-center gap-2">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" name="name" value="{{ $category->name }}"
                                                        class="w-32 rounded-lg border border-slate-300 px-3 py-1.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 sm:w-40">
                                                    <select name="type_id"
                                                        class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                        @foreach ($types as $type)
                                                        <option value="{{ $type->id }}" @selected($type->id == $category->type_id)>
                                                            {{ $type->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    {{-- Simpan --}}
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-blue-600 transition-all duration-200 hover:border-blue-600 hover:bg-blue-600 hover:text-white">
                                                        <span class="material-symbols-outlined text-[16px]"
                                                            style="font-variation-settings: 'wght' 400;">
                                                            check
                                                        </span>
                                                        Simpan
                                                    </button>
                                                </form>

                                                {{-- Delete --}}
                                                <form action="{{ route('library.destroyCategory', $category->id) }}"
                                                    method="POST"
                                                    class="delete-form"
                                                    data-item-name="kategori ini">
                                                    @csrf
                                                    @method('DELETE')
                                                    {{-- Hapus --}}
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 rounded-lg border border-transparent px-3 py-1.5 text-xs font-medium text-red-600 transition-all duration-200 hover:border-red-600 hover:bg-red-600 hover:text-white">
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
                                        <td colspan="3" class="px-5 py-12 text-center">
                                            <div class="mx-auto flex max-w-xs flex-col items-center gap-2">
                                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                                    </svg>
                                                </div>
                                                <p class="text-sm font-medium text-slate-600">Belum ada kategori</p>
                                                <p class="text-xs text-slate-400">Tambahkan kategori pertama di form di atas.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        function loadSweetAlert(callback) {
            if (window.Swal) {
                callback();
                return;
            }
            var script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
            script.onload = callback;
            document.head.appendChild(script);
        }

        function initDeleteConfirm() {
            document.querySelectorAll('.delete-form').forEach(function(form) {
                if (form.dataset.confirmBound) return;
                form.dataset.confirmBound = 'true';

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var itemName = form.dataset.itemName || 'data ini';

                    loadSweetAlert(function() {
                        Swal.fire({
                            title: 'Hapus ' + itemName + '?',
                            text: 'Data yang sudah dihapus tidak dapat dikembalikan.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc2626',
                            cancelButtonColor: '#64748b',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal',
                            reverseButtons: true,
                            focusCancel: true,
                            background: '#ffffff',
                            borderRadius: '16px'
                        }).then(function(result) {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            });
        }

        initDeleteConfirm();
        window.initDeleteConfirm = initDeleteConfirm;
    })();
</script>
@endsection