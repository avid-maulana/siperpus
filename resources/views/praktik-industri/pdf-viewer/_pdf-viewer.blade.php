<div id="praktikIndustriPdfModal"
    class="fixed inset-0 z-[99999] hidden opacity-0 transition-opacity duration-300 ease-out" aria-hidden="true">
    <div id="praktikIndustriPdfBackdrop" class="absolute inset-0 bg-slate-950/90"></div>
    <div id="praktikIndustriPdfModalContent"
        class="absolute inset-0 flex flex-col bg-white translate-y-2 scale-[0.99] transition-all duration-300 ease-out">
        @include(
            'praktik-industri.pdf-viewer._pdf-viewer-header'
        )@include('praktik-industri.pdf-viewer._pdf-viewer-workspace')
    </div>
</div>