document.addEventListener("DOMContentLoaded", () => {

    const search = document.getElementById("search");
    const searchButton = document.getElementById("search-button");
    const loading = document.getElementById("loading-bar");
    const result = document.getElementById("skripsi-result");
    const resultInfo = document.getElementById("result-info");
    

    if (!search || !loading || !result || !resultInfo) return;

    let controller = null;

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

    const loadData = async (url) => {

        // Batalkan request sebelumnya
        if (controller) {
            controller.abort();
        }

        controller = new AbortController();

        showLoading();

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

            // Update total hasil
            const meta = result.querySelector("#result-meta");

            if (meta) {
                resultInfo.innerHTML = `
                    Menampilkan
                    <span class="font-semibold text-blue-600">
                        ${Number(meta.dataset.total).toLocaleString("id-ID")}
                    </span>
                    skripsi
                `;
            }

            // Update URL browser tanpa reload
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

    const triggerSearch = () => {
        const url = new URL(window.location.href);

        if (search.value.trim() !== "") {
            url.searchParams.set("search", search.value.trim());
        } else {
            url.searchParams.delete("search");
        }

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
        }

        loadData(url);

    });

});
