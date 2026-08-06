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
    |
    | Script hanya dijalankan jika elemen homepage user ditemukan.
    |
    */

    const homepage = document.getElementById("userHomepage");

    if (!homepage) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Initialize Features
    |--------------------------------------------------------------------------
    |
    | Fitur homepage user berikutnya dapat dipanggil dari sini.
    |
    */

    initLiteratureCards();
}

/*
|--------------------------------------------------------------------------
| Literature Cards
|--------------------------------------------------------------------------
|
| Tempat untuk interaction khusus card literatur pada homepage.
| Untuk saat ini belum membutuhkan logic tambahan.
|
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
        | Contoh fitur yang nantinya bisa ditambahkan:
        |
        | - card animation
        | - quick preview
        | - bookmark
        | - tracking
        |
        */
    });
}
