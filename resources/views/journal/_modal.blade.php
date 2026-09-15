<div id="journalModalOverlay"
    class="fixed inset-0 z-[70] hidden items-center justify-center
           bg-slate-950/70 backdrop-blur-sm
           opacity-0 transition-opacity duration-300 px-4">

    <div id="journalModalBox"
        class="w-full max-w-sm
               translate-y-2
               rounded-3xl
               border border-white/10
               bg-white
               p-6
               text-center
               shadow-2xl
               transition-all duration-300 ease-out">

        <button id="journalModalClose" type="button" aria-label="Tutup"
            class="ml-auto flex h-8 w-8 items-center justify-center
                   rounded-full text-slate-400
                   transition-colors hover:bg-slate-100 hover:text-slate-700">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>

        <span class="mx-auto -mt-2 flex h-20 w-20 items-center justify-center overflow-hidden rounded-2xl bg-slate-50">
            <img id="journalModalLogo" src="" alt="" class="h-full w-full object-contain">
        </span>

        <h3 id="journalModalTitle" class="mt-4 text-base font-bold text-slate-900"></h3>
        <p class="mt-1 text-sm text-slate-500">
            Anda akan diarahkan ke situs resmi database ini.
        </p>

        <div class="mt-5 flex flex-col gap-2">
            <a id="journalModalOpenLink" href="#" target="_blank" rel="noopener"
                class="flex h-11 items-center justify-center gap-2
                       rounded-xl bg-[#212A37] text-sm font-semibold text-white
                       transition-colors hover:bg-slate-700">
                <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                Buka Tautan
            </a>

            <button id="journalModalCopyLink" type="button"
                class="flex h-11 items-center justify-center gap-2
                       rounded-xl border border-slate-200 text-sm font-semibold text-slate-700
                       transition-colors hover:bg-slate-100">
                <span class="material-symbols-outlined text-[18px]">content_copy</span>
                <span id="journalModalCopyLabel">Salin Tautan</span>
            </button>
        </div>
    </div>
</div>