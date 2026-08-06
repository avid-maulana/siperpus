document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("loginForm");
    const button = document.getElementById("loginButton");
    const arrow = document.getElementById("loginArrow");
    const overlay = document.getElementById("loadingOverlay");
    const captcha = document.getElementById("captcha");

    // Hentikan jika bukan halaman login
    if (!form || !button || !overlay) {
        return;
    }

    const inputs = [
        document.getElementById("username"),
        document.getElementById("password"),
        captcha,
    ];

    let overlayTimer = null;

    const updateLoginButton = () => {
        const isComplete = inputs.every((input) => {
            return input && input.value.trim() !== "";
        });

        button.classList.toggle("is-ready", isComplete);
    };

    inputs.forEach((input) => {
        input?.addEventListener("input", updateLoginButton);
    });

    updateLoginButton();

    inputs.forEach((input) => {
        input?.addEventListener("input", updateLoginButton);
    });

    updateLoginButton();

    /**
     * Menampilkan loading overlay.
     */
    const showOverlay = () => {
        clearTimeout(overlayTimer);

        overlayTimer = setTimeout(() => {
            overlay.classList.remove("hidden");
            overlay.classList.add("flex");

            requestAnimationFrame(() => {
                overlay.classList.remove("opacity-0");
                overlay.classList.add("opacity-100");
            });
        }, 180);
    };

    /**
     * Menyembunyikan loading overlay.
     */
    const hideOverlay = () => {
        clearTimeout(overlayTimer);

        overlay.classList.remove("opacity-100");
        overlay.classList.add("opacity-0");

        setTimeout(() => {
            overlay.classList.add("hidden");
            overlay.classList.remove("flex");
        }, 300);
    };

    /**
     * Efek tombol ketika form disubmit.
     */
    const setButtonActive = () => {
        button.classList.add("btn-press", "btn-loading");

        if (arrow) {
            arrow.classList.add("translate-x-1");
        }
    };

    /**
     * Enter:
     * username -> password -> captcha -> submit
     */
    form.addEventListener("keydown", (event) => {
        if (event.key !== "Enter") {
            return;
        }

        const activeIndex = inputs.indexOf(document.activeElement);

        if (activeIndex > -1 && activeIndex < inputs.length - 1) {
            event.preventDefault();

            inputs[activeIndex + 1]?.focus();
        }
    });

    /**
     * Ketika form disubmit.
     */
    form.addEventListener("submit", () => {
        setButtonActive();
        showOverlay();

        document.activeElement?.blur();
    });

    /**
     * Reset state ketika user kembali menggunakan
     * tombol Back browser.
     */
    window.addEventListener("pageshow", () => {
        hideOverlay();

        button.classList.remove("btn-press");

        if (arrow) {
            arrow.classList.remove("translate-x-1");
        }
    });

    /**
     * Validasi karakter input CAPTCHA.
     */
    if (captcha) {
        captcha.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9+\-*/xX]/g, "");
        });

        captcha.addEventListener("keypress", (event) => {
            if (!/[0-9+\-*/xX]/.test(event.key) && event.key !== "Enter") {
                event.preventDefault();
            }
        });

        captcha.addEventListener("paste", (event) => {
            event.preventDefault();

            const text = (event.clipboardData || window.clipboardData)
                .getData("text")
                .replace(/[^0-9+\-*/xX]/g, "");

            captcha.setRangeText(
                text,
                captcha.selectionStart,
                captcha.selectionEnd,
                "end",
            );

            captcha.dispatchEvent(
                new Event("input", {
                    bubbles: true,
                }),
            );
        });
    }
});
