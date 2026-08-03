document.addEventListener("DOMContentLoaded", () => {
    const search = document.getElementById("search");
    const kbk = document.getElementById("kbk");
    const searchButton = document.getElementById("search-button");
    const loading = document.getElementById("loading-bar");
    const result = document.getElementById("skripsi-result");
    const resultInfo = document.getElementById("result-info");

    if (!search || !loading || !result || !resultInfo) return;

    let controller = null;

    // Menyimpan kombinasi pencarian terakhir
    let lastSearch = "";

    const showLoading = () => {
        loading.style.opacity = "1";
        loading.style.width = "30%";

        setTimeout(() => (loading.style.width = "60%"), 100);
        setTimeout(() => (loading.style.width = "85%"), 250);
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
                <p class="text-sm font-semibold text-slate-700">Memuat hasil pencarian...</p>
                <p class="mt-2 text-sm text-slate-500">Harap tunggu sebentar sambil kami mencari repository skripsi yang cocok.</p>
            </div>
        `;
    };

    const loadData = async (url) => {
        // Batalkan request sebelumnya
        if (controller) {
            controller.abort();
        }

        controller = new AbortController();

        showLoading();
        renderLoadingState();

        try {
            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
                signal: controller.signal,
            });

            if (!response.ok) {
                throw new Error("Gagal memuat data");
            }

            const html = await response.text();

            result.innerHTML = html;

            // Update total hasil
            const meta = result.querySelector("#result-meta");

            if (meta) {
                resultInfo.innerHTML = `
                ${Number(meta.dataset.total).toLocaleString("id-ID")}
                <span class="text-base font-medium text-slate-500">
                    Skripsi
                </span>
            `;
            }

            // Update URL browser tanpa reload, mengikuti URL final bila terjadi redirect.
            history.replaceState({}, "", response.url);
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

    const triggerSearch = () => {
        const url = new URL(window.location.href);

        // Search
        if (search.value.trim() !== "") {
            url.searchParams.set("search", search.value.trim());
        } else {
            url.searchParams.delete("search");
        }

        // KBK
        if (kbk && kbk.value !== "") {
            url.searchParams.set("kbk", kbk.value);
        } else {
            url.searchParams.delete("kbk");
        }

        // Reset ke halaman pertama setiap kali filter berubah.
        url.searchParams.delete("page");

        loadData(url);
    };

    search.addEventListener("keydown", (event) => {
        if (event.key === "Enter") {
            event.preventDefault();
            triggerSearch();
        }
    });

    searchButton?.addEventListener("click", () => {
        search.focus();
        triggerSearch();
    });

    kbk?.addEventListener("change", () => {
        triggerSearch();
    });

    // ==========================
    // Pagination AJAX
    // ==========================

    document.addEventListener("click", function (e) {
        const link = e.target.closest(".pagination a");

        if (!link) return;

        e.preventDefault();

        const url = new URL(link.href);

        if (search.value.trim() !== "") {
            url.searchParams.set("search", search.value.trim());
        } else {
            url.searchParams.delete("search");
        }

        if (kbk && kbk.value !== "") {
            url.searchParams.set("kbk", kbk.value);
        } else {
            url.searchParams.delete("kbk");
        }

        loadData(url);
    });
});
