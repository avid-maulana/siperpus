@php
    $babList = [
        'bab1' => 'BAB I',
        'bab2' => 'BAB II',
        'bab3' => 'BAB III',
        'bab4' => 'BAB IV',
        'bab5' => 'BAB V',
        'bab6' => 'BAB VI',
        'daftar_pustaka' => 'Daftar Pustaka',
    ];

    $judul = strip_tags($skripsi->judul ?? '');
@endphp

<div class="group flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:border-slate-300 hover:shadow-xl">

    <!-- Header -->
    <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
        <div class="mb-3 inline-flex items-center rounded-full bg-white px-3 py-1 text-[10px] font-semibold uppercase tracking-widest text-slate-500 shadow-sm">
            Skripsi
        </div>
        
        <!-- Judul dengan Animasi Expand -->
        <div class="relative">
            <h2
            class="max-h-[3.6em] overflow-hidden text-[15px] font-semibold leading-tight text-slate-900 transition-all duration-300 ease-out group-hover:max-h-[300px] group-hover:pb-1"
            title="{{ $judul }}">
            {{ $judul }}
        </h2>
            
            <!-- Gradient fade saat tidak hover -->
            <div class="absolute bottom-0 left-0 right-0 h-6 bg-gradient-to-t from-slate-50 to-transparent pointer-events-none transition-opacity duration-300 group-hover:opacity-0"></div>
        </div>
    </div>

    <!-- Content -->
    <div class="flex flex-1 flex-col p-6">
        
        <!-- Info Mahasiswa -->
        <div class="space-y-5">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 ring-1 ring-inset ring-slate-200">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="text-[10px] font-medium uppercase tracking-widest text-slate-400">Nama</div>
                    <div class="truncate text-sm font-semibold text-slate-700">
                        {{ $skripsi->user->nama_lengkap ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 ring-1 ring-inset ring-slate-200">
                    <span class="material-symbols-outlined text-[20px]">badge</span>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="text-[10px] font-medium uppercase tracking-widest text-slate-400">NIM</div>
                    <div class="truncate text-sm font-semibold text-slate-700">
                        {{ $skripsi->user->nomor_induk ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Repository Documents -->
<!-- Repository Documents -->
<div class="mt-8 border-t border-slate-100 pt-6">
    <h4 class="mb-4 text-xs font-semibold uppercase tracking-[0.125em] text-slate-500">
        Dokumen Repository
    </h4>

    <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-2">
        @foreach ($babList as $key => $label)
            @php
                $available = $skripsi->isi && $skripsi->isi->$key;
                $icon = $key === 'daftar_pustaka' ? 'menu_book' : 'description';
            @endphp

            @if ($available)
                <a
                    href="{{ route('pdf.viewer', ['path' => $skripsi->isi->$key]) }}"
                    class="group/link flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:border-[#212A37] hover:bg-[#212A37] hover:text-white hover:shadow-lg">

                    <span class="flex min-w-0 items-center gap-3">
                        <span class="material-symbols-outlined text-[18px] text-slate-400 transition-colors duration-300 group-hover/link:text-white">
                            {{ $icon }}
                        </span>

                        <span class="truncate">
                            {{ $label }}
                        </span>
                    </span>

                    <span class="material-symbols-outlined text-[18px] text-slate-300 transition-colors duration-300 group-hover/link:text-white">
                        open_in_new
                    </span>
                </a>
            @else
                <div
                    class="flex items-center justify-between rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-400">

                    <span class="flex min-w-0 items-center gap-3">
                        <span class="material-symbols-outlined text-[18px] text-slate-300">
                            {{ $icon }}
                        </span>

                        <span class="truncate">
                            {{ $label }}
                        </span>
                    </span>

                    <span class="text-[10px] font-medium">
                        Belum ada
                    </span>
                </div>
            @endif
        @endforeach
    </div>
</div>
    </div>
</div>