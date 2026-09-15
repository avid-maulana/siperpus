export function moveToBody(element) {
    if (element && element.parentElement !== document.body) {
        document.body.appendChild(element);
    }
}

export function createModalController({ modal, panel, backdrop, lockBody = true }) {
    const lock = () => lockBody && document.body.classList.add("overflow-hidden");
    const unlock = () => lockBody && document.body.classList.remove("overflow-hidden");

    const open = () => {
        if (!modal || !panel || !backdrop) return;
        modal.classList.remove("hidden");
        modal.classList.add("flex");
        backdrop.classList.remove("opacity-100");
        backdrop.classList.add("opacity-0");
        panel.classList.remove("translate-y-0", "scale-100", "opacity-100");
        panel.classList.add("translate-y-4", "scale-95", "opacity-0");
        void modal.offsetWidth;
        requestAnimationFrame(() => {
            backdrop.classList.remove("opacity-0");
            backdrop.classList.add("opacity-100");
            panel.classList.remove("translate-y-4", "scale-95", "opacity-0");
            panel.classList.add("translate-y-0", "scale-100", "opacity-100");
        });
        lock();
    };

    const close = (afterClose) => {
        if (!modal || !panel || !backdrop) return;
        backdrop.classList.remove("opacity-100");
        backdrop.classList.add("opacity-0");
        panel.classList.remove("translate-y-0", "scale-100", "opacity-100");
        panel.classList.add("translate-y-4", "scale-95", "opacity-0");
        setTimeout(() => {
            modal.classList.add("hidden");
            modal.classList.remove("flex");
            unlock();
            afterClose?.();
        }, 300);
    };

    return { open, close };
}

export function createSimpleModal(element) {
    return {
        open() {
            element?.classList.remove("hidden");
            element?.classList.add("flex");
        },
        close() {
            element?.classList.add("hidden");
            element?.classList.remove("flex");
        },
    };
}
