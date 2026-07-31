import "./bootstrap";
import "./skripsi";
import "./literature";
import "./navbar";
import "./home";

document.addEventListener("DOMContentLoaded", () => {
    const loader = document.getElementById("page-loader");
    const page = document.getElementById("page-content");

    // Animasi masuk halaman
    if (page) {
        requestAnimationFrame(() => {
            page.classList.add("page-enter");
        });
    }

    // Tampilkan loader saat pindah halaman
    document.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", function () {
            if (this.hasAttribute("data-ajax-page")) {
                return;
            }

            const href = this.getAttribute("href");

            if (
                !href ||
                href.startsWith("#") ||
                href.startsWith("javascript:") ||
                this.target === "_blank" ||
                this.hasAttribute("download")
            ) {
                return;
            }

            loader?.classList.remove("opacity-0", "invisible");
            loader?.classList.add("opacity-100");
        });
    });
});
