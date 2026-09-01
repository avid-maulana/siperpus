{{-- =========================================================
    PDF VIEWER MODAL - PRAKTIK INDUSTRI
    FULLSCREEN
    READ ONLY
    PDF.JS
    DETAIL PANEL
========================================================= --}}

<div
    id="praktikIndustriPdfModal"
    class="fixed inset-0 z-[99999] hidden opacity-0 transition-opacity duration-300 ease-out"
    aria-hidden="true"
>

    {{-- =====================================================
        BACKDROP
    ====================================================== --}}

    <div
        id="praktikIndustriPdfBackdrop"
        class="absolute inset-0 bg-slate-950/90"
    ></div>


    {{-- =====================================================
        MODAL CONTENT
    ====================================================== --}}

    <div
        id="praktikIndustriPdfModalContent"
        class="absolute inset-0
               flex flex-col
               bg-white
               translate-y-2
               scale-[0.99]
               transition-all
               duration-300
               ease-out"
    >

        {{-- =================================================
            HEADER
        ================================================== --}}

        <header
            class="relative
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
                   sm:px-6"
        >

            {{-- =============================================
                TITLE
            ============================================== --}}

            <div
                class="min-w-0
                       flex-1
                       pr-4"
            >

                <p
                    class="text-[10px]
                           font-semibold
                           uppercase
                           tracking-[0.16em]
                           text-slate-400"
                >
                    Repository Praktik Industri
                </p>

                <h2
                    id="praktikIndustriPdfTitle"
                    class="mt-0.5
                           truncate
                           text-sm
                           font-semibold
                           text-slate-800
                           sm:text-base"
                >
                    PDF Viewer
                </h2>

            </div>


            {{-- =============================================
                HEADER ACTIONS
            ============================================== --}}

            <div
                class="flex
                       shrink-0
                       items-center
                       gap-2"
            >

                {{-- ZOOM CONTROLS --}}

                <div
                    class="flex
                           h-10
                           items-center
                           gap-0.5
                           rounded-xl
                           border
                           border-slate-200
                           bg-white
                           px-1"
                >

                    <button
                        id="praktikIndustriPdfZoomOut"
                        type="button"
                        aria-label="Perkecil"
                        class="flex
                               h-8
                               w-8
                               items-center
                               justify-center
                               rounded-lg
                               text-slate-500
                               transition-all
                               duration-200
                               hover:bg-slate-100
                               hover:text-slate-800
                               active:scale-95
                               disabled:cursor-not-allowed
                               disabled:opacity-40
                               disabled:hover:bg-transparent"
                    >
                        <span class="material-symbols-outlined text-[19px]">
                            remove
                        </span>
                    </button>

                    <span
                        id="praktikIndustriPdfZoomLabel"
                        class="w-12
                               shrink-0
                               text-center
                               text-xs
                               font-semibold
                               text-slate-600"
                    >
                        100%
                    </span>

                    <button
                        id="praktikIndustriPdfZoomIn"
                        type="button"
                        aria-label="Perbesar"
                        class="flex
                               h-8
                               w-8
                               items-center
                               justify-center
                               rounded-lg
                               text-slate-500
                               transition-all
                               duration-200
                               hover:bg-slate-100
                               hover:text-slate-800
                               active:scale-95
                               disabled:cursor-not-allowed
                               disabled:opacity-40
                               disabled:hover:bg-transparent"
                    >
                        <span class="material-symbols-outlined text-[19px]">
                            add
                        </span>
                    </button>

                </div>


                {{-- DETAIL --}}

                <button
                    id="praktikIndustriPdfDetailToggle"
                    type="button"
                    aria-label="Lihat detail laporan"
                    aria-expanded="false"
                    class="flex
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
                           active:scale-95"
                >

                    <span
                        class="material-symbols-outlined text-[21px]"
                    >
                        info
                    </span>

                    <span class="hidden sm:inline">
                        Detail
                    </span>

                </button>


                {{-- CLOSE --}}

                <button
                    id="praktikIndustriPdfClose"
                    type="button"
                    aria-label="Tutup PDF"
                    class="flex
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
                           active:scale-95"
                >

                    <span
                        class="material-symbols-outlined text-[25px]"
                    >
                        close
                    </span>

                </button>

            </div>

        </header>


        {{-- =================================================
            PDF CONTENT AREA
        ================================================== --}}

        <main
            id="praktikIndustriPdfViewer"
            class="relative
                   min-h-0
                   flex-1
                   overflow-auto
                   bg-slate-200"
        >

            {{-- =============================================
                LOADING
            ============================================== --}}

            <div
                id="praktikIndustriPdfLoading"
                class="absolute
                       inset-0
                       z-20
                       flex
                       items-center
                       justify-center
                       bg-slate-100"
            >

                <div class="text-center">

                    <div
                        class="mx-auto
                               h-10
                               w-10
                               animate-spin
                               rounded-full
                               border-4
                               border-slate-300
                               border-t-slate-800"
                    ></div>

                    <p
                        class="mt-4
                               text-sm
                               font-medium
                               text-slate-600"
                    >
                        Memuat dokumen...
                    </p>

                </div>

            </div>


            {{-- =============================================
                ERROR
            ============================================== --}}

            <div
                id="praktikIndustriPdfError"
                class="absolute
                       inset-0
                       z-20
                       hidden
                       items-center
                       justify-center
                       bg-slate-100"
            >

                <div
                    class="max-w-md
                           px-6
                           text-center"
                >

                    <div
                        class="mx-auto
                               flex
                               h-12
                               w-12
                               items-center
                               justify-center
                               rounded-2xl
                               bg-red-50
                               text-red-500"
                    >

                        <span
                            class="material-symbols-outlined"
                        >
                            error_outline
                        </span>

                    </div>


                    <h3
                        class="mt-4
                               text-sm
                               font-semibold
                               text-slate-700"
                    >
                        Dokumen tidak dapat dimuat
                    </h3>


                    <p
                        id="praktikIndustriPdfErrorMessage"
                        class="mt-2
                               text-sm
                               leading-6
                               text-slate-500"
                    >
                        File PDF tidak dapat ditampilkan.
                    </p>

                </div>

            </div>


            {{-- =============================================
                PDF PAGES CONTAINER
            ============================================== --}}

            <div
                id="praktikIndustriPdfPages"
                class="flex
                       min-h-full
                       flex-col
                       items-center
                       gap-5
                       px-3
                       py-5
                       sm:px-6"
            ></div>


            {{-- =================================================
                DETAIL BACKDROP
            ================================================== --}}

            <div
                id="praktikIndustriPdfDetailBackdrop"
                class="absolute
                       inset-0
                       z-30
                       hidden
                       bg-slate-950/30
                       backdrop-blur-[1px]"
            ></div>


            {{-- =================================================
                DETAIL PANEL
            ================================================== --}}

            <aside
                id="praktikIndustriPdfDetailPanel"
                class="absolute
                       right-0
                       top-0
                       z-40
                       h-full
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
                       ease-out"
            >

                {{-- =========================================
                    DETAIL HEADER
                ========================================== --}}

                <div
                    class="sticky
                           top-0
                           z-10
                           flex
                           h-24
                           items-center
                           justify-between
                           border-b
                           border-slate-200
                           bg-white
                           px-6"
                >

                    <div>

                        <p
                            class="text-[11px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400"
                        >
                            Informasi Dokumen
                        </p>

                        <h3
                            class="mt-1
                                   text-lg
                                   font-semibold
                                   text-slate-800"
                        >
                            Detail Laporan
                        </h3>

                    </div>


                    {{-- CLOSE DETAIL --}}

                    <button
                        id="praktikIndustriPdfDetailClose"
                        type="button"
                        aria-label="Tutup detail"
                        class="flex
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
                               active:scale-95"
                    >

                        <span
                            class="material-symbols-outlined text-[26px]"
                        >
                            close
                        </span>

                    </button>

                </div>


                {{-- =========================================
                    DETAIL BODY
                ========================================== --}}

                <div
                    class="px-6
                           py-7"
                >

                    {{-- JUDUL --}}

                    <section>

                        <p
                            class="text-[11px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400"
                        >
                            Judul Laporan
                        </p>

                        <p
                            id="praktikIndustriPdfDetailJudul"
                            class="mt-3
                                   break-words
                                   text-base
                                   font-medium
                                   leading-7
                                   text-slate-700"
                        >
                            -
                        </p>

                    </section>


                    <div
                        class="my-7
                               border-t
                               border-slate-100"
                    ></div>


                    {{-- INDUSTRI --}}

                    <section>

                        <p
                            class="text-[11px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400"
                        >
                            Industri
                        </p>

                        <p
                            id="praktikIndustriPdfDetailIndustri"
                            class="mt-3
                                   break-words
                                   text-base
                                   font-semibold
                                   leading-7
                                   text-slate-800"
                        >
                            -
                        </p>

                    </section>


                    <div
                        class="my-7
                               border-t
                               border-slate-100"
                    ></div>


                    {{-- KETUA --}}

                    <section>

                        <p
                            class="text-[11px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400"
                        >
                            Ketua Tim
                        </p>

                        <p
                            id="praktikIndustriPdfDetailKetua"
                            class="mt-3
                                   break-words
                                   text-base
                                   font-medium
                                   text-slate-700"
                        >
                            -
                        </p>

                    </section>


                    <div
                        class="my-7
                               border-t
                               border-slate-100"
                    ></div>


                    {{-- TERAKHIR DIPERBARUI --}}

                    <section>

                        <p
                            class="text-[11px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400"
                        >
                            Terakhir Diperbarui
                        </p>

                        <div
                            class="mt-3
                                   inline-flex
                                   items-center
                                   rounded-xl
                                   bg-slate-100
                                   px-4
                                   py-2.5"
                        >

                            <span
                                id="praktikIndustriPdfDetailUpdated"
                                class="text-sm
                                       font-semibold
                                       text-slate-700"
                            >
                                -
                            </span>

                        </div>

                    </section>


                    {{-- INFO --}}

                    <div
                        class="mt-8
                               rounded-2xl
                               bg-slate-50
                               px-5
                               py-5"
                    >

                        <div
                            class="flex
                                   items-start
                                   gap-4"
                        >

                            <span
                                class="material-symbols-outlined
                                       shrink-0
                                       text-[24px]
                                       text-slate-400"
                            >
                                info
                            </span>

                            <p
                                class="text-sm
                                       leading-6
                                       text-slate-500"
                            >
                                Informasi ini mengikuti data laporan
                                yang tersedia pada repository.
                            </p>

                        </div>

                    </div>

                </div>

            </aside>

        </main>

    </div>

</div>