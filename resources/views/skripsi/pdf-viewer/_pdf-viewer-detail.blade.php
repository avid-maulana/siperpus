<div id="skripsiPdfDetailBackdrop"
    class="fixed inset-x-0 bottom-0 top-16 z-30 hidden bg-slate-950/30 backdrop-blur-[1px]"></div>
<aside id="skripsiPdfDetailPanel"
    class="fixed bottom-0 right-0 top-16 z-40 w-full max-w-md translate-x-full overflow-y-auto border-l border-slate-200 bg-white shadow-2xl transition-transform duration-300 ease-out">
    <div class="sticky top-0 z-10 flex h-24 items-center justify-between border-b border-slate-200 bg-white px-6">
        <div>
            <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Informasi Dokumen</p>
            <h3 class="mt-1 text-lg font-semibold text-slate-800">Detail Skripsi</h3>
        </div><button id="skripsiPdfDetailClose" type="button" aria-label="Tutup detail"
            class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-400 transition-all duration-200 hover:bg-slate-100 hover:text-slate-700 active:scale-95"><span
                class="material-symbols-outlined text-[26px]">close</span></button>
    </div>
    <div class="space-y-7 px-6 py-7">
        <section>
            <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Pemilik Skripsi</p>
            <p id="skripsiPdfDetailAuthor" class="mt-3 break-words text-base font-semibold leading-7 text-slate-800">-
            </p>
        </section>
        <section class="border-t border-slate-100 pt-7">
            <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">NIM</p>
            <p id="skripsiPdfDetailNim" class="mt-3 break-words text-base font-medium text-slate-700">-</p>
        </section>
        <section class="border-t border-slate-100 pt-7">
            <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Bab</p>
            <div class="mt-3 inline-flex items-center rounded-xl bg-slate-100 px-4 py-2.5"><span
                    id="skripsiPdfDetailChapter" class="text-sm font-semibold text-slate-700">-</span></div>
        </section>
        <section class="border-t border-slate-100 pt-7">
            <p class="text-[11px] font-semibold uppercase tracking-[0.16em] text-slate-400">Judul Skripsi</p>
            <p id="skripsiPdfDetailTitle" class="mt-3 break-words text-base font-medium leading-7 text-slate-700">-</p>
        </section>
        <div class="rounded-2xl bg-slate-50 px-5 py-5">
            <div class="flex items-start gap-4"><span
                    class="material-symbols-outlined shrink-0 text-[24px] text-slate-400">info</span>
                <p class="text-sm leading-6 text-slate-500">Informasi ini mengikuti data skripsi yang tersedia pada
                    repository.</p>
            </div>
        </div>
    </div>
</aside>