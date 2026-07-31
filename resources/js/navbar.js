document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.getElementById("navbar");

    if (navbar) {
        // Saklar: Jika scroll > 10px, tambahkan class "scrolled"
        const handleScroll = () => {
            if (window.scrollY > 10) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        };

        window.addEventListener("scroll", handleScroll, { passive: true });
        handleScroll(); // Pengecekan awal saat halaman diload
    }

    // --- Logout Overlay Handler ---
    const logoutForm = document.getElementById("logoutForm");
    const logoutButton = document.getElementById("logoutButton");
    const logoutOverlay = document.getElementById("logoutLoadingOverlay");

    if (logoutForm && logoutButton && logoutOverlay) {
        logoutForm.addEventListener("submit", () => {
            logoutOverlay.classList.remove("hidden");
            logoutOverlay.classList.add("flex");
            logoutButton.disabled = true;
            logoutButton.classList.add("opacity-70", "cursor-not-allowed");
        });
    }
});
