<div
    id="praktikIndustriAdminModal"
    class="fixed inset-0 z-[9998] hidden"
    aria-hidden="true"
>

    <div
        data-modal-backdrop
        class="absolute inset-0
               bg-slate-950/60
               backdrop-blur-sm"
    ></div>


    <div
        class="relative flex min-h-full
               items-center justify-center
               p-4"
    >

        <div
            data-modal-panel
            class="relative w-full max-w-3xl
                   max-h-[90vh]
                   overflow-hidden
                   rounded-3xl
                   border border-slate-200
                   bg-white
                   shadow-2xl
                   opacity-0
                   translate-y-4
                   scale-95
                   transition-all
                   duration-200"
        >

            {{-- HEADER --}}

            <div
                class="flex items-center justify-between
                       border-b border-slate-200
                       bg-white
                       px-6 py-5"
            >

                <div class="min-w-0">

                    <div
                        class="mb-1 text-[10px]
                               font-semibold
                               uppercase
                               tracking-widest
                               text-slate-400"
                    >
                        Administrasi Repository
                    </div>


                    <h3
                        data-modal-title
                        class="truncate
                               text-base
                               font-bold
                               text-[#212A37]"
                    >
                        Detail Laporan Praktik Industri
                    </h3>

                </div>


                <button
                    type="button"
                    data-modal-close
                    class="ml-4 flex h-9 w-9
                           shrink-0
                           items-center
                           justify-center
                           rounded-xl
                           text-slate-400
                           transition
                           hover:bg-slate-100
                           hover:text-slate-700"
                    aria-label="Tutup"
                >

                    <span class="material-symbols-outlined">
                        close
                    </span>

                </button>

            </div>


            {{-- CONTENT --}}

            <div
                data-modal-content
                class="max-h-[calc(90vh-90px)]
                       overflow-y-auto
                       p-6"
            ></div>

        </div>

    </div>

</div>