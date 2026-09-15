export function initRepositoryTable() {
    document.querySelectorAll("[data-repository-section]").forEach((section) => {
        const toggle = section.querySelector("[data-repository-toggle]");
        const content = section.querySelector("[data-repository-content]");
        const icon = section.querySelector("[data-repository-icon]");

        if (!toggle || !content || !icon) return;

        const isActive = section.dataset.repositorySection === "active";
        content.style.maxHeight = isActive ? "0px" : `${content.scrollHeight}px`;
        icon.textContent = isActive ? "expand_more" : "expand_less";

        toggle.addEventListener("click", () => {
            const isOpen = content.style.maxHeight !== "0px";
            content.style.maxHeight = isOpen ? "0px" : `${content.scrollHeight}px`;
            icon.textContent = isOpen ? "expand_more" : "expand_less";
        });
    });
}
