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
@endphp

<div class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:-translate-y-0.5 hover:border-blue-400 hover:shadow-md">
    <div class="flex items-start justify-between gap-4">
        <div class="min-w-0 flex-1">
            <div class="mb-3 flex items-center gap-2 text-xs text-slate-500">
                <div class="flex items-center gap-1.5 font-medium text-slate-900">
                    <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="truncate">{{ $skripsi->user->nama_lengkap ?? '-' }}</span>
                </div>
                <span class="text-slate-300">•</span>
                <span>Dokumen Skripsi</span>
            </div>

            <div class="flex items-start gap-3">
                <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <h2 class="text-base font-semibold leading-snug text-slate-900 sm:text-lg">
                        {{ strip_tags($skripsi->judul) }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        Pilih bab yang tersedia untuk membuka PDF.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="my-5 border-t border-slate-100"></div>

    <div class="flex flex-wrap gap-2">
        @foreach($babList as $key => $label)
            @php
                $available = $skripsi->isi && $skripsi->isi->$key;
            @endphp

            @if($available)
                <a href="{{ route('pdf.viewer', ['path' => $skripsi->isi->$key]) }}"
                   class="inline-flex items-center rounded-full border border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-700 transition-all hover:border-blue-600 hover:bg-blue-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-300">
                    {{ $label }}
                </a>
            @else
                <span class="inline-flex items-center rounded-full border border-dashed border-slate-200 bg-slate-50 px-3 py-1.5 text-xs font-medium text-slate-300 cursor-not-allowed select-none">
                    {{ $label }}
                </span>
            @endif
        @endforeach
    </div>
</div>