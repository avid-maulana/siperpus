import Chart from "chart.js/auto";
import { escapeHtml, formatCompactNumber, formatNumber } from "./formatters.js";

const chartColors = [
    "#2563EB", "#7C3AED", "#059669", "#EA580C", "#DC2626",
    "#0891B2", "#4F46E5", "#DB2777", "#65A30D", "#C2410C",
    "#0F766E", "#9333EA", "#0284C7", "#BE123C", "#64748B",
    "#16A34A", "#CA8A04", "#6366F1", "#0D9488", "#E11D48",
];

const parseDataset = (value) => {
    if (!value) return [];
    try {
        const parsed = JSON.parse(value);
        return Array.isArray(parsed)
            ? parsed.map((item) => ({ label: item.label ?? "-", value: Number(item.value ?? 0) }))
            : [];
    } catch (error) {
        console.error("Gagal membaca data dashboard:", error);
        return [];
    }
};

function createDoughnutChart({ canvasId, data, centerLabel, chartState, type }) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const chartData = data.filter((item) => Number(item.value) > 0);
    const total = data.reduce((sum, item) => sum + Number(item.value || 0), 0);
    const displayData = chartData.length ? chartData : [{ label: "Belum ada data", value: 1 }];
    const colors = chartData.length ? displayData.map((_, index) => chartColors[index % chartColors.length]) : ["#E2E8F0"];
    const centerTextPlugin = {
        id: `centerText-${canvasId}`,
        afterDraw(chart) {
            if (!chart.chartArea) return;
            const { ctx, chartArea } = chart;
            const centerX = (chartArea.left + chartArea.right) / 2;
            const centerY = (chartArea.top + chartArea.bottom) / 2;
            ctx.save();
            ctx.textAlign = "center";
            ctx.textBaseline = "middle";
            ctx.fillStyle = "#0F172A";
            ctx.font = "700 30px Inter, system-ui, sans-serif";
            ctx.fillText(formatCompactNumber(total), centerX, centerY - 10);
            ctx.fillStyle = "#94A3B8";
            ctx.font = "500 13px Inter, system-ui, sans-serif";
            ctx.fillText(centerLabel, centerX, centerY + 22);
            ctx.restore();
        },
    };

    chartState.charts[type]?.destroy();
    chartState.charts[type] = new Chart(canvas, {
        type: "doughnut",
        data: {
            labels: displayData.map((item) => item.label),
            datasets: [{
                data: displayData.map((item) => item.value),
                backgroundColor: colors,
                borderColor: "#FFFFFF",
                borderWidth: 3,
                hoverBorderColor: "#FFFFFF",
                hoverBorderWidth: 3,
                hoverOffset: chartData.length ? 6 : 0,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: "68%",
            animation: { duration: 700, easing: "easeOutQuart" },
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: chartData.length > 0,
                    callbacks: {
                        label(context) {
                            const value = Number(context.raw) || 0;
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${formatNumber(value)} (${percentage}%)`;
                        },
                    },
                },
            },
        },
        plugins: [centerTextPlugin],
    });
}

function createLegend({ legendId, data, type, maxVisible = 3 }) {
    const container = document.getElementById(legendId);
    if (!container) return;

    const visibleItems = data.slice(0, maxVisible);
    const showAllButton = `<button type="button" data-chart-modal="${type}" class="mt-3 inline-flex w-full items-center justify-center gap-1.5 rounded-lg border border-transparent px-3 py-2 text-xs font-medium text-blue-600 transition-all duration-200 hover:border-blue-600 hover:bg-blue-600 hover:text-white active:scale-[0.98]"><span>Lihat semuanya</span><span class="material-symbols-outlined text-[16px]">open_in_new</span></button>`;

    if (!data.length) {
        container.innerHTML = `<div class="border-t border-slate-100 pt-4"><p class="py-3 text-center text-xs text-slate-400">Belum ada data.</p>${showAllButton}</div>`;
        return;
    }

    container.innerHTML = `<div class="border-t border-slate-100 pt-3"><div class="space-y-1">${visibleItems.map((item, index) => {
        const color = chartColors[index % chartColors.length];
        const isZero = Number(item.value) === 0;
        return `<div class="flex min-w-0 items-center gap-3 rounded-lg py-1.5"><span class="h-3 w-3 shrink-0 rounded-full" style="background-color:${color}"></span><span class="min-w-0 flex-1 truncate text-sm ${isZero ? "text-slate-400" : "text-slate-500"}" title="${escapeHtml(item.label)}">${escapeHtml(item.label)}</span><span class="shrink-0 text-sm font-semibold tabular-nums ${isZero ? "text-slate-400" : "text-slate-700"}">${formatNumber(item.value)}</span></div>`;
    }).join("")}</div>${showAllButton}</div>`;
}

export function createDashboardCharts() {
    const element = document.getElementById("dashboardCharts");
    const state = { charts: {}, datasets: {} };
    if (!element) return state;

    ["kbk", "type", "category"].forEach((type) => {
        state.datasets[type] = parseDataset(element.dataset[type]);
    });

    [
        ["kbkChart", "kbk", "Skripsi", "kbkLegend"],
        ["typeChart", "type", "Literatur", "typeLegend"],
        ["categoryChart", "category", "Literatur", "categoryLegend"],
    ].forEach(([canvasId, type, centerLabel, legendId]) => {
        createDoughnutChart({ canvasId, type, centerLabel, data: state.datasets[type], chartState: state });
        createLegend({ legendId, type, data: state.datasets[type] });
    });

    return state;
}

export { chartColors };
