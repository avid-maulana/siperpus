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

/*
|--------------------------------------------------------------------------
| User Homepage Initialization
|--------------------------------------------------------------------------
*/

function initUserHomepage() {
    const homepage = document.getElementById("userHomepage");

    if (!homepage) {
        return;
    }

    initHeroSlider();
    initHeroSearch();
}

/*
|--------------------------------------------------------------------------
| Hero Background Slider
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Hero Search
|--------------------------------------------------------------------------
*/

function initHeroSearch() {
    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const form = document.getElementById("heroSearchForm");

    const input = document.getElementById("search");

    const filterTarget = document.getElementById("filterTarget");

    const searchError = document.getElementById("search-error");

    /*
    |--------------------------------------------------------------------------
    | Category Button
    |--------------------------------------------------------------------------
    */

    const categoryButton = document.getElementById("searchCategoryButton");

    const categoryDropdown = document.getElementById("searchCategoryDropdown");

    const categoryLabel = document.getElementById("searchCategoryLabel");

    const categoryIcon = document.getElementById("searchCategoryIcon");

    const categoryArrow = document.getElementById("searchCategoryArrow");

    /*
    |--------------------------------------------------------------------------
    | Quick Filter Buttons
    |--------------------------------------------------------------------------
    */

    const literatureButton = document.getElementById("filterLiteratureBtn");

    const skripsiButton = document.getElementById("filterSkripsiBtn");

    /*
    |--------------------------------------------------------------------------
    | Category Options
    |--------------------------------------------------------------------------
    */

    const categoryOptions = document.querySelectorAll(
        ".search-category-option",
    );

    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    */

    if (!form || !input || !filterTarget) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Button Styles
    |--------------------------------------------------------------------------
    */

    const activeClasses = [
        "bg-white",
        "text-slate-950",
        "hover:bg-slate-100",
        "shadow-lg",
        "shadow-slate-950/15",
    ];

    const inactiveClasses = [
        "border",
        "border-white/30",
        "bg-white/10",
        "text-white",
        "hover:bg-white/15",
    ];

    /*
    |--------------------------------------------------------------------------
    | Set Quick Filter State
    |--------------------------------------------------------------------------
    */

    const setQuickFilterState = (filter) => {
        /*
        |--------------------------------------------------------------------------
        | Literature
        |--------------------------------------------------------------------------
        */

        if (literatureButton) {
            literatureButton.classList.remove(
                ...activeClasses,
                ...inactiveClasses,
            );

            if (filter === "literature") {
                literatureButton.classList.add(...activeClasses);
            } else {
                literatureButton.classList.add(...inactiveClasses);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Skripsi
        |--------------------------------------------------------------------------
        */

        if (skripsiButton) {
            skripsiButton.classList.remove(
                ...activeClasses,
                ...inactiveClasses,
            );

            if (filter === "skripsi") {
                skripsiButton.classList.add(...activeClasses);
            } else {
                skripsiButton.classList.add(...inactiveClasses);
            }
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Open Dropdown
    |--------------------------------------------------------------------------
    */

    const openCategoryDropdown = () => {
        if (!categoryDropdown || !categoryButton) {
            return;
        }

        categoryDropdown.classList.remove("hidden");

        categoryButton.setAttribute("aria-expanded", "true");

        if (categoryArrow) {
            categoryArrow.classList.add("rotate-180");
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Close Dropdown
    |--------------------------------------------------------------------------
    */

    const closeCategoryDropdown = () => {
        if (!categoryDropdown || !categoryButton) {
            return;
        }

        categoryDropdown.classList.add("hidden");

        categoryButton.setAttribute("aria-expanded", "false");

        if (categoryArrow) {
            categoryArrow.classList.remove("rotate-180");
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Toggle Dropdown
    |--------------------------------------------------------------------------
    */

    const toggleCategoryDropdown = () => {
        if (!categoryDropdown) {
            return;
        }

        const isClosed = categoryDropdown.classList.contains("hidden");

        if (isClosed) {
            openCategoryDropdown();
        } else {
            closeCategoryDropdown();
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Clear Search Error
    |--------------------------------------------------------------------------
    */

    const clearSearchError = () => {
        if (searchError) {
            searchError.classList.add("hidden");
        }

        input.classList.remove("border-red-400", "ring-4", "ring-red-400/20");
    };

    /*
    |--------------------------------------------------------------------------
    | Apply Search Category
    |--------------------------------------------------------------------------
    */

    const applyCategory = (element) => {
        if (!element) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Read Dataset
        |--------------------------------------------------------------------------
        */

        const filter = element.dataset.filter || "";

        const label = element.dataset.label || "";

        const icon = element.dataset.icon || "category";

        const route = element.dataset.route || "";

        const placeholder = element.dataset.placeholder || "";

        /*
        |--------------------------------------------------------------------------
        | Route Guard
        |--------------------------------------------------------------------------
        */

        if (!route) {
            console.warn("Search category tidak memiliki route:", filter);

            closeCategoryDropdown();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Hidden Filter
        |--------------------------------------------------------------------------
        */

        filterTarget.value = filter;

        /*
        |--------------------------------------------------------------------------
        | Update Form Action
        |--------------------------------------------------------------------------
        */

        form.action = route;

        /*
        |--------------------------------------------------------------------------
        | Update Category Label
        |--------------------------------------------------------------------------
        */

        if (categoryLabel) {
            categoryLabel.textContent = label;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Category Icon
        |--------------------------------------------------------------------------
        */

        if (categoryIcon) {
            categoryIcon.textContent = icon;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Placeholder
        |--------------------------------------------------------------------------
        */

        if (placeholder) {
            input.placeholder = placeholder;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Quick Filter
        |--------------------------------------------------------------------------
        */

        setQuickFilterState(filter);

        /*
        |--------------------------------------------------------------------------
        | Clear Validation
        |--------------------------------------------------------------------------
        */

        clearSearchError();

        /*
        |--------------------------------------------------------------------------
        | Close Dropdown
        |--------------------------------------------------------------------------
        */

        closeCategoryDropdown();
    };

    /*
    |--------------------------------------------------------------------------
    | Category Button Click
    |--------------------------------------------------------------------------
    */

    if (categoryButton) {
        categoryButton.addEventListener("click", (event) => {
            event.preventDefault();
            event.stopPropagation();

            toggleCategoryDropdown();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Category Option Click
    |--------------------------------------------------------------------------
    */

    categoryOptions.forEach((option) => {
        option.addEventListener("click", (event) => {
            event.preventDefault();
            event.stopPropagation();

            applyCategory(option);
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Literature Quick Button
    |--------------------------------------------------------------------------
    */

    if (literatureButton) {
        literatureButton.addEventListener("click", (event) => {
            event.preventDefault();

            applyCategory(literatureButton);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Skripsi Quick Button
    |--------------------------------------------------------------------------
    */

    if (skripsiButton) {
        skripsiButton.addEventListener("click", (event) => {
            event.preventDefault();

            applyCategory(skripsiButton);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Close Dropdown When Clicking Outside
    |--------------------------------------------------------------------------
    */

    document.addEventListener("click", (event) => {
        if (!categoryDropdown || !categoryButton) {
            return;
        }

        const clickedDropdown = categoryDropdown.contains(event.target);

        const clickedButton = categoryButton.contains(event.target);

        if (!clickedDropdown && !clickedButton) {
            closeCategoryDropdown();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Close Dropdown With Escape
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape") {
            closeCategoryDropdown();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Search Submit Validation
    |--------------------------------------------------------------------------
    */

    form.addEventListener("submit", (event) => {
        const keyword = input.value.trim();

        /*
            |--------------------------------------------------------------------------
            | Empty Keyword
            |--------------------------------------------------------------------------
            */

        if (!keyword) {
            event.preventDefault();

            if (searchError) {
                searchError.classList.remove("hidden");
            }

            input.classList.add("border-red-400", "ring-4", "ring-red-400/20");

            input.focus();

            return;
        }

        /*
            |--------------------------------------------------------------------------
            | Valid Keyword
            |--------------------------------------------------------------------------
            */

        clearSearchError();
    });

    /*
    |--------------------------------------------------------------------------
    | Clear Error While Typing
    |--------------------------------------------------------------------------
    */

    input.addEventListener("input", () => {
        if (input.value.trim() !== "") {
            clearSearchError();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Default Category
    |--------------------------------------------------------------------------
    |
    | Homepage selalu dimulai dari Literatur.
    |--------------------------------------------------------------------------
    */

    if (literatureButton) {
        applyCategory(literatureButton);
    }
}
