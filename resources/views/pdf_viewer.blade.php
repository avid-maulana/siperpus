<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>
        {{ request('title', 'PDF Viewer') }}
    </title>


    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])


    <style>
        html, body {
            height: 100%;
            overflow: hidden;
        }

        /* =========================================================
           PDF PAGES CONTAINER
        ========================================================== */

        #pdf-container {

            display: flex;

            flex-direction: column;

            align-items: center;

            gap: 20px;

            width: 100%;

            min-height: 100%;

            padding: 24px 16px 96px;
        }


        /* =========================================================
           PDF PAGE
        ========================================================== */

        .pdf-page {

            display: block;

            max-width: 100%;

            height: auto;

            background: white;

            box-shadow:
                0 3px 14px rgba(15, 23, 42, 0.14);
        }


        /* =========================================================
           SCROLLBAR
        ========================================================== */

        #pdf-container::-webkit-scrollbar {

            width: 8px;
        }


        #pdf-container::-webkit-scrollbar-track {

            background: transparent;
        }


        #pdf-container::-webkit-scrollbar-thumb {

            background: #cbd5e1;

            border-radius: 999px;
        }
    </style>

</head>


<body
    class="h-screen
           overflow-hidden
           bg-white
           text-slate-800">


    {{-- =========================================================
        VIEWER ROOT
        FULLSCREEN / READ ONLY / PDF.JS / DETAIL PANEL
    ========================================================== --}}

    <div
        id="pdfViewer"
        class="relative
               flex
               h-screen
               w-screen
               flex-col
               bg-white">


        {{-- =================================================
            NAVBAR
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
                   shadow-sm
                   sm:px-6">


            {{-- TITLE / BAB --}}

            <div
                class="min-w-0
                       flex-1
                       pr-4">

                <p
                    class="text-[10px]
                           font-semibold
                           uppercase
                           tracking-[0.16em]
                           text-slate-400">

                    Repository Tesis

                </p>

                <h2
                    id="pdfTitle"
                    class="mt-0.5
                           truncate
                           text-sm
                           font-semibold
                           text-slate-800
                           sm:text-base">

                    {{ request('bab', request('title', 'Dokumen')) }}

                </h2>

            </div>


            {{-- HEADER ACTIONS --}}

            <div
                class="flex
                       shrink-0
                       items-center
                       gap-2">


                {{-- DETAIL --}}

                <button
                    id="pdfDetailToggle"
                    type="button"
                    aria-label="Lihat detail tesis"
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
                           active:scale-95">

                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <circle
                            cx="12"
                            cy="12"
                            r="9" />

                        <path
                            stroke-linecap="round"
                            d="M12 11v5M12 8h.01" />

                    </svg>

                    <span
                        class="hidden sm:inline">

                        Detail

                    </span>

                </button>


                {{-- CLOSE / KEMBALI --}}

                <button
                    id="pdfClose"
                    type="button"
                    onclick="history.back()"
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
                           active:scale-95">

                    <svg
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 6l12 12M18 6L6 18" />

                    </svg>

                </button>

            </div>

        </header>



        {{-- =================================================
            PDF VIEWER AREA
        ================================================== --}}

        <main
            id="pdfViewerArea"
            class="relative
                   min-h-0
                   flex-1
                   overflow-auto
                   bg-slate-200">


            {{-- LOADING --}}

            <div
                id="pdf-loading"
                class="absolute
                       inset-0
                       z-20
                       flex
                       items-center
                       justify-center
                       bg-slate-100">


                <div
                    class="text-center">


                    <div
                        class="mx-auto
                               h-10
                               w-10
                               animate-spin
                               rounded-full
                               border-4
                               border-slate-300
                               border-t-slate-800">
                    </div>


                    <p
                        class="mt-4
                               text-sm
                               font-medium
                               text-slate-600">

                        Memuat dokumen...

                    </p>

                </div>

            </div>



            {{-- PDF PAGES --}}

            <div
                id="pdf-container">
            </div>



            {{-- ERROR --}}

            <div
                id="pdf-error"
                class="absolute
                       inset-0
                       z-20
                       hidden
                       items-center
                       justify-center
                       bg-slate-100
                       px-6">


                <div
                    class="max-w-sm
                           text-center">


                    <div
                        class="mx-auto
                               flex
                               h-14
                               w-14
                               items-center
                               justify-center
                               rounded-2xl
                               bg-red-50
                               text-red-500
                               ring-1
                               ring-inset
                               ring-red-100">


                        <svg
                            class="h-7 w-7"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8">

                            <circle
                                cx="12"
                                cy="12"
                                r="9" />

                            <path
                                stroke-linecap="round"
                                d="M12 8v4M12 16h.01" />

                        </svg>

                    </div>


                    <h3
                        class="mt-5
                               text-lg
                               font-semibold
                               text-slate-800">

                        PDF gagal dimuat

                    </h3>


                    <p
                        id="pdf-error-message"
                        class="mt-2
                               text-sm
                               leading-relaxed
                               text-slate-500">

                        Dokumen tidak dapat ditampilkan.
                        Silakan kembali dan coba buka dokumen kembali.

                    </p>


                    <button
                        type="button"
                        onclick="history.back()"
                        class="mt-5
                               inline-flex
                               items-center
                               gap-2
                               rounded-xl
                               bg-blue-600
                               px-4
                               py-2.5
                               text-sm
                               font-semibold
                               text-white
                               transition
                               hover:bg-blue-700
                               active:scale-[0.98]">


                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19l-7-7 7-7" />

                        </svg>


                        Kembali

                    </button>

                </div>

            </div>



            {{-- =================================================
                DETAIL BACKDROP
            ================================================== --}}

            <div
                id="pdfDetailBackdrop"
                class="fixed
                       inset-x-0
                       top-16
                       bottom-0
                       z-30
                       hidden
                       bg-slate-950/30
                       backdrop-blur-[1px]">
            </div>



            {{-- =================================================
                DETAIL PANEL
            ================================================== --}}

            <aside
                id="pdfDetailPanel"
                class="fixed
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
                           px-6">


                    <div>

                        <p
                            class="text-[11px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400">

                            Informasi Dokumen

                        </p>


                        <h3
                            class="mt-1
                                   text-lg
                                   font-semibold
                                   text-slate-800">

                            Detail Tesis

                        </h3>

                    </div>


                    <button
                        id="pdfDetailClose"
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
                               active:scale-95">

                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 6l12 12M18 6L6 18" />

                        </svg>

                    </button>

                </div>


                {{-- DETAIL BODY --}}

                <div
                    class="px-6
                           py-7">


                    {{-- NAMA --}}

                    <section>

                        <p
                            class="text-[11px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400">

                            Nama Mahasiswa

                        </p>

                        <p
                            id="pdfDetailAuthor"
                            class="mt-3
                                   break-words
                                   text-base
                                   font-semibold
                                   leading-7
                                   text-slate-800">

                            -

                        </p>

                    </section>


                    <div
                        class="my-7
                               border-t
                               border-slate-100">
                    </div>


                    {{-- NIM --}}

                    <section>

                        <p
                            class="text-[11px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400">

                            NIM

                        </p>

                        <p
                            id="pdfDetailNim"
                            class="mt-3
                                   break-words
                                   text-base
                                   font-medium
                                   text-slate-700">

                            -

                        </p>

                    </section>


                    <div
                        class="my-7
                               border-t
                               border-slate-100">
                    </div>


                    {{-- BAGIAN --}}

                    <section>

                        <p
                            class="text-[11px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400">

                            Bagian

                        </p>

                        <div
                            class="mt-3
                                   inline-flex
                                   items-center
                                   rounded-xl
                                   bg-slate-100
                                   px-4
                                   py-2.5">

                            <span
                                id="pdfDetailChapter"
                                class="text-sm
                                       font-semibold
                                       text-slate-700">

                                -

                            </span>

                        </div>

                    </section>


                    <div
                        class="my-7
                               border-t
                               border-slate-100">
                    </div>


                    {{-- JUDUL --}}

                    <section>

                        <p
                            class="text-[11px]
                                   font-semibold
                                   uppercase
                                   tracking-[0.16em]
                                   text-slate-400">

                            Judul Tesis

                        </p>

                        <p
                            id="pdfDetailTitle"
                            class="mt-3
                                   break-words
                                   text-base
                                   font-medium
                                   leading-7
                                   text-slate-700">

                            -

                        </p>

                    </section>


                    {{-- INFO --}}

                    <div
                        class="mt-8
                               rounded-2xl
                               bg-slate-50
                               px-5
                               py-5">

                        <div
                            class="flex
                                   items-start
                                   gap-4">

                            <svg
                                class="h-6 w-6
                                       shrink-0
                                       text-slate-400"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8">

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9" />

                                <path
                                    stroke-linecap="round"
                                    d="M12 11v5M12 8h.01" />

                            </svg>

                            <p
                                class="text-sm
                                       leading-6
                                       text-slate-500">

                                Informasi ini mengikuti data tesis
                                yang tersedia pada repository.

                            </p>

                        </div>

                    </div>

                </div>

            </aside>



            {{-- =================================================
                ZOOM CONTROLS
            ================================================== --}}

            <div
                id="pdfZoomControls"
                class="pointer-events-none
                       fixed
                       inset-x-0
                       bottom-5
                       z-20
                       flex
                       justify-center">

                <div
                    class="pointer-events-auto
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

                    <button
                        id="pdfZoomOut"
                        type="button"
                        aria-label="Perkecil"
                        class="flex h-9 w-9 items-center justify-center rounded-xl text-slate-500 transition-all duration-200 hover:bg-slate-100 hover:text-slate-800 active:scale-95 disabled:pointer-events-none disabled:opacity-40">

                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" d="M6 12h12" />
                        </svg>

                    </button>

                    <span
                        id="pdfZoomLabel"
                        class="min-w-[3.25rem] text-center text-xs font-semibold text-slate-600">

                        50%

                    </span>

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

    </div>



    {{-- =========================================================
        PDF CONFIG
    ========================================================== --}}

    @if($pdfPath)

    <div
        id="pdf-config"
        data-pdf-url="{{ route(
                'pdf.proxy',
                ['url' => $pdfPath]
            ) }}"
        data-source-url="{{ $pdfPath }}"
        data-title="{{ request('title', 'Dokumen') }}"
        data-nama="{{ request('nama', '-') }}"
        data-nim="{{ request('nim', '-') }}"
        data-bab="{{ request('bab', request('title', 'Dokumen')) }}"
        data-tesis="{{ request('tesis', request('skripsi', '-')) }}"
        hidden>
    </div>

    @else

    <div
        id="pdf-config"
        data-pdf-url=""
        data-source-url=""
        data-title="{{ request('title', 'Dokumen') }}"
        data-nama="{{ request('nama', '-') }}"
        data-nim="{{ request('nim', '-') }}"
        data-bab="{{ request('bab', request('title', 'Dokumen')) }}"
        data-tesis="{{ request('tesis', request('skripsi', '-')) }}"
        hidden>
    </div>

    @endif

</body>

</html>