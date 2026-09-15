<div id="skripsiPdfModal" class="fixed inset-0 z-[99999] hidden opacity-0 transition-opacity duration-300 ease-out" aria-hidden="true">
    <div id="skripsiPdfBackdrop" class="absolute inset-0 bg-slate-950/90"></div>
    <div id="skripsiPdfModalContent" class="absolute inset-0 flex flex-col bg-white translate-y-2 scale-[0.99] transition-all duration-300 ease-out">
        @include('skripsi.pdf-viewer._pdf-viewer-header')
        <div class="flex min-h-0 flex-1">
            @include('skripsi.pdf-viewer._pdf-viewer-sidebar')
            @include('skripsi.pdf-viewer._pdf-viewer-document')
        </div>
    </div>
</div>
