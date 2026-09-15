/*
|--------------------------------------------------------------------------
| User Homepage
|--------------------------------------------------------------------------
| JavaScript khusus halaman homepage pengguna SIPERPUS.
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {
    initUserHomepage();
});

function initUserHomepage() {
    const homepage = document.getElementById("userHomepage");

    if (!homepage) {
        return;
    }

    initHeroSlider();
    initHeroSearch();
}

function initHeroSlider() {
    const slides = document.querySelectorAll(".hero-slide");

    if (!slides.length) {
        return;
    }

    let currentIndex = 0;

    const showSlide = (index) => {
        slides.forEach((slide, slideIndex) => {
            slide.classList.toggle("active", slideIndex === index);
        });
    };

    showSlide(currentIndex);

    if (slides.length <= 1) {
        return;
    }

    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }, 7000);
}

function initHeroSearch() {
    const form = document.getElementById("heroSearchForm");
    const input = document.getElementById("search");
    const filterTarget = document.getElementById("filterTarget");
    const searchError = document.getElementById("search-error");
    const categoryButton = document.getElementById("searchCategoryButton");
    const categoryDropdown = document.getElementById("searchCategoryDropdown");
    const categoryLabel = document.getElementById("searchCategoryLabel");
    const categoryIcon = document.getElementById("searchCategoryIcon");
    const categoryArrow = document.getElementById("searchCategoryArrow");
    const literatureButton = document.getElementById("filterLiteratureBtn");
    const skripsiButton = document.getElementById("filterSkripsiBtn");
    const categoryOptions = document.querySelectorAll(".search-category-option");

    if (!form || !input || !filterTarget) {
        return;
    }

    const activeClasses = ["bg-white", "text-slate-950", "hover:bg-slate-100", "shadow-lg", "shadow-slate-950/15"];
    const inactiveClasses = ["border", "border-white/30", "bg-white/10", "text-white", "hover:bg-white/15"];

    const setQuickFilterState = (filter) => {
        [
            [literatureButton, "literature"],
            [skripsiButton, "skripsi"],
        ].forEach(([button, value]) => {
            if (!button) return;
            button.classList.remove(...activeClasses, ...inactiveClasses);
            button.classList.add(...(filter === value ? activeClasses : inactiveClasses));
        });
    };

    const openCategoryDropdown = () => {
        if (!categoryDropdown || !categoryButton) return;
        categoryDropdown.classList.remove("hidden");
        categoryButton.setAttribute("aria-expanded", "true");
        categoryArrow?.classList.add("rotate-180");
    };

    const closeCategoryDropdown = () => {
        if (!categoryDropdown || !categoryButton) return;
        categoryDropdown.classList.add("hidden");
        categoryButton.setAttribute("aria-expanded", "false");
        categoryArrow?.classList.remove("rotate-180");
    };

    const clearSearchError = () => {
        searchError?.classList.add("hidden");
        input.classList.remove("border-red-400", "ring-4", "ring-red-400/20");
    };

    const applyCategory = (element) => {
        if (!element) return;
        const { filter = "", label = "", icon = "category", route = "", placeholder = "" } = element.dataset;
        if (!route) {
            console.warn("Search category tidak memiliki route:", filter);
            closeCategoryDropdown();
            return;
        }
        filterTarget.value = filter;
        form.action = route;
        if (categoryLabel) categoryLabel.textContent = label;
        if (categoryIcon) categoryIcon.textContent = icon;
        if (placeholder) input.placeholder = placeholder;
        setQuickFilterState(filter);
        clearSearchError();
        closeCategoryDropdown();
    };

    categoryButton?.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();
        categoryDropdown?.classList.contains("hidden") ? openCategoryDropdown() : closeCategoryDropdown();
    });
    categoryOptions.forEach((option) => option.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();
        applyCategory(option);
    }));
    literatureButton?.addEventListener("click", (event) => { event.preventDefault(); applyCategory(literatureButton); });
    skripsiButton?.addEventListener("click", (event) => { event.preventDefault(); applyCategory(skripsiButton); });

    document.addEventListener("click", (event) => {
        if (categoryDropdown && categoryButton && !categoryDropdown.contains(event.target) && !categoryButton.contains(event.target)) {
            closeCategoryDropdown();
        }
    });
    document.addEventListener("keydown", (event) => { if (event.key === "Escape") closeCategoryDropdown(); });

    form.addEventListener("submit", (event) => {
        if (!input.value.trim()) {
            event.preventDefault();
            searchError?.classList.remove("hidden");
            input.classList.add("border-red-400", "ring-4", "ring-red-400/20");
            input.focus();
            return;
        }
        clearSearchError();
    });
    input.addEventListener("input", () => { if (input.value.trim()) clearSearchError(); });

    if (literatureButton) {
        applyCategory(literatureButton);
    }
}
