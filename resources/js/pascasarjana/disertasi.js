document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("dissertationSearchForm");
    const input = document.getElementById("dissertationSearchInput");
    const result = document.getElementById("dissertationResult");
    const loading = document.getElementById("dissertationSearchLoading");
    const clearButton = document.getElementById("dissertationClearSearch");

    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    if (!form || !input || !result) {
        return;
    }

    let searchTimer = null;

    /*
    |--------------------------------------------------------------------------
    | SHOW LOADING
    |--------------------------------------------------------------------------
    */

    function showLoading() {
        if (!loading) {
            return;
        }

        loading.classList.remove("hidden");
    }

    /*
    |--------------------------------------------------------------------------
    | HIDE LOADING
    |--------------------------------------------------------------------------
    */

    function hideLoading() {
        if (!loading) {
            return;
        }

        loading.classList.add("hidden");
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD DISERTASI
    |--------------------------------------------------------------------------
    */

    async function loadDissertations(page = 1, updateUrl = true) {
        const search = input.value.trim();
        const params = new URLSearchParams();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if (search.length > 0) {
            params.set("search", search);
        }

        /*
        |--------------------------------------------------------------------------
        | PAGE
        |--------------------------------------------------------------------------
        */

        params.set("page", page);

        /*
        |--------------------------------------------------------------------------
        | LOADING
        |--------------------------------------------------------------------------
        */

        showLoading();

        result.classList.add(
            "opacity-50",
            "pointer-events-none",
            "transition-opacity",
            "duration-200",
        );

        try {
            const response = await fetch(
                `${form.action}?${params.toString()}`,
                {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "text/html",
                    },
                },
            );

            /*
            |--------------------------------------------------------------------------
            | HTTP ERROR
            |--------------------------------------------------------------------------
            */

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            /*
            |--------------------------------------------------------------------------
            | HTML
            |--------------------------------------------------------------------------
            */

            const html = await response.text();

            /*
            |--------------------------------------------------------------------------
            | UPDATE RESULT
            |--------------------------------------------------------------------------
            */

            result.innerHTML = html;

            /*
            |--------------------------------------------------------------------------
            | UPDATE URL
            |--------------------------------------------------------------------------
            */

            if (updateUrl) {
                const newUrl = `${form.action}?${params.toString()}`;

                window.history.replaceState({}, "", newUrl);
            }

            /*
            |--------------------------------------------------------------------------
            | SCROLL
            |--------------------------------------------------------------------------
            */

            if (page > 1) {
                result.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            }
        } catch (error) {
            console.error("Gagal mengambil data disertasi:", error);

            /*
            |--------------------------------------------------------------------------
            | ERROR STATE
            |--------------------------------------------------------------------------
            */

            result.innerHTML = `
                <div
                    class="rounded-2xl
                           border border-red-200
                           bg-red-50
                           px-6 py-12
                           text-center">

                    <span
                        class="material-symbols-outlined
                               text-[32px]
                               text-red-400">
                        error
                    </span>

                    <h3
                        class="mt-4
                               text-base
                               font-bold
                               text-red-800">
                        Gagal memuat data disertasi
                    </h3>

                    <p
                        class="mt-2
                               text-sm
                               text-red-600">
                        Silakan coba lagi beberapa saat.
                    </p>
                </div>
            `;
        } finally {
            hideLoading();

            result.classList.remove("opacity-50", "pointer-events-none");
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH DEBOUNCE
    |--------------------------------------------------------------------------
    */

    input.addEventListener("input", () => {
        clearTimeout(searchTimer);

        searchTimer = setTimeout(() => {
            loadDissertations(1);
        }, 400);
    });

    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    |
    | _pagination.blade.php menggunakan:
    |
    | data-dissertation-page="..."
    |
    */

    result.addEventListener("click", (event) => {
        const button = event.target.closest("[data-dissertation-page]");

        if (!button) {
            return;
        }

        event.preventDefault();

        const page = parseInt(button.dataset.dissertationPage, 10);

        if (!page || page < 1) {
            return;
        }

        loadDissertations(page);
    });

    /*
    |--------------------------------------------------------------------------
    | CLEAR SEARCH
    |--------------------------------------------------------------------------
    */

    if (clearButton) {
        clearButton.addEventListener("click", () => {
            input.value = "";

            loadDissertations(1);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ENTER
    |--------------------------------------------------------------------------
    */

    form.addEventListener("submit", (event) => {
        event.preventDefault();

        clearTimeout(searchTimer);

        loadDissertations(1);
    });
});
