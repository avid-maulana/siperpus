<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ request('title', 'PDF Viewer') }}</title>

    @vite(['resources/css/app.css'])

    <style>
        #pdf-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            padding: 24px;
        }

        .pdf-page {
            display: block;
            max-width: 100%;
            height: auto;
            background: white;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.15);
        }
    </style>
</head>

<body class="bg-slate-200">

    {{-- Header --}}
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white shadow-sm">

        <div class="flex min-h-16 items-center gap-4 px-6 py-3">

            {{-- Tombol Kembali --}}
            <button
                onclick="history.back()"
                class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7" />

                </svg>

                Kembali

            </button>

            {{-- Informasi Dokumen --}}
            <div class="min-w-0">

                {{-- BAB --}}
                <h1 class="text-base font-semibold text-slate-800">
                    {{ request('title', 'PDF Viewer') }}
                </h1>

                {{-- Judul Skripsi --}}
                @if(request('skripsi'))
                <p
                    class="mt-0.5 max-w-4xl truncate text-xs text-slate-500"
                    title="{{ request('skripsi') }}">

                    {{ request('skripsi') }}

                </p>
                @endif

            </div>

        </div>

    </header>

    {{-- Loading --}}
    <div
        id="pdf-loading"
        class="flex h-[calc(100vh-64px)] items-center justify-center">

        <div class="text-center">

            <div
                class="mx-auto h-10 w-10 animate-spin rounded-full border-4 border-slate-300 border-t-blue-600">
            </div>

            <p class="mt-4 text-sm font-medium text-slate-600">
                Memuat PDF...
            </p>

        </div>

    </div>

    {{-- PDF --}}
    <main
        id="pdf-container"
        class="hidden">
    </main>

    {{-- Error --}}
    <div
        id="pdf-error"
        class="hidden h-[calc(100vh-64px)] items-center justify-center">

        <div class="text-center">

            <h2 class="text-lg font-semibold text-slate-800">
                PDF gagal dimuat
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Dokumen tidak dapat ditampilkan.
            </p>

        </div>

    </div>

    {{-- PDF Config --}}
    <div
        id="pdf-config"
        data-pdf-url="{{ asset($pdfPath) }}"
        hidden>
    </div>

    {{-- PDF.js --}}
    <script type="module">
        import * as pdfjsLib
        from "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf.min.mjs";

        pdfjsLib.GlobalWorkerOptions.workerSrc =
            "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf.worker.min.mjs";

        const pdfConfig = document.getElementById("pdf-config");
        const pdfUrl = pdfConfig.dataset.pdfUrl;

        const container = document.getElementById("pdf-container");
        const loading = document.getElementById("pdf-loading");
        const error = document.getElementById("pdf-error");

        async function renderPDF() {

            try {

                const pdf =
                    await pdfjsLib.getDocument(pdfUrl).promise;

                /*
                |--------------------------------------------------------------------------
                | Render seluruh halaman
                |--------------------------------------------------------------------------
                */

                for (
                    let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++
                ) {

                    const page =
                        await pdf.getPage(pageNumber);

                    /*
                    |--------------------------------------------------------------------------
                    | Ukuran halaman
                    |--------------------------------------------------------------------------
                    */

                    const originalViewport =
                        page.getViewport({
                            scale: 1
                        });

                    /*
                    |--------------------------------------------------------------------------
                    | Lebar PDF
                    |--------------------------------------------------------------------------
                    |
                    | Maksimal 900px.
                    | Kalau layar lebih kecil akan menyesuaikan.
                    |
                    */

                    const maxWidth =
                        Math.min(
                            900,
                            window.innerWidth - 48
                        );

                    const scale =
                        maxWidth /
                        originalViewport.width;

                    const viewport =
                        page.getViewport({
                            scale: scale
                        });

                    /*
                    |--------------------------------------------------------------------------
                    | Canvas
                    |--------------------------------------------------------------------------
                    */

                    const canvas =
                        document.createElement("canvas");

                    canvas.className =
                        "pdf-page";

                    const context =
                        canvas.getContext("2d");

                    /*
                    |--------------------------------------------------------------------------
                    | High DPI
                    |--------------------------------------------------------------------------
                    */

                    const pixelRatio =
                        window.devicePixelRatio || 1;

                    canvas.width =
                        Math.floor(
                            viewport.width *
                            pixelRatio
                        );

                    canvas.height =
                        Math.floor(
                            viewport.height *
                            pixelRatio
                        );

                    canvas.style.width =
                        `${viewport.width}px`;

                    canvas.style.height =
                        `${viewport.height}px`;

                    /*
                    |--------------------------------------------------------------------------
                    | Render
                    |--------------------------------------------------------------------------
                    */

                    await page.render({

                        canvasContext: context,

                        viewport: viewport,

                        transform: [
                            pixelRatio,
                            0,
                            0,
                            pixelRatio,
                            0,
                            0
                        ]

                    }).promise;

                    container.appendChild(canvas);

                }

                /*
                |--------------------------------------------------------------------------
                | Tampilkan PDF
                |--------------------------------------------------------------------------
                */

                loading.classList.add("hidden");

                container.classList.remove("hidden");

            } catch (err) {

                console.error(
                    "PDF Viewer Error:",
                    err
                );

                loading.classList.add("hidden");

                error.classList.remove("hidden");

                error.classList.add("flex");

            }

        }

        renderPDF();
    </script>

</body>

</html>