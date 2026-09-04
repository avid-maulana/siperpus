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
| Collapsible Chapter Sidebar (Icon Rail on Minimize)
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
    | CHAPTER SIDEBAR
    |--------------------------------------------------------------------------
    */

    const chapterPanel = document.getElementById("skripsiPdfChapterPanel");

    const chapterToggle = document.getElementById("skripsiPdfChapterToggle");

    const chapterToggleIcon = document.getElementById("skripsiPdfChapterToggleIcon");

    const chapterHeaderText = document.getElementById("skripsiPdfChapterHeaderText");

    const chapterList = document.getElementById("skripsiPdfChapterList");

    const chapterListTitle = document.getElementById("skripsiPdfChapterListTitle");

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

    const zoomControls = document.getElementById("skripsiPdfZoomControls");

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
    | TRIGGER SELECTOR
    |--------------------------------------------------------------------------
    */

    const TRIGGER_SELECTOR = "[data-skripsi-pdf-viewer]";

    /*
    |--------------------------------------------------------------------------
    | SIDEBAR WIDTH (EXPANDED / COLLAPSED)
    |--------------------------------------------------------------------------
    */

    const SIDEBAR_EXPANDED_CLASS = "w-72";

    const SIDEBAR_COLLAPSED_CLASS = "w-20";

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
    | CURRENT TRIGGER (UNTUK DAFTAR BAB)
    |--------------------------------------------------------------------------
    */

    let currentTriggerButton = null;

    /*
    |--------------------------------------------------------------------------
    | STATE SIDEBAR (DEFAULT: EXPANDED)
    |--------------------------------------------------------------------------
    */

    let isChapterExpanded = true;

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

        if (/^https?:\/\//i.test(cleanPath)) {
            return cleanPath;
        }

        if (!sisintaFileUrl) {
            throw new Error("SISINTA_FILE_URL belum tersedia.");
        }

        return `${sisintaFileUrl}/` + cleanPath.replace(/^\/+/, "");
    };

    /*
    |--------------------------------------------------------------------------
    | BUILD FETCH URL (VIA PROXY UNTUK DOMAIN EKSTERNAL)
    |--------------------------------------------------------------------------
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
    | SHOW / HIDE LOADING & ERROR
    |--------------------------------------------------------------------------
    */

    const showLoading = () => {
        loading?.classList.remove("hidden");

        loading?.classList.add("flex");
    };

    const hideLoading = () => {
        loading?.classList.add("hidden");

        loading?.classList.remove("flex");
    };

    const showError = (message) => {
        hideLoading();

        if (errorMessage) {
            errorMessage.textContent =
                message || "File PDF tidak dapat ditampilkan.";
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
        const nama =
            button.dataset.pdfNama || button.dataset.skripsiAuthor || "-";

        const nim = button.dataset.pdfNim || button.dataset.skripsiNim || "-";

        const bab =
            button.dataset.pdfTitle || button.dataset.skripsiChapter || "-";

        const judul =
            button.dataset.pdfSkripsi || button.dataset.skripsiTitle || "-";

        if (title) {
            title.textContent = bab;
        }

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

        console.log("DETAIL SKRIPSI:", { nama, nim, bab, judul });
    };

    /*
    |--------------------------------------------------------------------------
    | GET TRIGGER LIST (SEMUA TOMBOL PDF DI HALAMAN)
    |--------------------------------------------------------------------------
    */

    const getTriggerList = () => {
        return Array.from(document.querySelectorAll(TRIGGER_SELECTOR));
    };

    /*
    |--------------------------------------------------------------------------
    | KUNCI GROUPING SKRIPSI (BERDASARKAN NIM, FALLBACK KE JUDUL)
    |--------------------------------------------------------------------------
    */

    const getSkripsiKey = (button) => {
        const nim = button.dataset.pdfNim || button.dataset.skripsiNim || "";

        if (nim) {
            return `nim:${nim}`;
        }

        const judul =
            button.dataset.pdfSkripsi || button.dataset.skripsiTitle || "";

        return `judul:${judul}`;
    };

    const getChapterGroup = (button) => {
        const key = getSkripsiKey(button);

        return getTriggerList().filter((item) => getSkripsiKey(item) === key);
    };

    /*
    |--------------------------------------------------------------------------
    | ANGKA ROMAWI (UNTUK BADGE BAB SAAT DIMINIMIZE / DIEXPAND)
    |--------------------------------------------------------------------------
    */

    const toRoman = (num) => {
        const table = [
            ["M", 1000], ["CM", 900], ["D", 500], ["CD", 400],
            ["C", 100], ["XC", 90], ["L", 50], ["XL", 40],
            ["X", 10], ["IX", 9], ["V", 5], ["IV", 4], ["I", 1],
        ];

        let result = "";

        let n = num;

        for (const [roman, value] of table) {
            while (n >= value) {
                result += roman;

                n -= value;
            }
        }

        return result || "-";
    };

    const isDaftarPustaka = (label) => /pustaka/i.test(label);

    /*
    |--------------------------------------------------------------------------
    | TENTUKAN BADGE UNTUK SATU BAB
    |--------------------------------------------------------------------------
    |
    | - "Daftar Pustaka" -> ikon buku
    | - Label yang sudah mengandung angka romawi ("BAB I", dst) -> dipakai langsung
    | - Selain itu -> fallback ke angka romawi berdasar urutan di grup
    |
    */

    const getChapterBadge = (item, indexInGroup) => {
        const label =
            item.dataset.pdfTitle || item.dataset.skripsiChapter || "-";

        if (isDaftarPustaka(label)) {
            return { icon: "book" };
        }

        const match = label.match(/\b([IVXLCDM]+)\b/i);

        if (match) {
            return { text: match[1].toUpperCase() };
        }

        return { text: toRoman(indexInGroup + 1) };
    };

    const bookIconSvg = `
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 4.5A2.5 2.5 0 017.5 2H19v17H7.5A2.5 2.5 0 005 21.5v-17Z" />
            <path stroke-linecap="round" d="M5 19.5A2.5 2.5 0 017.5 17H19" />
        </svg>
    `;

    /*
    |--------------------------------------------------------------------------
    | RENDER DAFTAR BAB DI SIDEBAR
    |--------------------------------------------------------------------------
    */

    const renderChapterList = () => {
        if (!chapterList) {
            return;
        }

        chapterList.innerHTML = "";

        if (!currentTriggerButton) {
            chapterList.innerHTML =
                '<p class="px-3 py-4 text-sm text-slate-400">Tidak ada bab lain.</p>';

            if (chapterListTitle) {
                chapterListTitle.textContent = "-";
            }

            return;
        }

        const group = getChapterGroup(currentTriggerButton);

        if (chapterListTitle) {
            const judul =
                currentTriggerButton.dataset.pdfSkripsi ||
                currentTriggerButton.dataset.skripsiTitle ||
                "-";

            chapterListTitle.textContent = judul;
        }

        if (group.length === 0) {
            chapterList.innerHTML =
                '<p class="px-3 py-4 text-sm text-slate-400">Tidak ada bab lain.</p>';

            return;
        }

        group.forEach((item, index) => {
            const bab =
                item.dataset.pdfTitle || item.dataset.skripsiChapter || "-";

            const isActive = item === currentTriggerButton;

            const badge = getChapterBadge(item, index);

            const chapterButton = document.createElement("button");

            chapterButton.type = "button";

            chapterButton.title = bab;

            chapterButton.className = [
                "flex",
                "w-full",
                "items-center",
                "gap-3",
                "rounded-xl",
                "px-3",
                "py-3",
                "text-left",
                "transition-all",
                "duration-150",
                isActive
                    ? "bg-slate-800 text-white"
                    : "text-slate-600 hover:bg-slate-100 hover:text-slate-800",
            ].join(" ");

            /*
            |----------------------------------------------------------------
            | BADGE (ANGKA ROMAWI / IKON BUKU)
            |----------------------------------------------------------------
            */

            const badgeEl = document.createElement("span");

            badgeEl.className = [
                "flex",
                "h-8",
                "w-8",
                "shrink-0",
                "items-center",
                "justify-center",
                "rounded-lg",
                "text-xs",
                "font-bold",
                isActive
                    ? "bg-white/15 text-white"
                    : "bg-slate-100 text-slate-600",
            ].join(" ");

            if (badge.icon === "book") {
                badgeEl.innerHTML = bookIconSvg;
            } else {
                badgeEl.textContent = badge.text;
            }

            chapterButton.appendChild(badgeEl);

            /*
            |----------------------------------------------------------------
            | LABEL (DIBUAT WRAP, TIDAK TERPOTONG, HANYA TAMPIL SAAT EXPANDED)
            |----------------------------------------------------------------
            */

            const labelEl = document.createElement("span");

            labelEl.className = [
                "chapter-label",
                "min-w-0",
                "flex-1",
                "whitespace-normal",
                "break-words",
                "text-sm",
                "font-medium",
                "leading-snug",
            ].join(" ");

            labelEl.textContent = bab;

            chapterButton.appendChild(labelEl);

            chapterButton.addEventListener("click", (event) => {
                event.preventDefault();

                event.stopPropagation();

                if (isActive) {
                    return;
                }

                openPdf(item);
            });

            chapterList.appendChild(chapterButton);
        });

        applyChapterExpandedState();
    };

    /*
    |--------------------------------------------------------------------------
    | TERAPKAN STATE EXPANDED / COLLAPSED KE SELURUH ELEMEN SIDEBAR
    |--------------------------------------------------------------------------
    */

    const applyChapterExpandedState = () => {
        if (!chapterPanel) {
            return;
        }

        chapterPanel.dataset.expanded = isChapterExpanded ? "true" : "false";

        chapterPanel.classList.toggle(SIDEBAR_EXPANDED_CLASS, isChapterExpanded);

        chapterPanel.classList.toggle(SIDEBAR_COLLAPSED_CLASS, !isChapterExpanded);

        chapterHeaderText?.classList.toggle("hidden", !isChapterExpanded);

        chapterToggle?.setAttribute("aria-expanded", String(isChapterExpanded));

        chapterToggle?.setAttribute(
            "aria-label",
            isChapterExpanded ? "Ciutkan daftar bab" : "Perluas daftar bab",
        );

        if (chapterToggleIcon) {
            chapterToggleIcon.style.transform = isChapterExpanded
                ? "rotate(0deg)"
                : "rotate(180deg)";
        }

        /*
        |------------------------------------------------------------------
        | LABEL BAB DISEMBUNYIKAN SAAT COLLAPSED, BADGE JADI TENGAH
        |------------------------------------------------------------------
        */

        chapterList?.querySelectorAll(".chapter-label").forEach((el) => {
            el.classList.toggle("hidden", !isChapterExpanded);
        });

        chapterList?.querySelectorAll("button").forEach((btn) => {
            btn.classList.toggle("justify-center", !isChapterExpanded);
        });
    };

    const toggleChapterExpanded = () => {
        isChapterExpanded = !isChapterExpanded;

        applyChapterExpandedState();

        updateZoomControlsPosition();
    };

    /*
    |--------------------------------------------------------------------------
    | SELARASKAN POSISI KONTROL ZOOM DENGAN LEBAR SIDEBAR
    |--------------------------------------------------------------------------
    */

    const updateZoomControlsPosition = () => {
        if (!zoomControls || !chapterPanel) {
            return;
        }

        zoomControls.style.left = `${chapterPanel.offsetWidth}px`;
    };

    window.addEventListener("resize", () => {
        updateZoomControlsPosition();

        
    });

    chapterPanel?.addEventListener("transitionend", (event) => {
        if (event.propertyName === "width") {
            updateZoomControlsPosition();
        }
    });

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
        const opened = detailPanel?.classList.contains("translate-x-0");

        if (opened) {
            closeDetail();
        } else {
            openDetail();
        }
    };

    /*
    |--------------------------------------------------------------------------
    | ANIMATE OPEN / CLOSE MODAL
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
    | UPDATE ZOOM UI
    |--------------------------------------------------------------------------
    */

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

    /*
    |--------------------------------------------------------------------------
    | RENDER SINGLE PAGE
    |--------------------------------------------------------------------------
    */

    const renderPage = async (pdf, pageNumber) => {
        const page = await pdf.getPage(pageNumber);

        const viewport = page.getViewport({ scale: 1 });

        const viewerWidth = viewer?.clientWidth || window.innerWidth;

        const horizontalPadding = window.innerWidth < 640 ? 24 : 48;

        const availableWidth = Math.max(viewerWidth - horizontalPadding, 300);

        const fitScale = availableWidth / viewport.width;

        const scale = fitScale * currentZoom;

        const finalViewport = page.getViewport({ scale });

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

        const context = canvas.getContext("2d", { alpha: false });

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
    | RENDER ALL PAGES
    |--------------------------------------------------------------------------
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
    | APPLY ZOOM
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

            hideLoading();

            if (viewer) {
                viewer.scrollTop = 0;
            }
        } catch (err) {
            console.error("PDF.js error:", err);

            showError("PDF tidak dapat dimuat. Periksa koneksi atau path file.");
        }
    };

    /*
    |--------------------------------------------------------------------------
    | OPEN PDF
    |--------------------------------------------------------------------------
    */

    const openPdf = (button) => {
        isClosing = false;

        currentTriggerButton = button;

        renderChapterList();

        currentZoom = ZOOM_DEFAULT;

        updateZoomUI();

        const filePath = button.dataset.pdfPath;

        if (!filePath) {
            console.error("PDF Viewer Skripsi: data-pdf-path tidak ditemukan.");

            return;
        }

        setDetailData(button);

        resetDetail();

        resetViewer();

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

        const fetchUrl = buildFetchUrl(pdfUrl);

        console.log("PDF PATH:", filePath);

        console.log("PDF URL (asli):", pdfUrl);

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

            currentTriggerButton = null;

            renderChapterList();

            isClosing = false;
        });
    };

    /*
    |--------------------------------------------------------------------------
    | OPEN BUTTON (EVENT DELEGATION)
    |--------------------------------------------------------------------------
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
    | CHAPTER SIDEBAR TOGGLE
    |--------------------------------------------------------------------------
    */

    chapterToggle?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        toggleChapterExpanded();
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
    | ZOOM
    |--------------------------------------------------------------------------
    */

    zoomInButton?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        applyZoom(currentZoom + ZOOM_STEP);
    });

    zoomOutButton?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        applyZoom(currentZoom - ZOOM_STEP);
    });

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

    backdrop?.addEventListener("click", (event) => {
        event.preventDefault();

        event.stopPropagation();

        closePdf();
    });

    /*
    |--------------------------------------------------------------------------
    | KEYBOARD (ESC)
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", (event) => {
        if (modal.classList.contains("hidden")) {
            return;
        }

        if (event.key !== "Escape") {
            return;
        }

        if (detailPanel?.classList.contains("translate-x-0")) {
            closeDetail();

            return;
        }

        closePdf();
    });

    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */

    applyChapterExpandedState();

    updateZoomControlsPosition();
});