document.addEventListener("DOMContentLoaded", () => {

    // =====================================================
    // VALIDASI HALAMAN
    // =====================================================

    const filterForm = document.getElementById("filterForm");

    if (!filterForm) return;

    // =====================================================
    // ELEMENT
    // =====================================================

    const searchInput = document.getElementById("searchInput");
    const clearBtn = document.getElementById("clearSearch");

    const typeSelect = document.getElementById("typeSelect");
    const categorySelect = document.getElementById("categorySelect");

    const resultsContainer = document.getElementById("resultsContainer");
    const loadingBar = document.getElementById("loadingBar");

    const customDropdowns = document.querySelectorAll(".dropdown-container");
    const typeDropdown = document.getElementById("customTypeDropdown");
    const categoryDropdown = document.getElementById("customCategoryDropdown");

    // =====================================================
    // STATE
    // =====================================================

    const state = {
        debounceTimer: null,
        activeController: null,
        loadingBarTimer: null,
    };

    // =====================================================
    // LOADING BAR
    // =====================================================

    const startLoadingBar = () => {

        clearInterval(state.loadingBarTimer);

        loadingBar.style.transition = "none";
        loadingBar.style.width = "0%";
        loadingBar.style.opacity = "1";

        // Force reflow
        void loadingBar.offsetWidth;

        loadingBar.style.transition =
            "width 0.3s ease-out, opacity 0.3s ease-out";

        let progress = 0;

        state.loadingBarTimer = setInterval(() => {

            progress += (90 - progress) * 0.1;

            loadingBar.style.width = `${progress}%`;

        }, 120);

        resultsContainer.classList.add("is-loading");

    };

    const finishLoadingBar = () => {

        clearInterval(state.loadingBarTimer);

        loadingBar.style.width = "100%";

        setTimeout(() => {
            loadingBar.style.opacity = "0";
        }, 150);

        resultsContainer.classList.remove("is-loading");

    };
        // =====================================================
    // DROPDOWN
    // =====================================================

    const closeDropdown = (container) => {

        if (!container) return;

        const menu = container.querySelector(".dropdown-menu");
        const arrow = container.querySelector(".dropdown-trigger svg");

        menu?.classList.add(
            "opacity-0",
            "invisible",
            "scale-95",
            "pointer-events-none"
        );

        menu?.classList.remove(
            "opacity-100",
            "visible",
            "scale-100",
            "pointer-events-allowed"
        );

        arrow?.classList.remove("rotate-180");

    };

    customDropdowns.forEach((container) => {

        const trigger = container.querySelector(".dropdown-trigger");
        const menu = container.querySelector(".dropdown-menu");
        const arrow = trigger.querySelector("svg");

        trigger.addEventListener("click", (e) => {

            e.stopPropagation();

            customDropdowns.forEach((other) => {

                if (other !== container) {
                    closeDropdown(other);
                }

            });

            const isOpen = !menu.classList.contains("opacity-0");

            if (isOpen) {

                closeDropdown(container);

            } else {

                menu.classList.remove(
                    "opacity-0",
                    "invisible",
                    "scale-95",
                    "pointer-events-none"
                );

                menu.classList.add(
                    "opacity-100",
                    "visible",
                    "scale-100",
                    "pointer-events-allowed"
                );

                arrow.classList.add("rotate-180");

            }

        });

        const items = container.querySelectorAll(".dropdown-item");

        items.forEach((item) => {

            item.addEventListener("click", () => {

                const value = item.dataset.value;

                const select =
                    container.id === "customTypeDropdown"
                        ? typeSelect
                        : categorySelect;

                select.value = value;

                closeDropdown(container);

                select.dispatchEvent(new Event("change"));

            });

        });

    });

    document.addEventListener("click", () => {

        customDropdowns.forEach((container) => {

            closeDropdown(container);

        });

    });

    // =====================================================
    // FILTER
    // =====================================================

    const filterCategoryOptions = () => {

        const selectedType = typeSelect.value;

        Array.from(categorySelect.options).forEach((option) => {

            const optionType = option.dataset.type;

            option.hidden =
                !!(selectedType && optionType && optionType !== selectedType);

        });

        if (categoryDropdown) {

            const items =
                categoryDropdown.querySelectorAll(".dropdown-item");

            items.forEach((item) => {

                const optionType = item.dataset.type;

                if (selectedType && optionType && optionType !== selectedType) {

                    item.classList.add("hidden");

                } else {

                    item.classList.remove("hidden");

                }

            });

        }

    };

    const syncCustomDropdownLabels = () => {

        customDropdowns.forEach((container) => {

            const select =
                container.id === "customTypeDropdown"
                    ? typeSelect
                    : categorySelect;

            const label = container.querySelector(".selected-text");

            if (!select || !label) return;

            const activeOption = select.options[select.selectedIndex];

            label.textContent = activeOption
                ? activeOption.text
                : "";

        });

    };
        // =====================================================
    // AJAX
    // =====================================================

    const buildUrl = () => {

        const params = new URLSearchParams();

        if (searchInput.value.trim()) {
            params.set("search", searchInput.value.trim());
        }

        if (typeSelect.value) {
            params.set("type_id", typeSelect.value);
        }

        if (categorySelect.value) {
            params.set("category_id", categorySelect.value);
        }

        const queryString = params.toString();

        return filterForm.action + (queryString ? `?${queryString}` : "");

    };

    const syncControlsFromUrl = (url) => {

        let params;

        try {

            params = new URL(url, window.location.origin).searchParams;

        } catch {

            return;

        }

        searchInput.value = params.get("search") || "";
        typeSelect.value = params.get("type_id") || "";

        filterCategoryOptions();

        categorySelect.value = params.get("category_id") || "";

        syncCustomDropdownLabels();

        clearBtn.classList.toggle(
            "hidden",
            !searchInput.value
        );

    };

    const applyResultsFromHtml = async (html) => {

        const parser = new DOMParser();

        const documentHtml = parser.parseFromString(
            html,
            "text/html"
        );

        const newResults =
            documentHtml.getElementById("resultsContainer");

        if (newResults) {

            resultsContainer.innerHTML = newResults.innerHTML;

        }

    };

    const fetchResults = async (
        url,
        {
            pushState = true,
            syncControls = false,
        } = {}
    ) => {

        if (state.activeController) {

            state.activeController.abort();

        }

        state.activeController = new AbortController();

        startLoadingBar();

        try {

            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
                signal: state.activeController.signal,
            });

            const html = await response.text();

            await applyResultsFromHtml(html);

            if (syncControls) {

                syncControlsFromUrl(url);

            }

            if (pushState) {

                window.history.pushState({}, "", url);

            }

            finishLoadingBar();

        } catch (error) {

            if (error.name === "AbortError") {

                return;

            }

            console.error(
                "Gagal memuat data literatur:",
                error
            );

            finishLoadingBar();

        }

    };
        // =====================================================
    // EVENT LISTENER
    // =====================================================

    searchInput.addEventListener("input", () => {

        clearBtn.classList.toggle(
            "hidden",
            !searchInput.value
        );

        clearTimeout(state.debounceTimer);

        state.debounceTimer = setTimeout(() => {

            fetchResults(buildUrl());

        }, 400);

    });

    clearBtn.addEventListener("click", () => {

        searchInput.value = "";

        clearBtn.classList.add("hidden");

        fetchResults(buildUrl());

        searchInput.focus();

    });

    typeSelect.addEventListener("change", () => {

        filterCategoryOptions();

        categorySelect.value = "";

        syncCustomDropdownLabels();

        fetchResults(buildUrl());

    });

    categorySelect.addEventListener("change", () => {

        syncCustomDropdownLabels();

        fetchResults(buildUrl());

    });

    resultsContainer.addEventListener("click", (event) => {

        const link = event.target.closest("a[data-ajax-page]");

        if (!link) return;

        event.preventDefault();

        window.scrollTo({
            top: 0,
            behavior: "smooth",
        });

        fetchResults(link.href, {
            syncControls: link.hasAttribute("data-reset-filter"),
        });

    });

    filterForm.addEventListener("submit", (event) => {

        event.preventDefault();

        clearTimeout(state.debounceTimer);

        fetchResults(buildUrl());

    });

    window.addEventListener("popstate", () => {

        fetchResults(window.location.href, {
            pushState: false,
            syncControls: true,
        });

    });

    // =====================================================
    // INITIALIZE
    // =====================================================

    filterCategoryOptions();

    syncCustomDropdownLabels();

});