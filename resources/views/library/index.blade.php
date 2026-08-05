@extends('layouts.app')

@section('title', 'Manajemen Literatur')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-800">
    <section class="relative -mt-20 overflow-hidden">
        <img
            src="{{ asset('gambar/rak 1.png') }}"
            alt="Universitas Negeri Malang"
            class="absolute inset-0 h-full w-full object-cover">

        <div class="absolute inset-0 bg-gradient-to-r from-[#212A37]/95 via-[#212A37]/80 to-[#212A37]/60"></div>

        <div class="relative mx-auto flex min-h-[420px] max-w-7xl items-center px-4 py-24 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="mb-3 text-sm font-semibold uppercase tracking-[0.35em] text-slate-300">Panel Admin</p>
                <h1 class="text-4xl font-bold leading-tight text-white sm:text-5xl lg:text-6xl">
                    Kelola Koleksi Literatur
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-300 sm:text-lg">
                    Tambah, perbarui, dan atur literatur agar koleksi tetap rapi, informatif, dan mudah ditemukan.
                </p>
            </div>
        </div>
    </section>

    <div class="relative z-20 mx-auto -mt-14 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-[28px] border border-slate-200/80 bg-gradient-to-br from-white via-slate-50 to-[#f8fafc] p-6 shadow-[0_25px_80px_-25px_rgba(15,23,42,0.35)] ring-1 ring-slate-100 sm:p-8">
            <div class="space-y-12 w-full">
        {{-- Flash Message --}}
        @if (session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- SECTION: Tipe Literatur --}}
    <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
        <h3 class="text-xl font-semibold text-gray-700">Tambah Tipe Literatur</h3>
        <form action="{{ route('library.storeType') }}" method="POST" class="flex flex-col md:flex-row gap-4">
            @csrf
            <input type="text" name="name" placeholder="Nama Tipe Literatur" required
                class="flex-1 border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Tambah</button>
        </form>

        <h3 class="text-xl font-semibold text-gray-700 mt-8">Daftar Tipe Literatur</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($types as $type)
                    <tr>
                        <td class="px-4 py-3">{{ $type->id }}</td>
                        <td class="px-4 py-3">{{ $type->name }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('library.updateType', $type->id) }}" method="POST" class="flex gap-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" value="{{ $type->name }}"
                                        class="w-32 border border-gray-300 rounded-md px-2 py-1 text-sm focus:ring focus:ring-indigo-200">
                                    <button type="submit"
                                        class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Update</button>
                                </form>
                                <form action="{{ route('library.destroyType', $type->id) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- SECTION: Kategori Literatur --}}
    <div class="bg-white p-6 rounded-lg shadow-md space-y-6">
        <h3 class="text-xl font-semibold text-gray-700">Tambah Kategori Literatur</h3>
        <form action="{{ route('library.storeCategory') }}" method="POST" class="grid md:grid-cols-3 gap-4">
            @csrf
            <input type="text" name="name" placeholder="Nama Kategori" required
                class="border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
            <select name="type_id" required
                class="border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                <option value="">Pilih Tipe</option>
                @foreach ($types as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Tambah</button>
        </form>

        <h3 class="text-xl font-semibold text-gray-700 mt-8">Daftar Kategori Literatur</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">ID & Nama</th>
                        <th class="px-4 py-3 text-left">Tipe</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($categories as $category)
                    <tr>
                        <td class="px-4 py-3">{{ $category->id }}: {{ $category->name }}</td>
                        <td class="px-4 py-3">{{ $category->type->name }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <form action="{{ route('library.updateCategory', $category->id) }}" method="POST" class="flex gap-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" value="{{ $category->name }}"
                                        class="w-32 border border-gray-300 rounded-md px-2 py-1 focus:ring focus:ring-indigo-200">
                                    <select name="type_id"
                                        class="border border-gray-300 rounded-md px-2 py-1 focus:ring focus:ring-indigo-200">
                                        @foreach ($types as $type)
                                        <option value="{{ $type->id }}" @selected($type->id == $category->type_id)>
                                            {{ $type->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Update</button>
                                </form>
                                <form action="{{ route('library.destroyCategory', $category->id) }}" method="POST" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center text-sm text-slate-500">
                            Belum ada data literatur.
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
            confirmButtonText: '<i class="fa fa-trash"></i> Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true,
            background: '#ffffff',
            borderRadius: '18px'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@endsection