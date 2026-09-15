<main id="pdfViewerArea" class="relative min-h-0 flex-1 overflow-auto bg-slate-200">
    <div id="pdf-loading" class="absolute inset-0 z-20 flex items-center justify-center bg-slate-100">
        <div class="text-center">
            <div class="mx-auto h-10 w-10 animate-spin rounded-full border-4 border-slate-300 border-t-slate-800"></div>
            <p class="mt-4 text-sm font-medium text-slate-600">Memuat dokumen...</p>
        </div>
    </div>

    <div id="pdf-container"></div>

    <div id="pdf-error" class="absolute inset-0 z-20 hidden items-center justify-center bg-slate-100 px-6">
        <div class="max-w-sm text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 text-red-500 ring-1 ring-inset ring-red-100">
                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="9" />
                    <path stroke-linecap="round" d="M12 8v4M12 16h.01" />
                </svg>
            </div>

            <h3 class="mt-5 text-lg font-semibold text-slate-800">PDF gagal dimuat</h3>

            <p id="pdf-error-message" class="mt-2 text-sm leading-relaxed text-slate-500">
                Dokumen tidak dapat ditampilkan. Silakan kembali dan coba buka dokumen kembali.
            </p>

            <button
                type="button"
                onclick="history.back()"
                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 active:scale-[0.98]">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </button>
        </div>
    </div>

    <div id="pdfDetailBackdrop" class="fixed inset-x-0 top-16 bottom-0 z-30 hidden bg-slate-950/30 backdrop-blur-[1px]"></div>

    <aside
        id="pdfDetailPanel"
        class="fixed right-0 top-16 bottom-0 z-40 w-full max-w-md translate-x-full overflow-y-auto border-l border-slate-200 bg-white shadow-2xl transition-transform duration-300 ease-out">
        <div class="sticky top-0 z-10 flex h-24 items-center justify-between border-b border-slate-200 bg-white px-6">
            <div>
                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Informasi Dokumen</p>
                <h3 id="pdfDetailHeading" class="mt-1 text-lg font-semibold text-slate-800">Detail {{ request('document_type', 'Tesis') }}</h3>
            </div>

            <button
                id="pdfDetailClose"
                type="button"
                aria-label="Tutup detail"
                class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-400 transition-all duration-200 hover:bg-slate-100 hover:text-slate-700 active:scale-95">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
        </div>

        <div class="px-6 py-7">
            <section>
                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Nama Mahasiswa</p>
                <p id="pdfDetailAuthor" class="mt-3 break-words text-base font-semibold leading-7 text-slate-800">-</p>
            </section>

            <div class="my-7 border-t border-slate-100"></div>

            <section>
                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">NIM</p>
                <p id="pdfDetailNim" class="mt-3 break-words text-base font-medium text-slate-700">-</p>
            </section>

            <div class="my-7 border-t border-slate-100"></div>

            <section>
                <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Bagian</p>
                <div class="mt-3 inline-flex items-center rounded-xl bg-slate-100 px-4 py-2.5">
                    <span id="pdfDetailChapter" class="text-sm font-semibold text-slate-700">-</span>
                </div>
            </section>

            <div class="my-7 border-t border-slate-100"></div>

            <section>
                <p id="pdfDetailTitleLabel" class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Judul {{ request('document_type', 'Tesis') }}</p>
                <p id="pdfDetailTitle" class="mt-3 break-words text-base font-medium leading-7 text-slate-700">-</p>
            </section>

            <div class="mt-8 rounded-2xl bg-slate-50 px-5 py-5">
                <div class="flex items-start gap-4">
                    <svg class="h-6 w-6 shrink-0 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" />
                        <path stroke-linecap="round" d="M12 11v5M12 8h.01" />
                    </svg>
                    <p class="text-sm leading-6 text-slate-500">
                        Informasi ini mengikuti data {{ strtolower(request('document_type', 'Tesis')) }} yang tersedia pada repository.
                    </p>
                </div>
            </div>
        </div>
    </aside>

    <div id="pdfZoomControls" class="pointer-events-none fixed inset-x-0 bottom-5 z-20 flex justify-center">
        <div class="pointer-events-auto flex items-center gap-1 rounded-2xl border border-slate-200 bg-white/95 px-2 py-1.5 shadow-lg backdrop-blur">
            <button
                id="pdfZoomOut"
                type="button"
                aria-label="Perkecil"
                class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition-all duration-200 hover:bg-slate-100 hover:text-slate-800 active:scale-95 disabled:pointer-events-none disabled:opacity-40">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M6 12h12" />
                </svg>
            </button>

            <span id="pdfZoomLabel" class="min-w-[3.25rem] text-center text-xs font-semibold text-slate-600">50%</span>

            <button
                id="pdfZoomIn"
                type="button"
                aria-label="Perbesar"
                class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition-all duration-200 hover:bg-slate-100 hover:text-slate-800 active:scale-95 disabled:pointer-events-none disabled:opacity-40">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" d="M12 6v12M6 12h12" />
                </svg>
            </button>

            <div class="mx-1 h-5 w-px bg-slate-200"></div>

            <button
                id="pdfZoomReset"
                type="button"
                aria-label="Reset zoom"
                class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition-all duration-200 hover:bg-slate-100 hover:text-slate-800 active:scale-95">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h5M20 20v-5h-5M4 9a8 8 0 0114-5M20 15a8 8 0 01-14 5" />
                </svg>
            </button>
        </div>
    </div>
</main>