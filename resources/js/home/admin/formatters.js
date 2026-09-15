export function formatNumber(value) {
    return new Intl.NumberFormat("id-ID").format(Number(value) || 0);
}

export function formatCompactNumber(value) {
    const number = Number(value) || 0;
    if (number >= 1_000_000) {
        const formatted = number / 1_000_000;
        return `${formatted.toFixed(formatted % 1 === 0 ? 0 : 1).replace(".", ",")}M`;
    }
    if (number >= 1_000) {
        const formatted = number / 1_000;
        return `${formatted.toFixed(formatted % 1 === 0 ? 0 : 1).replace(".", ",")}K`;
    }
    return formatNumber(number);
}

export function formatPercentage(value) {
    const number = Number(value) || 0;
    if (number === 0) return "0%";
    if (number < 0.1) return "<0,1%";
    return `${number.toFixed(1).replace(".", ",")}%`;
}

export function escapeHtml(value) {
    return String(value ?? "")
        .replaceAll("&", "&amp;")
        .replaceAll("<", "&lt;")
        .replaceAll(">", "&gt;")
        .replaceAll('"', "&quot;")
        .replaceAll("'", "&#039;");
}
