document.addEventListener("DOMContentLoaded", () => {
    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const search = document.getElementById("search");
    const kbk = document.getElementById("kbk");
    const searchButton = document.getElementById("search-button");
    const loading = document.getElementById("loading-bar");
    const result = document.getElementById("skripsi-result");
    const resultInfo = document.getElementById("result-info");

    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    if (!search || !loading || !result || !resultInfo) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | AJAX CONTROLLER
    |--------------------------------------------------------------------------
    */

    let controller = null;
    let lastSearch = "";

    /*
    |--------------------------------------------------------------------------
    | LOADING BAR
    |--------------------------------------------------------------------------
    */

    const showLoading = () => {
        loading.style.opacity = "1";
        loading.style.width = "30%";

        setTimeout(() => {
            loading.style.width = "60%";
        }, 100);

        setTimeout(() => {
            loading.style.width = "85%";
        }, 250);
    };

    const hideLoading = () => {
        loading.style.width = "100%";

        setTimeout(() => {
            loading.style.opacity = "0";
            loading.style.width = "0";
        }, 200);
    };

    /*
    |--------------------------------------------------------------------------
    | LOADING STATE
    |--------------------------------------------------------------------------
    */

    const renderLoadingState = () => {
        result.innerHTML = `
            <div
                class="rounded-3xl
                       border
                       border-slate-200
                       bg-white
                       p-10
                       text-center
                       shadow-sm"
            >

                <div
                    class="mx-auto
                           mb-4
                           h-12
                           w-12
                           animate-spin
                           rounded-full
                           border-4
                           border-slate-200
                           border-t-slate-900"
                ></div>

                <p
                    class="text-sm
                           font-semibold
                           text-slate-700"
                >
                    Memuat hasil pencarian...
                </p>

                <p
                    class="mt-2
                           text-sm
                           text-slate-500"
                >
                    Harap tunggu sebentar sambil kami mencari
                    repository skripsi yang cocok.
                </p>

            </div>
        `;
    };

    /*
    |--------------------------------------------------------------------------
    | LOAD DATA
    |--------------------------------------------------------------------------
    */

    const loadData = async (url) => {
        /*
        |--------------------------------------------------------------------------
        | Batalkan request sebelumnya
        |--------------------------------------------------------------------------
        */

        if (controller) {
            controller.abort();
        }

        controller = new AbortController();

        /*
        |--------------------------------------------------------------------------
        | Loading
        |--------------------------------------------------------------------------
        */

        showLoading();
        renderLoadingState();

        try {
            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },

                signal: controller.signal,
            });

            /*
            |--------------------------------------------------------------------------
            | Validasi Response
            |--------------------------------------------------------------------------
            */

            if (!response.ok) {
                throw new Error("Gagal memuat data");
            }

            /*
            |--------------------------------------------------------------------------
            | Ambil HTML
            |--------------------------------------------------------------------------
            */

            const html = await response.text();

            /*
            |--------------------------------------------------------------------------
            | Render Result
            |--------------------------------------------------------------------------
            */

            result.innerHTML = html;

            /*
            |--------------------------------------------------------------------------
            | Update Total
            |--------------------------------------------------------------------------
            */

            const meta = result.querySelector("#result-meta");

            if (meta) {
                resultInfo.innerHTML = `
                    ${Number(meta.dataset.total).toLocaleString("id-ID")}

                    <span
                        class="text-base
                               font-medium
                               text-slate-500"
                    >
                        Skripsi
                    </span>
                `;
            }

            /*
            |--------------------------------------------------------------------------
            | Update URL
            |--------------------------------------------------------------------------
            */

            history.replaceState({}, "", response.url);
        } catch (error) {
            if (error.name !== "AbortError") {
                console.error("Gagal memuat repository Skripsi:", error);
            }
        } finally {
            hideLoading();
        }
    };

    /*
    |--------------------------------------------------------------------------
    | TRIGGER SEARCH
    |--------------------------------------------------------------------------
    */

    const triggerSearch = () => {
        const url = new URL(window.location.href);

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        const searchValue = search.value.trim();

        if (searchValue !== "") {
            url.searchParams.set("search", searchValue);
        } else {
            url.searchParams.delete("search");
        }

        /*
        |--------------------------------------------------------------------------
        | KBK
        |--------------------------------------------------------------------------
        */

        if (kbk && kbk.value !== "") {
            url.searchParams.set("kbk", kbk.value);
        } else {
            url.searchParams.delete("kbk");
        }

        /*
        |--------------------------------------------------------------------------
        | Reset Page
        |--------------------------------------------------------------------------
        */

        url.searchParams.delete("page");

        /*
        |--------------------------------------------------------------------------
        | Hindari Request Duplikat
        |--------------------------------------------------------------------------
        */

        const requestUrl = url.toString();

        if (requestUrl === lastSearch) {
            return;
        }

        lastSearch = requestUrl;

        /*
        |--------------------------------------------------------------------------
        | Load
        |--------------------------------------------------------------------------
        */

        loadData(url);
    };

    /*
    |--------------------------------------------------------------------------
    | ENTER
    |--------------------------------------------------------------------------
    */

    search.addEventListener("keydown", (event) => {
        if (event.key !== "Enter") {
            return;
        }

        event.preventDefault();

        triggerSearch();
    });

    /*
    |--------------------------------------------------------------------------
    | SEARCH BUTTON
    |--------------------------------------------------------------------------
    */

    searchButton?.addEventListener("click", () => {
        search.focus();

        triggerSearch();
    });

    /*
    |--------------------------------------------------------------------------
    | KBK
    |--------------------------------------------------------------------------
    */

    kbk?.addEventListener("change", () => {
        triggerSearch();
    });

    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    document.addEventListener("click", (event) => {
        const link = event.target.closest(".pagination a");

        if (!link) {
            return;
        }

        event.preventDefault();

        const url = new URL(link.href);

        /*
            |--------------------------------------------------------------------------
            | Pertahankan Search
            |--------------------------------------------------------------------------
            */

        if (search.value.trim() !== "") {
            url.searchParams.set("search", search.value.trim());
        } else {
            url.searchParams.delete("search");
        }

        /*
            |--------------------------------------------------------------------------
            | Pertahankan KBK
            |--------------------------------------------------------------------------
            */

        if (kbk && kbk.value !== "") {
            url.searchParams.set("kbk", kbk.value);
        } else {
            url.searchParams.delete("kbk");
        }

        /*
            |--------------------------------------------------------------------------
            | Load Pagination
            |--------------------------------------------------------------------------
            */

        lastSearch = url.toString();

        loadData(url);
    });
});
