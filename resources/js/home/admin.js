import Chart from "chart.js/auto";

/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
|
| JavaScript khusus halaman dashboard admin SIPERPUS.
|
| Fitur:
| - Doughnut chart KBK
| - Doughnut chart tipe
| - Doughnut chart kategori
| - Custom legend
| - Modal detail distribusi
|
*/

document.addEventListener("DOMContentLoaded", () => {
    initDistributionCharts();
    initChartModal();
    initLoginActivityModal();
});

/*
|--------------------------------------------------------------------------
| Dashboard State
|--------------------------------------------------------------------------
*/

const dashboardState = {
    charts: {},
    datasets: {
        kbk: [],
        type: [],
        category: [],
    },
};

/*
|--------------------------------------------------------------------------
| Chart Colors
|--------------------------------------------------------------------------
*/

const chartColors = [
    "#2563EB",
    "#7C3AED",
    "#059669",
    "#EA580C",
    "#DC2626",
    "#0891B2",
    "#4F46E5",
    "#DB2777",
    "#65A30D",
    "#C2410C",
    "#0F766E",
    "#9333EA",
    "#0284C7",
    "#BE123C",
    "#64748B",
    "#16A34A",
    "#CA8A04",
    "#6366F1",
    "#0D9488",
    "#E11D48",
];

/*
|--------------------------------------------------------------------------
| Initialize Distribution Charts
|--------------------------------------------------------------------------
*/

function initDistributionCharts() {
    const dashboardCharts = document.getElementById("dashboardCharts");

    if (!dashboardCharts) {
        return;
    }

    dashboardState.datasets.kbk = parseDataset(dashboardCharts.dataset.kbk);

    dashboardState.datasets.type = parseDataset(dashboardCharts.dataset.type);

    dashboardState.datasets.category = parseDataset(
        dashboardCharts.dataset.category,
    );

    /*
    |--------------------------------------------------------------------------
    | KBK
    |--------------------------------------------------------------------------
    */

    createDoughnutChart({
        canvasId: "kbkChart",
        type: "kbk",
        centerLabel: "Skripsi",
    });

    createLegend({
        legendId: "kbkLegend",
        type: "kbk",
        maxVisible: 3,
    });

    /*
    |--------------------------------------------------------------------------
    | Type
    |--------------------------------------------------------------------------
    */

    createDoughnutChart({
        canvasId: "typeChart",
        type: "type",
        centerLabel: "Literatur",
    });

    createLegend({
        legendId: "typeLegend",
        type: "type",
        maxVisible: 3,
    });

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    createDoughnutChart({
        canvasId: "categoryChart",
        type: "category",
        centerLabel: "Literatur",
    });

    createLegend({
        legendId: "categoryLegend",
        type: "category",
        maxVisible: 3,
    });
}

/*
|--------------------------------------------------------------------------
| Parse Dataset
|--------------------------------------------------------------------------
*/

function parseDataset(value) {
    if (!value) {
        return [];
    }

    try {
        const parsed = JSON.parse(value);

        if (!Array.isArray(parsed)) {
            return [];
        }

        return parsed.map((item) => ({
            label: item.label ?? "-",
            value: Number(item.value ?? 0),
        }));
    } catch (error) {
        console.error("Gagal membaca data dashboard:", error);

        return [];
    }
}

/*
|--------------------------------------------------------------------------
| Doughnut Chart
|--------------------------------------------------------------------------
*/

function createDoughnutChart({ canvasId, type, centerLabel }) {
    const canvas = document.getElementById(canvasId);

    if (!canvas) {
        return;
    }

    const data = dashboardState.datasets[type] ?? [];

    /*
    |--------------------------------------------------------------------------
    | Chart hanya menggunakan data > 0
    |--------------------------------------------------------------------------
    |
    | Item bernilai 0 tetap ditampilkan pada legend/modal,
    | tetapi tidak perlu dibuat sebagai potongan doughnut.
    |
    */

    const chartData = data.filter((item) => Number(item.value) > 0);

    const total = data.reduce((sum, item) => sum + Number(item.value || 0), 0);

    /*
    |--------------------------------------------------------------------------
    | Empty Chart
    |--------------------------------------------------------------------------
    */

    const displayData = chartData.length
        ? chartData
        : [
              {
                  label: "Belum ada data",
                  value: 1,
              },
          ];

    const colors = chartData.length
        ? displayData.map((_, index) => chartColors[index % chartColors.length])
        : ["#E2E8F0"];

    /*
    |--------------------------------------------------------------------------
    | Center Text Plugin
    |--------------------------------------------------------------------------
    */

    const centerTextPlugin = {
        id: `centerText-${canvasId}`,

        afterDraw(chart) {
            const { ctx, chartArea } = chart;

            if (!chartArea) {
                return;
            }

            const centerX = (chartArea.left + chartArea.right) / 2;

            const centerY = (chartArea.top + chartArea.bottom) / 2;

            ctx.save();

            /*
            |--------------------------------------------------------------------------
            | Total
            |--------------------------------------------------------------------------
            */

            ctx.textAlign = "center";
            ctx.textBaseline = "middle";

            ctx.fillStyle = "#0F172A";
            ctx.font = "700 30px Inter, system-ui, sans-serif";

            ctx.fillText(formatCompactNumber(total), centerX, centerY - 10);

            /*
            |--------------------------------------------------------------------------
            | Label
            |--------------------------------------------------------------------------
            */

            ctx.fillStyle = "#94A3B8";
            ctx.font = "500 13px Inter, system-ui, sans-serif";

            ctx.fillText(centerLabel, centerX, centerY + 22);

            ctx.restore();
        },
    };

    /*
    |--------------------------------------------------------------------------
    | Destroy Existing Chart
    |--------------------------------------------------------------------------
    */

    if (dashboardState.charts[type]) {
        dashboardState.charts[type].destroy();
    }

    /*
    |--------------------------------------------------------------------------
    | Create Chart
    |--------------------------------------------------------------------------
    */

    dashboardState.charts[type] = new Chart(canvas, {
        type: "doughnut",

        data: {
            labels: displayData.map((item) => item.label),

            datasets: [
                {
                    data: displayData.map((item) => item.value),

                    backgroundColor: colors,

                    borderColor: "#FFFFFF",
                    borderWidth: 3,

                    hoverBorderColor: "#FFFFFF",
                    hoverBorderWidth: 3,

                    hoverOffset: chartData.length ? 6 : 0,
                },
            ],
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            cutout: "68%",

            animation: {
                duration: 700,
                easing: "easeOutQuart",
            },

            plugins: {
                legend: {
                    display: false,
                },

                tooltip: {
                    enabled: chartData.length > 0,

                    callbacks: {
                        label(context) {
                            const value = Number(context.raw) || 0;

                            const percentage =
                                total > 0
                                    ? ((value / total) * 100).toFixed(1)
                                    : 0;

                            return `${formatNumber(value)} (${percentage}%)`;
                        },
                    },
                },
            },
        },

        plugins: [centerTextPlugin],
    });
}

/*
|--------------------------------------------------------------------------
| Custom Legend
|--------------------------------------------------------------------------
*/

function createLegend({ legendId, type, maxVisible = 3 }) {
    const container = document.getElementById(legendId);

    if (!container) {
        return;
    }

    const data = dashboardState.datasets[type] ?? [];

    const visibleItems = data.slice(0, maxVisible);

    /*
    |--------------------------------------------------------------------------
    | Empty Dataset
    |--------------------------------------------------------------------------
    */

    if (!data.length) {
        container.innerHTML = `
            <div
                class="border-t border-slate-100 pt-4">

                <p
                    class="py-3 text-center
                           text-xs text-slate-400">

                    Belum ada data.

                </p>

                ${createShowAllButton(type)}

            </div>
        `;

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Legend
    |--------------------------------------------------------------------------
    */

    container.innerHTML = `
        <div
            class="border-t
                   border-slate-100
                   pt-3">

            <div class="space-y-1">

                ${visibleItems
                    .map((item, index) => createLegendItem(item, index))
                    .join("")}

            </div>

            ${createShowAllButton(type)}

        </div>
    `;
}

/*
|--------------------------------------------------------------------------
| Legend Item
|--------------------------------------------------------------------------
*/

function createLegendItem(item, index) {
    const color = chartColors[index % chartColors.length];

    const isZero = Number(item.value) === 0;

    return `
        <div
            class="flex min-w-0
                   items-center gap-3
                   rounded-lg
                   py-1.5">

            <span
                class="h-3 w-3
                       shrink-0 rounded-full"
                style="
                    background-color:
                    ${color};
                ">
            </span>


            <span
                class="min-w-0 flex-1
                       truncate text-sm
                       ${isZero ? "text-slate-400" : "text-slate-500"}"
                title="${escapeHtml(item.label)}">

                ${escapeHtml(item.label)}

            </span>


            <span
                class="shrink-0
                       text-sm font-semibold
                       tabular-nums
                       ${isZero ? "text-slate-400" : "text-slate-700"}">

                ${formatNumber(item.value)}

            </span>

        </div>
    `;
}

/*
|--------------------------------------------------------------------------
| Show All Button
|--------------------------------------------------------------------------
|
| Tombol selalu ditampilkan agar semua card konsisten.
|
*/

function createShowAllButton(type) {
    return `
        <button
            type="button"
            data-chart-modal="${type}"
            class="mt-3
                   inline-flex w-full
                   items-center justify-center
                   gap-1.5
                   rounded-lg
                   border border-transparent
                   px-3 py-2
                   text-xs font-medium
                   text-blue-600
                   transition-all duration-200
                   hover:border-blue-600
                   hover:bg-blue-600
                   hover:text-white
                   active:scale-[0.98]">

            <span>
                Lihat semuanya
            </span>

            <span
                class="material-symbols-outlined
                       text-[16px]"
                style="
                    font-variation-settings:
                    'wght' 300;
                ">

                open_in_new

            </span>

        </button>
    `;
}

/*
|--------------------------------------------------------------------------
| Initialize Chart Modal
|--------------------------------------------------------------------------
*/

function initChartModal() {
    const modal = document.getElementById("chartDetailModal");

    if (!modal) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Move Modal to Body
    |--------------------------------------------------------------------------
    |
    | Mencegah fixed modal terpengaruh parent yang memiliki
    | transform, overflow, atau stacking context.
    |
    */

    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    /*
    |--------------------------------------------------------------------------
    | Open Button
    |--------------------------------------------------------------------------
    */

    document.addEventListener("click", (event) => {
        const button = event.target.closest("[data-chart-modal]");

        if (!button) {
            return;
        }

        const type = button.dataset.chartModal;

        openChartModal(type);
    });

    /*
    |--------------------------------------------------------------------------
    | Backdrop Click
    |--------------------------------------------------------------------------
    */

    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            closeChartModal();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Escape
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && isChartModalOpen()) {
            closeChartModal();
        }
    });
}

/*
|--------------------------------------------------------------------------
| Open Chart Modal
|--------------------------------------------------------------------------
*/

function openChartModal(type) {
    const modal = document.getElementById("chartDetailModal");

    const card = document.getElementById("chartDetailModalCard");

    if (!modal || !card) {
        return;
    }

    const data = dashboardState.datasets[type] ?? [];

    const config = getChartModalConfig(type);

    renderChartModal(data, config);

    /*
    |--------------------------------------------------------------------------
    | Lock Body Scroll
    |--------------------------------------------------------------------------
    */

    document.body.classList.add("overflow-hidden");

    /*
    |--------------------------------------------------------------------------
    | Display Modal
    |--------------------------------------------------------------------------
    */

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    /*
    |--------------------------------------------------------------------------
    | Animate In
    |--------------------------------------------------------------------------
    */

    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            modal.classList.remove(
                "opacity-0",
                "bg-slate-950/0",
                "backdrop-blur-none",
            );

            modal.classList.add(
                "opacity-100",
                "bg-slate-950/50",
                "backdrop-blur-sm",
            );

            card.classList.remove("opacity-0", "scale-95", "translate-y-4");

            card.classList.add("opacity-100", "scale-100", "translate-y-0");
        });
    });
}

/*
|--------------------------------------------------------------------------
| Close Chart Modal
|--------------------------------------------------------------------------
*/

function closeChartModal() {
    const modal = document.getElementById("chartDetailModal");

    const card = document.getElementById("chartDetailModalCard");

    if (!modal || !card) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Animate Out
    |--------------------------------------------------------------------------
    */

    modal.classList.remove(
        "opacity-100",
        "bg-slate-950/50",
        "backdrop-blur-sm",
    );

    modal.classList.add("opacity-0", "bg-slate-950/0", "backdrop-blur-none");

    card.classList.remove("opacity-100", "scale-100", "translate-y-0");

    card.classList.add("opacity-0", "scale-95", "translate-y-4");

    /*
    |--------------------------------------------------------------------------
    | Hide After Animation
    |--------------------------------------------------------------------------
    */

    window.setTimeout(() => {
        modal.classList.remove("flex");
        modal.classList.add("hidden");

        document.body.classList.remove("overflow-hidden");
    }, 300);
}

/*
|--------------------------------------------------------------------------
| Modal State
|--------------------------------------------------------------------------
*/

function isChartModalOpen() {
    const modal = document.getElementById("chartDetailModal");

    return modal && !modal.classList.contains("hidden");
}

/*
|--------------------------------------------------------------------------
| Chart Modal Configuration
|--------------------------------------------------------------------------
*/

function getChartModalConfig(type) {
    const configs = {
        kbk: {
            title: "Distribusi KBK",
            subtitle:
                "Distribusi skripsi berdasarkan Kompetensi Bidang Keahlian.",
            unit: "Skripsi",
        },

        type: {
            title: "Distribusi Tipe Literatur",
            subtitle: "Distribusi koleksi berdasarkan tipe literatur.",
            unit: "Literatur",
        },

        category: {
            title: "Distribusi Kategori Literatur",
            subtitle: "Distribusi koleksi berdasarkan kategori literatur.",
            unit: "Literatur",
        },
    };

    return (
        configs[type] ?? {
            title: "Detail Distribusi",
            subtitle: "Informasi lengkap distribusi data.",
            unit: "Data",
        }
    );
}

/*
|--------------------------------------------------------------------------
| Render Chart Modal
|--------------------------------------------------------------------------
*/

function renderChartModal(data, config) {
    const title = document.getElementById("chartDetailTitle");

    const subtitle = document.getElementById("chartDetailSubtitle");

    const count = document.getElementById("chartDetailCount");

    const totalElement = document.getElementById("chartDetailTotal");

    const content = document.getElementById("chartDetailContent");

    if (!title || !subtitle || !count || !totalElement || !content) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Total
    |--------------------------------------------------------------------------
    */

    const total = data.reduce((sum, item) => sum + Number(item.value || 0), 0);

    /*
    |--------------------------------------------------------------------------
    | Header
    |--------------------------------------------------------------------------
    */

    title.textContent = config.title;

    subtitle.textContent = config.subtitle;

    count.textContent = formatNumber(data.length);

    totalElement.textContent = `${formatCompactNumber(total)} ${config.unit}`;

    /*
    |--------------------------------------------------------------------------
    | Empty
    |--------------------------------------------------------------------------
    */

    if (!data.length) {
        content.innerHTML = `
            <div
                class="flex min-h-[220px]
                       flex-col items-center
                       justify-center
                       px-6 py-10
                       text-center">

                <span
                    class="material-symbols-outlined
                           text-4xl
                           text-slate-300">

                    database_off

                </span>

                <p
                    class="mt-3 text-sm
                           font-medium
                           text-slate-500">

                    Belum ada data.

                </p>

            </div>
        `;

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Rows
    |--------------------------------------------------------------------------
    */

    content.innerHTML = data
        .map((item, index) => {
            const value = Number(item.value || 0);

            const percentage = total > 0 ? (value / total) * 100 : 0;

            const color = chartColors[index % chartColors.length];

            const isZero = value === 0;

            return `
                <div
                    class="grid
                           grid-cols-[minmax(0,1fr)_72px_58px]
                           gap-3
                           border-b border-slate-100
                           px-5 py-3.5
                           last:border-b-0
                           sm:grid-cols-[minmax(0,1fr)_90px_70px]
                           sm:gap-4
                           sm:px-6">

                    <div
                        class="flex min-w-0
                               items-center gap-3">

                        <span
                            class="h-3 w-3
                                   shrink-0
                                   rounded-full"
                            style="
                                background-color:
                                ${color};
                            ">
                        </span>


                        <span
                            class="min-w-0
                                   truncate
                                   text-sm
                                   ${
                                       isZero
                                           ? "text-slate-400"
                                           : "text-slate-600"
                                   }"
                            title="${escapeHtml(item.label)}">

                            ${escapeHtml(item.label)}

                        </span>

                    </div>


                    <p
                        class="text-right
                               text-sm
                               font-semibold
                               tabular-nums
                               ${isZero ? "text-slate-400" : "text-slate-700"}">

                        ${formatNumber(value)}

                    </p>


                    <p
                        class="text-right
                               text-sm
                               tabular-nums
                               ${isZero ? "text-slate-400" : "text-slate-500"}">

                        ${formatPercentage(percentage)}

                    </p>

                </div>
            `;
        })
        .join("");
}

/*
|--------------------------------------------------------------------------
| Login Activity Modal
|--------------------------------------------------------------------------
*/

function initLoginActivityModal() {
    const modal = document.getElementById("loginActivityModal");
    const openButton = document.getElementById("openLoginActivityModal");

    if (!modal || !openButton) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Move Modal to Body
    |--------------------------------------------------------------------------
    |
    | Modal dipindahkan langsung ke body agar position fixed tidak
    | terpengaruh overflow, transform, atau stacking context parent.
    |
    */

    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    /*
    |--------------------------------------------------------------------------
    | Open
    |--------------------------------------------------------------------------
    */

    openButton.addEventListener("click", () => {
        openLoginActivityModal();
    });

    /*
    |--------------------------------------------------------------------------
    | Close Buttons
    |--------------------------------------------------------------------------
    */

    modal.querySelectorAll("[data-close-login-modal]").forEach((button) => {
        button.addEventListener("click", () => {
            closeLoginActivityModal();
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Backdrop
    |--------------------------------------------------------------------------
    */

    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            closeLoginActivityModal();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Escape
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && isLoginActivityModalOpen()) {
            closeLoginActivityModal();
        }
    });
}

/*
|--------------------------------------------------------------------------
| Open Login Activity Modal
|--------------------------------------------------------------------------
*/

function openLoginActivityModal() {
    const modal = document.getElementById("loginActivityModal");

    const card = document.getElementById("loginActivityModalCard");

    if (!modal || !card) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Lock Page Scroll
    |--------------------------------------------------------------------------
    */

    document.body.classList.add("overflow-hidden");

    /*
    |--------------------------------------------------------------------------
    | Show Modal
    |--------------------------------------------------------------------------
    */

    modal.classList.remove("hidden");
    modal.classList.add("flex");

    /*
    |--------------------------------------------------------------------------
    | Animate In
    |--------------------------------------------------------------------------
    |
    | Double requestAnimationFrame memastikan browser sempat menerapkan
    | initial state sebelum transition dimulai.
    |
    */

    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            /*
            |--------------------------------------------------------------------------
            | Backdrop
            |--------------------------------------------------------------------------
            */

            modal.classList.remove(
                "opacity-0",
                "bg-slate-950/0",
                "backdrop-blur-none",
            );

            modal.classList.add(
                "opacity-100",
                "bg-slate-950/50",
                "backdrop-blur-sm",
            );

            /*
            |--------------------------------------------------------------------------
            | Card
            |--------------------------------------------------------------------------
            */

            card.classList.remove("opacity-0", "scale-95", "translate-y-4");

            card.classList.add("opacity-100", "scale-100", "translate-y-0");
        });
    });
}

/*
|--------------------------------------------------------------------------
| Close Login Activity Modal
|--------------------------------------------------------------------------
*/

function closeLoginActivityModal() {
    const modal = document.getElementById("loginActivityModal");

    const card = document.getElementById("loginActivityModalCard");

    if (!modal || !card) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Animate Backdrop Out
    |--------------------------------------------------------------------------
    */

    modal.classList.remove(
        "opacity-100",
        "bg-slate-950/50",
        "backdrop-blur-sm",
    );

    modal.classList.add("opacity-0", "bg-slate-950/0", "backdrop-blur-none");

    /*
    |--------------------------------------------------------------------------
    | Animate Card Out
    |--------------------------------------------------------------------------
    */

    card.classList.remove("opacity-100", "scale-100", "translate-y-0");

    card.classList.add("opacity-0", "scale-95", "translate-y-4");

    /*
    |--------------------------------------------------------------------------
    | Hide After Animation
    |--------------------------------------------------------------------------
    */

    window.setTimeout(() => {
        modal.classList.remove("flex");
        modal.classList.add("hidden");

        document.body.classList.remove("overflow-hidden");
    }, 300);
}

/*
|--------------------------------------------------------------------------
| Login Activity Modal State
|--------------------------------------------------------------------------
*/

function isLoginActivityModalOpen() {
    const modal = document.getElementById("loginActivityModal");

    return modal && !modal.classList.contains("hidden");
}

/*
|--------------------------------------------------------------------------
| Number Formatter
|--------------------------------------------------------------------------
*/

function formatNumber(value) {
    return new Intl.NumberFormat("id-ID").format(Number(value) || 0);
}

/*
|--------------------------------------------------------------------------
| Compact Number Formatter
|--------------------------------------------------------------------------
|
| 5700  => 5,7K
| 2200  => 2,2K
| 950   => 950
|
*/

function formatCompactNumber(value) {
    const number = Number(value) || 0;

    if (number >= 1_000_000) {
        const formatted = number / 1_000_000;

        return `${formatted
            .toFixed(formatted % 1 === 0 ? 0 : 1)
            .replace(".", ",")}M`;
    }

    if (number >= 1_000) {
        const formatted = number / 1_000;

        return `${formatted
            .toFixed(formatted % 1 === 0 ? 0 : 1)
            .replace(".", ",")}K`;
    }

    return formatNumber(number);
}

/*
|--------------------------------------------------------------------------
| Percentage Formatter
|--------------------------------------------------------------------------
*/

function formatPercentage(value) {
    const number = Number(value) || 0;

    if (number === 0) {
        return "0%";
    }

    if (number < 0.1) {
        return "<0,1%";
    }

    return `${number.toFixed(1).replace(".", ",")}%`;
}

/*
|--------------------------------------------------------------------------
| Escape HTML
|--------------------------------------------------------------------------
*/

function escapeHtml(value) {
    return String(value ?? "")
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");
}

/*
|--------------------------------------------------------------------------
| Global Modal Function
|--------------------------------------------------------------------------
|
| Tetap diekspos supaya tombol onclick pada Blade lama
| masih bisa digunakan jika diperlukan.
|
*/

/*
|--------------------------------------------------------------------------
| Global Functions
|--------------------------------------------------------------------------
*/

window.openChartModal = openChartModal;
window.closeChartModal = closeChartModal;

window.openLoginActivityModal = openLoginActivityModal;
window.closeLoginActivityModal = closeLoginActivityModal;
