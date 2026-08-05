@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
@php
$readOnlyInputClass = 'w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 pr-11 text-sm font-medium text-slate-500 outline-none select-none';
$passwordInputBase = 'w-full rounded-xl border bg-white px-4 py-3 text-sm text-slate-900 outline-none placeholder:text-slate-400 transition duration-200 hover:border-slate-300 focus:border-blue-500 focus:ring-4';
@endphp

<div class="min-h-[calc(100vh-5rem)] bg-slate-50">
    <div class="mx-auto max-w-3xl px-6 py-10 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Edit Profil</h1>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Kelola keamanan akun dan perbarui password Anda.
            </p>
        </div>

        {{-- Alert Success --}}
        @if (session('success'))
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm text-emerald-700">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <div>
                <p class="font-semibold">Berhasil</p>
                <p class="mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        {{-- General Error --}}
        @if ($errors->any())
        <div class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700">
            <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-1.5a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 4.5h.008v.008H12v-.008Z" />
            </svg>
            <div>
                <p class="font-semibold">Gagal menyimpan perubahan</p>
                <p class="mt-0.5 text-red-600">Periksa kembali data yang Anda masukkan.</p>
            </div>
        </div>
        @endif

        {{-- Card --}}
        <div class="overflow-hidden rounded-[24px] border border-slate-200 bg-white shadow-sm">
            {{-- Account Information --}}
            <div class="border-b border-slate-200 px-6 py-6 sm:px-8">
                <div class="mb-6">
                    <h2 class="text-base font-semibold text-slate-900">Informasi Akun</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Informasi berikut terhubung dengan akun Anda dan tidak dapat diubah.
                    </p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    {{-- Username --}}
                    <div>
                        <label for="username" class="mb-2 block text-sm font-medium text-slate-700">Username</label>
                        <div class="relative">
                            <input
                                id="username"
                                type="text"
                                value="{{ Auth::user()->username }}"
                                readonly
                                aria-readonly="true"
                                tabindex="-1"
                                class="{{ $readOnlyInputClass }}">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400" title="Username tidak dapat diubah">
                                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-2 flex items-center gap-1.5 text-xs text-slate-400">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4" />
                                <path d="M12 8h.01" />
                            </svg>
                            Username tidak dapat diubah.
                        </p>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                        <div class="relative">
                            <input
                                id="email"
                                type="text"
                                value="{{ Auth::user()->email ?? 'Email belum tersedia' }}"
                                readonly
                                aria-readonly="true"
                                tabindex="-1"
                                class="{{ $readOnlyInputClass }}">
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400" title="Email tidak dapat diubah">
                                <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </div>
                        </div>
                        <p class="mt-2 flex items-center gap-1.5 text-xs text-slate-400">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4" />
                                <path d="M12 8h.01" />
                            </svg>
                            Email tidak dapat diubah.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Password Form --}}
            <form action="{{ route('profile.update') }}" method="POST" class="px-6 py-6 sm:px-8">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <h2 class="text-base font-semibold text-slate-900">Ubah Password</h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Masukkan password lama untuk mengonfirmasi perubahan.
                    </p>
                </div>

                <div class="space-y-5">
                    {{-- Current Password --}}
                    <div>
                        <label for="current_password" class="mb-2 block text-sm font-medium text-slate-700">Password Lama</label>
                        <input
                            id="current_password"
                            name="current_password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password lama"
                            class="{{ $passwordInputBase }} {{ $errors->has('current_password') ? 'border-red-400 focus:border-red-500 focus:ring-red-500/10' : 'border-slate-200 focus:ring-blue-500/10' }}">
                        @error('current_password')
                        <p class="mt-2 flex items-center gap-1.5 text-xs font-medium text-red-600">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="m15 9-6 6" />
                                <path d="m9 9 6 6" />
                            </svg>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password Baru</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Masukkan password baru"
                                class="{{ $passwordInputBase }} {{ $errors->has('password') ? 'border-red-400 focus:border-red-500 focus:ring-red-500/10' : 'border-slate-200 focus:ring-blue-500/10' }}">
                            @error('password')
                            <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Konfirmasi Password</label>
                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Ulangi password baru"
                                class="{{ $passwordInputBase }} border-slate-200 focus:ring-blue-500/10">
                        </div>
                    </div>

                    {{-- Password Information --}}
                    <div class="rounded-xl border border-blue-100 bg-blue-50/60 px-4 py-3">
                        <div class="flex gap-3">
                            <svg class="mt-0.5 h-4.5 w-4.5 shrink-0 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 16v-4" />
                                <path d="M12 8h.01" />
                            </svg>
                            <p class="text-xs leading-5 text-blue-700">
                                Gunakan password yang kuat dan hindari menggunakan password yang sama dengan akun lain.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">
                    <a
                        href="{{ route('home') }}"
                        class="inline-flex h-12 items-center justify-center rounded-xl border border-slate-200 bg-white px-5 text-sm font-semibold text-slate-600 transition-all duration-200 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900 active:scale-[0.98]">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex h-12 items-center justify-center gap-2 rounded-xl bg-[#212A37]/95 px-6 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-[#212A37] hover:shadow-md active:scale-[0.98] focus:outline-none focus:ring-4 focus:ring-slate-500/20">
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection