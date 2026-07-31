@extends('layouts.app')

@section('title', 'Manajemen Literatur')

@section('content')
<div class="container mx-auto px-4 py-10 space-y-12">
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
                                        class="px-3 py-1 bg-sky-600 text-white rounded hover:bg-sky-700 transition">Update</button>
                                </form>
                                <form action="{{ route('library.destroyType', $type->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus tipe ini?')">
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
                    @foreach ($categories as $category)
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
                                        class="px-3 py-1 bg-sky-600 text-white rounded hover:bg-sky-700 transition">Update</button>
                                </form>
                                <form action="{{ route('library.destroyCategory', $category->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
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

@endsection