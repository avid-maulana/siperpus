import "./bootstrap";

import "./skripsi";
import "./literature";
import "./navbar";

import "./home/user";

import "./disertasi/repository";

import "./pdf-viewer";

/*
|--------------------------------------------------------------------------
| Praktik Industri
|--------------------------------------------------------------------------
|
| User
| - laporan.js
|
| Admin
| - admin.js
|
*/

import "./praktik-industri/laporan";
import "./praktik-industri/admin";

/*
|--------------------------------------------------------------------------
| Page Loader
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {
    const loader = document.getElementById("page-loader");

    const page = document.getElementById("page-content");

    /*
    |--------------------------------------------------------------------------
    | Animasi Masuk Halaman
    |--------------------------------------------------------------------------
    */

    if (page) {
        requestAnimationFrame(() => {
            page.classList.add("page-enter");
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Loader Saat Pindah Halaman
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", function () {
            /*
                    |--------------------------------------------------------------------------
                    | Lewati Link AJAX
                    |--------------------------------------------------------------------------
                    */

            if (this.hasAttribute("data-ajax-page")) {
                return;
            }

            const href = this.getAttribute("href");

            /*
                    |--------------------------------------------------------------------------
                    | Link Tidak Perlu Loader
                    |--------------------------------------------------------------------------
                    */

            if (
                !href ||
                href.startsWith("#") ||
                href.startsWith("javascript:") ||
                this.target === "_blank" ||
                this.hasAttribute("download")
            ) {
                return;
            }

            /*
                    |--------------------------------------------------------------------------
                    | Tampilkan Loader
                    |--------------------------------------------------------------------------
                    */

            if (loader) {
                loader.classList.remove("opacity-0", "invisible");

                loader.classList.add("opacity-100");
            }
        });
    });
});

/*
|--------------------------------------------------------------------------
| Fix Back / Forward Browser
|--------------------------------------------------------------------------
|
| Ketika halaman dikembalikan dari browser cache
| (bfcache), loader harus dipastikan hilang
| dan content kembali terlihat.
|
|--------------------------------------------------------------------------
*/

window.addEventListener("pageshow", (event) => {
    const loader = document.getElementById("page-loader");

    const page = document.getElementById("page-content");

    /*
        |--------------------------------------------------------------------------
        | Pastikan Loader Hilang
        |--------------------------------------------------------------------------
        */

    if (loader) {
        loader.classList.remove("opacity-100");

        loader.classList.add("opacity-0", "invisible");
    }

    /*
        |--------------------------------------------------------------------------
        | Pastikan Content Terlihat
        |--------------------------------------------------------------------------
        */

    if (page) {
        page.classList.add("page-enter");
    }

    /*
        |--------------------------------------------------------------------------
        | Cek Stylesheet Setelah bfcache
        |--------------------------------------------------------------------------
        */

    if (event.persisted) {
        const stylesheets = Array.from(
            document.querySelectorAll('link[rel="stylesheet"]'),
        );

        const viteStylesheetExists = stylesheets.some((link) =>
            link.href.includes("/build/assets/"),
        );

        /*
            |--------------------------------------------------------------------------
            | Reload Jika Stylesheet Vite Hilang
            |--------------------------------------------------------------------------
            */

        if (!viteStylesheetExists) {
            window.location.reload();
        }
    }
});
