document.addEventListener("DOMContentLoaded", () => {
    const searchForm = document.querySelector(
        'form[action*="/praktik-industri"]',
    );

    const searchInput = searchForm?.querySelector('input[name="search"]');

    const resultContainer = document.getElementById("praktikIndustriResult");

    if (!searchForm || !searchInput || !resultContainer) {
        return;
    }

    let controller = null;

    /*
    |--------------------------------------------------------------------------
    | Loading Bar
    |--------------------------------------------------------------------------
    */

    const createLoadingBar = () => {
        let loadingBar = document.getElementById(
            "praktik-industri-loading-bar",
        );

        if (loadingBar) {
            return loadingBar;
        }

        loadingBar = document.createElement("div");

        loadingBar.id = "praktik-industri-loading-bar";

        loadingBar.className = `
            fixed
            left-0
            top-0
            z-[9999]
            h-[3px]
            w-0
            bg-blue-600
            opacity-0
            transition-all
            duration-300
        `;

        document.body.appendChild(loadingBar);

        return loadingBar;
    };

    const showLoading = () => {
        const loadingBar = createLoadingBar();

        loadingBar.style.width = "15%";
        loadingBar.style.opacity = "1";

        requestAnimationFrame(() => {
            loadingBar.style.width = "70%";
        });
    };

    const hideLoading = () => {
        const loadingBar = createLoadingBar();

        loadingBar.style.width = "100%";

        setTimeout(() => {
            loadingBar.style.opacity = "0";

            setTimeout(() => {
                loadingBar.style.width = "0";
            }, 200);
        }, 200);
    };

    /*
    |--------------------------------------------------------------------------
    | Loading Result
    |--------------------------------------------------------------------------
    */

    const showResultLoading = () => {
        resultContainer.classList.add("pointer-events-none", "opacity-50");

        resultContainer.style.transition = "opacity 200ms ease";
    };

    const hideResultLoading = () => {
        resultContainer.classList.remove("pointer-events-none", "opacity-50");
    };

    /*
    |--------------------------------------------------------------------------
    | Fetch Result
    |--------------------------------------------------------------------------
    */

    const fetchResults = async (url, pushState = true) => {
        if (controller) {
            controller.abort();
        }

        controller = new AbortController();

        showLoading();
        showResultLoading();

        try {
            const response = await fetch(url, {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "text/html",
                },
                signal: controller.signal,
            });

            if (!response.ok) {
                throw new Error(`HTTP error ${response.status}`);
            }

            const html = await response.text();

            const parser = new DOMParser();

            const documentHTML = parser.parseFromString(html, "text/html");

            const newResult = documentHTML.getElementById(
                "praktikIndustriResult",
            );

            if (!newResult) {
                throw new Error(
                    "Container hasil Praktik Industri tidak ditemukan.",
                );
            }

            resultContainer.innerHTML = newResult.innerHTML;

            /*
            |--------------------------------------------------------------------------
            | Update URL
            |--------------------------------------------------------------------------
            */

            if (pushState) {
                window.history.pushState({}, "", url);
            }

            /*
            |--------------------------------------------------------------------------
            | Scroll ke hasil
            |--------------------------------------------------------------------------
            */

            const resultTop =
                resultContainer.getBoundingClientRect().top +
                window.scrollY -
                100;

            window.scrollTo({
                top: resultTop,
                behavior: "smooth",
            });

            /*
            |--------------------------------------------------------------------------
            | Re-bind Pagination
            |--------------------------------------------------------------------------
            */

            bindPagination();
        } catch (error) {
            if (error.name === "AbortError") {
                return;
            }

            console.error("Praktik Industri:", error);

            resultContainer.innerHTML = `
                <div class="rounded-2xl border border-red-200 bg-red-50 px-6 py-12 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100">
                        <span class="material-symbols-outlined text-red-500">
                            error
                        </span>
                    </div>

                    <h3 class="mt-4 text-base font-semibold text-red-700">
                        Gagal memuat laporan
                    </h3>

                    <p class="mt-1 text-sm text-red-600">
                        Terjadi kesalahan saat mengambil data.
                        Silakan coba lagi.
                    </p>
                </div>
            `;
        } finally {
            hideLoading();
            hideResultLoading();
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Search Submit (hanya jalan saat Enter / klik tombol Cari)
    |--------------------------------------------------------------------------
    */

    searchForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const formData = new FormData(searchForm);

        const params = new URLSearchParams(formData);

        const url = `${searchForm.action}?${params.toString()}`;

        fetchResults(url);
    });

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

    const bindPagination = () => {
        const paginationLinks = resultContainer.querySelectorAll("a[href]");

        paginationLinks.forEach((link) => {
            if (link.dataset.piBound === "true") {
                return;
            }

            link.dataset.piBound = "true";

            link.addEventListener("click", (event) => {
                const href = link.getAttribute("href");

                if (!href || href === "#" || link.hasAttribute("target")) {
                    return;
                }

                /*
                    | Hanya intercept pagination
                    */

                if (!href.includes("praktik-industri")) {
                    return;
                }

                event.preventDefault();

                fetchResults(href);
            });
        });
    };

    /*
    |--------------------------------------------------------------------------
    | Browser Back / Forward
    |--------------------------------------------------------------------------
    */

    window.addEventListener("popstate", () => {
        fetchResults(window.location.href, false);
    });

    /*
    |--------------------------------------------------------------------------
    | Initial Binding
    |--------------------------------------------------------------------------
    */

    bindPagination();
});                                                                                                                                                                                                                                                                                                                                                