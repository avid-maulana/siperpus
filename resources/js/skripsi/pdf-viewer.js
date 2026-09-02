/*
|--------------------------------------------------------------------------
| PDF VIEWER SKRIPSI
|--------------------------------------------------------------------------
| PDF.js
| Fullscreen
| Read Only
| No Browser PDF Toolbar
| Detail Panel
| Zoom Controls
|--------------------------------------------------------------------------
*/

import * as pdfjsLib from "pdfjs-dist";
import pdfWorker from "pdfjs-dist/build/pdf.worker.min.mjs?url";

pdfjsLib.GlobalWorkerOptions.workerSrc = pdfWorker;

/*
|--------------------------------------------------------------------------
| DOM READY
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {
    /*
    |--------------------------------------------------------------------------
    | MODAL
    |--------------------------------------------------------------------------
    */

    const modal = document.getElementById("skripsiPdfModal");

    const modalContent = document.getElementById("skripsiPdfModalContent");

    const backdrop = document.getElementById("skripsiPdfBackdrop");

    const closeButton = document.getElementById("skripsiPdfClose");

    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
    */

    const viewer = document.getElementById("skripsiPdfViewer");

    const pagesContainer = document.getElementById("skripsiPdfPages");

    const loading = document.getElementById("skripsiPdfLoading");

    const error = document.getElementById("skripsiPdfError");

    const errorMessage = document.getElementById("skripsiPdfErrorMessage");

    /*
    |--------------------------------------------------------------------------
    | TITLE
    |--------------------------------------------------------------------------
    */

    const title = document.getElementById("skripsiPdfTitle");

    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */

    const detailToggle = document.getElementById("skripsiPdfDetailToggle");

    const detailPanel = document.getElementById("skripsiPdfDetailPanel");

    const detailClose = document.getElementById("skripsiPdfDetailClose");

    const detailBackdrop = document.getElementById("skripsiPdfDetailBackdrop");

    const detailAuthor = document.getElementById("skripsiPdfDetailAuthor");

    const detailNim = document.getElementById("skripsiPdfDetailNim");

    const detailChapter = document.getElementById("skripsiPdfDetailChapter");

    const detailTitle = document.getElementById("skripsiPdfDetailTitle");

    /*
    |--------------------------------------------------------------------------
    | ZOOM CONTROLS
    |--------------------------------------------------------------------------
    */

    const zoomOutButton = document.getElementById("skripsiPdfZoomOut");

    const zoomInButton = document.getElementById("skripsiPdfZoomIn");

    const zoomResetButton = document.getElementById("skripsiPdfZoomReset");

    const zoomLabel = document.getElementById("skripsiPdfZoomLabel");

    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    if (!modal || !modalContent || !pagesContainer) {
        console.warn("PDF Viewer Skripsi: element utama tidak ditemukan.");

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | PINDAHKAN MODAL KE BODY
    |--------------------------------------------------------------------------
    */

    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    /*
    |--------------------------------------------------------------------------
    | SISINTA BASE URL
    |--------------------------------------------------------------------------
    */

    const sisintaFileUrl = (window.SISINTA_FILE_URL || "").replace(/\/+$/, "");

    /*
    |--------------------------------------------------------------------------
    | CURRENT PDF
    |--------------------------------------------------------------------------
    */

    let currentPdf = null;

    let currentLoadingTask = null;

    let isClosing = false;

    let isZooming = false;

    let currentZoom = 0.5;

    /*
    |--------------------------------------------------------------------------
    | ZOOM CONFIG
    |--------------------------------------------------------------------------
    */

    const ZOOM_MIN = 0.5;

    const ZOOM_MAX = 2.5;

    const ZOOM_STEP = 0.15;

    const ZOOM_DEFAULT = 0.5;

    /*
    |--------------------------------------------------------------------------
    | BUILD PDF URL
    |--------------------------------------------------------------------------
    */

    const buildPdfUrl = (filePath) => {
        const cleanPath = String(filePath || "").trim();

        if (!cleanPath) {
            throw new Error("Path PDF tidak ditemukan.");
        }

        /*
        |--------------------------------------------------------------------------
        | SUDAH URL LENGKAP
        |--------------------------------------------------------------------------
        */

        if (/^https?:\/\//i.test(cleanPath)) {
            return cleanPath;
        }

        /*
        |--------------------------------------------------------------------------
        | BASE URL
        |--------------------------------------------------------------------------
        */

        if (!sisintaFileUrl) {
            throw new Error("SISINTA_FILE_URL belum tersedia.");
        }

        /*
        |--------------------------------------------------------------------------
        | PATH RELATIF
        |--------------------------------------------------------------------------
        */

        return `${sisintaFileUrl}/` + cleanPath.replace(/^\/+/, "");
    };

    /*
    |--------------------------------------------------------------------------
    | BUILD FETCH URL (VIA PROXY UNTUK DOMAIN EKSTERNAL)
    |--------------------------------------------------------------------------
    |
    | Browser tidak bisa fetch() PDF langsung dari domain lain
    | (mis. tei.um.ac.id) kalau server itu tidak mengirim header
    | CORS (Access-Control-Allow-Origin). Ini bukan bug di server
    | dokumen, tapi memang aturan browser.
    |
    | Solusinya: request dilempar ke backend Laravel sendiri lewat
    | route('pdf.proxy'), backend yang fetch ke domain eksternal
    | (server-ke-server tidak kena CORS), lalu backend meneruskan
    | isi PDF-nya ke browser.
    |
    | Kalau URL-nya memang sudah 1 origin dengan halaman ini
    | (misalnya suatu saat file disimpan lokal di /storage),
    | proxy dilewati saja karena tidak perlu.
    |
    */

    const buildFetchUrl = (targetUrl) => {
        try {
            const target = new URL(targetUrl, window.location.origin);

            if (target.origin === window.location.origin) {
                return targetUrl;
            }
        } catch (e) {
            console.warn(
                "PDF Viewer Skripsi: gagal parse URL, fallback ke proxy.",
                e,
            );
        }

        return "/pdf-proxy?url=" + encodeURIComponent(targetUrl);
    };

    /*
    |--------------------------------------------------------------------------
    | SHOW LOADING
    |--------------------------------------------------------------------------
    */

    const showLoading = () => {
        loading?.classList.remove("hidden");

        loading?.classList.add("flex");
    };

    /*
    |--------------------------------------------------------------------------
    | HIDE LOADING
    |--------------------------------------------------------------------------
    */

    const hideLoading = () => {
        loading?.classList.add("hidden");

        loading?.classList.remove("flex");
    };

    /*
    |--------------------------------------------------------------------------
    | SHOW ERROR
    |--------------------------------------------------------------------------
    */

    const showError = (message) => {
        hideLoading();

        if (errorMessage) {
            errorMessage.textContent =
                message || "File PDF tidak dapat ditampilkan.";
        }

        error?.classList.remove("hidden");

        error?.classList.add("flex");
    };

    /*
    |--------------------------------------------------------------------------
    | HIDE ERROR
    |--------------------------------------------------------------------------
    */

    const hideError = () => {
        error?.classList.add("hidden");

        error?.classList.remove("flex");
    };

    /*
    |--------------------------------------------------------------------------
    | CLEAR PDF PAGES
    |--------------------------------------------------------------------------
    */

    const clearPages = () => {
        pagesContainer.innerHTML = "";
    };

    /*
    |--------------------------------------------------------------------------
    | CLEAR PDF
    |--------------------------------------------------------------------------
    */

    const clearPdf = async () => {
        /*
        |--------------------------------------------------------------------------
        | CANCEL LOADING TASK
        |--------------------------------------------------------------------------
        */

        if (currentLoadingTask) {
            try {
                await currentLoadingTask.destroy();
            } catch (e) {
                console.warn("PDF loading task:", e);
            }

            currentLoadingTask = null;
        }

        /*
        |--------------------------------------------------------------------------
        | DESTROY PDF DOCUMENT
        |--------------------------------------------------------------------------
        */

        if (currentPdf) {
            try {
                await currentPdf.destroy();
            } catch (e) {
                console.warn("PDF document:", e);
            }

            currentPdf = null;
        }

        /*
        |--------------------------------------------------------------------------
        | CLEAR CANVAS
        |--------------------------------------------------------------------------
        */

        clearPages();
    };

    /*
    |--------------------------------------------------------------------------
    | RESET VIEWER
    |--------------------------------------------------------------------------
    */

    const resetViewer = () => {
        clearPages();

        showLoading();

        hideError();
    };

    /*
    |--------------------------------------------------------------------------
    | SET DETAIL DATA
    |--------------------------------------------------------------------------
    */

    const setDetailData = (button) => {
        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */

        const nama =
            button.dataset.pdfNama || button.dataset.skripsiAuthor || "-";

        const nim = button.dataset.pdfNim || button.dataset.skripsiNim || "-";

        const bab =
            button.dataset.pdfTitle || button.dataset.skripsiChapter || "-";

        const judul =
            button.dataset.pdfSkripsi || button.dataset.skripsiTitle || "-";

        /*
        |--------------------------------------------------------------------------
        | HEADER TITLE
        |--------------------------------------------------------------------------
        */

        if (title) {
            title.textContent = bab;
        }

        /*
        |--------------------------------------------------------------------------
        | DETAIL
        |--------------------------------------------------------------------------
        */

        if (detailAuthor) {
            detailAuthor.textContent = nama;
        }

        if (detailNim) {
            detailNim.textContent = nim;
        }

        if (detailChapter) {
            detailChapter.textContent = bab;
        }

        if (detailTitle) {
            detailTitle.textContent = judul;
        }

        /*
        |--------------------------------------------------------------------------
        | DEBUG
        |--------------------------------------------------------------------------
        */

        console.log("DETAIL SKRIPSI:", {
            nama,
            nim,
            bab,
            judul,
        });
    };

    /*
    |--------------------------------------------------------------------------
    | RESET DETAIL
    |--------------------------------------------------------------------------
    */

    const resetDetail = () => {
        detailPanel?.classList.remove("translate-x-0");

        detailPanel?.classList.add("translate-x-full");

        detailBackdrop?.classList.add("hidden");

        detailToggle?.setAttribute("aria-expanded", "false");
    };

    /*
    |--------------------------------------------------------------------------
    | OPEN DETAIL
    |--------------------------------------------------------------------------
    */

    const openDetail = () => {
        if (!detailPanel) {
            return;
        }

        detailPanel.classList.remove("translate-x-full");

        detailPanel.classList.add("translate-x-0");

        detailBackdrop?.classList.remove("hidden");

        detailToggle?.setAttribute("aria-expanded", "true");
    };

    /*
    |--------------------------------------------------------------------------
    | CLOSE DETAIL
    |--------------------------------------------------------------------------
    */

    const closeDetail = () => {
        if (!detailPanel) {
            return;
        }

        detailPanel.classList.remove("translate-x-0");

        detailPanel.classList.add("translate-x-full");

        detailBackdrop?.classList.add("hidden");

        detailToggle?.setAttribute("aria-expanded", "false");
    };

    /*
    |--------------------------------------------------------------------------
    | TOGGLE DETAIL
    |--------------------------------------------------------------------------
    */

    const toggleDetail = () => {
        if (!detailPanel) {
            return;
        }

        const opened = detailPanel.classList.contains("translate-x-0");

        if (opened) {
            closeDetail();
        } else {
            openDetail();
        }
    };

    /*
    |--------------------------------------------------------------------------
    | ANIMATE OPEN
    |--------------------------------------------------------------------------
    */

    const animateOpen = () => {
        modal.classList.remove("hidden");

        /*
        |--------------------------------------------------------------------------
        | STATE AWAL
        |--------------------------------------------------------------------------
        */

        modal.classList.remove("opacity-100");

        modal.classList.add("opacity-0");

        modalContent.classList.remove("translate-y-0", "scale-100");

        modalContent.classList.add("translate-y-2", "scale-[0.99]");

        /*
        |--------------------------------------------------------------------------
        | FORCE REFLOW
        |--------------------------------------------------------------------------
        */

        void modal.offsetWidth;

        /*
        |--------------------------------------------------------------------------
        | ANIMATE
        |--------------------------------------------------------------------------
        */

        requestAnimationFrame(() => {
            modal.classList.remove("opacity-0");

            modal.classList.add("opacity-100");

            modalContent.classList.remove("translate-y-2", "scale-[0.99]");

            modalContent.classList.add("translate-y-0", "scale-100");
        });
    };

    /*
    |--------------------------------------------------------------------------
    | ANIMATE CLOSE
    |--------------------------------------------------------------------------
    */

    const animateClose = (callback) => {
        modalContent.classList.remove("translate-y-0", "scale-100");

        modalContent.classList.add("translate-y-2", "scale-[0.99]");

        modal.classList.remove("opacity-100");

        modal.classList.add("opacity-0");

        window.setTimeout(callback, 300);
    };

    /*
    |--------------------------------------------------------------------------
    | UPDATE ZOOM UI
    |--------------------------------------------------------------------------
    */

    const updateZoomUI = () => {
        if (zoomLabel) {
            zoomLabel.textContent = `${Math.round(currentZoom * 100)}%`;
        }

        if (zoomOutButton) {
            zoomOutButton.disabled = currentZoom <= ZOOM_MIN;

            zoomOutButton.classList.toggle(
                "opacity-40",
                currentZoom <= ZOOM_MIN,
            );
        }

        if (zoomInButton) {
            zoomInButton.disabled = currentZoom >= ZOOM_MAX;

            zoomInButton.classList.toggle(
                "opacity-40",
                currentZoom >= ZOOM_MAX,
            );
        }
    };

    /*
    |--------------------------------------------------------------------------
    | RENDER SINGLE PAGE
    |--------------------------------------------------------------------------
    */

    const renderPage = async (pdf, pageNumber) => {
        const page = await pdf.getPage(pageNumber);

        /*
        |--------------------------------------------------------------------------
        | DEFAULT VIEWPORT
        |--------------------------------------------------------------------------
        */

        const viewport = page.getViewport({
            scale: 1,
        });

        /*
        |--------------------------------------------------------------------------
        | CONTAINER WIDTH
        |--------------------------------------------------------------------------
        */

        const viewerWidth = viewer?.clientWidth || window.innerWidth;

        const horizontalPadding = window.innerWidth < 640 ? 24 : 48;

        const availableWidth = Math.max(viewerWidth - horizontalPadding, 300);

        /*
        |--------------------------------------------------------------------------
        | SCALE (FIT-TO-WIDTH x ZOOM USER)
        |--------------------------------------------------------------------------
        */

        const fitScale = availableWidth / viewport.width;

        const scale = fitScale * currentZoom;

        const finalViewport = page.getViewport({
            scale,
        });

        /*
        |--------------------------------------------------------------------------
        | PAGE WRAPPER
        |--------------------------------------------------------------------------
        */

        const pageWrapper = document.createElement("div");

        pageWrapper.className = [
            "relative",
            "overflow-hidden",
            "bg-white",
            "shadow-lg",
            "mx-auto",
        ].join(" ");

        pageWrapper.style.width = `${finalViewport.width}px`;

        pageWrapper.style.height = `${finalViewport.height}px`;

        /*
        |--------------------------------------------------------------------------
        | CANVAS
        |--------------------------------------------------------------------------
        */

        const canvas = document.createElement("canvas");

        const context = canvas.getContext("2d", {
            alpha: false,
        });

        /*
        |--------------------------------------------------------------------------
        | DEVICE PIXEL RATIO
        |--------------------------------------------------------------------------
        */

        const outputScale = Math.min(window.devicePixelRatio || 1, 2);

        canvas.width = Math.floor(finalViewport.width * outputScale);

        canvas.height = Math.floor(finalViewport.height * outputScale);

        canvas.style.width = `${finalViewport.width}px`;

        canvas.style.height = `${finalViewport.height}px`;

        canvas.className = "block";

        /*
        |--------------------------------------------------------------------------
        | HIGH DPI
        |--------------------------------------------------------------------------
        */

        const transform =
            outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] : null;

        /*
        |--------------------------------------------------------------------------
        | APPEND
        |--------------------------------------------------------------------------
        */

        pageWrapper.appendChild(canvas);

        pagesContainer.appendChild(pageWrapper);

        /*
        |--------------------------------------------------------------------------
        | RENDER
        |--------------------------------------------------------------------------
        */

        await page.render({
            canvasContext: context,
            viewport: finalViewport,
            transform,
        }).promise;

        /*
        |--------------------------------------------------------------------------
        | CLEAN PAGE
        |--------------------------------------------------------------------------
        */

        page.cleanup();
    };

    /*
    |--------------------------------------------------------------------------
    | RENDER ALL PAGES (DIPAKAI SAAT LOAD & SAAT ZOOM BERUBAH)
    |--------------------------------------------------------------------------
    */

    const renderAllPages = async (pdf) => {
        clearPages();

        for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
            /*
            |--------------------------------------------------------------------------
            | STOP IF CLOSING
            |--------------------------------------------------------------------------
            */

            if (isClosing) {
                return;
            }

            await renderPage(pdf, pageNumber);
        }
    };

    /*
    |--------------------------------------------------------------------------
    | APPLY ZOOM (RE-RENDER TANPA FETCH ULANG PDF)
    |--------------------------------------------------------------------------
    */

    const applyZoom = async (nextZoom) => {
        if (!currentPdf || isZooming) {
            return;
        }

        const clamped = Math.min(ZOOM_MAX, Math.max(ZOOM_MIN, nextZoom));

        if (clamped === currentZoom) {
            return;
        }

        isZooming = true;

        currentZoom = clamped;

        updateZoomUI();

        /*
        |--------------------------------------------------------------------------
        | SIMPAN RASIO SCROLL SUPAYA POSISI BACA TIDAK LONCAT
        |--------------------------------------------------------------------------
        */

        const scrollRatio =
            viewer && viewer.scrollHeight > 0
                ? viewer.scrollTop / viewer.scrollHeight
                : 0;

        await renderAllPages(currentPdf);

        if (viewer) {
            viewer.scrollTop = scrollRatio * viewer.scrollHeight;
        }

        isZooming = false;
    };

    /*
    |--------------------------------------------------------------------------
    | RENDER PDF
    |--------------------------------------------------------------------------
    */

    const renderPdf = async (pdfUrl) => {
        try {
            /*
            |--------------------------------------------------------------------------
            | CLEAR PREVIOUS
            |--------------------------------------------------------------------------
            */

            await clearPdf();

            /*
            |--------------------------------------------------------------------------
            | PDF.JS LOAD
            |--------------------------------------------------------------------------
            */

            currentLoadingTask = pdfjsLib.getDocument({
                url: pdfUrl,

                /*
                    |--------------------------------------------------------------------------
                    | CREDENTIALS
                    |--------------------------------------------------------------------------
                    */

                withCredentials: false,

                /*
                    |--------------------------------------------------------------------------
                    | RANGE REQUEST
                    |--------------------------------------------------------------------------
                    */

                disableRange: false,

                disableStream: false,
            });

            /*
            |--------------------------------------------------------------------------
            | GET DOCUMENT
            |--------------------------------------------------------------------------
            */

            currentPdf = await currentLoadingTask.promise;

            currentLoadingTask = null;

            /*
            |--------------------------------------------------------------------------
            | TOTAL PAGES
            |--------------------------------------------------------------------------
            */

            console.log("Jumlah halaman PDF:", currentPdf.numPages);

            /*
            |--------------------------------------------------------------------------
            | RENDER SEMUA HALAMAN
            |--------------------------------------------------------------------------
            */

            await renderAllPages(currentPdf);

            /*
            |--------------------------------------------------------------------------
            | HIDE LOADING
            |--------------------------------------------------------------------------
            */

            hideLoading();

            /*
            |--------------------------------------------------------------------------
            | SCROLL TOP
            |--------------------------------------------------------------------------
            */

            if (viewer) {
                viewer.scrollTop = 0;
            }
        } catch (err) {
            console.error("PDF.js error:", err);

            showError(
                "PDF tidak dapat dimuat. Periksa koneksi atau path file.",
            );
        }
    };

    /*
    |--------------------------------------------------------------------------
    | OPEN PDF
    |--------------------------------------------------------------------------
    */

    const openPdf = (button) => {
        isClosing = false;

        /*
        |--------------------------------------------------------------------------
        | RESET ZOOM SETIAP BUKA BAB BARU
        |--------------------------------------------------------------------------
        */

        currentZoom = ZOOM_DEFAULT;

        updateZoomUI();

        /*
        |--------------------------------------------------------------------------
        | PATH
        |--------------------------------------------------------------------------
        */

        const filePath = button.dataset.pdfPath;

        if (!filePath) {
            console.error("PDF Viewer Skripsi: data-pdf-path tidak ditemukan.");

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | DETAIL DATA
        |--------------------------------------------------------------------------
        */

        setDetailData(button);

        /*
        |--------------------------------------------------------------------------
        | CLOSE DETAIL
        |--------------------------------------------------------------------------
        */

        resetDetail();

        /*
        |--------------------------------------------------------------------------
        | RESET VIEWER
        |--------------------------------------------------------------------------
        */

        resetViewer();

        /*
        |--------------------------------------------------------------------------
        | BUILD URL
        |--------------------------------------------------------------------------
        */

        let pdfUrl;

        try {
            pdfUrl = buildPdfUrl(filePath);
        } catch (err) {
            console.error(err);

            showError(err.message);

            document.body.classList.add("overflow-hidden");

            modal.setAttribute("aria-hidden", "false");

            animateOpen();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | URL YANG DI-FETCH
        |--------------------------------------------------------------------------
        |
        | pdfUrl        -> URL asli dokumen (dipakai untuk log & debug).
        | fetchUrl      -> URL yang benar-benar di-fetch PDF.js.
        |                  Dialihkan lewat /pdf-proxy kalau pdfUrl beda
        |                  origin, supaya tidak kena CORS di browser.
        |
        */

        const fetchUrl = buildFetchUrl(pdfUrl);

        /*
        |--------------------------------------------------------------------------
        | DEBUG
        |--------------------------------------------------------------------------
        */

        console.log("PDF PATH:", filePath);

        console.log("PDF URL (asli):", pdfUrl);

        console.log("PDF URL (di-fetch):", fetchUrl);

        /*
        |--------------------------------------------------------------------------
        | MODAL
        |--------------------------------------------------------------------------
        */

        modal.setAttribute("aria-hidden", "false");

        /*
        |--------------------------------------------------------------------------
        | LOCK BODY
        |--------------------------------------------------------------------------
        */

        document.body.classList.add("overflow-hidden");

        /*
        |--------------------------------------------------------------------------
        | OPEN ANIMATION
        |--------------------------------------------------------------------------
        */

        animateOpen();

        /*
        |--------------------------------------------------------------------------
        | LOAD PDF.JS
        |--------------------------------------------------------------------------
        */

        renderPdf(fetchUrl);
    };

    /*
    |--------------------------------------------------------------------------
    | CLOSE PDF
    |--------------------------------------------------------------------------
    */

    const closePdf = () => {
        if (modal.classList.contains("hidden")) {
            return;
        }

        if (isClosing) {
            return;
        }

        isClosing = true;

        /*
        |--------------------------------------------------------------------------
        | CLOSE DETAIL
        |--------------------------------------------------------------------------
        */

        closeDetail();

        /*
        |--------------------------------------------------------------------------
        | ANIMATION
        |--------------------------------------------------------------------------
        */

        animateClose(async () => {
            /*
                |--------------------------------------------------------------------------
                | HIDE
                |--------------------------------------------------------------------------
                */

            modal.classList.add("hidden");

            modal.setAttribute("aria-hidden", "true");

            /*
                |--------------------------------------------------------------------------
                | UNLOCK BODY
                |--------------------------------------------------------------------------
                */

            document.body.classList.remove("overflow-hidden");

            /*
                |--------------------------------------------------------------------------
                | CLEAR PDF
                |--------------------------------------------------------------------------
                */

            await clearPdf();

            /*
                |--------------------------------------------------------------------------
                | RESET
                |--------------------------------------------------------------------------
                */

            resetViewer();

            isClosing = false;
        });
    };

    /*
    |--------------------------------------------------------------------------
    | OPEN BUTTON
    |--------------------------------------------------------------------------
    |
    | Event delegation supaya tetap bekerja
    | setelah AJAX pagination/filter.
    |
    */

    document.addEventListener("click", (event) => {
        const button = event.target.closest("[data-skripsi-pdf-viewer]");

        if (!button) {
            return;
        }

        event.preventDefault();

        event.stopPropagation();

        openPdf(button);
    });

    /*
    |--------------------------------------------------------------------------
    | DETAIL BUTTON
    |--------------------------------------------------------------------------
    */

    detailToggle?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        toggleDetail();
    });

    /*
    |--------------------------------------------------------------------------
    | DETAIL CLOSE
    |--------------------------------------------------------------------------
    */

    detailClose?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        closeDetail();
    });

    /*
    |--------------------------------------------------------------------------
    | DETAIL BACKDROP
    |--------------------------------------------------------------------------
    */

    detailBackdrop?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        closeDetail();
    });

    /*
    |--------------------------------------------------------------------------
    | ZOOM IN
    |--------------------------------------------------------------------------
    */

    zoomInButton?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        applyZoom(currentZoom + ZOOM_STEP);
    });

    /*
    |--------------------------------------------------------------------------
    | ZOOM OUT
    |--------------------------------------------------------------------------
    */

    zoomOutButton?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        applyZoom(currentZoom - ZOOM_STEP);
    });

    /*
    |--------------------------------------------------------------------------
    | ZOOM RESET
    |--------------------------------------------------------------------------
    */

    zoomResetButton?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        applyZoom(ZOOM_DEFAULT);
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL CLOSE
    |--------------------------------------------------------------------------
    */

    closeButton?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        closePdf();
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL BACKDROP
    |--------------------------------------------------------------------------
    */

    backdrop?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        closePdf();
    });

    /*
    |--------------------------------------------------------------------------
    | ESCAPE
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        if (modal.classList.contains("hidden")) {
            return;
        }

        /*
            |--------------------------------------------------------------------------
            | DETAIL TERBUKA
            |--------------------------------------------------------------------------
            */

        if (detailPanel?.classList.contains("translate-x-0")) {
            closeDetail();

            return;
        }

        /*
            |--------------------------------------------------------------------------
            | CLOSE MODAL
            |--------------------------------------------------------------------------
            */

        closePdf();
    });
});
