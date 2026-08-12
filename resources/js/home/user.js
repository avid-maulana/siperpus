/*
|--------------------------------------------------------------------------
| User Homepage
|--------------------------------------------------------------------------
|
| JavaScript khusus halaman homepage pengguna SIPERPUS.
|
| Semua interaksi yang hanya digunakan oleh homepage user
| diletakkan di file ini.
|
| Jangan masukkan fitur dashboard admin ke file ini.
|
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {
    initUserHomepage();
});

/*
|--------------------------------------------------------------------------
| Initialize User Homepage
|--------------------------------------------------------------------------
*/

function initUserHomepage() {
    /*
    |--------------------------------------------------------------------------
    | Homepage Guard
    |--------------------------------------------------------------------------
    */

    const homepage = document.getElementById("userHomepage");

    if (!homepage) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Initialize Features
    |--------------------------------------------------------------------------
    */

    initHeroSlider();
    initLiteratureCards();
    initHeroFilterButtons();
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

    let current = 0;

    const showSlide = (index) => {
        slides.forEach((slide, i) => {
            if (i === index) {
                /*
                |--------------------------------------------------------------------------
                | Reset Animation
                |--------------------------------------------------------------------------
                */

                slide.style.animation = "none";

                /*
                | Trigger reflow
                */

                slide.offsetHeight;

                slide.style.animation = "";

                slide.classList.add("active");
            } else {
                slide.classList.remove("active");
            }
        });
    };

    /*
    |--------------------------------------------------------------------------
    | Initial Slide
    |--------------------------------------------------------------------------
    */

    showSlide(current);

    /*
    |--------------------------------------------------------------------------
    | Slider
    |--------------------------------------------------------------------------
    */

    setInterval(() => {
        current = (current + 1) % slides.length;

        showSlide(current);
    }, 7000);
}

/*
|--------------------------------------------------------------------------
| Literature Cards
|--------------------------------------------------------------------------
*/

function initLiteratureCards() {
    const cards = document.querySelectorAll("[data-literature-card]");

    if (!cards.length) {
        return;
    }

    cards.forEach((card) => {
        /*
        |--------------------------------------------------------------------------
        | Future Interaction
        |--------------------------------------------------------------------------
        |
        | - card animation
        | - quick preview
        | - bookmark
        | - tracking
        |
        */
    });
}

/*
|--------------------------------------------------------------------------
| Hero Filter Buttons
|--------------------------------------------------------------------------
|
| Mengatur:
| - Temukan Literatur
| - Temukan Skripsi
|
| Tombol hanya mengubah mode pencarian.
| Tidak langsung melakukan redirect.
|
|--------------------------------------------------------------------------
*/

function initHeroFilterButtons() {
    const literatureBtn = document.getElementById("filterLiteratureBtn");

    const skripsiBtn = document.getElementById("filterSkripsiBtn");

    const searchForm = document.getElementById("heroSearchForm");

    const filterTarget = document.getElementById("filterTarget");

    const searchInput = document.getElementById("search");

    const searchError = document.getElementById("search-error");

    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    */

    if (!literatureBtn || !skripsiBtn || !searchForm || !filterTarget) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Button Style
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
    | Set Active Button
    |--------------------------------------------------------------------------
    */

    const setActiveButton = (activeButton, inactiveButton) => {
        /*
        | Active
        */

        activeButton.classList.remove(...inactiveClasses);

        activeButton.classList.add(...activeClasses);

        /*
        | Inactive
        */

        inactiveButton.classList.remove(...activeClasses);

        inactiveButton.classList.add(...inactiveClasses);
    };

    /*
    |--------------------------------------------------------------------------
    | Apply Search Mode
    |--------------------------------------------------------------------------
    */

    const applyMode = (mode) => {
        const button = mode === "skripsi" ? skripsiBtn : literatureBtn;

        const route = button.dataset.route;

        /*
        |--------------------------------------------------------------------------
        | Update Target
        |--------------------------------------------------------------------------
        */

        filterTarget.value = mode;

        /*
        |--------------------------------------------------------------------------
        | Update Form Action
        |--------------------------------------------------------------------------
        */

        if (route) {
            searchForm.action = route;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Button State
        |--------------------------------------------------------------------------
        */

        if (mode === "skripsi") {
            setActiveButton(skripsiBtn, literatureBtn);

            if (searchInput) {
                searchInput.placeholder =
                    "Cari judul skripsi, penulis, atau kata kunci...";
            }
        } else {
            setActiveButton(literatureBtn, skripsiBtn);

            if (searchInput) {
                searchInput.placeholder =
                    "Cari judul literatur, penulis, atau kata kunci...";
            }
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Temukan Literatur
    |--------------------------------------------------------------------------
    */

    literatureBtn.addEventListener("click", (event) => {
        event.preventDefault();

        applyMode("literature");
    });

    /*
    |--------------------------------------------------------------------------
    | Temukan Skripsi
    |--------------------------------------------------------------------------
    */

    skripsiBtn.addEventListener("click", (event) => {
        event.preventDefault();

        applyMode("skripsi");
    });

    /*
    |--------------------------------------------------------------------------
    | Default
    |--------------------------------------------------------------------------
    */

    applyMode("literature");

    /*
    |--------------------------------------------------------------------------
    | Search Validation
    |--------------------------------------------------------------------------
    */

    if (!searchInput) {
        return;
    }

    searchForm.addEventListener("submit", (event) => {
        const keyword = searchInput.value.trim();

        /*
        |--------------------------------------------------------------------------
        | Empty Search
        |--------------------------------------------------------------------------
        */

        if (!keyword) {
            event.preventDefault();

            if (searchError) {
                searchError.classList.remove("hidden");
            }

            searchInput.classList.add(
                "border-red-400",
                "ring-4",
                "ring-red-400/20",
            );

            searchInput.focus();

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Valid Search
        |--------------------------------------------------------------------------
        */

        if (searchError) {
            searchError.classList.add("hidden");
        }

        searchInput.classList.remove(
            "border-red-400",
            "ring-4",
            "ring-red-400/20",
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Search Input
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener("input", () => {
        if (searchInput.value.trim() !== "") {
            if (searchError) {
                searchError.classList.add("hidden");
            }

            searchInput.classList.remove(
                "border-red-400",
                "ring-4",
                "ring-red-400/20",
            );
        }
    });
}
