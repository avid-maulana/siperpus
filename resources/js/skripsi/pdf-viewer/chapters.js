const TRIGGER_SELECTOR = "[data-skripsi-pdf-viewer]";
const SIDEBAR_EXPANDED_CLASS = "w-72";
const SIDEBAR_COLLAPSED_CLASS = "w-20";

const bookIconSvg = `
    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 4.5A2.5 2.5 0 017.5 2H19v17H7.5A2.5 2.5 0 005 21.5v-17Z" />
        <path stroke-linecap="round" d="M5 19.5A2.5 2.5 0 017.5 17H19" />
    </svg>
`;

const toRoman = (number) => {
    const table = [
        ["M", 1000], ["CM", 900], ["D", 500], ["CD", 400],
        ["C", 100], ["XC", 90], ["L", 50], ["XL", 40],
        ["X", 10], ["IX", 9], ["V", 5], ["IV", 4], ["I", 1],
    ];
    let result = "";
    let remaining = number;

    for (const [roman, value] of table) {
        while (remaining >= value) {
            result += roman;
            remaining -= value;
        }
    }

    return result || "-";
};

const getTriggerValue = (button, primary, fallback) =>
    button.dataset[primary] || button.dataset[fallback] || "-";

const getTriggerRawValue = (button, primary, fallback) =>
    button.dataset[primary] || button.dataset[fallback] || "";

export function createChapterController({
    panel,
    toggle,
    toggleIcon,
    headerText,
    list,
    listTitle,
    onOpenPdf,
    updateZoomControlsPosition,
}) {
    let currentTriggerButton = null;
    let isExpanded = true;

    const getTriggerList = () => Array.from(document.querySelectorAll(TRIGGER_SELECTOR));

    const getSkripsiKey = (button) => {
        const nim = getTriggerRawValue(button, "pdfNim", "skripsiNim");
        if (nim) {
            return `nim:${nim}`;
        }
        return `judul:${getTriggerRawValue(button, "pdfSkripsi", "skripsiTitle")}`;
    };

    const getChapterGroup = (button) => {
        const key = getSkripsiKey(button);
        return getTriggerList().filter((item) => getSkripsiKey(item) === key);
    };

    const getChapterBadge = (item, index) => {
        const label = getTriggerValue(item, "pdfTitle", "skripsiChapter");
        if (/pustaka/i.test(label)) {
            return { icon: "book" };
        }
        const match = label.match(/\b([IVXLCDM]+)\b/i);
        return match ? { text: match[1].toUpperCase() } : { text: toRoman(index + 1) };
    };

    const applyExpandedState = () => {
        if (!panel) {
            return;
        }

        panel.dataset.expanded = isExpanded ? "true" : "false";
        panel.classList.toggle(SIDEBAR_EXPANDED_CLASS, isExpanded);
        panel.classList.toggle(SIDEBAR_COLLAPSED_CLASS, !isExpanded);
        headerText?.classList.toggle("hidden", !isExpanded);
        toggle?.setAttribute("aria-expanded", String(isExpanded));
        toggle?.setAttribute("aria-label", isExpanded ? "Ciutkan daftar bab" : "Perluas daftar bab");

        if (toggleIcon) {
            toggleIcon.style.transform = isExpanded ? "rotate(0deg)" : "rotate(180deg)";
        }

        list?.querySelectorAll(".chapter-label").forEach((element) => {
            element.classList.toggle("hidden", !isExpanded);
        });
        list?.querySelectorAll("button").forEach((button) => {
            button.classList.toggle("justify-center", !isExpanded);
        });
    };

    const render = () => {
        if (!list) {
            return;
        }

        list.innerHTML = "";
        if (!currentTriggerButton) {
            list.innerHTML = '<p class="px-3 py-4 text-sm text-slate-400">Tidak ada bab lain.</p>';
            if (listTitle) listTitle.textContent = "-";
            return;
        }

        const group = getChapterGroup(currentTriggerButton);
        if (listTitle) {
            listTitle.textContent = getTriggerValue(currentTriggerButton, "pdfSkripsi", "skripsiTitle");
        }

        if (!group.length) {
            list.innerHTML = '<p class="px-3 py-4 text-sm text-slate-400">Tidak ada bab lain.</p>';
            return;
        }

        group.forEach((item, index) => {
            const label = getTriggerValue(item, "pdfTitle", "skripsiChapter");
            const button = document.createElement("button");
            const badge = getChapterBadge(item, index);
            const badgeElement = document.createElement("span");
            const labelElement = document.createElement("span");
            const isActive = item === currentTriggerButton;

            button.type = "button";
            button.title = label;
            button.className = [
                "flex", "w-full", "items-center", "gap-3", "rounded-xl", "px-3", "py-3",
                "text-left", "transition-all", "duration-150",
                isActive ? "bg-slate-800 text-white" : "text-slate-600 hover:bg-slate-100 hover:text-slate-800",
            ].join(" ");

            badgeElement.className = [
                "flex", "h-8", "w-8", "shrink-0", "items-center", "justify-center", "rounded-lg", "text-xs", "font-bold",
                isActive ? "bg-white/15 text-white" : "bg-slate-100 text-slate-600",
            ].join(" ");
            badgeElement.innerHTML = badge.icon === "book" ? bookIconSvg : badge.text;

            labelElement.className = "chapter-label min-w-0 flex-1 whitespace-normal break-words text-sm font-medium leading-snug";
            labelElement.textContent = label;

            button.append(badgeElement, labelElement);
            button.addEventListener("click", (event) => {
                event.preventDefault();
                event.stopPropagation();
                if (!isActive) onOpenPdf(item);
            });
            list.appendChild(button);
        });

        applyExpandedState();
    };

    const setCurrentTrigger = (button) => {
        currentTriggerButton = button;
        render();
    };

    toggle?.addEventListener("click", (event) => {
        event.preventDefault();
        event.stopPropagation();
        isExpanded = !isExpanded;
        applyExpandedState();
        updateZoomControlsPosition();
    });

    window.addEventListener("resize", updateZoomControlsPosition);
    panel?.addEventListener("transitionend", (event) => {
        if (event.propertyName === "width") updateZoomControlsPosition();
    });

    applyExpandedState();
    updateZoomControlsPosition();

    return { render, setCurrentTrigger };
}
