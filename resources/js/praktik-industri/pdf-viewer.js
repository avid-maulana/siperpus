/*
|--------------------------------------------------------------------------
| PDF VIEWER PRAKTIK INDUSTRI
|--------------------------------------------------------------------------
| PDF.js
| Fullscreen
| Read Only
| No Browser PDF Toolbar
| Detail Panel
| Zoom In/Out
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

    const modal = document.getElementById("praktikIndustriPdfModal");

    const modalContent = document.getElementById(
        "praktikIndustriPdfModalContent",
    );

    const backdrop = document.getElementById("praktikIndustriPdfBackdrop");

    const closeButton = document.getElementById("praktikIndustriPdfClose");

    /*
    |--------------------------------------------------------------------------
    | PDF
    |--------------------------------------------------------------------------
    */

    const viewer = document.getElementById("praktikIndustriPdfViewer");

    const pagesContainer = document.getElementById("praktikIndustriPdfPages");

    const loading = document.getElementById("praktikIndustriPdfLoading");

    const error = document.getElementById("praktikIndustriPdfError");

    const errorMessage = document.getElementById(
        "praktikIndustriPdfErrorMessage",
    );

    /*
    |--------------------------------------------------------------------------
    | TITLE
    |--------------------------------------------------------------------------
    */

    const title = document.getElementById("praktikIndustriPdfTitle");

    /*
    |--------------------------------------------------------------------------
    | ZOOM
    |--------------------------------------------------------------------------
    */

    const zoomOutButton = document.getElementById("praktikIndustriPdfZoomOut");

    const zoomInButton = document.getElementById("praktikIndustriPdfZoomIn");

    const zoomResetButton = document.getElementById(
        "praktikIndustriPdfZoomReset",
    );

    const zoomLabel = document.getElementById("praktikIndustriPdfZoomLabel");

    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */

    const detailToggle = document.getElementById(
        "praktikIndustriPdfDetailToggle",
    );

    const detailPanel = document.getElementById(
        "praktikIndustriPdfDetailPanel",
    );

    const detailClose = document.getElementById(
        "praktikIndustriPdfDetailClose",
    );

    const detailBackdrop = document.getElementById(
        "praktikIndustriPdfDetailBackdrop",
    );

    const detailJudul = document.getElementById(
        "praktikIndustriPdfDetailJudul",
    );

    const detailIndustri = document.getElementById(
        "praktikIndustriPdfDetailIndustri",
    );

    const detailKetua = document.getElementById(
        "praktikIndustriPdfDetailKetua",
    );

    const detailUpdated = document.getElementById(
        "praktikIndustriPdfDetailUpdated",
    );

    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    if (!modal || !modalContent || !pagesContainer) {
        console.warn(
            "PDF Viewer Praktik Industri: element utama tidak ditemukan.",
        );

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
    | CURRENT PDF
    |--------------------------------------------------------------------------
    */

    let currentPdf = null;

    let currentLoadingTask = null;

    let isClosing = false;

    let isZooming = false;

    /*
    |--------------------------------------------------------------------------
    | ZOOM STATE
    |--------------------------------------------------------------------------
    */

    const ZOOM_MIN = 0.5;

    const ZOOM_MAX = 2.5;

    const ZOOM_STEP = 0.15;

    const ZOOM_DEFAULT = 0.5;

    let currentZoom = ZOOM_DEFAULT;

    /*
    |--------------------------------------------------------------------------
    | BUILD FETCH URL (VIA PROXY UNTUK DOMAIN EKSTERNAL)
    |--------------------------------------------------------------------------
    |
    | File laporan Praktik Industri biasanya disimpan lokal
    | (storage Laravel, satu origin dengan halaman ini), jadi
    | umumnya TIDAK perlu proxy.
    |
    | Tapi kalau suatu saat file disimpan di domain lain
    | (seperti kasus SISINTA di skripsi) dan server itu tidak
    | mengizinkan CORS, proxy otomatis dipakai lewat
    | route('pdf.proxy') supaya tetap bisa dimuat.
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
                "PDF Viewer Praktik Industri: gagal parse URL, fallback ke proxy.",
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
        if (currentLoadingTask) {
            try {
                await currentLoadingTask.destroy();
            } catch (e) {
                console.warn("PDF loading task:", e);
            }

            currentLoadingTask = null;
        }

        if (currentPdf) {
            try {
                await currentPdf.destroy();
            } catch (e) {
                console.warn("PDF document:", e);
            }

            currentPdf = null;
        }

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
        const judul = button.dataset.judul || "-";

        const industri = button.dataset.industri || "-";

        const ketua = button.dataset.ketua || "-";

        const updated = button.dataset.updated || "-";

        if (title) {
            title.textContent = judul;
        }

        if (detailJudul) {
            detailJudul.textContent = judul;
        }

        if (detailIndustri) {
            detailIndustri.textContent = industri;
        }

        if (detailKetua) {
            detailKetua.textContent = ketua;
        }

        if (detailUpdated) {
            detailUpdated.textContent = updated;
        }
    };

    /*
    |--------------------------------------------------------------------------
    | RESET / OPEN / CLOSE / TOGGLE DETAIL
    |--------------------------------------------------------------------------
    */

    const resetDetail = () => {
        detailPanel?.classList.remove("translate-x-0");

        detailPanel?.classList.add("translate-x-full");

        detailBackdrop?.classList.add("hidden");

        detailToggle?.setAttribute("aria-expanded", "false");
    };

    const openDetail = () => {
        if (!detailPanel) {
            return;
        }

        detailPanel.classList.remove("translate-x-full");

        detailPanel.classList.add("translate-x-0");

        detailBackdrop?.classList.remove("hidden");

        detailToggle?.setAttribute("aria-expanded", "true");
    };

    const closeDetail = () => {
        if (!detailPanel) {
            return;
        }

        detailPanel.classList.remove("translate-x-0");

        detailPanel.classList.add("translate-x-full");

        detailBackdrop?.classList.add("hidden");

        detailToggle?.setAttribute("aria-expanded", "false");
    };

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
    | ANIMATE OPEN / CLOSE
    |--------------------------------------------------------------------------
    */

    const animateOpen = () => {
        modal.classList.remove("hidden");

        modal.classList.remove("opacity-100");

        modal.classList.add("opacity-0");

        modalContent.classList.remove("translate-y-0", "scale-100");

        modalContent.classList.add("translate-y-2", "scale-[0.99]");

        void modal.offsetWidth;

        requestAnimationFrame(() => {
            modal.classList.remove("opacity-0");

            modal.classList.add("opacity-100");

            modalContent.classList.remove("translate-y-2", "scale-[0.99]");

            modalContent.classList.add("translate-y-0", "scale-100");
        });
    };

    const animateClose = (callback) => {
        modalContent.classList.remove("translate-y-0", "scale-100");

        modalContent.classList.add("translate-y-2", "scale-[0.99]");

        modal.classList.remove("opacity-100");

        modal.classList.add("opacity-0");

        window.setTimeout(callback, 300);
    };

    /*
    |--------------------------------------------------------------------------
    | RENDER SINGLE PAGE
    |--------------------------------------------------------------------------
    */

    const renderPage = async (pdf, pageNumber) => {
        const page = await pdf.getPage(pageNumber);

        const viewport = page.getViewport({
            scale: 1,
        });

        const viewerWidth = viewer?.clientWidth || window.innerWidth;

        const horizontalPadding = window.innerWidth < 640 ? 24 : 48;

        const availableWidth = Math.max(viewerWidth - horizontalPadding, 300);

        /*
        |--------------------------------------------------------------------------
        | SCALE (fit-lebar otomatis x currentZoom)
        |--------------------------------------------------------------------------
        */

        const scale = (availableWidth / viewport.width) * currentZoom;

        const finalViewport = page.getViewport({
            scale,
        });

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

        const canvas = document.createElement("canvas");

        const context = canvas.getContext("2d", {
            alpha: false,
        });

        const outputScale = Math.min(window.devicePixelRatio || 1, 2);

        canvas.width = Math.floor(finalViewport.width * outputScale);

        canvas.height = Math.floor(finalViewport.height * outputScale);

        canvas.style.width = `${finalViewport.width}px`;

        canvas.style.height = `${finalViewport.height}px`;

        canvas.className = "block";

        const transform =
            outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] : null;

        pageWrapper.appendChild(canvas);

        pagesContainer.appendChild(pageWrapper);

        await page.render({
            canvasContext: context,
            viewport: finalViewport,
            transform,
        }).promise;

        page.cleanup();
    };

    /*
    |--------------------------------------------------------------------------
    | RENDER SEMUA HALAMAN
    |--------------------------------------------------------------------------
    |
    | Dipisah dari renderPdf supaya bisa dipakai ulang saat zoom
    | berubah, tanpa perlu fetch ulang dokumen dari server.
    |
    */

    const renderAllPages = async (pdf) => {
        clearPages();

        for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
            if (isClosing) {
                return;
            }

            await renderPage(pdf, pageNumber);
        }
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
    | APPLY ZOOM (RE-RENDER TANPA FETCH ULANG PDF)
    |--------------------------------------------------------------------------
    |
    | Posisi scroll (rasio) disimpan dulu sebelum re-render,
    | lalu dipulihkan setelahnya, supaya halaman yang sedang
    | dibaca tidak "loncat" saat zoom berubah.
    |
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
    | RENDER PDF (LOAD AWAL)
    |--------------------------------------------------------------------------
    */

    const renderPdf = async (pdfUrl) => {
        try {
            await clearPdf();

            currentLoadingTask = pdfjsLib.getDocument({
                url: pdfUrl,
                withCredentials: false,
                disableRange: false,
                disableStream: false,
            });

            currentPdf = await currentLoadingTask.promise;

            currentLoadingTask = null;

            console.log("Jumlah halaman PDF:", currentPdf.numPages);

            await renderAllPages(currentPdf);

            if (isClosing) {
                return;
            }

            updateZoomUI();

            hideLoading();

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

        const filePath = button.dataset.pdfPath;

        if (!filePath) {
            console.error(
                "PDF Viewer Praktik Industri: data-pdf-path tidak ditemukan.",
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | RESET ZOOM SETIAP BUKA LAPORAN BARU
        |--------------------------------------------------------------------------
        */

        currentZoom = ZOOM_DEFAULT;

        updateZoomUI();

        setDetailData(button);

        resetDetail();

        resetViewer();

        const pdfUrl = String(filePath).trim();

        const fetchUrl = buildFetchUrl(pdfUrl);

        console.log("PDF PATH:", filePath);

        console.log("PDF URL (di-fetch):", fetchUrl);

        modal.setAttribute("aria-hidden", "false");

        document.body.classList.add("overflow-hidden");

        animateOpen();

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

        closeDetail();

        animateClose(async () => {
            modal.classList.add("hidden");

            modal.setAttribute("aria-hidden", "true");

            document.body.classList.remove("overflow-hidden");

            await clearPdf();

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
        const button = event.target.closest(
            "[data-praktik-industri-pdf-viewer]",
        );

        if (!button) {
            return;
        }

        event.preventDefault();

        event.stopPropagation();

        openPdf(button);
    });

    /*
    |--------------------------------------------------------------------------
    | ZOOM BUTTONS
    |--------------------------------------------------------------------------
    */

    zoomOutButton?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        applyZoom(currentZoom - ZOOM_STEP);
    });

    zoomInButton?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        applyZoom(currentZoom + ZOOM_STEP);
    });

    zoomResetButton?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        applyZoom(ZOOM_DEFAULT);
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

    detailClose?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        closeDetail();
    });

    detailBackdrop?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        closeDetail();
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

        if (detailPanel?.classList.contains("translate-x-0")) {
            closeDetail();

            return;
        }

        closePdf();
    });
});
