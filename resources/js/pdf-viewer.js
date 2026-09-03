/*
|--------------------------------------------------------------------------
| PDF VIEWER TESIS
|--------------------------------------------------------------------------
| PDF.js
| Fullscreen page (bukan modal)
| Read Only
| Floating header (title + Detail + Close)
| Sliding detail panel
| Floating zoom controls
|--------------------------------------------------------------------------
*/

import * as pdfjsLib from "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf.min.mjs";

pdfjsLib.GlobalWorkerOptions.workerSrc =
    "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.10.38/pdf.worker.min.mjs";


document.addEventListener("DOMContentLoaded", () => {

    /*
    |--------------------------------------------------------------------------
    | ELEMENTS
    |--------------------------------------------------------------------------
    */

    const pdfConfig = document.getElementById("pdf-config");

    const viewerArea = document.getElementById("pdfViewerArea");

    const pagesContainer = document.getElementById("pdf-container");

    const loading = document.getElementById("pdf-loading");

    const errorBox = document.getElementById("pdf-error");

    const errorMessage = document.getElementById("pdf-error-message");

    const title = document.getElementById("pdfTitle");

    const detailToggle = document.getElementById("pdfDetailToggle");

    const detailPanel = document.getElementById("pdfDetailPanel");

    const detailClose = document.getElementById("pdfDetailClose");

    const detailBackdrop = document.getElementById("pdfDetailBackdrop");

    const detailAuthor = document.getElementById("pdfDetailAuthor");

    const detailNim = document.getElementById("pdfDetailNim");

    const detailChapter = document.getElementById("pdfDetailChapter");

    const detailTitle = document.getElementById("pdfDetailTitle");

    const zoomOutButton = document.getElementById("pdfZoomOut");

    const zoomInButton = document.getElementById("pdfZoomIn");

    const zoomResetButton = document.getElementById("pdfZoomReset");

    const zoomLabel = document.getElementById("pdfZoomLabel");


    if (!pdfConfig || !pagesContainer) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | CONFIG DARI BLADE
    |--------------------------------------------------------------------------
    */

    const pdfUrl = pdfConfig.dataset.pdfUrl || "";

    const sourceUrl = pdfConfig.dataset.sourceUrl || "";


    /*
    |--------------------------------------------------------------------------
    | ISI DETAIL PANEL + HEADER TITLE
    |--------------------------------------------------------------------------
    */

    const bab = pdfConfig.dataset.bab || pdfConfig.dataset.title || "-";

    if (title) title.textContent = bab;

    if (detailAuthor) detailAuthor.textContent = pdfConfig.dataset.nama || "-";

    if (detailNim) detailNim.textContent = pdfConfig.dataset.nim || "-";

    if (detailChapter) detailChapter.textContent = bab;

    if (detailTitle) detailTitle.textContent = pdfConfig.dataset.tesis || "-";


    /*
    |--------------------------------------------------------------------------
    | ZOOM CONFIG
    |--------------------------------------------------------------------------
    */

    const ZOOM_MIN = 0.5;

    const ZOOM_MAX = 2.5;

    const ZOOM_STEP = 0.15;

    const ZOOM_DEFAULT = 0.5;

    let currentZoom = ZOOM_DEFAULT;

    let currentPdf = null;

    let isZooming = false;


    /*
    |--------------------------------------------------------------------------
    | HELPER - LOADING / ERROR / SHOW
    |--------------------------------------------------------------------------
    */

    function showLoading() {

        loading?.classList.remove("hidden");

        loading?.classList.add("flex");

        errorBox?.classList.add("hidden");

        errorBox?.classList.remove("flex");
    }

    function hideLoading() {

        loading?.classList.add("hidden");

        loading?.classList.remove("flex");
    }

    function showError(message = "PDF gagal dimuat.") {

        console.error("PDF Viewer Error:", message);

        hideLoading();

        if (errorMessage) {

            errorMessage.textContent = message;
        }

        errorBox?.classList.remove("hidden");

        errorBox?.classList.add("flex");
    }

    function clearPages() {

        pagesContainer.innerHTML = "";
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE ZOOM UI
    |--------------------------------------------------------------------------
    */

    function updateZoomUI() {

        if (zoomLabel) {

            zoomLabel.textContent = `${Math.round(currentZoom * 100)}%`;
        }

        if (zoomOutButton) {

            zoomOutButton.disabled = currentZoom <= ZOOM_MIN;
        }

        if (zoomInButton) {

            zoomInButton.disabled = currentZoom >= ZOOM_MAX;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER SINGLE PAGE (FIT-TO-WIDTH x ZOOM USER)
    |--------------------------------------------------------------------------
    */

    async function renderPage(pdf, pageNumber) {

        const page = await pdf.getPage(pageNumber);

        const baseViewport = page.getViewport({ scale: 1 });

        const viewerWidth = viewerArea?.clientWidth || window.innerWidth;

        const horizontalPadding = window.innerWidth < 640 ? 24 : 48;

        const availableWidth = Math.max(viewerWidth - horizontalPadding, 300);

        const fitScale = availableWidth / baseViewport.width;

        const scale = fitScale * currentZoom;

        const viewport = page.getViewport({ scale });

        const canvas = document.createElement("canvas");

        canvas.className = "pdf-page";

        const context = canvas.getContext("2d", { alpha: false });

        if (!context) {

            throw new Error("Canvas PDF tidak dapat dibuat.");
        }

        const pixelRatio = Math.min(window.devicePixelRatio || 1, 2);

        canvas.width = Math.floor(viewport.width * pixelRatio);

        canvas.height = Math.floor(viewport.height * pixelRatio);

        canvas.style.width = `${viewport.width}px`;

        canvas.style.height = `${viewport.height}px`;

        const transform =
            pixelRatio !== 1 ? [pixelRatio, 0, 0, pixelRatio, 0, 0] : null;

        await page.render({
            canvasContext: context,
            viewport,
            transform,
        }).promise;

        pagesContainer.appendChild(canvas);

        page.cleanup();
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER ALL PAGES
    |--------------------------------------------------------------------------
    */

    async function renderAllPages(pdf) {

        clearPages();

        for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {

            await renderPage(pdf, pageNumber);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | APPLY ZOOM (RE-RENDER TANPA FETCH ULANG PDF)
    |--------------------------------------------------------------------------
    */

    async function applyZoom(nextZoom) {

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
            viewerArea && viewerArea.scrollHeight > 0
                ? viewerArea.scrollTop / viewerArea.scrollHeight
                : 0;

        await renderAllPages(currentPdf);

        if (viewerArea) {

            viewerArea.scrollTop = scrollRatio * viewerArea.scrollHeight;
        }

        isZooming = false;
    }


    /*
    |--------------------------------------------------------------------------
    | RENDER PDF (LOAD DOKUMEN)
    |--------------------------------------------------------------------------
    */

    async function renderPDF() {

        if (!pdfUrl) {

            showError("URL PDF tidak tersedia.");

            return;
        }

        try {

            showLoading();

            const loadingTask = pdfjsLib.getDocument({ url: pdfUrl });

            currentPdf = await loadingTask.promise;

            if (!currentPdf || !currentPdf.numPages) {

                throw new Error("Dokumen PDF tidak memiliki halaman.");
            }

            updateZoomUI();

            await renderAllPages(currentPdf);

            hideLoading();

            if (viewerArea) {

                viewerArea.scrollTop = 0;
            }

            console.log(`PDF berhasil dimuat, jumlah halaman: ${currentPdf.numPages}`);

        } catch (error) {

            console.error("Gagal memuat PDF:", error);

            showError(error?.message || "PDF gagal dimuat.");
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL PANEL
    |--------------------------------------------------------------------------
    */

    function openDetail() {

        detailPanel?.classList.remove("translate-x-full");

        detailPanel?.classList.add("translate-x-0");

        detailBackdrop?.classList.remove("hidden");

        detailToggle?.setAttribute("aria-expanded", "true");
    }

    function closeDetail() {

        detailPanel?.classList.remove("translate-x-0");

        detailPanel?.classList.add("translate-x-full");

        detailBackdrop?.classList.add("hidden");

        detailToggle?.setAttribute("aria-expanded", "false");
    }

    function toggleDetail() {

        const opened = detailPanel?.classList.contains("translate-x-0");

        if (opened) {

            closeDetail();

        } else {

            openDetail();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | EVENTS
    |--------------------------------------------------------------------------
    */

    detailToggle?.addEventListener("click", (event) => {

        event.preventDefault();

        toggleDetail();
    });

    detailClose?.addEventListener("click", (event) => {

        event.preventDefault();

        closeDetail();
    });

    detailBackdrop?.addEventListener("click", (event) => {

        event.preventDefault();

        closeDetail();
    });

    zoomInButton?.addEventListener("click", (event) => {

        event.preventDefault();

        applyZoom(currentZoom + ZOOM_STEP);
    });

    zoomOutButton?.addEventListener("click", (event) => {

        event.preventDefault();

        applyZoom(currentZoom - ZOOM_STEP);
    });

    zoomResetButton?.addEventListener("click", (event) => {

        event.preventDefault();

        applyZoom(ZOOM_DEFAULT);
    });

    document.addEventListener("keydown", (event) => {

        if (event.key !== "Escape") {

            return;
        }

        if (detailPanel?.classList.contains("translate-x-0")) {

            closeDetail();
        }
    });


    /*
    |--------------------------------------------------------------------------
    | RESIZE -> RE-RENDER (FIT-TO-WIDTH)
    |--------------------------------------------------------------------------
    */

    let resizeTimer = null;

    window.addEventListener("resize", () => {

        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(() => {

            if (currentPdf) {

                renderAllPages(currentPdf);
            }

        }, 250);
    });


    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */

    updateZoomUI();

    renderPDF();

    if (sourceUrl) {

        console.log("Repository source:", sourceUrl);
    }

});