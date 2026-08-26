/*
|--------------------------------------------------------------------------
| ADMIN PRAKTIK INDUSTRI
|--------------------------------------------------------------------------
| DETAIL LAPORAN
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => {
    /*
    |--------------------------------------------------------------------------
    | ELEMENT MODAL
    |--------------------------------------------------------------------------
    */

    const modal = document.getElementById("praktikIndustriAdminModal");

    if (!modal) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | PINDAHKAN MODAL KE BODY
    |--------------------------------------------------------------------------
    */

    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    /*
    |--------------------------------------------------------------------------
    | ELEMENT MODAL
    |--------------------------------------------------------------------------
    */

    const panel = modal.querySelector("[data-modal-panel]");

    const title = modal.querySelector("[data-modal-title]");

    const content = modal.querySelector("[data-modal-content]");

    const closeButton = modal.querySelector("[data-modal-close]");

    const backdrop = modal.querySelector("[data-modal-backdrop]");

    if (!panel || !title || !content) {
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    */

    const escapeHtml = (value) => {
        if (value === null || value === undefined) {
            return "-";
        }

        return String(value)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    };

    /*
    |--------------------------------------------------------------------------
    | OPEN MODAL
    |--------------------------------------------------------------------------
    */

    const openModal = (modalTitle, modalContent) => {
        title.textContent = modalTitle;

        content.innerHTML = modalContent;

        modal.classList.remove("hidden");

        modal.setAttribute("aria-hidden", "false");

        document.body.classList.add("overflow-hidden");

        requestAnimationFrame(() => {
            panel.classList.remove("opacity-0", "translate-y-4", "scale-95");

            panel.classList.add("opacity-100", "translate-y-0", "scale-100");
        });
    };

    /*
    |--------------------------------------------------------------------------
    | CLOSE MODAL
    |--------------------------------------------------------------------------
    */

    const closeModal = () => {
        if (modal.classList.contains("hidden")) {
            return;
        }

        panel.classList.remove("opacity-100", "translate-y-0", "scale-100");

        panel.classList.add("opacity-0", "translate-y-4", "scale-95");

        setTimeout(() => {
            modal.classList.add("hidden");

            modal.setAttribute("aria-hidden", "true");

            content.innerHTML = "";

            document.body.classList.remove("overflow-hidden");
        }, 200);
    };

    /*
    |--------------------------------------------------------------------------
    | CLOSE BUTTON
    |--------------------------------------------------------------------------
    */

    closeButton?.addEventListener("click", closeModal);

    /*
    |--------------------------------------------------------------------------
    | BACKDROP
    |--------------------------------------------------------------------------
    */

    backdrop?.addEventListener("click", closeModal);

    /*
    |--------------------------------------------------------------------------
    | ESCAPE KEY
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && !modal.classList.contains("hidden")) {
            closeModal();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | DETAIL LAPORAN
    |--------------------------------------------------------------------------
    */

    const openDetail = (button) => {
        /*
        |--------------------------------------------------------------------------
        | CARI ROW
        |--------------------------------------------------------------------------
        */

        const row = button.closest("[data-praktik-row]");

        if (!row) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */

        const kelompok = row.dataset.group || "-";

        const judul = row.dataset.title || "-";

        const ketua = row.dataset.ketua || "-";

        let anggota = [];

        try {
            anggota = JSON.parse(row.dataset.anggota || "[]");
        } catch (error) {
            console.error("Gagal membaca data anggota:", error);

            anggota = [];
        }

        const industri = row.dataset.industri || "-";

        const tanggal = row.dataset.date || "-";

        const waktu = row.dataset.time || "-";

        const pdf = row.dataset.pdf || "";

        const jumlahRevisi = Number(row.dataset.revisions || 0);

        const anggotaHtml = anggota.length
            ? `
            <div
                class="rounded-2xl
                    border
                    border-slate-200
                    bg-white
                    p-4"
            >

                <div
                    class="flex
                        items-center
                        gap-2"
                >

                    <span
                        class="material-symbols-outlined
                            text-[18px]
                            text-slate-400"
                    >
                        group
                    </span>

                    <span
                        class="text-[10px]
                            font-bold
                            uppercase
                            tracking-wider
                            text-slate-400"
                    >
                        Anggota Kelompok
                    </span>

                    <span
                        class="rounded-full
                            bg-slate-100
                            px-2 py-0.5
                            text-[10px]
                            font-semibold
                            text-slate-500"
                    >
                        ${anggota.length}
                    </span>

                </div>


                <div class="mt-3 space-y-2">

                    ${anggota
                        .map(
                            (member, index) => `
                                <div
                                    class="flex
                                        items-center
                                        gap-3
                                        rounded-xl
                                        bg-slate-50
                                        px-3 py-2.5"
                                >

                                    <div
                                        class="flex
                                            h-7
                                            w-7
                                            shrink-0
                                            items-center
                                            justify-center
                                            rounded-lg
                                            bg-white
                                            text-xs
                                            font-bold
                                            text-slate-500
                                            ring-1
                                            ring-slate-200"
                                    >
                                        ${index + 1}
                                    </div>

                                    <div
                                        class="min-w-0
                                            truncate
                                            text-sm
                                            font-semibold
                                            text-[#212A37]"
                                    >
                                        ${escapeHtml(member.nama || "-")}
                                    </div>

                                </div>
                            `,
                        )
                        .join("")}

                </div>

            </div>
        `
            : "";

        /*
        |--------------------------------------------------------------------------
        | STATUS REVISI
        |--------------------------------------------------------------------------
        */

        const revisionBadge =
            jumlahRevisi > 0
                ? `
                    <span
                        class="inline-flex
                               items-center
                               gap-1.5
                               rounded-full
                               border
                               border-amber-200
                               bg-amber-50
                               px-3
                               py-1.5
                               text-xs
                               font-semibold
                               text-amber-700"
                    >

                        <span
                            class="material-symbols-outlined
                                   text-[15px]"
                        >
                            history
                        </span>

                        ${jumlahRevisi} riwayat revisi

                    </span>
                `
                : `
                    <span
                        class="inline-flex
                               items-center
                               gap-1.5
                               rounded-full
                               bg-slate-100
                               px-3
                               py-1.5
                               text-xs
                               font-semibold
                               text-slate-500"
                    >

                        Tidak ada revisi

                    </span>
                `;

        /*
        |--------------------------------------------------------------------------
        | PDF BUTTON
        |--------------------------------------------------------------------------
        */

        const pdfButton = pdf
            ? `
                    <a
                        href="${escapeHtml(pdf)}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex
                               items-center
                               justify-center
                               gap-2
                               rounded-xl
                               bg-[#212A37]
                               px-4
                               py-3
                               text-sm
                               font-semibold
                               text-white
                               shadow-sm
                               transition-all
                               duration-200
                               hover:bg-[#2b3747]
                               hover:shadow-md"
                    >

                        <span
                            class="material-symbols-outlined
                                   text-[19px]"
                        >
                            picture_as_pdf
                        </span>

                        Buka Laporan PDF

                    </a>
                `
            : `
                    <span
                        class="inline-flex
                               items-center
                               justify-center
                               gap-2
                               rounded-xl
                               bg-slate-100
                               px-4
                               py-3
                               text-sm
                               font-semibold
                               text-slate-400"
                    >

                        <span
                            class="material-symbols-outlined
                                   text-[19px]"
                        >
                            picture_as_pdf
                        </span>

                        File tidak tersedia

                    </span>
                `;

        /*
        |--------------------------------------------------------------------------
        | MODAL CONTENT
        |--------------------------------------------------------------------------
        */

        const modalContent = `

            <div class="space-y-7">

                <!-- STATUS -->

                <div
                    class="flex
                           items-center
                           justify-between
                           gap-4"
                >

                    <span
                        class="inline-flex
                               items-center
                               gap-2
                               rounded-full
                               bg-emerald-50
                               px-3
                               py-1.5
                               text-xs
                               font-semibold
                               text-emerald-600"
                    >

                        <span
                            class="h-2
                                   w-2
                                   rounded-full
                                   bg-emerald-500"
                        ></span>

                        Laporan terbaru

                    </span>


                    ${revisionBadge}

                </div>


                <!-- JUDUL -->

                <div>

                    <div
                        class="mb-2
                               text-[10px]
                               font-bold
                               uppercase
                               tracking-[0.12em]
                               text-slate-400"
                    >
                        Judul Laporan
                    </div>


                    <div
                        class="rounded-2xl
                               border
                               border-slate-200
                               bg-slate-50/70
                               p-5"
                    >

                        <div
                            class="flex
                                   items-start
                                   gap-4"
                        >

                            <div
                                class="flex
                                       h-11
                                       w-11
                                       shrink-0
                                       items-center
                                       justify-center
                                       rounded-xl
                                       bg-white
                                       text-slate-500
                                       shadow-sm
                                       ring-1
                                       ring-slate-200"
                            >

                                <span
                                    class="material-symbols-outlined
                                           text-[22px]"
                                >
                                    description
                                </span>

                            </div>


                            <div class="min-w-0">

                                <div
                                    class="text-[10px]
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-400"
                                >
                                    Judul Laporan
                                </div>


                                <div
                                    class="mt-1
                                           break-words
                                           text-sm
                                           font-semibold
                                           leading-6
                                           text-[#212A37]"
                                >
                                    ${escapeHtml(judul)}
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- INFORMATION -->

                <div>

                    <div
                        class="mb-3
                               text-[10px]
                               font-bold
                               uppercase
                               tracking-[0.12em]
                               text-slate-400"
                    >
                        Informasi Laporan
                    </div>


                    <div
                        class="grid
                               grid-cols-2
                               gap-3"
                    >

                        <!-- KELOMPOK -->

                        <div
                            class="rounded-2xl
                                   border
                                   border-slate-200
                                   bg-white
                                   p-4"
                        >

                            <div
                                class="flex
                                       items-center
                                       gap-2"
                            >

                                <span
                                    class="material-symbols-outlined
                                           text-[18px]
                                           text-slate-400"
                                >
                                    groups
                                </span>

                                <span
                                    class="text-[10px]
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-400"
                                >
                                    Kelompok
                                </span>

                            </div>


                            <div
                                class="mt-3
                                       text-sm
                                       font-bold
                                       text-[#212A37]"
                            >
                                ${escapeHtml(kelompok)}
                            </div>

                        </div>


                        <!-- KETUA -->

                        <div
                            class="rounded-2xl
                                   border
                                   border-slate-200
                                   bg-white
                                   p-4"
                        >

                            <div
                                class="flex
                                       items-center
                                       gap-2"
                            >

                                <span
                                    class="material-symbols-outlined
                                           text-[18px]
                                           text-slate-400"
                                >
                                    person
                                </span>

                                <span
                                    class="text-[10px]
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-400"
                                >
                                    Ketua Kelompok
                                </span>

                            </div>


                            <div
                                class="mt-3
                                       truncate
                                       text-sm
                                       font-bold
                                       text-[#212A37]"
                                title="${escapeHtml(ketua)}"
                            >
                                ${escapeHtml(ketua)}
                            </div>

                        </div>


                        <!-- INDUSTRI -->

                        <div
                            class="rounded-2xl
                                   border
                                   border-slate-200
                                   bg-white
                                   p-4"
                        >

                            <div
                                class="flex
                                       items-center
                                       gap-2"
                            >

                                <span
                                    class="material-symbols-outlined
                                           text-[18px]
                                           text-slate-400"
                                >
                                    business
                                </span>

                                <span
                                    class="text-[10px]
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-400"
                                >
                                    Tempat Praktik
                                </span>

                            </div>


                            <div
                                class="mt-3
                                       truncate
                                       text-sm
                                       font-bold
                                       text-[#212A37]"
                                title="${escapeHtml(industri)}"
                            >
                                ${escapeHtml(industri)}
                            </div>

                        </div>


                        <!-- UPDATE -->

                        <div
                            class="rounded-2xl
                                   border
                                   border-slate-200
                                   bg-white
                                   p-4"
                        >

                            <div
                                class="flex
                                       items-center
                                       gap-2"
                            >

                                <span
                                    class="material-symbols-outlined
                                           text-[18px]
                                           text-slate-400"
                                >
                                    schedule
                                </span>

                                <span
                                    class="text-[10px]
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-400"
                                >
                                    Terakhir Diperbarui
                                </span>

                            </div>


                            <div
                                class="mt-3
                                       text-sm
                                       font-bold
                                       text-[#212A37]"
                            >
                                ${escapeHtml(tanggal)}
                            </div>


                            ${
                                waktu !== "-"
                                    ? `
                                        <div
                                            class="mt-0.5
                                                   text-xs
                                                   text-slate-400"
                                        >
                                            ${escapeHtml(waktu)} WIB
                                        </div>
                                      `
                                    : ""
                            }

                        </div>

                                        </div>

                </div>


                <!-- ANGGOTA KELOMPOK -->

                ${anggotaHtml}


                <!-- ACTION -->

                <div>

                    <div
                        class="mb-3
                               text-[10px]
                               font-bold
                               uppercase
                               tracking-[0.12em]
                               text-slate-400"
                    >
                        Aksi
                    </div>


                    <div
                        class="flex
                               items-center
                               justify-between
                               gap-4
                               border-t
                               border-slate-200
                               pt-4"
                    >

                        <div
                            class="text-xs
                                   leading-5
                                   text-slate-400"
                        >
                            Laporan yang ditampilkan merupakan
                            laporan terbaru dari kelompok ini.
                        </div>


                        <div class="shrink-0">

                            ${pdfButton}

                        </div>

                    </div>

                </div>

            </div>

        `;

        /*
        |--------------------------------------------------------------------------
        | OPEN
        |--------------------------------------------------------------------------
        */

        openModal("Detail Laporan Praktik Industri", modalContent);
    };

    /*
    |--------------------------------------------------------------------------
    | BIND DETAIL BUTTON
    |--------------------------------------------------------------------------
    */

    const bindDetail = () => {
        const resultContainer =
            window.praktikIndustriAdmin?.getResultContainer?.();

        if (!resultContainer) {
            return;
        }

        resultContainer.querySelectorAll("[data-detail]").forEach((button) => {
            if (button.dataset.detailBound === "true") {
                return;
            }

            button.dataset.detailBound = "true";

            button.addEventListener("click", (event) => {
                event.preventDefault();

                openDetail(button);
            });
        });
    };

    /*
    |--------------------------------------------------------------------------
    | AJAX RESULT UPDATED
    |--------------------------------------------------------------------------
    */

    document.addEventListener("praktikIndustriAdminResultUpdated", () => {
        bindDetail();
    });

    /*
    |--------------------------------------------------------------------------
    | INITIAL
    |--------------------------------------------------------------------------
    */

    requestAnimationFrame(() => {
        bindDetail();
    });

    /*
    |--------------------------------------------------------------------------
    | EXPORT MODAL
    |--------------------------------------------------------------------------
    */

    window.praktikIndustriAdminModal = {
        open: openModal,

        close: closeModal,
    };
});
