<header
    class="relative z-30 flex h-16 shrink-0 items-center justify-between border-b border-slate-200 bg-white px-4 shadow-sm sm:px-6">

    <div class="min-w-0 flex-1 pr-4">
        <p id="pdfRepositoryLabel" class="text-[10px] font-semibold uppercase tracking-[0.16em] text-slate-400">
            Repository {{ request('document_type', 'Tesis') }}
        </p>

        <h2 id="pdfTitle" class="mt-0.5 truncate text-sm font-semibold text-slate-800 sm:text-base">
            {{ request('bab', request('title', 'Dokumen')) }}
        </h2>
    </div>

    <div class="flex shrink-0 items-center gap-2">
        <button
            id="pdfDetailToggle"
            type="button"
            aria-label="Lihat detail dokumen"
            aria-expanded="false"
            class="flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 text-sm font-medium text-slate-600 transition-all duration-200 hover:border-slate-300 hover:bg-slate-50 hover:text-slate-800 active:scale-95">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="9" />
                <path stroke-linecap="round" d="M12 11v5M12 8h.01" />
            </svg>
            <span class="hidden sm:inline">Detail</span>
        </button>

        <button
            id="pdfClose"
            type="button"
            onclick="history.back()"
            aria-label="Tutup PDF"
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-slate-400 transition-all duration-200 hover:bg-slate-100 hover:text-slate-700 active:scale-95">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
            </svg>
        </button>
    </div>
</header>