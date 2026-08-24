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
        /* =========================================================
           PDF CONTAINER
        ========================================================== */

        #pdf-container {

            display: flex;

            flex-direction: column;

            align-items: center;

            gap: 20px;

            width: 100%;

            padding: 28px;
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


        /* =========================================================
           RESPONSIVE
        ========================================================== */

        @media (max-width: 1023px) {

            .info-sidebar {

                position: relative !important;

                top: 0 !important;
            }
        }


        @media (max-width: 640px) {

            #pdf-container {

                padding: 12px;

                gap: 14px;
            }


            .pdf-page {

                width: 100%;
            }
        }
    </style>

</head>


<body
    class="min-h-screen
           bg-slate-100
           text-slate-800">


    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <header
        class="sticky
               top-0
               z-50
               border-b
               border-slate-200
               bg-white
               shadow-sm">

        <div
            class="mx-auto
                   flex
                   min-h-[72px]
                   max-w-[1600px]
                   items-center
                   gap-4
                   px-5
                   sm:px-7
                   lg:px-8">


            {{-- =================================================
                KEMBALI
            ================================================== --}}

            <button
                type="button"
                onclick="history.back()"
                class="group
                       inline-flex
                       shrink-0
                       items-center
                       gap-2
                       rounded-xl
                       bg-blue-600
                       px-4
                       py-2.5
                       text-sm
                       font-semibold
                       text-white
                       shadow-sm
                       transition-all
                       duration-200
                       hover:bg-blue-700
                       hover:shadow-md
                       active:scale-[0.97]">


                <svg
                    class="h-5 w-5
                           transition-transform
                           duration-200
                           group-hover:-translate-x-0.5"
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


            {{-- =================================================
                INFORMASI DOKUMEN
            ================================================== --}}

            <div
                class="min-w-0">


                <div
                    class="text-[10px]
                           font-semibold
                           uppercase
                           tracking-[0.18em]
                           text-slate-400">

                    PDF VIEWER

                </div>


                <h1
                    class="mt-0.5
                           truncate
                           text-lg
                           font-semibold
                           text-slate-800">

                    {{ request('bab', request('title', 'Dokumen')) }}

                </h1>

            </div>

        </div>

    </header>



    {{-- =========================================================
        MAIN
    ========================================================== --}}

    <main
        class="mx-auto
               max-w-[1600px]
               px-4
               py-5
               sm:px-6
               lg:px-8">


        <div
            class="grid
                   items-start
                   gap-5
                   lg:grid-cols-[350px_minmax(0,1fr)]">


            {{-- =================================================
                SIDEBAR
            ================================================== --}}

            <aside
                class="info-sidebar
                       lg:sticky
                       lg:top-[92px]">


                <div
                    class="overflow-hidden
                           rounded-2xl
                           border
                           border-slate-200
                           bg-white
                           shadow-sm">


                    {{-- =================================================
                        SIDEBAR HEADER
                    ================================================== --}}

                    <div
                        class="relative
                               overflow-hidden
                               bg-[#212A37]
                               px-6
                               py-6">


                        <div
                            class="pointer-events-none
                                   absolute
                                   -right-16
                                   -top-16
                                   h-40
                                   w-40
                                   rounded-full
                                   bg-white/[0.05]
                                   blur-3xl">
                        </div>


                        <div
                            class="relative">


                            <div
                                class="flex
                                       items-center
                                       gap-2">


                                <svg
                                    class="h-5 w-5
                                           text-white/70"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 9.5L12 5l9 4.5-9 4.5L3 9.5Z" />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6.5 11.5V15c0 1.7 2.5 3 5.5 3s5.5-1.3 5.5-3v-3.5" />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 10v5" />

                                </svg>


                                <span
                                    class="text-[11px]
                                           font-semibold
                                           uppercase
                                           text-white/70">

                                    Informasi Skripsi

                                </span>

                            </div>


                            <p
                                class="mt-2
                                       text-xs
                                       leading-relaxed
                                       text-white/45">

                                Informasi dokumen yang sedang kamu baca.

                            </p>

                        </div>

                    </div>



                    {{-- =================================================
                        SIDEBAR CONTENT
                    ================================================== --}}

                    <div
                        class="p-6">


                        {{-- =================================================
                            NAMA
                        ================================================== --}}

                        <div
                            class="flex
                                   items-start
                                   gap-3">


                            <div
                                class="flex
                                       h-10
                                       w-10
                                       shrink-0
                                       items-center
                                       justify-center
                                       rounded-xl
                                       bg-slate-100
                                       text-slate-500
                                       ring-1
                                       ring-inset
                                       ring-slate-200">


                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <circle
                                        cx="12"
                                        cy="8"
                                        r="3.5" />

                                    <path
                                        stroke-linecap="round"
                                        d="M5 20c.7-3.5 3.2-5.5 7-5.5s6.3 2 7 5.5" />

                                </svg>

                            </div>


                            <div
                                class="min-w-0
                                       flex-1">

                                <div
                                    class="text-[10px]
                                           font-semibold
                                           uppercase
                                           text-slate-400">

                                    Nama Mahasiswa

                                </div>


                                <div
                                    class="mt-1
                                           break-words
                                           text-sm
                                           font-semibold
                                           leading-relaxed
                                           text-slate-700">

                                    {{ request('nama', '-') }}

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            NIM
                        ================================================== --}}

                        <div
                            class="mt-6
                                   flex
                                   items-start
                                   gap-3">


                            <div
                                class="flex
                                       h-10
                                       w-10
                                       shrink-0
                                       items-center
                                       justify-center
                                       rounded-xl
                                       bg-slate-100
                                       text-slate-500
                                       ring-1
                                       ring-inset
                                       ring-slate-200">


                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <rect
                                        x="5"
                                        y="3.5"
                                        width="14"
                                        height="17"
                                        rx="2" />

                                    <path
                                        stroke-linecap="round"
                                        d="M9 8h6M9 12h6M9 16h3" />

                                </svg>

                            </div>


                            <div
                                class="min-w-0
                                       flex-1">


                                <div
                                    class="text-[10px]
                                           font-semibold
                                           uppercase
                                           text-slate-400">

                                    NIM

                                </div>


                                <div
                                    class="mt-1
                                           break-words
                                           text-sm
                                           font-semibold
                                           leading-relaxed
                                           text-slate-700">

                                    {{ request('nim', '-') }}

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            JUDUL
                        ================================================== --}}

                        <div
                            class="mt-6
                                   flex
                                   items-start
                                   gap-3">


                            <div
                                class="flex
                                       h-10
                                       w-10
                                       shrink-0
                                       items-center
                                       justify-center
                                       rounded-xl
                                       bg-slate-100
                                       text-slate-500
                                       ring-1
                                       ring-inset
                                       ring-slate-200">


                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 4.5A2.5 2.5 0 017.5 2H19v17H7.5A2.5 2.5 0 005 21.5v-17Z" />

                                    <path
                                        stroke-linecap="round"
                                        d="M5 19.5A2.5 2.5 0 017.5 17H19" />

                                </svg>

                            </div>


                            <div
                                class="min-w-0
                                       flex-1">


                                <div
                                    class="text-[10px]
                                           font-semibold
                                           uppercase
                                           text-slate-400">

                                    Judul Skripsi

                                </div>


                                <div
                                    class="mt-1
                                           break-words
                                           text-sm
                                           font-semibold
                                           leading-relaxed
                                           text-slate-700">

                                    {{ request('skripsi', '-') }}

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            BAGIAN
                        ================================================== --}}

                        <div
                            class="mt-6
                                   flex
                                   items-start
                                   gap-3">


                            <div
                                class="flex
                                       h-10
                                       w-10
                                       shrink-0
                                       items-center
                                       justify-center
                                       rounded-xl
                                       bg-blue-50
                                       text-blue-600
                                       ring-1
                                       ring-inset
                                       ring-blue-100">


                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 3.5h8l4 4V20.5H6V3.5Z" />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M14 3.5v4h4M9 12h6M9 15.5h6" />

                                </svg>

                            </div>


                            <div
                                class="min-w-0
                                       flex-1">


                                <div
                                    class="text-[10px]
                                           font-semibold
                                           uppercase
                                           tracking-[0.15em]
                                           text-slate-400">

                                    Bagian

                                </div>


                                <div
                                    class="mt-1">

                                    <span
                                        class="inline-flex
                                               items-center
                                               rounded-lg
                                               bg-blue-50
                                               px-2.5
                                               py-1
                                               text-xs
                                               font-semibold
                                               text-blue-700
                                               ring-1
                                               ring-inset
                                               ring-blue-100">

                                        {{ request('bab', request('title', '-')) }}

                                    </span>

                                </div>

                            </div>

                        </div>



                        {{-- =================================================
                            DIVIDER
                        ================================================== --}}

                        <div
                            class="my-6
                                   border-t
                                   border-slate-100">
                        </div>



                        {{-- =================================================
                            KEMBALI
                        ================================================== --}}

                        <button
                            type="button"
                            onclick="history.back()"
                            class="group
                                   flex
                                   w-full
                                   items-center
                                   justify-center
                                   gap-2
                                   rounded-xl
                                   border
                                   border-slate-200
                                   bg-white
                                   px-4
                                   py-3
                                   text-sm
                                   font-semibold
                                   text-slate-600
                                   transition-all
                                   duration-200
                                   hover:border-blue-600
                                   hover:bg-blue-600
                                   hover:text-white
                                   active:scale-[0.98]">


                            <svg
                                class="h-5 w-5
                                       transition-transform
                                       duration-200
                                       group-hover:-translate-x-0.5"
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

            </aside>



            {{-- =================================================
                PDF VIEWER
            ================================================== --}}

            <section
                class="min-w-0
                       overflow-hidden
                       rounded-2xl
                       border
                       border-slate-200
                       bg-slate-200
                       shadow-sm">


                {{-- =================================================
                    LOADING
                ================================================== --}}

                <div
                    id="pdf-loading"
                    class="flex
                           min-h-[calc(100vh-120px)]
                           items-center
                           justify-center">


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
                                   border-t-blue-600">
                        </div>


                        <p
                            class="mt-4
                                   text-sm
                                   font-medium
                                   text-slate-600">

                            Memuat PDF...

                        </p>

                    </div>

                </div>



                {{-- =================================================
                    PDF
                ================================================== --}}

                <main
                    id="pdf-container"
                    class="hidden">
                </main>



                {{-- =================================================
                    ERROR
                ================================================== --}}

                <div
                    id="pdf-error"
                    class="hidden
                           min-h-[calc(100vh-120px)]
                           items-center
                           justify-center
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


                        <h2
                            class="mt-5
                                   text-lg
                                   font-semibold
                                   text-slate-800">

                            PDF gagal dimuat

                        </h2>


                        <p
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

            </section>

        </div>

    </main>



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
        hidden>
    </div>

    @else

    <div
        id="pdf-config"
        data-pdf-url=""
        data-source-url=""
        data-title="{{ request('title', 'Dokumen') }}"
        hidden>
    </div>

    @endif

</body>

</html>