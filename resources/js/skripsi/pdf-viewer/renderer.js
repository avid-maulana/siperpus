import * as pdfjsLib from "pdfjs-dist";
import pdfWorker from "pdfjs-dist/build/pdf.worker.min.mjs?url";

pdfjsLib.GlobalWorkerOptions.workerSrc = pdfWorker;

const ZOOM_MIN = 0.5;
const ZOOM_MAX = 2.5;
const ZOOM_STEP = 0.15;
const ZOOM_DEFAULT = 0.5;

export function createPdfRenderer({
    viewer,
    pagesContainer,
    loading,
    error,
    errorMessage,
    zoomOutButton,
    zoomInButton,
    zoomLabel,
    isClosing,
}) {
    let currentPdf = null;
    let currentLoadingTask = null;
    let currentZoom = ZOOM_DEFAULT;
    let isZooming = false;

    const showLoading = () => {
        loading?.classList.remove("hidden");
        loading?.classList.add("flex");
        error?.classList.add("hidden");
        error?.classList.remove("flex");
    };

    const hideLoading = () => {
        loading?.classList.add("hidden");
        loading?.classList.remove("flex");
    };

    const showError = (message) => {
        hideLoading();
        if (errorMessage) {
            errorMessage.textContent = message || "File PDF tidak dapat ditampilkan.";
        }
        error?.classList.remove("hidden");
        error?.classList.add("flex");
    };

    const hideError = () => {
        error?.classList.add("hidden");
        error?.classList.remove("flex");
    };

    const clearPages = () => {
        pagesContainer.innerHTML = "";
    };

    const updateZoomUI = () => {
        if (zoomLabel) {
            zoomLabel.textContent = `${Math.round(currentZoom * 100)}%`;
        }
        if (zoomOutButton) {
            zoomOutButton.disabled = currentZoom <= ZOOM_MIN;
            zoomOutButton.classList.toggle("opacity-40", currentZoom <= ZOOM_MIN);
        }
        if (zoomInButton) {
            zoomInButton.disabled = currentZoom >= ZOOM_MAX;
            zoomInButton.classList.toggle("opacity-40", currentZoom >= ZOOM_MAX);
        }
    };

    const renderPage = async (pdf, pageNumber) => {
        const page = await pdf.getPage(pageNumber);
        const viewport = page.getViewport({ scale: 1 });
        const viewerWidth = viewer?.clientWidth || window.innerWidth;
        const horizontalPadding = window.innerWidth < 640 ? 24 : 48;
        const availableWidth = Math.max(viewerWidth - horizontalPadding, 300);
        const scale = (availableWidth / viewport.width) * currentZoom;
        const finalViewport = page.getViewport({ scale });
        const pageWrapper = document.createElement("div");

        pageWrapper.className = "relative mx-auto overflow-hidden bg-white shadow-lg";
        pageWrapper.style.width = `${finalViewport.width}px`;
        pageWrapper.style.height = `${finalViewport.height}px`;

        const canvas = document.createElement("canvas");
        const context = canvas.getContext("2d", { alpha: false });
        const outputScale = Math.min(window.devicePixelRatio || 1, 2);

        if (!context) {
            throw new Error("Canvas PDF tidak dapat dibuat.");
        }

        canvas.width = Math.floor(finalViewport.width * outputScale);
        canvas.height = Math.floor(finalViewport.height * outputScale);
        canvas.style.width = `${finalViewport.width}px`;
        canvas.style.height = `${finalViewport.height}px`;
        canvas.className = "block";

        pageWrapper.appendChild(canvas);
        pagesContainer.appendChild(pageWrapper);

        await page.render({
            canvasContext: context,
            viewport: finalViewport,
            transform: outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] : null,
        }).promise;

        page.cleanup();
    };

    const renderAllPages = async (pdf) => {
        clearPages();
        for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber += 1) {
            if (isClosing()) {
                return;
            }
            await renderPage(pdf, pageNumber);
        }
    };

    const clearPdf = async () => {
        if (currentLoadingTask) {
            try {
                await currentLoadingTask.destroy();
            } catch (exception) {
                console.warn("PDF loading task:", exception);
            }
            currentLoadingTask = null;
        }

        if (currentPdf) {
            try {
                await currentPdf.destroy();
            } catch (exception) {
                console.warn("PDF document:", exception);
            }
            currentPdf = null;
        }

        clearPages();
    };

    const resetViewer = () => {
        clearPages();
        showLoading();
        hideError();
    };

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
            await renderAllPages(currentPdf);
            hideLoading();
            if (viewer) {
                viewer.scrollTop = 0;
            }
        } catch (exception) {
            console.error("PDF.js error:", exception);
            showError("PDF tidak dapat dimuat. Periksa koneksi atau path file.");
        }
    };

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

        const scrollRatio = viewer && viewer.scrollHeight > 0
            ? viewer.scrollTop / viewer.scrollHeight
            : 0;

        await renderAllPages(currentPdf);

        if (viewer) {
            viewer.scrollTop = scrollRatio * viewer.scrollHeight;
        }

        isZooming = false;
    };

    return {
        applyZoom,
        clearPdf,
        getCurrentZoom: () => currentZoom,
        hideError,
        renderPdf,
        resetViewer,
        setDefaultZoom: () => {
            currentZoom = ZOOM_DEFAULT;
            updateZoomUI();
        },
        showError,
        updateZoomUI,
        zoomStep: ZOOM_STEP,
    };
}
