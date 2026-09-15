<main id="praktikIndustriPdfViewer" class="relative min-h-0 flex-1 overflow-auto bg-slate-200">
    <div id="praktikIndustriPdfLoading" class="absolute inset-0 z-20 flex items-center justify-center bg-slate-100">
        <div class="text-center">
            <div class="mx-auto h-10 w-10 animate-spin rounded-full border-4 border-slate-300 border-t-slate-800"></div>
            <p class="mt-4 text-sm font-medium text-slate-600">Memuat dokumen...</p>
        </div>
    </div>
    <div id="praktikIndustriPdfError" class="absolute inset-0 z-20 hidden items-center justify-center bg-slate-100">
        <div class="max-w-md px-6 text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-500"><span
                    class="material-symbols-outlined">error_outline</span></div>
            <h3 class="mt-4 text-sm font-semibold text-slate-700">Dokumen tidak dapat dimuat</h3>
            <p id="praktikIndustriPdfErrorMessage" class="mt-2 text-sm leading-6 text-slate-500">File PDF tidak dapat
                ditampilkan.</p>
        </div>
    </div>
    <div id="praktikIndustriPdfPages" class="flex min-h-full flex-col items-center gap-5 px-3 py-5 sm:px-6"></div>
    @include('praktik-industri.pdf-viewer._pdf-viewer-detail')
    @include('praktik-industri.pdf-viewer._pdf-viewer-zoom')
</main>