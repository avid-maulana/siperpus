document.addEventListener("DOMContentLoaded", () => {

    const search = document.getElementById("search");
    const loading = document.getElementById("loading-bar");
    const result = document.getElementById("skripsi-result");
    const resultInfo = document.getElementById("result-info");
    

    if (!search || !loading || !result || !resultInfo) return;

    let timeout;
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

    search.addEventListener("input", function () {

        clearTimeout(timeout);

        timeout = setTimeout(() => {

            const url = new URL("/skripsi", window.location.origin);

            if (this.value.trim() !== "") {
                url.searchParams.set("search", this.value.trim());
            }

            loadData(url);

        }, 400);

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