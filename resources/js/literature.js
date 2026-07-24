document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("filterForm");

    if (!form) return;

    const search = document.getElementById("searchInput");
    const clearButton = document.getElementById("clearSearch");
    const reset = document.getElementById("resetSearch");
    const type = document.getElementById("typeSelect");
    const category = document.getElementById("categorySelect");
    const results = document.getElementById("resultsContainer");

    let debounce = null;
    let controller = null;
    let activeRequestId = 0;
    let loadingTimer = null;

    function syncCategoryOptions() {
        if (!category) return;

        const currentValue = category.value;

        Array.from(category.options).forEach((option) => {
            option.hidden = false;
        });

        if (currentValue && !Array.from(category.options).some(option => option.value === currentValue)) {
            category.value = "";
        }
    }

    function buildUrl(base = form.action) {
        const params = new URLSearchParams();

        if (search.value.trim()) {
            params.set("search", search.value.trim());
        }

        if (type?.value) {
            params.set("type", type.value);
        }

        if (category?.value) {
            params.set("category_id", category.value);
        }

        return params.toString()
            ? `${base}?${params.toString()}`
            : base;
    }

    function render(html) {
        results.innerHTML = html;
    }

    function clearLoading() {
        if (loadingTimer) {
            clearTimeout(loadingTimer);
            loadingTimer = null;
        }
    }

    function showLoading() {
        clearLoading();

        loadingTimer = setTimeout(() => {
            results.innerHTML = `
                <div class="rounded-[2rem] border border-slate-200 bg-white p-10 text-center shadow-sm">
                    <div class="mx-auto h-10 w-10 animate-spin rounded-full border-4 border-blue-100 border-t-blue-600"></div>
                    <p class="mt-4 text-sm font-medium text-slate-600">Mencari literatur...</p>
                </div>
            `;
        }, 180);
    }

    async function request(url, push = true) {
        controller?.abort();
        controller = new AbortController();
        activeRequestId += 1;
        const currentRequestId = activeRequestId;

        clearLoading();

        if (url !== location.href && !url.includes("page=")) {
            showLoading();
        }

        try {
            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                signal: controller.signal
            });

            if (!response.ok) {
                throw new Error(response.status);
            }

            const html = await response.text();

            if (currentRequestId === activeRequestId) {
                render(html);
            }

            if (push && currentRequestId === activeRequestId) {
                history.pushState({}, "", url);
            }

        } catch (error) {
            if (error.name === "AbortError") {
                return;
            }

            if (currentRequestId === activeRequestId) {
                render(`
                    <div class="rounded-[2rem] border border-dashed border-slate-200 bg-slate-50 p-12 text-center">
                        <span class="material-symbols-outlined text-5xl text-slate-400">search_off</span>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">Tidak ada hasil</h3>
                        <p class="mt-2 text-sm text-slate-500">Coba ubah kata kunci, tipe, atau kategori untuk menemukan koleksi yang Anda cari.</p>
                    </div>
                `);
            }
        } finally {
            if (currentRequestId === activeRequestId) {
                clearLoading();
                controller = null;
            }
        }
    }

    function refresh(push = true) {
        request(buildUrl(), push);
    }

    form.addEventListener("submit", e => {
        e.preventDefault();
    });

    syncCategoryOptions();

    search.addEventListener("input", () => {
        clearButton?.classList.toggle("hidden", !search.value.trim());

        clearTimeout(debounce);

        debounce = setTimeout(() => {
            refresh();
        }, 250);
    });

    type?.addEventListener("change", () => {
        syncCategoryOptions();
        refresh();
    });

    category?.addEventListener("change", () => {
        refresh();
    });

    clearButton?.addEventListener("click", () => {
        search.value = "";
        clearButton.classList.add("hidden");
        refresh();
        search.focus();
    });

    reset?.addEventListener("click", () => {
        search.value = "";
        if (type) type.value = "";
        if (category) category.value = "";
        syncCategoryOptions();
        clearButton?.classList.add("hidden");
        refresh();
        search.focus();
    });

    results.addEventListener("click", (e) => {
        const link = e.target.closest("[data-ajax-page]");

        if (!link) return;

        e.preventDefault();

        request(link.href);

        window.scrollTo({ top: 0, behavior: "smooth" });
    });

    window.addEventListener("popstate", () => {
        const params = new URL(location.href).searchParams;
        search.value = params.get("search") || "";

        if (type) {
            type.value = params.get("type") || "";
        }

        if (category) {
            category.value = params.get("category_id") || "";
        }

        syncCategoryOptions();
        clearButton?.classList.toggle("hidden", !search.value.trim());
        request(location.href, false);
    });
});
