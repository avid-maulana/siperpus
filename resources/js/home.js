import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", () => {
    /*
    |--------------------------------------------------------------------------
    | Dashboard Chart Section
    |--------------------------------------------------------------------------
    */

    const chartSection = document.getElementById("dashboardCharts");

    if (!chartSection) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Parse Data dari Blade
    |--------------------------------------------------------------------------
    */

    const parseChartData = (value) => {
        try {
            return JSON.parse(value || "[]");
        } catch (error) {
            console.error("Gagal membaca data chart:", error);
            return [];
        }
    };

    const kbkData = parseChartData(chartSection.dataset.kbk);

    const typeData = parseChartData(chartSection.dataset.type);

    const categoryData = parseChartData(chartSection.dataset.category);

    /*
    |--------------------------------------------------------------------------
    | Format Angka Singkat
    |--------------------------------------------------------------------------
    |
    | 950      -> 950
    | 1200     -> 1,2K
    | 5700     -> 5,7K
    | 1200000  -> 1,2Jt
    |
    */

    const formatNumber = (value) => {
        const number = Number(value) || 0;

        if (number >= 1_000_000) {
            const formatted = (number / 1_000_000)
                .toFixed(1)
                .replace(".", ",")
                .replace(",0", "");

            return `${formatted}Jt`;
        }

        if (number >= 1_000) {
            const formatted = (number / 1_000)
                .toFixed(1)
                .replace(".", ",")
                .replace(",0", "");

            return `${formatted}K`;
        }

        return number.toLocaleString("id-ID");
    };

    /*
    |--------------------------------------------------------------------------
    | Format Angka Lengkap
    |--------------------------------------------------------------------------
    */

    const formatFullNumber = (value) => {
        return Number(value || 0).toLocaleString("id-ID");
    };

    /*
    |--------------------------------------------------------------------------
    | Warna Chart
    |--------------------------------------------------------------------------
    */

    const chartColors = [
        "#2563EB",
        "#7C3AED",
        "#059669",
        "#D97706",
        "#DC2626",
        "#0891B2",
        "#4F46E5",
        "#DB2777",
        "#65A30D",
        "#EA580C",
        "#0F766E",
        "#9333EA",
        "#0284C7",
        "#BE123C",
        "#64748B",
        "#16A34A",
        "#CA8A04",
        "#C026D3",
        "#0369A1",
        "#4338CA",
    ];

    /*
    |--------------------------------------------------------------------------
    | Escape HTML
    |--------------------------------------------------------------------------
    */

    const escapeHtml = (value) => {
        return String(value ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    };

    /*
    |--------------------------------------------------------------------------
    | Normalize Data
    |--------------------------------------------------------------------------
    */

    const normalizeData = (data) => {
        if (!Array.isArray(data)) {
            return [];
        }

        return data.map((item, index) => ({
            label: item.label ?? "-",

            value: Number(item.value || 0),

            color: chartColors[index % chartColors.length],
        }));
    };

    /*
    |--------------------------------------------------------------------------
    | Center Text Plugin
    |--------------------------------------------------------------------------
    */

    const createCenterTextPlugin = (pluginId, centerLabel) => {
        return {
            id: pluginId,

            afterDraw(chart) {
                if (!chart.chartArea) {
                    return;
                }

                const { ctx, chartArea } = chart;

                /*
                |--------------------------------------------------------------------------
                | Total
                |--------------------------------------------------------------------------
                */

                const originalValues = chart.$originalValues ?? [];

                const total = originalValues.reduce(
                    (sum, value) => sum + Number(value || 0),
                    0,
                );

                /*
                |--------------------------------------------------------------------------
                | Center Position
                |--------------------------------------------------------------------------
                */

                const centerX = (chartArea.left + chartArea.right) / 2;

                const centerY = (chartArea.top + chartArea.bottom) / 2;

                ctx.save();

                ctx.textAlign = "center";
                ctx.textBaseline = "middle";

                /*
                |--------------------------------------------------------------------------
                | Number
                |--------------------------------------------------------------------------
                */

                ctx.fillStyle = "#0F172A";

                ctx.font =
                    "700 24px Inter, ui-sans-serif, system-ui, sans-serif";

                ctx.fillText(formatNumber(total), centerX, centerY - 9);

                /*
                |--------------------------------------------------------------------------
                | Label
                |--------------------------------------------------------------------------
                */

                ctx.fillStyle = "#94A3B8";

                ctx.font =
                    "500 11px Inter, ui-sans-serif, system-ui, sans-serif";

                ctx.fillText(centerLabel, centerX, centerY + 16);

                ctx.restore();
            },
        };
    };

    /*
    |--------------------------------------------------------------------------
    | Modal Configuration
    |--------------------------------------------------------------------------
    */

    const chartModalData = {
        kbk: {
            title: "Semua KBK",

            subtitle: "Daftar seluruh Kompetensi Bidang Keahlian.",

            data: kbkData,
        },

        type: {
            title: "Semua Tipe Literatur",

            subtitle: "Daftar seluruh tipe literatur yang tersedia.",

            data: typeData,
        },

        category: {
            title: "Semua Kategori Literatur",

            subtitle: "Daftar seluruh kategori literatur yang tersedia.",

            data: categoryData,
        },
    };

    /*
    |--------------------------------------------------------------------------
    | Modal Elements
    |--------------------------------------------------------------------------
    */

    const chartModal = document.getElementById("chartDetailModal");

    const chartModalCard = document.getElementById("chartDetailModalCard");

    /*
    |--------------------------------------------------------------------------
    | Modal State
    |--------------------------------------------------------------------------
    */

    let modalClosing = false;

    let closeTimer = null;

    /*
    |--------------------------------------------------------------------------
    | Show Chart Modal
    |--------------------------------------------------------------------------
    */

    window.showChartModal = function (type) {
        const config = chartModalData[type];

        if (!config || !chartModal) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Elements
        |--------------------------------------------------------------------------
        */

        const titleElement = document.getElementById("chartDetailTitle");

        const subtitleElement = document.getElementById("chartDetailSubtitle");

        const countElement = document.getElementById("chartDetailCount");

        const totalElement = document.getElementById("chartDetailTotal");

        const contentElement = document.getElementById("chartDetailContent");

        if (
            !titleElement ||
            !subtitleElement ||
            !countElement ||
            !totalElement ||
            !contentElement
        ) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Batalkan Timer Close Sebelumnya
        |--------------------------------------------------------------------------
        */

        if (closeTimer) {
            clearTimeout(closeTimer);

            closeTimer = null;
        }

        modalClosing = false;

        /*
        |--------------------------------------------------------------------------
        | Normalize + Sort
        |--------------------------------------------------------------------------
        */

        const items = normalizeData(config.data).sort(
            (a, b) => b.value - a.value,
        );

        /*
        |--------------------------------------------------------------------------
        | Total
        |--------------------------------------------------------------------------
        */

        const total = items.reduce((sum, item) => sum + item.value, 0);

        /*
        |--------------------------------------------------------------------------
        | Modal Information
        |--------------------------------------------------------------------------
        */

        titleElement.textContent = config.title;

        subtitleElement.textContent = config.subtitle;

        countElement.textContent = formatFullNumber(items.length);

        totalElement.textContent = formatFullNumber(total);

        /*
        |--------------------------------------------------------------------------
        | Empty State
        |--------------------------------------------------------------------------
        */

        if (items.length === 0) {
            contentElement.innerHTML = `

                <div
                    class="flex min-h-[260px]
                           items-center justify-center">

                    <div class="text-center">

                        <span
                            class="material-symbols-outlined
                                   text-4xl text-slate-300">

                            donut_large

                        </span>

                        <p
                            class="mt-2
                                   text-sm
                                   text-slate-400">

                            Belum ada data.

                        </p>

                    </div>

                </div>
            `;
        } else {
            /*
            |--------------------------------------------------------------------------
            | Render Data
            |--------------------------------------------------------------------------
            */

            contentElement.innerHTML = items
                .map((item) => {
                    const label = escapeHtml(item.label);

                    const percentage =
                        total > 0
                            ? ((item.value / total) * 100).toFixed(1)
                            : "0.0";

                    return `

                            <div
                                class="grid
                                       grid-cols-[minmax(0,1fr)_90px_70px]
                                       items-center
                                       gap-4
                                       border-b
                                       border-slate-100
                                       px-6 py-3
                                       last:border-b-0">


                                <!-- Name -->
                                <div
                                    class="flex min-w-0
                                           items-center gap-3">

                                    <span
                                        class="h-2.5 w-2.5
                                               shrink-0 rounded-full"
                                        style="
                                            background-color:
                                            ${item.color};
                                        ">
                                    </span>


                                    <span
                                        class="truncate
                                               text-sm
                                               font-medium
                                               text-slate-700"
                                        title="${label}">

                                        ${label}

                                    </span>

                                </div>


                                <!-- Value -->
                                <div
                                    class="text-right
                                           text-sm
                                           font-semibold
                                           tabular-nums
                                           ${
                                               item.value === 0
                                                   ? "text-slate-400"
                                                   : "text-slate-700"
                                           }">

                                    ${formatFullNumber(item.value)}

                                </div>


                                <!-- Percentage -->
                                <div
                                    class="text-right
                                           text-xs
                                           tabular-nums
                                           ${
                                               item.value === 0
                                                   ? "text-slate-300"
                                                   : "text-slate-500"
                                           }">

                                    ${percentage.replace(".", ",")}%

                                </div>

                            </div>
                        `;
                })
                .join("");
        }

        /*
        |--------------------------------------------------------------------------
        | Reset Modal Content Scroll
        |--------------------------------------------------------------------------
        */

        contentElement.scrollTop = 0;

        /*
        |--------------------------------------------------------------------------
        | Pindahkan Modal Langsung ke Body
        |--------------------------------------------------------------------------
        |
        | Ini penting.
        |
        | Dengan begitu position: fixed selalu mengikuti viewport dan
        | tidak terpengaruh transform / animation dari parent dashboard.
        |
        */

        if (chartModal.parentElement !== document.body) {
            document.body.appendChild(chartModal);
        }

        /*
        |--------------------------------------------------------------------------
        | Lock Background Scroll
        |--------------------------------------------------------------------------
        */

        document.body.style.overflow = "hidden";

        /*
        |--------------------------------------------------------------------------
        | Initial Animation State
        |--------------------------------------------------------------------------
        */

        chartModal.classList.remove(
            "hidden",
            "opacity-100",
            "bg-slate-950/50",
            "backdrop-blur-[2px]",
        );

        chartModal.classList.add(
            "flex",
            "opacity-0",
            "bg-slate-950/0",
            "backdrop-blur-none",
        );

        if (chartModalCard) {
            chartModalCard.classList.remove(
                "opacity-100",
                "scale-100",
                "translate-y-0",
            );

            chartModalCard.classList.add(
                "opacity-0",
                "scale-95",
                "translate-y-4",
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Enter Animation
        |--------------------------------------------------------------------------
        |
        | Double requestAnimationFrame memastikan browser sempat
        | menggambar state awal sebelum masuk ke state akhir.
        |
        */

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                /*
                |--------------------------------------------------------------------------
                | Backdrop
                |--------------------------------------------------------------------------
                */

                chartModal.classList.remove(
                    "opacity-0",
                    "bg-slate-950/0",
                    "backdrop-blur-none",
                );

                chartModal.classList.add(
                    "opacity-100",
                    "bg-slate-950/50",
                    "backdrop-blur-[2px]",
                );

                /*
                |--------------------------------------------------------------------------
                | Card
                |--------------------------------------------------------------------------
                */

                if (chartModalCard) {
                    chartModalCard.classList.remove(
                        "opacity-0",
                        "scale-95",
                        "translate-y-4",
                    );

                    chartModalCard.classList.add(
                        "opacity-100",
                        "scale-100",
                        "translate-y-0",
                    );
                }
            });
        });
    };

    /*
    |--------------------------------------------------------------------------
    | Close Chart Modal
    |--------------------------------------------------------------------------
    */

    window.closeChartModal = function () {
        if (!chartModal) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Modal Sudah Ditutup
        |--------------------------------------------------------------------------
        */

        if (chartModal.classList.contains("hidden") || modalClosing) {
            return;
        }

        modalClosing = true;

        /*
        |--------------------------------------------------------------------------
        | Backdrop Exit Animation
        |--------------------------------------------------------------------------
        */

        chartModal.classList.remove(
            "opacity-100",
            "bg-slate-950/50",
            "backdrop-blur-[2px]",
        );

        chartModal.classList.add(
            "opacity-0",
            "bg-slate-950/0",
            "backdrop-blur-none",
        );

        /*
        |--------------------------------------------------------------------------
        | Card Exit Animation
        |--------------------------------------------------------------------------
        */

        if (chartModalCard) {
            chartModalCard.classList.remove(
                "opacity-100",
                "scale-100",
                "translate-y-0",
            );

            chartModalCard.classList.add(
                "opacity-0",
                "scale-95",
                "translate-y-4",
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Hide Setelah Transition Selesai
        |--------------------------------------------------------------------------
        */

        closeTimer = setTimeout(() => {
            chartModal.classList.add("hidden");

            chartModal.classList.remove("flex");

            /*
            |--------------------------------------------------------------------------
            | Unlock Background Scroll
            |--------------------------------------------------------------------------
            */

            document.body.style.overflow = "";

            modalClosing = false;

            closeTimer = null;
        }, 300);
    };

    /*
    |--------------------------------------------------------------------------
    | Klik Backdrop untuk Tutup
    |--------------------------------------------------------------------------
    */

    chartModal?.addEventListener("click", (event) => {
        /*
         * Hanya tutup jika klik terjadi di luar modal card.
         */

        if (chartModalCard && !chartModalCard.contains(event.target)) {
            window.closeChartModal();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | ESC untuk Tutup
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        if (chartModal && !chartModal.classList.contains("hidden")) {
            window.closeChartModal();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Custom Legend
    |--------------------------------------------------------------------------
    */

    const createLegend = ({ legendId, data, type, maxVisible = 3 }) => {
        const container = document.getElementById(legendId);

        if (!container) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Normalize + Sort
        |--------------------------------------------------------------------------
        */

        const items = normalizeData(data).sort((a, b) => b.value - a.value);

        /*
        |--------------------------------------------------------------------------
        | Empty State
        |--------------------------------------------------------------------------
        */

        if (items.length === 0) {
            container.innerHTML = `

    <div
        class="border-t
               border-slate-100
               pt-3">

        <!-- Visible Items -->
        <div>

            ${visibleItems.map(createItem).join("")}

        </div>


        <!-- Show All Button -->
        <button
            type="button"
            onclick="showChartModal('${type}')"
            class="mt-3
                   inline-flex
                   w-full
                   items-center
                   justify-center
                   gap-1.5
                   rounded-lg
                   border
                   border-transparent
                   px-2.5
                   py-1.5
                   text-xs
                   font-medium
                   text-blue-600
                   transition-all
                   duration-200
                   hover:border-blue-600
                   hover:bg-blue-600
                   hover:text-white">

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

    </div>
`;

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Data yang Ditampilkan
        |--------------------------------------------------------------------------
        */

        const visibleItems = items.slice(0, maxVisible);

        const hiddenCount = Math.max(items.length - maxVisible, 0);

        /*
        |--------------------------------------------------------------------------
        | Legend Item
        |--------------------------------------------------------------------------
        */

        const createItem = (item) => {
            const label = escapeHtml(item.label);

            return `

                <div
                    class="flex
                           items-center
                           justify-between
                           gap-3
                           py-1.5">


                    <!-- Label -->
                    <div
                        class="flex min-w-0
                               items-center
                               gap-2.5">

                        <span
                            class="h-2.5 w-2.5
                                   shrink-0
                                   rounded-full"
                            style="
                                background-color:
                                ${item.color};
                            ">
                        </span>


                        <span
                            class="truncate
                                   text-xs
                                   text-slate-500"
                            title="${label}">

                            ${label}

                        </span>

                    </div>


                    <!-- Value -->
                    <span
                        class="shrink-0
                               text-xs
                               font-semibold
                               tabular-nums
                               ${
                                   item.value === 0
                                       ? "text-slate-400"
                                       : "text-slate-700"
                               }">

                        ${formatNumber(item.value)}

                    </span>

                </div>
            `;
        };

        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        container.innerHTML = `

    <div
        class="border-t
               border-slate-100
               pt-3">

        <!-- Visible Items -->
        <div>

            ${visibleItems.map(createItem).join("")}

        </div>


        <!-- Show All Button -->
        <button
            type="button"
            onclick="showChartModal('${type}')"
            class="mt-3
                   inline-flex
                   w-full
                   items-center
                   justify-center
                   gap-1.5
                   rounded-lg
                   border
                   border-transparent
                   px-2.5
                   py-1.5
                   text-xs
                   font-medium
                   text-blue-600
                   transition-all
                   duration-200
                   hover:border-blue-600
                   hover:bg-blue-600
                   hover:text-white">

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

    </div>
`;
    };

    /*
    |--------------------------------------------------------------------------
    | Create Doughnut Chart
    |--------------------------------------------------------------------------
    */

    const createDoughnutChart = ({
        canvasId,
        wrapperId,
        data,
        centerLabel,
    }) => {
        const canvas = document.getElementById(canvasId);

        const wrapper = document.getElementById(wrapperId);

        if (!canvas || !wrapper) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Normalize
        |--------------------------------------------------------------------------
        */

        const items = normalizeData(data);

        /*
        |--------------------------------------------------------------------------
        | Total
        |--------------------------------------------------------------------------
        */

        const total = items.reduce((sum, item) => sum + item.value, 0);

        /*
        |--------------------------------------------------------------------------
        | Ada Nilai > 0
        |--------------------------------------------------------------------------
        */

        const hasPositiveValue = items.some((item) => item.value > 0);

        /*
        |--------------------------------------------------------------------------
        | Visual Data
        |--------------------------------------------------------------------------
        |
        | Jika semua data = 0, kita gunakan nilai dummy 1 supaya
        | doughnut abu-abu tetap terlihat.
        |
        */

        const chartLabels = hasPositiveValue
            ? items.map((item) => item.label)
            : ["Belum ada data"];

        const chartValues = hasPositiveValue
            ? items.map((item) => item.value)
            : [1];

        const chartBackgroundColors = hasPositiveValue
            ? items.map((item) => item.color)
            : ["#E2E8F0"];

        /*
        |--------------------------------------------------------------------------
        | Create Chart
        |--------------------------------------------------------------------------
        */

        const chart = new Chart(canvas, {
            type: "doughnut",

            /*
                    |--------------------------------------------------------------------------
                    | Data
                    |--------------------------------------------------------------------------
                    */

            data: {
                labels: chartLabels,

                datasets: [
                    {
                        data: chartValues,

                        backgroundColor: chartBackgroundColors,

                        borderColor: "#FFFFFF",

                        borderWidth: 3,

                        hoverBorderColor: "#FFFFFF",

                        hoverBorderWidth: 3,

                        hoverOffset: hasPositiveValue ? 7 : 0,
                    },
                ],
            },

            /*
                    |--------------------------------------------------------------------------
                    | Options
                    |--------------------------------------------------------------------------
                    */

            options: {
                responsive: true,

                maintainAspectRatio: false,

                cutout: "67%",

                /*
                        |--------------------------------------------------------------------------
                        | Layout
                        |--------------------------------------------------------------------------
                        */

                layout: {
                    padding: {
                        top: 5,

                        bottom: 5,

                        left: 5,

                        right: 5,
                    },
                },

                /*
                        |--------------------------------------------------------------------------
                        | Animation
                        |--------------------------------------------------------------------------
                        */

                animation: {
                    duration: 700,

                    easing: "easeOutQuart",
                },

                /*
                        |--------------------------------------------------------------------------
                        | Plugins
                        |--------------------------------------------------------------------------
                        */

                plugins: {
                    /*
                            |--------------------------------------------------------------------------
                            | Legend
                            |--------------------------------------------------------------------------
                            */

                    legend: {
                        display: false,
                    },

                    /*
                            |--------------------------------------------------------------------------
                            | Tooltip
                            |--------------------------------------------------------------------------
                            */

                    tooltip: {
                        enabled: hasPositiveValue,

                        padding: 12,

                        titleMarginBottom: 7,

                        displayColors: true,

                        callbacks: {
                            label(context) {
                                const value = Number(context.raw || 0);

                                const percentage =
                                    total > 0
                                        ? ((value / total) * 100).toFixed(1)
                                        : "0.0";

                                return (
                                    `${context.label}: ` +
                                    `${formatFullNumber(value)} ` +
                                    `(${percentage.replace(".", ",")}%)`
                                );
                            },
                        },
                    },
                },
            },

            /*
                    |--------------------------------------------------------------------------
                    | Custom Plugin
                    |--------------------------------------------------------------------------
                    */

            plugins: [
                createCenterTextPlugin(`${canvasId}CenterText`, centerLabel),
            ],
        });

        /*
        |--------------------------------------------------------------------------
        | Original Values
        |--------------------------------------------------------------------------
        */

        chart.$originalValues = items.map((item) => item.value);

        chart.draw();
    };

    /*
    |--------------------------------------------------------------------------
    | KBK
    |--------------------------------------------------------------------------
    */

    createDoughnutChart({
        canvasId: "kbkChart",

        wrapperId: "kbkChartWrapper",

        data: kbkData,

        centerLabel: "Skripsi",
    });

    createLegend({
        legendId: "kbkLegend",

        data: kbkData,

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

        wrapperId: "typeChartWrapper",

        data: typeData,

        centerLabel: "Literatur",
    });

    createLegend({
        legendId: "typeLegend",

        data: typeData,

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

        wrapperId: "categoryChartWrapper",

        data: categoryData,

        centerLabel: "Literatur",
    });

    createLegend({
        legendId: "categoryLegend",

        data: categoryData,

        type: "category",

        maxVisible: 3,
    });
});
