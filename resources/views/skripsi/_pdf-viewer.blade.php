{{-- =========================================================
    PDF VIEWER MODAL - SKRIPSI
    FULLSCREEN
    READ ONLY
    PDF.JS
    DETAIL PANEL
    COLLAPSIBLE CHAPTER SIDEBAR
    ========================================================= --}}

    <div id="skripsiPdfModal" class="fixed inset-0 z-[99999] hidden opacity-0 transition-opacity duration-300 ease-out"
        aria-hidden="true">

        {{-- =====================================================
        BACKDROP
        ====================================================== --}}

        <div id="skripsiPdfBackdrop" class="absolute inset-0 bg-slate-950/90"></div>


        {{-- =====================================================
        MODAL CONTENT
        ====================================================== --}}

        <div id="skripsiPdfModalContent" class="absolute inset-0
               flex flex-col
               bg-white
               translate-y-2
               scale-[0.99]
               transition-all
               duration-300
               ease-out">

            {{-- =================================================
            HEADER
            ================================================== --}}

            <header class="relative
                   z-30
                   flex
                   h-16
                   shrink-0
                   items-center
                   justify-between
                   border-b
                   border-slate-200
                   bg-white
                   px-4
                   sm:px-6">

                {{-- =============================================
                TITLE
                ============================================== --}}

                <div class="min-w-0
                       flex-1
                       pr-4">

                    <p class="text-[10px]
                           font-semibold
                           uppercase
                           tracking-[0.16em]
                           text-slate-400">
                        Repository Skripsi
                    </p>

                    <h2 id="skripsiPdfTitle" class="mt-0.5
                           truncate
                           text-sm
                           font-semibold
                           text-slate-800
                           sm:text-base">
                        PDF Viewer
                    </h2>

                </div>


                {{-- =============================================
                HEADER ACTIONS
                ============================================== --}}

                <div class="flex
                       shrink-0
                       items-center
                       gap-2">

                    {{-- DETAIL --}}

                    <button id="skripsiPdfDetailToggle" type="button" aria-label="Lihat detail skripsi"
                        aria-expanded="false" class="flex
                           h-10
                           items-center
                           gap-2
                           rounded-xl
                           border
                           border-slate-200
                           bg-white
                           px-3
                           text-sm
                           font-medium
                           text-slate-600
                           transition-all
                           duration-200
                           hover:border-slate-300
                           hover:bg-slate-50
                           hover:text-slate-800
                           active:scale-95">

                        <span class="material-symbols-outlined text-[21px]">
                            info
                        </span>

                        <span class="hidden sm:inline">
                            Detail
                        </span>

                    </button>


                    {{-- CLOSE --}}

                    <button id="skripsiPdfClose" type="button" aria-label="Tutup PDF" class="flex
                           h-10
                           w-10
                           shrink-0
                           items-center
                           justify-center
                           rounded-xl
                           text-slate-400
                           transition-all
                           duration-200
                           hover:bg-slate-100
                           hover:text-slate-700
                           active:scale-95">

                        <span class="material-symbols-outlined text-[25px]">
                            close
                        </span>

                    </button>

                </div>

            </header>


            {{-- =================================================
            BODY (SIDEBAR + PDF VIEWER)
            ================================================== --}}

            <div class="flex min-h-0 flex-1">

                {{-- =============================================
                CHAPTER SIDEBAR (COLLAPSIBLE)
                ============================================== --}}

                <aside id="skripsiPdfChapterPanel" data-expanded="true" class="relative
                       flex
                       w-72
                       shrink-0
                       flex-col
                       border-r
                       border-slate-200
                       bg-white
                       transition-all
                       duration-300
                       ease-out">

                    {{-- COLLAPSE / EXPAND TOGGLE --}}

                    <button id="skripsiPdfChapterToggle" type="button" aria-label="Ciutkan daftar bab"
                        aria-expanded="true" class="absolute
                           -right-3
                           top-6
                           z-10
                           flex
                           h-7
                           w-7
                           items-center
                           justify-center
                           rounded-full
                           border
                           border-slate-200
                           bg-white
                           text-slate-500
                           shadow-md
                           transition-transform
                           duration-300
                           hover:bg-slate-50
                           hover:text-slate-700">

                        <svg id="skripsiPdfChapterToggleIcon" class="h-4 w-4 transition-transform duration-300"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>

                    </button>


                    {{-- SIDEBAR HEADER --}}

                    <div class="flex
                           h-20
                           shrink-0
                           items-center
                           gap-3
                           border-b
                           border-slate-100
                           px-5">

                        <div class="flex
                               h-10
                               w-10
                               shrink-0
                               items-center
                               justify-center
                               rounded-xl
                               bg-slate-800
                               text-white">

                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 4.5A2.5 2.5 0 017.5 2H19v17H7.5A2.5 2.5 0 005 21.5v-17Z" />
                                <path stroke-linecap="round" d="M5 19.5A2.5 2.5 0 017.5 17H19" />
                            </svg>

                        </div>


                        <div id="skripsiPdfChapterHeaderText" class="min-w-0">

                            <p class="text-[10px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400">
                                Daftar Bab
                            </p>

                            <h3 id="skripsiPdfChapterListTitle" class="truncate
                                   text-sm
                                   font-semibold
                                   text-slate-800">
                                -
                            </h3>

                        </div>

                    </div>


                    {{-- CHAPTER LIST --}}

                    <nav id="skripsiPdfChapterList" class="flex
                           flex-1
                           flex-col
                           gap-1
                           overflow-y-auto
                           p-3">

                        <p class="px-3
                               py-4
                               text-sm
                               text-slate-400">
                            Tidak ada bab lain.
                        </p>

                    </nav>

                </aside>


                {{-- =============================================
                PDF CONTENT AREA
                ============================================== --}}

                <main id="skripsiPdfViewer" class="relative
                       min-h-0
                       min-w-0
                       flex-1
                       overflow-auto
                       bg-slate-200">

                    {{-- LOADING --}}

                    <div id="skripsiPdfLoading" class="absolute
                           inset-0
                           z-20
                           flex
                           items-center
                           justify-center
                           bg-slate-100">

                        <div class="text-center">

                            <div class="mx-auto
                                   h-10
                                   w-10
                                   animate-spin
                                   rounded-full
                                   border-4
                                   border-slate-300
                                   border-t-slate-800"></div>

                            <p class="mt-4
                                   text-sm
                                   font-medium
                                   text-slate-600">
                                Memuat dokumen...
                            </p>

                        </div>

                    </div>


                    {{-- ERROR --}}

                    <div id="skripsiPdfError" class="absolute
                           inset-0
                           z-20
                           hidden
                           items-center
                           justify-center
                           bg-slate-100">

                        <div class="max-w-md
                               px-6
                               text-center">

                            <div class="mx-auto
                                   flex
                                   h-12
                                   w-12
                                   items-center
                                   justify-center
                                   rounded-2xl
                                   bg-red-50
                                   text-red-500">

                                <span class="material-symbols-outlined">
                                    error_outline
                                </span>

                            </div>


                            <h3 class="mt-4
                                   text-sm
                                   font-semibold
                                   text-slate-700">
                                Dokumen tidak dapat dimuat
                            </h3>


                            <p id="skripsiPdfErrorMessage" class="mt-2
                                   text-sm
                                   leading-6
                                   text-slate-500">
                                File PDF tidak dapat ditampilkan.
                            </p>

                        </div>

                    </div>


                    {{-- PDF PAGES CONTAINER --}}

                    <div id="skripsiPdfPages" class="flex
       min-h-full
       flex-col
       items-center
       gap-5
       px-3
       pt-5
       pb-32
       sm:px-6"></div>

                    {{-- =========================================
                    DETAIL BACKDROP
                    ========================================== --}}

                    <div id="skripsiPdfDetailBackdrop" class="fixed
               inset-x-0
               top-16
               bottom-0
               z-30
               hidden
               bg-slate-950/30
               backdrop-blur-[1px]"></div>


                    {{-- =========================================
                    DETAIL PANEL
                    ========================================== --}}

                    <aside id="skripsiPdfDetailPanel" class="fixed
               right-0
               top-16
               bottom-0
               z-40
               w-full
               max-w-md
               translate-x-full
               overflow-y-auto
               border-l
               border-slate-200
               bg-white
               shadow-2xl
               transition-transform
               duration-300
               ease-out">

                        {{-- DETAIL HEADER --}}

                        <div class="sticky
                               top-0
                               z-10
                               flex
                               h-24
                               items-center
                               justify-between
                               border-b
                               border-slate-200
                               bg-white
                               px-6">

                            <div>

                                <p class="text-[11px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.16em]
                                       text-slate-400">
                                    Informasi Dokumen
                                </p>

                                <h3 class="mt-1
                                       text-lg
                                       font-semibold
                                       text-slate-800">
                                    Detail Skripsi
                                </h3>

                            </div>


                            {{-- CLOSE DETAIL --}}

                            <button id="skripsiPdfDetailClose" type="button" aria-label="Tutup detail" class="flex
                                   h-10
                                   w-10
                                   items-center
                                   justify-center
                                   rounded-xl
                                   text-slate-400
                                   transition-all
                                   duration-200
                                   hover:bg-slate-100
                                   hover:text-slate-700
                                   active:scale-95">

                                <span class="material-symbols-outlined text-[26px]">
                                    close
                                </span>

                            </button>

                        </div>


                        {{-- DETAIL BODY --}}

                        <div class="px-6
                               py-7">

                            {{-- PEMILIK --}}

                            <section>

                                <p class="text-[11px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.16em]
                                       text-slate-400">
                                    Pemilik Skripsi
                                </p>

                                <p id="skripsiPdfDetailAuthor" class="mt-3
                                       break-words
                                       text-base
                                       font-semibold
                                       leading-7
                                       text-slate-800">
                                    -
                                </p>

                            </section>


                            <div class="my-7
                                   border-t
                                   border-slate-100"></div>


                            {{-- NIM --}}

                            <section>

                                <p class="text-[11px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.16em]
                                       text-slate-400">
                                    NIM
                                </p>

                                <p id="skripsiPdfDetailNim" class="mt-3
                                       break-words
                                       text-base
                                       font-medium
                                       text-slate-700">
                                    -
                                </p>

                            </section>


                            <div class="my-7
                                   border-t
                                   border-slate-100"></div>


                            {{-- BAB --}}

                            <section>

                                <p class="text-[11px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.16em]
                                       text-slate-400">
                                    Bab
                                </p>

                                <div class="mt-3
                                       inline-flex
                                       items-center
                                       rounded-xl
                                       bg-slate-100
                                       px-4
                                       py-2.5">

                                    <span id="skripsiPdfDetailChapter" class="text-sm
                                           font-semibold
                                           text-slate-700">
                                        -
                                    </span>

                                </div>

                            </section>


                            <div class="my-7
                                   border-t
                                   border-slate-100"></div>


                            {{-- JUDUL --}}

                            <section>

                                <p class="text-[11px]
                                       font-semibold
                                       uppercase
                                       tracking-[0.16em]
                                       text-slate-400">
                                    Judul Skripsi
                                </p>

                                <p id="skripsiPdfDetailTitle" class="mt-3
                                       break-words
                                       text-base
                                       font-medium
                                       leading-7
                                       text-slate-700">
                                    -
                                </p>

                            </section>


                            {{-- INFO --}}

                            <div class="mt-8
                                   rounded-2xl
                                   bg-slate-50
                                   px-5
                                   py-5">

                                <div class="flex
                                       items-start
                                       gap-4">

                                    <span class="material-symbols-outlined
                                           shrink-0
                                           text-[24px]
                                           text-slate-400">
                                        info
                                    </span>

                                    <p class="text-sm
                                           leading-6
                                           text-slate-500">
                                        Informasi ini mengikuti data skripsi
                                        yang tersedia pada repository.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </aside>


                    {{-- =========================================
                    ZOOM CONTROLS
                    ========================================== --}}

                    <div id="skripsiPdfZoomControls" style="left: 18rem;" class="pointer-events-none
               fixed
               right-0
               bottom-5
               z-20
               flex
               justify-center
               transition-[left]
               duration-300
               ease-out">

                        <div class="pointer-events-auto
                   flex
                   items-center
                   gap-1
                   rounded-2xl
                   border
                   border-slate-200
                   bg-white/95
                   px-2
                   py-1.5
                   shadow-lg
                   backdrop-blur">

                            <button id="skripsiPdfZoomOut" type="button" aria-label="Perkecil"
                                class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition-all duration-200 hover:bg-slate-100 hover:text-slate-800 active:scale-95 disabled:pointer-events-none">
                                <span class="material-symbols-outlined text-[20px]">remove</span>
                            </button>

                            <span id="skripsiPdfZoomLabel"
                                class="min-w-[3.25rem] text-center text-xs font-semibold text-slate-600">
                                100%
                            </span>

                            <button id="skripsiPdfZoomIn" type="button" aria-label="Perbesar"
                                class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition-all duration-200 hover:bg-slate-100 hover:text-slate-800 active:scale-95 disabled:pointer-events-none">
                                <span class="material-symbols-outlined text-[20px]">add</span>
                            </button>

                            <div class="mx-1 h-5 w-px bg-slate-200"></div>

                            <button id="skripsiPdfZoomReset" type="button" aria-label="Reset zoom"
                                class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition-all duration-200 hover:bg-slate-100 hover:text-slate-800 active:scale-95">
                                <span class="material-symbols-outlined text-[20px]">restart_alt</span>
                            </button>

                        </div>

                    </div>

                </main>

            </div>

        </div>

    </div>