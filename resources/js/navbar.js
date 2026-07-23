document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.getElementById("navbar");

    // Jika halaman tidak memiliki navbar, hentikan script
    if (!navbar) return;

    let lastScroll = 0;

    window.addEventListener(
        "scroll",
        () => {
            const current = window.scrollY;

            // Tambahkan shadow saat scroll
            navbar.classList.toggle("shadow-sm", current > 10);

            // Hide navbar saat scroll ke bawah, tampilkan saat scroll ke atas
            if (current > lastScroll && current > 80) {
                navbar.style.transform = "translateY(-100%)";
            } else {
                navbar.style.transform = "translateY(0)";
            }

            lastScroll = current;
        },
        { passive: true }
    );
});