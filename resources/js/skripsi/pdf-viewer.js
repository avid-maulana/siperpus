import { createChapterController } from "./pdf-viewer/chapters.js";
import { createPdfRenderer } from "./pdf-viewer/renderer.js";
import { createViewerUi } from "./pdf-viewer/ui.js";

const buildFetchUrl = (targetUrl) => {
    try {
        const target = new URL(targetUrl, window.location.origin);
        if (target.origin === window.location.origin) return targetUrl;
    } catch (exception) {
        console.warn(
            "PDF Viewer Skripsi: gagal parse URL, fallback ke proxy.",
            exception,
        );
    }
    return "/pdf-proxy?url=" + encodeURIComponent(targetUrl);
};

const buildPdfUrl = (filePath, sisintaFileUrl) => {
    const cleanPath = String(filePath || "").trim();
    if (!cleanPath) throw new Error("Path PDF tidak ditemukan.");
    if (/^https?:\/\//i.test(cleanPath)) return cleanPath;
    if (!sisintaFileUrl) throw new Error("SISINTA_FILE_URL belum tersedia.");
    return `${sisintaFileUrl}/${cleanPath.replace(/^\/+/, "")}`;
};

document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("skripsiPdfModal");
    const modalContent = document.getElementById("skripsiPdfModalContent");
    const backdrop = document.getElementById("skripsiPdfBackdrop");
    const closeButton = document.getElementById("skripsiPdfClose");
    const viewer = document.getElementById("skripsiPdfViewer");
    const pagesContainer = document.getElementById("skripsiPdfPages");
    const loading = document.getElementById("skripsiPdfLoading");
    const error = document.getElementById("skripsiPdfError");
    const errorMessage = document.getElementById("skripsiPdfErrorMessage");
    const title = document.getElementById("skripsiPdfTitle");
    const detailToggle = document.getElementById("skripsiPdfDetailToggle");
    const detailPanel = document.getElementById("skripsiPdfDetailPanel");
    const detailClose = document.getElementById("skripsiPdfDetailClose");
    const detailBackdrop = document.getElementById("skripsiPdfDetailBackdrop");
    const detailAuthor = document.getElementById("skripsiPdfDetailAuthor");
    const detailNim = document.getElementById("skripsiPdfDetailNim");
    const detailChapter = document.getElementById("skripsiPdfDetailChapter");
    const detailTitle = document.getElementById("skripsiPdfDetailTitle");
    const chapterPanel = document.getElementById("skripsiPdfChapterPanel");
    const chapterToggle = document.getElementById("skripsiPdfChapterToggle");
    const chapterToggleIcon = document.getElementById(
        "skripsiPdfChapterToggleIcon",
    );
    const chapterHeaderText = document.getElementById(
        "skripsiPdfChapterHeaderText",
    );
    const chapterList = document.getElementById("skripsiPdfChapterList");
    const chapterListTitle = document.getElementById(
        "skripsiPdfChapterListTitle",
    );
    const zoomControls = document.getElementById("skripsiPdfZoomControls");
    const zoomOutButton = document.getElementById("skripsiPdfZoomOut");
    const zoomInButton = document.getElementById("skripsiPdfZoomIn");
    const zoomResetButton = document.getElementById("skripsiPdfZoomReset");
    const zoomLabel = document.getElementById("skripsiPdfZoomLabel");

    if (!modal || !modalContent || !pagesContainer) {
        console.warn("PDF Viewer Skripsi: element utama tidak ditemukan.");
        return;
    }

    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    const rendererState = { closing: false };
    const renderer = createPdfRenderer({
        viewer,
        pagesContainer,
        loading,
        error,
        errorMessage,
        zoomOutButton,
        zoomInButton,
        zoomLabel,
        isClosing: () => rendererState.closing,
    });
    const ui = createViewerUi({
        modal,
        modalContent,
        detailPanel,
        detailToggle,
        detailBackdrop,
    });
    let currentTriggerButton = null;

    const chapters = createChapterController({
        panel: chapterPanel,
        toggle: chapterToggle,
        toggleIcon: chapterToggleIcon,
        headerText: chapterHeaderText,
        list: chapterList,
        listTitle: chapterListTitle,
        onOpenPdf: openPdf,
        updateZoomControlsPosition: () => {
            if (zoomControls && chapterPanel)
                zoomControls.style.left = `${chapterPanel.offsetWidth}px`;
        },
    });

    const setDetailData = (button) => {
        const nama =
            button.dataset.pdfNama || button.dataset.skripsiAuthor || "-";
        const nim = button.dataset.pdfNim || button.dataset.skripsiNim || "-";
        const bab =
            button.dataset.pdfTitle || button.dataset.skripsiChapter || "-";
        const judul =
            button.dataset.pdfSkripsi || button.dataset.skripsiTitle || "-";
        if (title) title.textContent = bab;
        if (detailAuthor) detailAuthor.textContent = nama;
        if (detailNim) detailNim.textContent = nim;
        if (detailChapter) detailChapter.textContent = bab;
        if (detailTitle) detailTitle.textContent = judul;
    };

    function openPdf(button) {
        rendererState.closing = false;
        currentTriggerButton = button;
        chapters.setCurrentTrigger(button);
        renderer.setDefaultZoom();
        setDetailData(button);
        ui.resetDetail();
        renderer.resetViewer();

        let pdfUrl;
        try {
            const sisintaFileUrl = (window.SISINTA_FILE_URL || "").replace(
                /\/+$/,
                "",
            );
            pdfUrl = buildPdfUrl(button.dataset.pdfPath, sisintaFileUrl);
        } catch (exception) {
            renderer.showError(exception.message);
            document.body.classList.add("overflow-hidden");
            modal.setAttribute("aria-hidden", "false");
            ui.animateOpen();
            return;
        }

        modal.setAttribute("aria-hidden", "false");
        document.body.classList.add("overflow-hidden");
        ui.animateOpen();
        renderer.renderPdf(buildFetchUrl(pdfUrl));
    }

    const closePdf = () => {
        if (modal.classList.contains("hidden") || rendererState.closing) return;
        rendererState.closing = true;
        ui.closeDetail();
        ui.animateClose(async () => {
            modal.classList.add("hidden");
            modal.setAttribute("aria-hidden", "true");
            document.body.classList.remove("overflow-hidden");
            await renderer.clearPdf();
            renderer.resetViewer();
            currentTriggerButton = null;
            chapters.setCurrentTrigger(null);
            rendererState.closing = false;
        });
    };

    document.addEventListener("click", (event) => {
        const button = event.target.closest("[data-skripsi-pdf-viewer]");
        if (!button) return;
        event.preventDefault();
        event.stopPropagation();
        openPdf(button);
    });

    detailToggle?.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();
        ui.toggleDetail();
    });
    detailClose?.addEventListener("click", ui.closeDetail);
    detailBackdrop?.addEventListener("click", ui.closeDetail);
    zoomInButton?.addEventListener("click", () =>
        renderer.applyZoom(renderer.getCurrentZoom() + renderer.zoomStep),
    );
    zoomOutButton?.addEventListener("click", () =>
        renderer.applyZoom(renderer.getCurrentZoom() - renderer.zoomStep),
    );
    zoomResetButton?.addEventListener("click", () => renderer.applyZoom(0.5));
    closeButton?.addEventListener("click", closePdf);
    backdrop?.addEventListener("click", closePdf);

    document.addEventListener("keydown", (event) => {
        if (modal.classList.contains("hidden") || event.key !== "Escape")
            return;
        if (detailPanel?.classList.contains("translate-x-0")) ui.closeDetail();
        else closePdf();
    });
});
