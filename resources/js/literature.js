document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("filterForm");

    if (!form) return;

    const search = document.getElementById("searchInput");
    const clear = document.getElementById("clearSearch");
    const reset = document.getElementById("resetSearch");
    const type = document.getElementById("typeSelect");
    const category = document.getElementById("categorySelect");
    const results = document.getElementById("resultsContainer");

    let debounce = null;
    let controller = null;

    /**
     * Build URL
     */
    function buildUrl(base = form.action) {

        const params = new URLSearchParams();

        if (search.value.trim()) {
            params.set("search", search.value.trim());
        }

        if (type?.value) {
            params.set("type_id", type.value);
        }

        if (category?.value) {
            params.set("category_id", category.value);
        }

        return params.toString()
            ? `${base}?${params.toString()}`
            : base;
    }

    /**
     * Render Result
     */
    function render(html) {
        results.innerHTML = html;
    }

    /**
     * AJAX Request
     */
    async function request(url, push = true) {

        controller?.abort();

        controller = new AbortController();

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

            render(await response.text());

            if (push) {
                history.pushState({}, "", url);
            }

        } catch (error) {

            if (error.name !== "AbortError") {
                console.error(error);
            }

        }

    }

    /**
     * Refresh Data
     */
    function refresh(push = true) {
        request(buildUrl(), push);
    }

    /**
     * Prevent Form Submit
     */
    form.addEventListener("submit", e => {
        e.preventDefault();
    });

    /**
     * Live Search
     */
    search.addEventListener("input", () => {

        clear.classList.toggle("hidden", !search.value.trim());

        clearTimeout(debounce);

        debounce = setTimeout(() => {

            refresh();

        }, 300);

    });

    /**
     * Filter Type
     */
    type?.addEventListener("change", () => {

        refresh();

    });

    /**
     * Filter Category
     */
    category?.addEventListener("change", () => {

        refresh();

    });

    /**
     * Clear Search
     */
    clear?.addEventListener("click", () => {

        search.value = "";

        clear.classList.add("hidden");

        refresh();

        search.focus();

    });

    /**
     * Reset Filter
     */
    reset?.addEventListener("click", () => {

        search.value = "";

        if (type) type.value = "";
        if (category) category.value = "";

        clear.classList.add("hidden");

        refresh();

        search.focus();

    });

    /**
     * AJAX Pagination
     */
    results.addEventListener("click", (e) => {

        const link = e.target.closest("[data-ajax-page]");

        if (!link) return;

        e.preventDefault();

        request(link.href);

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });

    });

    /**
     * Browser Back / Forward
     */
    window.addEventListener("popstate", () => {

        const params = new URL(location.href).searchParams;

        search.value = params.get("search") || "";

        if (type) {
            type.value = params.get("type_id") || "";
        }

        if (category) {
            category.value = params.get("category_id") || "";
        }

        clear.classList.toggle("hidden", !search.value.trim());

        request(location.href, false);

    });

});