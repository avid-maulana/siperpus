export function createViewerUi({
    modal,
    modalContent,
    detailPanel,
    detailToggle,
    detailBackdrop,
}) {
    const resetDetail = () => {
        detailPanel?.classList.remove("translate-x-0");
        detailPanel?.classList.add("translate-x-full");
        detailBackdrop?.classList.add("hidden");
        detailToggle?.setAttribute("aria-expanded", "false");
    };

    const openDetail = () => {
        if (!detailPanel) return;
        detailPanel.classList.remove("translate-x-full");
        detailPanel.classList.add("translate-x-0");
        detailBackdrop?.classList.remove("hidden");
        detailToggle?.setAttribute("aria-expanded", "true");
    };

    const closeDetail = () => {
        if (!detailPanel) return;
        detailPanel.classList.remove("translate-x-0");
        detailPanel.classList.add("translate-x-full");
        detailBackdrop?.classList.add("hidden");
        detailToggle?.setAttribute("aria-expanded", "false");
    };

    const toggleDetail = () => {
        detailPanel?.classList.contains("translate-x-0") ? closeDetail() : openDetail();
    };

    const animateOpen = () => {
        modal.classList.remove("hidden", "opacity-100");
        modal.classList.add("opacity-0");
        modalContent.classList.remove("translate-y-0", "scale-100");
        modalContent.classList.add("translate-y-2", "scale-[0.99]");
        void modal.offsetWidth;
        requestAnimationFrame(() => {
            modal.classList.remove("opacity-0");
            modal.classList.add("opacity-100");
            modalContent.classList.remove("translate-y-2", "scale-[0.99]");
            modalContent.classList.add("translate-y-0", "scale-100");
        });
    };

    const animateClose = (callback) => {
        modalContent.classList.remove("translate-y-0", "scale-100");
        modalContent.classList.add("translate-y-2", "scale-[0.99]");
        modal.classList.remove("opacity-100");
        modal.classList.add("opacity-0");
        window.setTimeout(callback, 300);
    };

    return { animateClose, animateOpen, closeDetail, resetDetail, toggleDetail };
}
