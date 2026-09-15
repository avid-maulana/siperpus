import { createDashboardCharts } from "./charts.js";
import { createChartModal, exposeChartModal } from "./chart-modal.js";
import { createLoginActivityModal, exposeLoginModal } from "./login-modal.js";

document.addEventListener("DOMContentLoaded", () => {
    const chartState = createDashboardCharts();
    const chartModal = createChartModal({ datasets: chartState.datasets });
    const loginModal = createLoginActivityModal();

    exposeChartModal(chartModal);
    exposeLoginModal(loginModal);
});
