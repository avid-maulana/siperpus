{{-- =========================================================
    PDF VIEWER MODAL - SKRIPSI
========================================================= --}}

<div
    id="skripsiPdfModal"
    class="fixed inset-0 z-[99999] hidden"
    aria-hidden="true"
>

    {{-- BACKDROP --}}
    <div
        id="skripsiPdfBackdrop"
        class="absolute inset-0 bg-slate-950/70 backdrop-blur-md"
    ></div>


    {{-- CENTER CONTAINER --}}
    <div
        class="absolute inset-0
               flex items-center justify-center
               p-4 sm:p-6"
    >

        {{-- MODAL --}}
        <div
            class="relative
                   flex
                   h-[90vh]
                   w-full
                   max-w-6xl
                   flex-col
                   overflow-hidden
                   rounded-2xl
                   border
                   border-slate-200
                   bg-white
                   shadow-2xl"
        >

            {{-- =================================================
                HEADER
            ================================================== --}}

            <div
                class="flex
                       h-[64px]
                       shrink-0
                       items-center
                       justify-between
                       border-b
                       border-slate-200
                       bg-white
                       px-5"
            >

                <div class="min-w-0">

                    <p
                        class="text-[10px]
                               font-semibold
                               uppercase
                               tracking-[0.15em]
                               text-slate-400"
                    >
                        Repository Skripsi
                    </p>

                    <h2
                        id="skripsiPdfTitle"
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


                {{-- CLOSE --}}

                <button
                    id="skripsiPdfClose"
                    type="button"
                    aria-label="Tutup PDF"
                    class="ml-4
                           flex
                           h-9
                           w-9
                           shrink-0
                           items-center
                           justify-center
                           rounded-xl
                           text-slate-400
                           transition
                           hover:bg-slate-100
                           hover:text-slate-700
                           active:scale-95"
                >

                    <span
                        class="material-symbols-outlined text-[22px]"
                    >
                        close
                    </span>

                </button>

            </div>


            {{-- =================================================
                PDF CONTENT
            ================================================== --}}

            <div
                class="relative
                       min-h-0
                       flex-1
                       overflow-hidden
                       bg-slate-100"
            >

                {{-- LOADING --}}

                <div
                    id="skripsiPdfLoading"
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


                {{-- ERROR --}}

                <div
                    id="skripsiPdfError"
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

                            <span class="material-symbols-outlined">
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
                            class="mt-2
                                   text-sm
                                   leading-6
                                   text-slate-500"
                        >
                            File PDF tidak dapat ditampilkan.
                            Silakan coba lagi.
                        </p>

                    </div>

                </div>


                {{-- PDF --}}

                <iframe
                    id="skripsiPdfFrame"
                    title="PDF Skripsi"
                    class="block h-full w-full border-0"
                    src=""
                    loading="lazy"
                ></iframe>

            </div>

        </div>

    </div>

</div>