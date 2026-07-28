document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("filterForm");

    const search = document.getElementById("searchInput");
    const type = document.getElementById("typeSelect");
    const category = document.getElementById("categorySelect");

    const clearButton = document.getElementById("clearSearch");
    const resetButton = document.getElementById("resetSearch");

    const loading = document.getElementById("loading-bar");
    const result = document.getElementById("resultsContainer");
    const resultInfo = document.getElementById("result-info");

    if (!form || !loading || !result || !resultInfo) return;

    let controller = null;

    // ==========================
    // Loading
    // ==========================

    const showLoading = () => {

        loading.style.opacity = "1";
        loading.style.width = "30%";

        setTimeout(() => loading.style.width = "60%", 100);
        setTimeout(() => loading.style.width = "85%", 250);

    };

    const hideLoading = () => {

        loading.style.width = "100%";

        setTimeout(() => {

            loading.style.opacity = "0";
            loading.style.width = "0";

        }, 200);

    };

    const renderLoadingState = () => {

        result.innerHTML = `
            <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center shadow-sm">

                <div class="mx-auto mb-4 h-12 w-12 animate-spin rounded-full border-4 border-slate-200 border-t-slate-900"></div>

                <p class="text-sm font-semibold text-slate-700">
                    Memuat hasil pencarian...
                </p>

                <p class="mt-2 text-sm text-slate-500">
                    Harap tunggu sebentar sambil kami mencari literatur yang sesuai.
                </p>

            </div>
        `;

    };

    // ==========================
    // AJAX
    // ==========================

    const loadData = async (url) => {

        if (controller) {
            controller.abort();
        }

        controller = new AbortController();

        showLoading();
        renderLoadingState();

        try {

            const response = await fetch(url, {

                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },

                signal: controller.signal

            });

            if (!response.ok) {

                throw new Error("Gagal memuat data");

            }

            const html = await response.text();

            result.innerHTML = html;

            const meta = result.querySelector("#result-meta");

            if (meta) {

                resultInfo.innerHTML = `
                    ${Number(meta.dataset.total).toLocaleString("id-ID")}
                    <span class="text-lg font-medium text-slate-500">
                        Literatur
                    </span>
                `;

            }

            history.replaceState({}, "", url);

        } catch (error) {

            if (error.name !== "AbortError") {

                console.error(error);

            }

        } finally {

            hideLoading();

        }

    };

        // ==========================
    // Search
    // ==========================

    const triggerSearch = (page = null) => {

        const url = new URL(form.action);

        // Search
        if (search.value.trim() !== "") {
            url.searchParams.set("search", search.value.trim());
        }

        // Type
        if (type.value !== "") {
            url.searchParams.set("type", type.value);
        }

        // Category
        if (category.value !== "") {
            url.searchParams.set("category_id", category.value);
        }

        // Page
        if (page) {
            url.searchParams.set("page", page);
        }

        loadData(url);

    };

    // ==========================
    // Search Input
    // ==========================

    search.addEventListener("input", () => {

        clearButton.classList.toggle(
            "hidden",
            search.value.trim() === ""
        );

    });

    search.addEventListener("keydown", (event) => {

        if (event.key !== "Enter") return;

        event.preventDefault();

        triggerSearch();

    });

    // ==========================
    // Search Button
    // ==========================

    form.addEventListener("submit", (event) => {

        event.preventDefault();

        triggerSearch();

    });

    // ==========================
    // Filter
    // ==========================

    type?.addEventListener("change", () => {

        triggerSearch();

    });

    category?.addEventListener("change", () => {

        triggerSearch();

    });

    // ==========================
    // Clear Search
    // ==========================

    clearButton?.addEventListener("click", () => {

        search.value = "";

        clearButton.classList.add("hidden");

        search.focus();

        triggerSearch();

    });

    // ==========================
    // Reset
    // ==========================

    resetButton?.addEventListener("click", () => {

        search.value = "";

        type.value = "";

        category.value = "";

        clearButton.classList.add("hidden");

        resetButton?.addEventListener("click", () => {

            search.value = "";
            type.value = "";
            category.value = "";

            clearButton.classList.add("hidden");

            loadData(form.action);

        });

    });

        // ==========================
    // Pagination AJAX
    // ==========================

    document.addEventListener("click", (event) => {

        const link = event.target.closest("[data-ajax-page]");

        if (!link) return;

        event.preventDefault();

        const page = new URL(link.href).searchParams.get("page");

        triggerSearch(page);

        window.scrollTo({
            top: result.offsetTop - 120,
            behavior: "smooth"
        });

    });

    // ==========================
    // Browser Back / Forward
    // ==========================

    window.addEventListener("popstate", () => {

        loadData(window.location.href);

    });

    // ==========================
    // Initial State
    // ==========================

    clearButton?.classList.toggle(
        "hidden",
        search.value.trim() === ""
    );

});