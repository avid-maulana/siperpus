import "./bootstrap";
import "./skripsi";
import "./literature";
import "./navbar";
import "./home";

document.addEventListener("DOMContentLoaded", () => {
    const loader = document.getElementById("page-loader");
    const page = document.getElementById("page-content");

    // ================================
    // ANIMASI MASUK HALAMAN
    // ================================
    if (page) {
        requestAnimationFrame(() => {
            page.classList.add("page-enter");
        });
    }

    // ================================
    // LOADER SAAT PINDAH HALAMAN
    // ================================
    document.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", function () {
            // Link AJAX tidak menggunakan page loader
            if (this.hasAttribute("data-ajax-page")) {
                return;
            }

            const href = this.getAttribute("href");

            // Abaikan link yang tidak melakukan navigasi halaman
            if (
                !href ||
                href.startsWith("#") ||
                href.startsWith("javascript:") ||
                this.target === "_blank" ||
                this.hasAttribute("download")
            ) {
                return;
            }

            if (loader) {
                loader.classList.remove(
                    "opacity-0",
                    "invisible"
                );

                loader.classList.add("opacity-100");
            }
        });
    });
});


// ====================================
// FIX KETIKA KEMBALI DENGAN BACK/FORWARD
// ====================================
window.addEventListener("pageshow", (event) => {
    const loader = document.getElementById("page-loader");
    const page = document.getElementById("page-content");

    // Pastikan loader selalu hilang
    if (loader) {
        loader.classList.remove("opacity-100");
        loader.classList.add(
            "opacity-0",
            "invisible"
        );
    }

    // Pastikan content terlihat kembali
    if (page) {
        page.classList.add("page-enter");
    }

    // Jika halaman berasal dari bfcache,
    // cek apakah stylesheet Vite masih tersedia
    if (event.persisted) {
        const stylesheets = Array.from(
            document.querySelectorAll('link[rel="stylesheet"]')
        );

        const viteStylesheetExists = stylesheets.some((link) =>
            link.href.includes("/build/assets/")
        );

        if (!viteStylesheetExists) {
            window.location.reload();
        }
    }
});