import * as pdfjsLib from "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf.min.mjs";

/*
|--------------------------------------------------------------------------
| PDF.js Worker
|--------------------------------------------------------------------------
*/

pdfjsLib.GlobalWorkerOptions.workerSrc =
    "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf.worker.min.mjs";


/*
|--------------------------------------------------------------------------
| Jalankan hanya jika PDF Viewer tersedia
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const pdfConfig =
        document.getElementById("pdf-config");

    const pdfContainer =
        document.getElementById("pdf-container");

    const pdfLoading =
        document.getElementById("pdf-loading");

    const pdfError =
        document.getElementById("pdf-error");


    /*
    |--------------------------------------------------------------------------
    | Pastikan halaman PDF Viewer
    |--------------------------------------------------------------------------
    */

    if (!pdfConfig || !pdfContainer) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Ambil konfigurasi dari Blade
    |--------------------------------------------------------------------------
    */

    const pdfUrl =
        pdfConfig.dataset.pdfUrl || "";

    const sourceUrl =
        pdfConfig.dataset.sourceUrl || "";

    const title =
        pdfConfig.dataset.title || "Dokumen";


    /*
    |--------------------------------------------------------------------------
    | Helper - Error
    |--------------------------------------------------------------------------
    */

    function showError(message = "PDF gagal dimuat.") {

        console.error(
            "PDF Viewer Error:",
            message
        );


        /*
        | Sembunyikan loading
        */

        if (pdfLoading) {

            pdfLoading.classList.add(
                "hidden"
            );
        }


        /*
        | Sembunyikan container PDF
        */

        if (pdfContainer) {

            pdfContainer.classList.add(
                "hidden"
            );
        }


        /*
        | Tampilkan error
        */

        if (pdfError) {

            pdfError.classList.remove(
                "hidden"
            );

            pdfError.classList.add(
                "flex"
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Helper - Loading
    |--------------------------------------------------------------------------
    */

    function showLoading() {

        if (pdfLoading) {

            pdfLoading.classList.remove(
                "hidden"
            );

            pdfLoading.classList.add(
                "flex"
            );
        }


        if (pdfError) {

            pdfError.classList.add(
                "hidden"
            );

            pdfError.classList.remove(
                "flex"
            );
        }


        if (pdfContainer) {

            pdfContainer.classList.add(
                "hidden"
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Helper - Selesai Loading
    |--------------------------------------------------------------------------
    */

    function showPDF() {

        if (pdfLoading) {

            pdfLoading.classList.add(
                "hidden"
            );

            pdfLoading.classList.remove(
                "flex"
            );
        }


        if (pdfError) {

            pdfError.classList.add(
                "hidden"
            );

            pdfError.classList.remove(
                "flex"
            );
        }


        if (pdfContainer) {

            pdfContainer.classList.remove(
                "hidden"
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Validasi URL
    |--------------------------------------------------------------------------
    */

    if (!pdfUrl) {

        showError(
            "URL PDF tidak tersedia."
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Render PDF
    |--------------------------------------------------------------------------
    */

    async function renderPDF() {

        try {

            showLoading();


            /*
            |--------------------------------------------------------------------------
            | Load PDF
            |--------------------------------------------------------------------------
            */

            const loadingTask =
                pdfjsLib.getDocument({
                    url: pdfUrl,
                });


            const pdf =
                await loadingTask.promise;


            /*
            |--------------------------------------------------------------------------
            | Pastikan PDF memiliki halaman
            |--------------------------------------------------------------------------
            */

            if (
                !pdf ||
                !pdf.numPages
            ) {

                throw new Error(
                    "Dokumen PDF tidak memiliki halaman."
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Bersihkan container
            |--------------------------------------------------------------------------
            */

            pdfContainer.innerHTML = "";


            /*
            |--------------------------------------------------------------------------
            | Render setiap halaman
            |--------------------------------------------------------------------------
            */

            for (
                let pageNumber = 1;

                pageNumber <= pdf.numPages;

                pageNumber++
            ) {

                const page =
                    await pdf.getPage(
                        pageNumber
                    );


                /*
                |--------------------------------------------------------------------------
                | Ukuran asli halaman
                |--------------------------------------------------------------------------
                */

                const originalViewport =
                    page.getViewport({
                        scale: 1,
                    });


                /*
                |--------------------------------------------------------------------------
                | Area PDF
                |--------------------------------------------------------------------------
                */

                const pdfSection =
                    pdfContainer.parentElement;


                const availableWidth =
                    pdfSection
                        ? pdfSection.clientWidth - 56
                        : window.innerWidth - 56;


                /*
                |--------------------------------------------------------------------------
                | Maksimal lebar PDF
                |--------------------------------------------------------------------------
                */

                const maxWidth =
                    Math.min(
                        900,
                        Math.max(
                            300,
                            availableWidth
                        )
                    );


                /*
                |--------------------------------------------------------------------------
                | Hitung scale
                |--------------------------------------------------------------------------
                */

                const scale =
                    maxWidth /
                    originalViewport.width;


                const viewport =
                    page.getViewport({
                        scale,
                    });


                /*
                |--------------------------------------------------------------------------
                | Canvas
                |--------------------------------------------------------------------------
                */

                const canvas =
                    document.createElement(
                        "canvas"
                    );


                canvas.className =
                    "pdf-page";


                /*
                |--------------------------------------------------------------------------
                | Context
                |--------------------------------------------------------------------------
                */

                const context =
                    canvas.getContext(
                        "2d"
                    );


                if (!context) {

                    throw new Error(
                        "Canvas PDF tidak dapat dibuat."
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Device Pixel Ratio
                |--------------------------------------------------------------------------
                */

                const pixelRatio =
                    window.devicePixelRatio || 1;


                /*
                |--------------------------------------------------------------------------
                | Canvas Resolution
                |--------------------------------------------------------------------------
                */

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


                /*
                |--------------------------------------------------------------------------
                | Ukuran tampilan
                |--------------------------------------------------------------------------
                */

                canvas.style.width =
                    `${viewport.width}px`;

                canvas.style.height =
                    `${viewport.height}px`;


                /*
                |--------------------------------------------------------------------------
                | Render halaman
                |--------------------------------------------------------------------------
                */

                await page.render({

                    canvasContext:
                        context,

                    viewport:
                        viewport,

                    transform: [
                        pixelRatio,
                        0,
                        0,
                        pixelRatio,
                        0,
                        0,
                    ],

                }).promise;


                /*
                |--------------------------------------------------------------------------
                | Tambahkan canvas ke halaman
                |--------------------------------------------------------------------------
                */

                pdfContainer.appendChild(
                    canvas
                );
            }


            /*
            |--------------------------------------------------------------------------
            | PDF berhasil
            |--------------------------------------------------------------------------
            */

            showPDF();


            /*
            |--------------------------------------------------------------------------
            | Log informasi
            |--------------------------------------------------------------------------
            */

            console.log(
                `PDF berhasil dimuat: ${title}`
            );

            console.log(
                `Jumlah halaman: ${pdf.numPages}`
            );


        } catch (error) {

            console.error(
                "Gagal memuat PDF:",
                error
            );


            showError(
                error?.message ||
                "PDF gagal dimuat."
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Jalankan PDF Viewer
    |--------------------------------------------------------------------------
    */

    renderPDF();


    /*
    |--------------------------------------------------------------------------
    | Responsive Re-render
    |--------------------------------------------------------------------------
    |
    | Ketika ukuran browser berubah, PDF perlu dirender ulang
    | supaya ukurannya tetap sesuai container.
    |
    */

    let resizeTimer = null;

    window.addEventListener(
        "resize",
        () => {

            clearTimeout(
                resizeTimer
            );


            resizeTimer =
                setTimeout(
                    () => {

                        renderPDF();

                    },
                    250
                );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Simpan source URL untuk debugging
    |--------------------------------------------------------------------------
    */

    if (sourceUrl) {

        console.log(
            "Repository source:",
            sourceUrl
        );
    }

});