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

    initLiteratureCards();
    initHeroFilterButtons();
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
| Tombol:
| - Temukan Literatur
| - Temukan Skripsi
|
| Masing-masing tombol menuju route yang disimpan
| pada atribut data-route.
|
|--------------------------------------------------------------------------
*/

function initHeroFilterButtons() {
    const literatureBtn = document.getElementById("filterLiteratureBtn");
    const skripsiBtn = document.getElementById("filterSkripsiBtn");

    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    */

    if (!literatureBtn || !skripsiBtn) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Literature
    |--------------------------------------------------------------------------
    */

    literatureBtn.addEventListener("click", () => {
        const route = literatureBtn.dataset.route;

        if (!route) {
            return;
        }

        window.location.href = route;
    });

    /*
    |--------------------------------------------------------------------------
    | Skripsi
    |--------------------------------------------------------------------------
    */

    skripsiBtn.addEventListener("click", () => {
        const route = skripsiBtn.dataset.route;

        if (!route) {
            return;
        }

        window.location.href = route;
    });
}
