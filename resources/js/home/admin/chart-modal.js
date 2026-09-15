import { chartColors } from "./charts.js";
import { escapeHtml, formatNumber, formatPercentage } from "./formatters.js";

const configs = {
    kbk: { title: "Distribusi KBK", subtitle: "Distribusi skripsi berdasarkan Kompetensi Bidang Keahlian.", unit: "Skripsi" },
    type: { title: "Distribusi Tipe Literatur", subtitle: "Distribusi koleksi berdasarkan tipe literatur.", unit: "Literatur" },
    category: { title: "Distribusi Kategori Literatur", subtitle: "Distribusi koleksi berdasarkan kategori literatur.", unit: "Literatur" },
};

const renderRows = (data) => {
    if (!data.length) return `<div class="flex min-h-[220px] flex-col items-center justify-center px-6 py-10 text-center"><span class="material-symbols-outlined text-4xl text-slate-300">database_off</span><p class="mt-3 text-sm font-medium text-slate-500">Belum ada data.</p></div>`;
    const total = data.reduce((sum, item) => sum + Number(item.value || 0), 0);
    return data.map((item, index) => {
        const value = Number(item.value || 0);
        const isZero = value === 0;
        const color = chartColors[index % chartColors.length];
        const percentage = total > 0 ? (value / total) * 100 : 0;
        return `<div class="grid grid-cols-[minmax(0,1fr)_72px_58px] gap-3 border-b border-slate-100 px-5 py-3.5 last:border-b-0 sm:grid-cols-[minmax(0,1fr)_90px_70px] sm:gap-4 sm:px-6"><div class="flex min-w-0 items-center gap-3"><span class="h-3 w-3 shrink-0 rounded-full" style="background-color:${color}"></span><span class="min-w-0 truncate text-sm ${isZero ? "text-slate-400" : "text-slate-600"}" title="${escapeHtml(item.label)}">${escapeHtml(item.label)}</span></div><p class="text-right text-sm font-semibold tabular-nums ${isZero ? "text-slate-400" : "text-slate-700"}">${formatNumber(value)}</p><p class="text-right text-sm tabular-nums ${isZero ? "text-slate-400" : "text-slate-500"}">${formatPercentage(percentage)}</p></div>`;
    }).join("");
};

export function createChartModal({ datasets }) {
    const modal = document.getElementById("chartDetailModal");
    const card = document.getElementById("chartDetailModalCard");
    if (!modal || !card) return { open: () => {}, close: () => {}, isOpen: () => false };
    if (modal.parentElement !== document.body) document.body.appendChild(modal);

    const close = () => {
        modal.classList.remove("opacity-100", "bg-slate-950/50", "backdrop-blur-sm");
        modal.classList.add("opacity-0", "bg-slate-950/0", "backdrop-blur-none");
        card.classList.remove("opacity-100", "scale-100", "translate-y-0");
        card.classList.add("opacity-0", "scale-95", "translate-y-4");
        window.setTimeout(() => { modal.classList.remove("flex"); modal.classList.add("hidden"); document.body.classList.remove("overflow-hidden"); }, 300);
    };

    const open = (type) => {
        const data = datasets[type] || [];
        const config = configs[type] || { title: "Detail Distribusi", subtitle: "Informasi lengkap distribusi data.", unit: "Data" };
        const title = document.getElementById("chartDetailTitle");
        const subtitle = document.getElementById("chartDetailSubtitle");
        const count = document.getElementById("chartDetailCount");
        const totalElement = document.getElementById("chartDetailTotal");
        const content = document.getElementById("chartDetailContent");
        const total = data.reduce((sum, item) => sum + Number(item.value || 0), 0);
        if (!title || !subtitle || !count || !totalElement || !content) return;
        title.textContent = config.title;
        subtitle.textContent = config.subtitle;
        count.textContent = formatNumber(data.length);
        totalElement.textContent = `${formatNumber(total)} ${config.unit}`;
        content.innerHTML = renderRows(data);
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

    document.addEventListener("click", (event) => { const button = event.target.closest("[data-chart-modal]"); if (button) open(button.dataset.chartModal); });
    modal.addEventListener("click", (event) => { if (event.target === modal) close(); });
    document.addEventListener("keydown", (event) => { if (event.key === "Escape" && !modal.classList.contains("hidden")) close(); });
    return { open, close, isOpen: () => !modal.classList.contains("hidden") };
}

export function exposeChartModal(modal) {
    window.openChartModal = modal.open;
    window.closeChartModal = modal.close;
}
