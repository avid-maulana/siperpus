@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="mx-auto min-h-[calc(100vh-5rem)] max-w-3xl px-6 py-10 lg:px-8">
    <div class="rounded-[28px] bg-white p-8 shadow-xl shadow-slate-900/5">
        <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Profil</h1>
                <p class="mt-2 text-sm text-slate-500">Ubah password akun Anda di sini.</p>
            </div>
            <div class="rounded-3xl bg-slate-50 px-4 py-3 text-sm text-slate-600">
                {{ Auth::user()->nama_lengkap ?? Auth::user()->username }}
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <label for="username" class="text-sm font-medium text-slate-700">Username</label>
                    <input id="username" type="text" value="{{ Auth::user()->username }}" disabled class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700 outline-none" />
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-sm font-medium text-slate-700">Email</label>
                    <input id="email" type="text" value="{{ Auth::user()->email ?? '-' }}" disabled class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700 outline-none" />
                </div>
            </div>

            <div class="space-y-2">
                <label for="current_password" class="text-sm font-medium text-slate-700">Password Lama</label>
                <input id="current_password" name="current_password" type="password" required class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200" />
                @error('current_password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="space-y-2">
                    <label for="password" class="text-sm font-medium text-slate-700">Password Baru</label>
                    <input id="password" name="password" type="password" required class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200" />
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-medium text-slate-700">Konfirmasi Password Baru</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-2xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200" />
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('home') }}" class="inline-flex h-14 items-center justify-center rounded-2xl border border-slate-200 bg-slate-100 px-6 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                    Kembali
                </a>
                <button type="submit" class="inline-flex h-14 items-center justify-center rounded-2xl bg-slate-900 px-6 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
