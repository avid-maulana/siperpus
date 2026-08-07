document.addEventListener("DOMContentLoaded", () => {
    // =========================================================
    // ELEMENTS
    // =========================================================

    const form = document.getElementById("filterForm");

    const search = document.getElementById("searchInput");
    const type = document.getElementById("typeSelect");
    const category = document.getElementById("categorySelect");

    const clearButton = document.getElementById("clearSearch");
    const resetButton = document.getElementById("resetSearch");

    const loading = document.getElementById("loading-bar");
    const result = document.getElementById("resultsContainer");

    // Elemen utama yang benar-benar wajib
    if (!form || !search || !type || !category || !result) {
        console.error("Literature filter: elemen utama tidak ditemukan.", {
            form,
            search,
            type,
            category,
            result,
        });

        return;
    }

    let controller = null;

    // =========================================================
    // SCROLL
    // =========================================================

    const scrollToTop = () => {
        const pageContent = document.getElementById("page-content");

        if (pageContent) {
            pageContent.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });

            return;
        }

        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });
    };

    // =========================================================
    // LOADING BAR
    // =========================================================

    const showLoading = () => {
        if (!loading) return;

        loading.style.opacity = "1";
        loading.style.width = "30%";

        setTimeout(() => {
            if (loading) {
                loading.style.width = "60%";
            }
        }, 100);

        setTimeout(() => {
            if (loading) {
                loading.style.width = "85%";
            }
        }, 250);
    };

    const hideLoading = () => {
        if (!loading) return;

        loading.style.width = "100%";

        setTimeout(() => {
            loading.style.opacity = "0";
            loading.style.width = "0";
        }, 200);
    };

    // =========================================================
    // RESULT LOADING STATE
    // =========================================================

    const renderLoadingState = () => {
        result.innerHTML = `
            <div
                class="rounded-3xl border border-slate-200
                       bg-white p-10 text-center shadow-sm">

                <div
                    class="mx-auto mb-4 h-12 w-12
                           animate-spin rounded-full
                           border-4 border-slate-200
                           border-t-slate-900">
                </div>

                <p class="text-sm font-semibold text-slate-700">
                    Memuat hasil pencarian...
                </p>

                <p class="mt-2 text-sm text-slate-500">
                    Harap tunggu sebentar sambil kami mencari
                    literatur yang sesuai.
                </p>

            </div>
        `;
    };

    // =========================================================
    // AJAX
    // =========================================================

    const loadData = async (url, showLoader = true, shouldScroll = true) => {
        if (controller) {
            controller.abort();
        }

        controller = new AbortController();

        if (showLoader) {
            showLoading();
            renderLoadingState();
        }

        try {
            const response = await fetch(url.toString(), {
                method: "GET",

                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "text/html",
                },

                signal: controller.signal,
            });

            if (!response.ok) {
                throw new Error(`Gagal memuat data: ${response.status}`);
            }

            const html = await response.text();

            // Ganti hanya bagian result
            result.innerHTML = html;

            // Update URL browser tanpa reload
            history.replaceState({}, "", url.toString());

            if (shouldScroll) {
                scrollToTop();
            }
        } catch (error) {
            if (error.name !== "AbortError") {
                console.error("Literature AJAX Error:", error);
            }
        } finally {
            if (showLoader) {
                hideLoading();
            }
        }
    };

    // =========================================================
    // BUILD URL
    // =========================================================

    const buildUrl = (page = null) => {
        const url = new URL(form.action, window.location.origin);

        // SEARCH
        const keyword = search.value.trim();

        if (keyword !== "") {
            url.searchParams.set("search", keyword);
        }

        // TYPE
        if (type.value !== "") {
            url.searchParams.set("type", type.value);
        }

        // CATEGORY
        if (category.value !== "") {
            url.searchParams.set("category_id", category.value);
        }

        // PAGE
        if (page) {
            url.searchParams.set("page", page);
        }

        return url;
    };

    // =========================================================
    // TRIGGER SEARCH
    // =========================================================

    const triggerSearch = (page = null, showLoader = true) => {
        const url = buildUrl(page);

        loadData(url, showLoader);
    };

    // =========================================================
    // SEARCH INPUT
    // Tidak AJAX saat mengetik
    // =========================================================

    search.addEventListener("input", () => {
        clearButton?.classList.toggle("hidden", search.value.trim() === "");
    });

    // =========================================================
    // ENTER SEARCH
    // =========================================================

    search.addEventListener("keydown", (event) => {
        if (event.key !== "Enter") {
            return;
        }

        event.preventDefault();

        triggerSearch();
    });

    // =========================================================
    // SEARCH BUTTON
    // =========================================================

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        triggerSearch();
    });

    // =========================================================
    // TYPE
    // Langsung AJAX ketika berubah
    // =========================================================

    type.addEventListener("change", () => {
        triggerSearch();
    });

    // =========================================================
    // CATEGORY
    // Langsung AJAX ketika berubah
    // =========================================================

    category.addEventListener("change", () => {
        triggerSearch();
    });

    // =========================================================
    // CLEAR SEARCH
    // =========================================================

    clearButton?.addEventListener("click", () => {
        search.value = "";

        clearButton.classList.add("hidden");

        search.focus();

        triggerSearch();
    });

    // =========================================================
    // RESET
    // =========================================================

    resetButton?.addEventListener("click", () => {
        // Kosongkan semua
        search.value = "";
        type.value = "";
        category.value = "";

        clearButton?.classList.add("hidden");

        // Request URL bersih
        const url = new URL(form.action, window.location.origin);

        loadData(url);
    });

    // =========================================================
    // PAGINATION AJAX
    // =========================================================

    document.addEventListener("click", (event) => {
        const link = event.target.closest("[data-ajax-page]");

        if (!link) {
            return;
        }

        event.preventDefault();

        const url = new URL(link.href);

        const page = url.searchParams.get("page");

        triggerSearch(page, false);
    });

    // =========================================================
    // BROWSER BACK / FORWARD
    // =========================================================

    window.addEventListener("popstate", () => {
        loadData(new URL(window.location.href), true, false);
    });

    // =========================================================
    // INITIAL STATE
    // =========================================================

    clearButton?.classList.toggle("hidden", search.value.trim() === "");
});
