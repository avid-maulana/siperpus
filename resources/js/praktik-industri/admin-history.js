/*
|--------------------------------------------------------------------------
| ADMIN PRAKTIK INDUSTRI
|--------------------------------------------------------------------------
| RIWAYAT REVISI LAPORAN
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {
    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let historyBound = false;


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    const escapeHtml = (value) => {
        if (
            value === null ||
            value === undefined
        ) {
            return "";
        }

        const div =
            document.createElement("div");

        div.textContent = String(value);

        return div.innerHTML;
    };


    /*
    |--------------------------------------------------------------------------
    | FORMAT TANGGAL
    |--------------------------------------------------------------------------
    */

    const formatDate = (value) => {

        if (!value) {
            return null;
        }

        const date = new Date(value);

        if (Number.isNaN(date.getTime())) {
            return null;
        }

        return new Intl.DateTimeFormat(
            "id-ID",
            {
                day: "2-digit",
                month: "long",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit",
                hour12: false,
            }
        ).format(date) + " WIB";
    };


    /*
    |--------------------------------------------------------------------------
    | AMBIL TANGGAL
    |--------------------------------------------------------------------------
    |
    | Mencoba beberapa kemungkinan struktur response.
    |
    */

    const getItemDate = (item) => {

        if (!item) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | FIELD LANGSUNG
        |--------------------------------------------------------------------------
        */

        const directDates = [
            item.date,
            item.updated_at,
            item.created_at,
            item.tanggal,
            item.tanggal_revisi,
            item.updatedAt,
            item.createdAt,
        ];


        for (const value of directDates) {

            const formatted =
                formatDate(value);

            if (formatted) {
                return formatted;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | OBJECT FILE
        |--------------------------------------------------------------------------
        */

        const file =
            item.file_laporan ||
            item.fileLaporan ||
            item.file_data ||
            item.fileData ||
            item.file;


        if (
            file &&
            typeof file === "object"
        ) {

            const fileDates = [
                file.updated_at,
                file.created_at,
                file.updatedAt,
                file.createdAt,
                file.date,
            ];


            for (const value of fileDates) {

                const formatted =
                    formatDate(value);

                if (formatted) {
                    return formatted;
                }

            }

        }


        /*
        |--------------------------------------------------------------------------
        | OBJECT REVISI
        |--------------------------------------------------------------------------
        */

        const revisi =
            item.revisi_data ||
            item.revisiData ||
            item.revisi_file ||
            item.revisiFile;


        if (
            revisi &&
            typeof revisi === "object"
        ) {

            const revisionDates = [
                revisi.updated_at,
                revisi.created_at,
                revisi.updatedAt,
                revisi.createdAt,
                revisi.date,
            ];


            for (const value of revisionDates) {

                const formatted =
                    formatDate(value);

                if (formatted) {
                    return formatted;
                }

            }

        }


        return null;
    };


    /*
    |--------------------------------------------------------------------------
    | MODAL API
    |--------------------------------------------------------------------------
    */

    const getModal = () => {
        return window.praktikIndustriAdminModal;
    };


    /*
    |--------------------------------------------------------------------------
    | HISTORY BUTTON
    |--------------------------------------------------------------------------
    */

    const getHistoryButtons = () => {

        const resultContainer =
            window.praktikIndustriAdmin
                ?.getResultContainer?.();


        if (!resultContainer) {
            return [];
        }


        return Array.from(
            resultContainer.querySelectorAll(
                "[data-history]"
            )
        );
    };


    /*
    |--------------------------------------------------------------------------
    | BUILD HISTORY ITEM
    |--------------------------------------------------------------------------
    */

    const renderHistoryItem = (
        item,
        index,
        total
    ) => {

        /*
        |--------------------------------------------------------------------------
        | JUDUL
        |--------------------------------------------------------------------------
        */

        const title =
            item.title ||
            item.judul ||
            item.judul_laporan ||
            item.nama ||
            "Laporan Praktik Industri";


        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */

        const date =
            getItemDate(item);


        /*
        |--------------------------------------------------------------------------
        | VERSION
        |--------------------------------------------------------------------------
        */

        const version =
            item.version ??
            item.revisi ??
            item.revision ??
            item.nomor_revisi ??
            Math.max(
                total - index,
                1
            );


        /*
        |--------------------------------------------------------------------------
        | PDF
        |--------------------------------------------------------------------------
        */

        let pdf =
            item.pdf ||
            item.pdf_url ||
            item.file_url ||
            item.url ||
            "";


        /*
        |--------------------------------------------------------------------------
        | PDF DARI OBJECT FILE
        |--------------------------------------------------------------------------
        */

        if (
            !pdf &&
            item.file &&
            typeof item.file === "object"
        ) {

            pdf =
                item.file.url ||
                item.file.path ||
                item.file.file ||
                item.file.file_url ||
                "";

        }


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        const isLatest =
            index === 0;


        const status =
            isLatest
                ? "Laporan terbaru"
                : `Revisi ${version}`;


        /*
        |--------------------------------------------------------------------------
        | TANGGAL TEXT
        |--------------------------------------------------------------------------
        */

        const dateText =
            date ||
            "Tanggal tidak tersedia";


        /*
        |--------------------------------------------------------------------------
        | PDF BUTTON
        |--------------------------------------------------------------------------
        */

        const pdfButton =
            pdf

                ? `
                    <a
                        href="${escapeHtml(pdf)}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="
                            inline-flex
                            h-10
                            items-center
                            justify-center
                            gap-2
                            shrink-0
                            rounded-xl
                            border
                            border-slate-200
                            bg-white
                            px-3.5
                            text-xs
                            font-semibold
                            text-slate-600
                            shadow-sm
                            transition-all
                            duration-200
                            hover:border-red-200
                            hover:bg-red-50
                            hover:text-red-600
                            hover:shadow-md
                        "
                        title="Lihat file PDF"
                    >

                        <span
                            class="
                                material-symbols-outlined
                                text-[17px]
                            "
                        >
                            picture_as_pdf
                        </span>

                        Lihat File

                    </a>
                `

                : `
                    <span
                        class="
                            inline-flex
                            h-10
                            items-center
                            justify-center
                            gap-2
                            shrink-0
                            rounded-xl
                            border
                            border-slate-200
                            bg-slate-50
                            px-3.5
                            text-xs
                            font-semibold
                            text-slate-300
                        "
                        title="File tidak tersedia"
                    >

                        <span
                            class="
                                material-symbols-outlined
                                text-[17px]
                            "
                        >
                            picture_as_pdf
                        </span>

                        File Tidak Tersedia

                    </span>
                `;


        /*
        |--------------------------------------------------------------------------
        | TIMELINE ITEM
        |--------------------------------------------------------------------------
        */

        return `
            <div
                class="
                    relative
                    pl-10
                    ${index < total - 1 ? "pb-5" : ""}
                "
            >

                ${
                    index < total - 1
                        ? `
                            <div
                                class="
                                    absolute
                                    left-[14px]
                                    top-7
                                    bottom-0
                                    w-px
                                    bg-slate-200
                                "
                            ></div>
                        `
                        : ""
                }


                <!-- TIMELINE DOT -->

                <div
                    class="
                        absolute
                        left-0
                        top-1
                        flex
                        h-7
                        w-7
                        items-center
                        justify-center
                        rounded-full
                        border
                        ${
                            isLatest
                                ? `
                                    border-emerald-200
                                    bg-emerald-50
                                    text-emerald-600
                                `
                                : `
                                    border-slate-200
                                    bg-white
                                    text-slate-400
                                `
                        }
                    "
                >

                    <span
                        class="
                            material-symbols-outlined
                            text-[14px]
                        "
                    >
                        ${
                            isLatest
                                ? "check"
                                : "history"
                        }
                    </span>

                </div>


                <!-- HISTORY CARD -->

                <div
                    class="
                        rounded-2xl
                        border
                        border-slate-200
                        bg-white
                        p-4
                        shadow-sm
                        transition-all
                        duration-200
                        hover:border-slate-300
                        hover:shadow-md
                    "
                >

                    <!-- TOP -->

                    <div
                        class="
                            flex
                            items-start
                            justify-between
                            gap-4
                        "
                    >

                        <div
                            class="min-w-0"
                        >

                            <!-- BADGE -->

                            <div
                                class="
                                    flex
                                    flex-wrap
                                    items-center
                                    gap-2
                                "
                            >

                                <span
                                    class="
                                        inline-flex
                                        items-center
                                        rounded-full
                                        px-2.5
                                        py-1
                                        text-[9px]
                                        font-bold
                                        uppercase
                                        tracking-wider
                                        ${
                                            isLatest
                                                ? `
                                                    bg-emerald-50
                                                    text-emerald-600
                                                `
                                                : `
                                                    bg-slate-100
                                                    text-slate-500
                                                `
                                        }
                                    "
                                >
                                    ${escapeHtml(status)}
                                </span>


                                ${
                                    !isLatest
                                        ? `
                                            <span
                                                class="
                                                    text-[10px]
                                                    font-medium
                                                    text-slate-400
                                                "
                                            >
                                                Versi ${escapeHtml(version)}
                                            </span>
                                          `
                                        : ""
                                }

                            </div>


                            <!-- TITLE -->

                            <h4
                                class="
                                    mt-2
                                    line-clamp-2
                                    text-sm
                                    font-semibold
                                    leading-5
                                    text-[#212A37]
                                "
                            >
                                ${escapeHtml(title)}
                            </h4>

                        </div>


                        <!-- PDF -->

                        ${pdfButton}

                    </div>


                    <!-- META -->

                    <div
                        class="
                            mt-3
                            flex
                            items-center
                            gap-2
                            border-t
                            border-slate-100
                            pt-3
                        "
                    >

                        <span
                            class="
                                material-symbols-outlined
                                text-[16px]
                                text-slate-400
                            "
                        >
                            schedule
                        </span>


                        <span
                            class="
                                text-[10px]
                                font-medium
                                ${
                                    date
                                        ? "text-slate-400"
                                        : "text-slate-300"
                                }
                            "
                        >
                            ${escapeHtml(dateText)}
                        </span>

                    </div>

                </div>

            </div>
        `;
    };


    /*
    |--------------------------------------------------------------------------
    | NORMALIZE HISTORY DATA
    |--------------------------------------------------------------------------
    */

    const normalizeHistory = (data) => {

        if (!data) {
            return [];
        }


        /*
        |--------------------------------------------------------------------------
        | ARRAY LANGSUNG
        |--------------------------------------------------------------------------
        */

        if (Array.isArray(data)) {
            return data;
        }


        /*
        |--------------------------------------------------------------------------
        | COMMON RESPONSE FORMAT
        |--------------------------------------------------------------------------
        */

        if (Array.isArray(data.data)) {
            return data.data;
        }


        if (Array.isArray(data.history)) {
            return data.history;
        }


        if (Array.isArray(data.riwayat)) {
            return data.riwayat;
        }


        if (Array.isArray(data.laporan)) {
            return data.laporan;
        }


        return [];
    };


    /*
    |--------------------------------------------------------------------------
    | EMPTY STATE
    |--------------------------------------------------------------------------
    */

    const renderEmpty = () => {

        return `
            <div
                class="
                    flex
                    min-h-[260px]
                    items-center
                    justify-center
                "
            >

                <div
                    class="
                        max-w-sm
                        text-center
                    "
                >

                    <div
                        class="
                            mx-auto
                            flex
                            h-14
                            w-14
                            items-center
                            justify-center
                            rounded-2xl
                            bg-slate-100
                            text-slate-400
                        "
                    >

                        <span
                            class="
                                material-symbols-outlined
                                text-[27px]
                            "
                        >
                            history
                        </span>

                    </div>


                    <h4
                        class="
                            mt-4
                            text-sm
                            font-bold
                            text-slate-700
                        "
                    >
                        Belum ada riwayat revisi
                    </h4>


                    <p
                        class="
                            mt-1
                            text-xs
                            leading-5
                            text-slate-400
                        "
                    >
                        Kelompok ini belum memiliki
                        laporan revisi sebelumnya.
                    </p>

                </div>

            </div>
        `;
    };


    /*
    |--------------------------------------------------------------------------
    | RENDER HISTORY
    |--------------------------------------------------------------------------
    */

    const renderHistory = (
        group,
        history
    ) => {

        const items =
            normalizeHistory(history);


        if (!items.length) {
            return renderEmpty();
        }


        /*
        |--------------------------------------------------------------------------
        | SORT BERDASARKAN TANGGAL
        |--------------------------------------------------------------------------
        */

        const sorted =
            [...items].sort((a, b) => {

                const dateA =
                    new Date(
                        a.updated_at ||
                        a.created_at ||
                        a.tanggal_revisi ||
                        a.tanggal ||
                        a.date ||
                        0
                    ).getTime();


                const dateB =
                    new Date(
                        b.updated_at ||
                        b.created_at ||
                        b.tanggal_revisi ||
                        b.tanggal ||
                        b.date ||
                        0
                    ).getTime();


                return dateB - dateA;
            });


        return `
            <div class="space-y-1">

                <!-- HEADER -->

                <div
                    class="
                        mb-5
                        rounded-2xl
                        border
                        border-slate-200
                        bg-white
                        p-4
                    "
                >

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                        "
                    >

                        <div
                            class="
                                flex
                                h-10
                                w-10
                                shrink-0
                                items-center
                                justify-center
                                rounded-xl
                                bg-amber-50
                                text-amber-600
                            "
                        >

                            <span
                                class="
                                    material-symbols-outlined
                                    text-[20px]
                                "
                            >
                                history
                            </span>

                        </div>


                        <div>

                            <div
                                class="
                                    text-[9px]
                                    font-bold
                                    uppercase
                                    tracking-[0.14em]
                                    text-slate-400
                                "
                            >
                                Riwayat Revisi
                            </div>


                            <div
                                class="
                                    mt-0.5
                                    text-sm
                                    font-bold
                                    text-[#212A37]
                                "
                            >
                                Kelompok ${escapeHtml(group)}
                            </div>

                        </div>


                        <div
                            class="
                                ml-auto
                                rounded-full
                                bg-slate-100
                                px-2.5
                                py-1
                                text-[10px]
                                font-bold
                                text-slate-500
                            "
                        >
                            ${sorted.length} versi
                        </div>

                    </div>

                </div>


                <!-- TIMELINE -->

                <div class="pl-1">

                    ${sorted
                        .map(
                            (item, index) =>
                                renderHistoryItem(
                                    item,
                                    index,
                                    sorted.length
                                )
                        )
                        .join("")}

                </div>

            </div>
        `;
    };


    /*
    |--------------------------------------------------------------------------
    | FETCH HISTORY
    |--------------------------------------------------------------------------
    */

    const loadHistory = async (
        button
    ) => {

        const group =
            button.dataset.group;


        if (!group) {
            return;
        }


        const modal =
            getModal();


        if (!modal) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | URL
        |--------------------------------------------------------------------------
        */

        const url =
            button.dataset.historyUrl ||
            `/library/praktik-industri/group/${encodeURIComponent(group)}/history`;


        /*
        |--------------------------------------------------------------------------
        | LOADING
        |--------------------------------------------------------------------------
        */

        modal.open(
            `Riwayat Revisi — Kelompok ${group}`,

            `
                <div
                    class="
                        flex
                        min-h-[280px]
                        items-center
                        justify-center
                    "
                >

                    <div
                        class="text-center"
                    >

                        <div
                            class="
                                mx-auto
                                flex
                                h-12
                                w-12
                                items-center
                                justify-center
                                rounded-2xl
                                bg-slate-100
                                text-slate-500
                            "
                        >

                            <span
                                class="
                                    material-symbols-outlined
                                    animate-spin
                                    text-[22px]
                                "
                            >
                                progress_activity
                            </span>

                        </div>


                        <div
                            class="
                                mt-3
                                text-xs
                                font-semibold
                                text-slate-500
                            "
                        >
                            Memuat riwayat...
                        </div>

                    </div>

                </div>
            `
        );


        /*
        |--------------------------------------------------------------------------
        | FETCH
        |--------------------------------------------------------------------------
        */

        try {

            const response =
                await fetch(
                    url,
                    {
                        headers: {
                            Accept:
                                "application/json",

                            "X-Requested-With":
                                "XMLHttpRequest",
                        },
                    }
                );


            if (!response.ok) {

                throw new Error(
                    `HTTP ${response.status}`
                );

            }


            const data =
                await response.json();


            /*
            |--------------------------------------------------------------------------
            | RENDER
            |--------------------------------------------------------------------------
            */

            const content =
                document.querySelector(
                    "[data-modal-content]"
                );


            if (!content) {
                return;
            }


            content.innerHTML =
                renderHistory(
                    group,
                    data
                );

        } catch (error) {

            console.error(
                "Gagal memuat riwayat Praktik Industri:",
                error
            );


            const content =
                document.querySelector(
                    "[data-modal-content]"
                );


            if (!content) {
                return;
            }


            content.innerHTML = `
                <div
                    class="
                        flex
                        min-h-[280px]
                        items-center
                        justify-center
                    "
                >

                    <div
                        class="
                            max-w-sm
                            text-center
                        "
                    >

                        <div
                            class="
                                mx-auto
                                flex
                                h-14
                                w-14
                                items-center
                                justify-center
                                rounded-2xl
                                bg-red-50
                                text-red-500
                            "
                        >

                            <span
                                class="
                                    material-symbols-outlined
                                    text-[27px]
                                "
                            >
                                error
                            </span>

                        </div>


                        <h4
                            class="
                                mt-4
                                text-sm
                                font-bold
                                text-slate-700
                            "
                        >
                            Riwayat gagal dimuat
                        </h4>


                        <p
                            class="
                                mt-1
                                text-xs
                                leading-5
                                text-slate-400
                            "
                        >
                            Terjadi kesalahan saat mengambil
                            data riwayat revisi.
                        </p>

                    </div>

                </div>
            `;
        }
    };


    /*
    |--------------------------------------------------------------------------
    | BIND BUTTON
    |--------------------------------------------------------------------------
    */

    const bindHistory = () => {

        const buttons =
            getHistoryButtons();


        buttons.forEach(
            (button) => {

                if (
                    button.dataset.historyBound ===
                    "true"
                ) {
                    return;
                }


                button.dataset.historyBound =
                    "true";


                button.addEventListener(
                    "click",
                    (event) => {

                        event.preventDefault();

                        loadHistory(button);

                    }
                );

            }
        );


        historyBound = true;
    };


    /*
    |--------------------------------------------------------------------------
    | RESULT AJAX BERUBAH
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        "praktikIndustriAdminResultUpdated",
        () => {

            historyBound = false;


            requestAnimationFrame(
                () => {
                    bindHistory();
                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    requestAnimationFrame(
        () => {
            bindHistory();
        }
    );
});