/*
|--------------------------------------------------------------------------
| ADMIN PRAKTIK INDUSTRI
|--------------------------------------------------------------------------
| Search + AJAX Result + Pagination + Sort Kolom
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {
    /*
    |--------------------------------------------------------------------------
    | ELEMENT
    |--------------------------------------------------------------------------
    */

    const resultContainer = document.getElementById(
        "praktikIndustriAdminResult",
    );

    const paginationContainer =
        document.getElementById(
            "praktikIndustriAdminPagination",
        );

    const searchForm =
        document.querySelector(
            'form[action*="praktik-industri"]',
        );

    if (!resultContainer) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let controller = null;

    let searchTimer = null;

    /*
    |--------------------------------------------------------------------------
    | EXPORT RESULT CONTAINER
    |--------------------------------------------------------------------------
    |
    | Dipakai oleh:
    | - admin-detail.js
    | - admin-history.js
    |
    */

    window.praktikIndustriAdmin =
        window.praktikIndustriAdmin || {};

    window.praktikIndustriAdmin.getResultContainer =
        () => resultContainer;

    /*
    |--------------------------------------------------------------------------
    | LOADING BAR
    |--------------------------------------------------------------------------
    */

    const showLoading = () => {
        resultContainer.classList.add(
            "relative",
            "pointer-events-none",
            "opacity-60",
        );
    };

    const hideLoading = () => {
        resultContainer.classList.remove(
            "pointer-events-none",
            "opacity-60",
        );
    };

    /*
    |--------------------------------------------------------------------------
    | BUILD URL
    |--------------------------------------------------------------------------
    |
    | search = true  -> override param 'search' pakai isi input pencarian
    |                   saat ini (dipakai untuk submit search & pagination).
    |
    | Param 'sort' & 'direction' TIDAK disentuh di sini secara sengaja:
    | link header kolom sudah membawa nilai sort/direction yang benar
    | dari server (lihat _table.blade.php), jadi tinggal diteruskan apa
    | adanya lewat 'url' yang dipakai fetchResult().
    |
    */

    const buildUrl = (url, search = null) => {
        const currentUrl = new URL(
            url,
            window.location.origin,
        );

        /*
        |--------------------------------------------------------------------------
        | SEARCH FORM
        |--------------------------------------------------------------------------
        */

        if (search !== null) {
            const input =
                searchForm?.querySelector(
                    '[name="search"]',
                );

            if (input) {
                const value =
                    input.value.trim();

                if (value) {
                    currentUrl.searchParams.set(
                        "search",
                        value,
                    );
                } else {
                    currentUrl.searchParams.delete(
                        "search",
                    );
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */

        const filterInput =
            searchForm?.querySelector(
                '[name="filter"]',
            );

        if (filterInput) {
            const value =
                filterInput.value.trim();

            if (value) {
                currentUrl.searchParams.set(
                    "filter",
                    value,
                );
            } else {
                currentUrl.searchParams.delete(
                    "filter",
                );
            }
        }

        return currentUrl.toString();
    };

    /*
    |--------------------------------------------------------------------------
    | FETCH RESULT
    |--------------------------------------------------------------------------
    */

    const fetchResult = async (
        url,
        options = {},
    ) => {
        /*
        |--------------------------------------------------------------------------
        | ABORT REQUEST SEBELUMNYA
        |--------------------------------------------------------------------------
        */

        if (controller) {
            controller.abort();
        }

        controller =
            new AbortController();

        /*
        |--------------------------------------------------------------------------
        | LOADING
        |--------------------------------------------------------------------------
        */

        showLoading();

        try {
            const response =
                await fetch(
                    buildUrl(url, true),
                    {
                        method: "GET",

                        headers: {
                            Accept:
                                "application/json",

                            "X-Requested-With":
                                "XMLHttpRequest",
                        },

                        signal:
                            controller.signal,
                    },
                );

            if (!response.ok) {
                throw new Error(
                    `HTTP ${response.status}`,
                );
            }

            const data =
                await response.json();

            /*
            |--------------------------------------------------------------------------
            | UPDATE RESULT
            |--------------------------------------------------------------------------
            */

            if (
                typeof data.result !==
                "undefined"
            ) {
                resultContainer.innerHTML =
                    data.result;
            } else if (
                typeof data.html !==
                "undefined"
            ) {
                resultContainer.innerHTML =
                    data.html;
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE PAGINATION
            |--------------------------------------------------------------------------
            */

            if (
                paginationContainer &&
                typeof data.pagination !==
                    "undefined"
            ) {
                paginationContainer.innerHTML =
                    data.pagination;
            }

            /*
            |--------------------------------------------------------------------------
            | EVENT
            |--------------------------------------------------------------------------
            |
            | Memberitahu:
            | - admin-detail.js
            | - admin-history.js
            |
            */

            document.dispatchEvent(
                new CustomEvent(
                    "praktikIndustriAdminResultUpdated",
                ),
            );

            /*
            |--------------------------------------------------------------------------
            | UPDATE URL
            |--------------------------------------------------------------------------
            */

            if (
                options.pushState !==
                false
            ) {
                window.history.pushState(
                    {},
                    "",
                    buildUrl(url, true),
                );
            }

            /*
            |--------------------------------------------------------------------------
            | SCROLL
            |--------------------------------------------------------------------------
            */

            if (
                options.scroll !== false
            ) {
                resultContainer.scrollIntoView(
                    {
                        behavior: "smooth",
                        block: "start",
                    },
                );
            }
        } catch (error) {
            /*
            |--------------------------------------------------------------------------
            | ABORT DIABAIKAN
            |--------------------------------------------------------------------------
            */

            if (
                error.name ===
                "AbortError"
            ) {
                return;
            }

            console.error(
                "Gagal memuat data Praktik Industri:",
                error,
            );

            /*
            |--------------------------------------------------------------------------
            | ERROR STATE
            |--------------------------------------------------------------------------
            */

            resultContainer.innerHTML = `
                <div
                    class="
                        flex
                        min-h-[280px]
                        items-center
                        justify-center
                        rounded-2xl
                        border
                        border-red-200
                        bg-red-50
                        p-8
                    "
                >

                    <div
                        class="
                            max-w-sm
                            text-center
                        "
                    >

                        <div
                            class="
                                mx-auto
                                flex
                                h-14
                                w-14
                                items-center
                                justify-center
                                rounded-2xl
                                bg-red-100
                                text-red-500
                            "
                        >

                            <span
                                class="
                                    material-symbols-outlined
                                    text-[26px]
                                "
                            >
                                error
                            </span>

                        </div>


                        <h3
                            class="
                                mt-4
                                text-sm
                                font-bold
                                text-red-700
                            "
                        >
                            Gagal memuat data
                        </h3>


                        <p
                            class="
                                mt-1
                                text-xs
                                leading-5
                                text-red-500
                            "
                        >
                            Terjadi kesalahan saat mengambil
                            data laporan Praktik Industri.
                        </p>


                        <button
                            type="button"
                            data-retry
                            class="
                                mt-4
                                inline-flex
                                items-center
                                gap-2
                                rounded-xl
                                bg-[#212A37]
                                px-4
                                py-2.5
                                text-xs
                                font-semibold
                                text-white
                            "
                        >

                            <span
                                class="
                                    material-symbols-outlined
                                    text-[16px]
                                "
                            >
                                refresh
                            </span>

                            Coba Lagi

                        </button>

                    </div>

                </div>
            `;
        } finally {
            hideLoading();
        }
    };

    /*
    |--------------------------------------------------------------------------
    | SEARCH SUBMIT
    |--------------------------------------------------------------------------
    */

    searchForm?.addEventListener(
        "submit",
        (event) => {
            event.preventDefault();

            clearTimeout(
                searchTimer,
            );

            const action =
                searchForm.action ||
                window.location.pathname;

            fetchResult(action, {
                pushState: true,
                scroll: true,
            });
        },
    );

    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        "click",
        (event) => {
            const link =
                event.target.closest(
                    "#praktikIndustriAdminPagination a",
                );

            if (!link) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Biarkan modifier key bekerja normal
            |--------------------------------------------------------------------------
            */

            if (
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey
            ) {
                return;
            }

            event.preventDefault();

            fetchResult(
                link.href,
                {
                    pushState: true,
                    scroll: true,
                },
            );
        },
    );

    /*
    |--------------------------------------------------------------------------
    | SORT DROPDOWN (buka / tutup menu pilihan arah)
    |--------------------------------------------------------------------------
    |
    | Klik tombol header (data-sort-toggle) -> buka/tutup menu
    | (data-sort-menu) miliknya, dan tutup semua menu lain yang
    | sedang terbuka.
    |
    | Klik di luar area manapun -> tutup semua menu.
    |
    */

    document.addEventListener(
        "click",
        (event) => {
            const toggle =
                event.target.closest(
                    "#praktikIndustriAdminResult [data-sort-toggle]",
                );

            /*
            |--------------------------------------------------------------------------
            | TUTUP MENU LAIN
            |--------------------------------------------------------------------------
            */

            document
                .querySelectorAll(
                    "#praktikIndustriAdminResult [data-sort-menu]",
                )
                .forEach((menu) => {

                    const isOwnMenu =
                        toggle &&
                        menu.dataset.sortMenu ===
                            toggle.dataset.column;

                    if (!isOwnMenu) {
                        menu.classList.add("hidden");
                    }

                });

            if (!toggle) {
                return;
            }

            event.preventDefault();
            event.stopPropagation();

            const menu =
                document.querySelector(
                    `#praktikIndustriAdminResult [data-sort-menu="${toggle.dataset.column}"]`,
                );

            menu?.classList.toggle("hidden");
        },
    );

    /*
    |--------------------------------------------------------------------------
    | SORT KOLOM (klik salah satu pilihan di dropdown)
    |--------------------------------------------------------------------------
    |
    | Link opsi (data-sort-link) sudah membawa query 'sort', 'direction',
    | dan 'page=1' dari server (lihat _table.blade.php), search tetap ikut
    | karena link dibangun dari fullUrlWithQuery() yang mempertahankan
    | query yang sedang aktif.
    |
    */

    document.addEventListener(
        "click",
        (event) => {
            const link =
                event.target.closest(
                    "#praktikIndustriAdminResult [data-sort-link]",
                );

            if (!link) {
                return;
            }

            if (
                event.ctrlKey ||
                event.metaKey ||
                event.shiftKey ||
                event.altKey
            ) {
                return;
            }

            event.preventDefault();

            fetchResult(
                link.href,
                {
                    pushState: true,
                    scroll: false,
                },
            );
        },
    );

    /*
    |--------------------------------------------------------------------------
    | RETRY
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        "click",
        (event) => {
            const retry =
                event.target.closest(
                    "[data-retry]",
                );

            if (!retry) {
                return;
            }

            const url =
                window.location.href;

            fetchResult(url, {
                pushState: false,
                scroll: false,
            });
        },
    );

    /*
    |--------------------------------------------------------------------------
    | BROWSER BACK / FORWARD
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        "popstate",
        () => {
            fetchResult(
                window.location.href,
                {
                    pushState: false,
                    scroll: false,
                },
            );
        },
    );

    /*
    |--------------------------------------------------------------------------
    | INITIAL EVENT
    |--------------------------------------------------------------------------
    */

    document.dispatchEvent(
        new CustomEvent(
            "praktikIndustriAdminResultUpdated",
        ),
    );
});