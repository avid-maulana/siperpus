export function createLoginActivityModal() {
    const modal = document.getElementById("loginActivityModal");
    const openButton = document.getElementById("openLoginActivityModal");
    if (!modal || !openButton) return { open: () => {}, close: () => {}, isOpen: () => false };
    const card = document.getElementById("loginActivityModalCard");
    if (modal.parentElement !== document.body) document.body.appendChild(modal);

    const open = () => {
        if (!card) return;
        document.body.classList.add("overflow-hidden");
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        requestAnimationFrame(() => requestAnimationFrame(() => {
            modal.classList.remove("opacity-0", "bg-slate-950/0", "backdrop-blur-none");
            modal.classList.add("opacity-100", "bg-slate-950/50", "backdrop-blur-sm");
            card.classList.remove("opacity-0", "scale-95", "translate-y-4");
            card.classList.add("opacity-100", "scale-100", "translate-y-0");
        }));
    };

    const close = () => {
        if (!card) return;
        modal.classList.remove("opacity-100", "bg-slate-950/50", "backdrop-blur-sm");
        modal.classList.add("opacity-0", "bg-slate-950/0", "backdrop-blur-none");
        card.classList.remove("opacity-100", "scale-100", "translate-y-0");
        card.classList.add("opacity-0", "scale-95", "translate-y-4");
        window.setTimeout(() => { modal.classList.remove("flex"); modal.classList.add("hidden"); document.body.classList.remove("overflow-hidden"); }, 300);
    };

    openButton.addEventListener("click", open);
    modal.querySelectorAll("[data-close-login-modal]").forEach((button) => button.addEventListener("click", close));
    modal.addEventListener("click", (event) => { if (event.target === modal) close(); });
    document.addEventListener("keydown", (event) => { if (event.key === "Escape" && !modal.classList.contains("hidden")) close(); });
    return { open, close, isOpen: () => !modal.classList.contains("hidden") };
}

export function exposeLoginModal(modal) {
    window.openLoginActivityModal = modal.open;
    window.closeLoginActivityModal = modal.close;
}
