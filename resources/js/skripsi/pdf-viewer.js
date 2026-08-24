document.addEventListener("DOMContentLoaded", () => {

    /*
    |--------------------------------------------------------------------------
    | PDF VIEWER ELEMENT
    |--------------------------------------------------------------------------
    */

    const modal = document.getElementById("skripsiPdfModal");
    const backdrop = document.getElementById("skripsiPdfBackdrop");
    const closeButton = document.getElementById("skripsiPdfClose");

    const frame = document.getElementById("skripsiPdfFrame");
    const title = document.getElementById("skripsiPdfTitle");

    const loading = document.getElementById("skripsiPdfLoading");
    const error = document.getElementById("skripsiPdfError");


    /*
    |--------------------------------------------------------------------------
    | VALIDASI
    |--------------------------------------------------------------------------
    */

    if (!modal || !frame) {
        console.warn(
            "PDF Viewer Skripsi: modal tidak ditemukan."
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | PINDAHKAN MODAL LANGSUNG KE BODY
    |--------------------------------------------------------------------------
    |
    | Ini penting supaya fixed positioning benar-benar
    | mengikuti viewport browser.
    |
    */

    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }


    /*
    |--------------------------------------------------------------------------
    | SISINTA URL
    |--------------------------------------------------------------------------
    */

    const sisintaFileUrl = (
        window.SISINTA_FILE_URL || ""
    ).replace(/\/+$/, "");


    /*
    |--------------------------------------------------------------------------
    | OPEN PDF
    |--------------------------------------------------------------------------
    */

    const openPdf = (button) => {

        const filePath =
            button.dataset.pdfPath;

        const pdfTitle =
            button.dataset.pdfTitle ||
            "PDF Viewer";


        /*
        |--------------------------------------------------------------------------
        | VALIDASI PATH
        |--------------------------------------------------------------------------
        */

        if (!filePath) {

            console.error(
                "PDF Viewer Skripsi: path file tidak ditemukan."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI URL
        |--------------------------------------------------------------------------
        */

        if (!sisintaFileUrl) {

            console.error(
                "PDF Viewer Skripsi: SISINTA_FILE_URL belum tersedia."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | BERSIHKAN PATH
        |--------------------------------------------------------------------------
        */

        const cleanPath = filePath
            .trim()
            .replace(/^\/+/, "");


        /*
        |--------------------------------------------------------------------------
        | URL FINAL
        |--------------------------------------------------------------------------
        */

        const pdfUrl =
            `${sisintaFileUrl}/${cleanPath}`;


        /*
        |--------------------------------------------------------------------------
        | TITLE
        |--------------------------------------------------------------------------
        */

        if (title) {
            title.textContent = pdfTitle;
        }


        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        loading?.classList.remove("hidden");
        loading?.classList.add("flex");

        error?.classList.add("hidden");
        error?.classList.remove("flex");

        frame.src = "";


        /*
        |--------------------------------------------------------------------------
        | OPEN MODAL
        |--------------------------------------------------------------------------
        */

        modal.classList.remove("hidden");

        modal.setAttribute(
            "aria-hidden",
            "false"
        );


        /*
        |--------------------------------------------------------------------------
        | LOCK PAGE
        |--------------------------------------------------------------------------
        */

        document.body.classList.add(
            "overflow-hidden"
        );


        /*
        |--------------------------------------------------------------------------
        | LOAD PDF
        |--------------------------------------------------------------------------
        */

        frame.onload = () => {

            loading?.classList.add("hidden");
            loading?.classList.remove("flex");

        };


        /*
        |--------------------------------------------------------------------------
        | ERROR PDF
        |--------------------------------------------------------------------------
        */

        frame.onerror = () => {

            loading?.classList.add("hidden");
            loading?.classList.remove("flex");

            error?.classList.remove("hidden");
            error?.classList.add("flex");

        };


        frame.src = pdfUrl;
    };


    /*
    |--------------------------------------------------------------------------
    | CLOSE PDF
    |--------------------------------------------------------------------------
    */

    const closePdf = () => {

        modal.classList.add("hidden");

        modal.setAttribute(
            "aria-hidden",
            "true"
        );


        document.body.classList.remove(
            "overflow-hidden"
        );


        frame.src = "";


        loading?.classList.remove("hidden");
        loading?.classList.add("flex");

        error?.classList.add("hidden");
        error?.classList.remove("flex");
    };


    /*
    |--------------------------------------------------------------------------
    | OPEN BUTTON
    |--------------------------------------------------------------------------
    |
    | Gunakan selector khusus Skripsi agar tidak
    | bentrok dengan pdf-viewer global.
    |
    */

    document.addEventListener("click", (event) => {

        const button = event.target.closest(
            "[data-skripsi-pdf-viewer]"
        );


        if (!button) {
            return;
        }


        event.preventDefault();

        openPdf(button);
    });


    /*
    |--------------------------------------------------------------------------
    | CLOSE
    |--------------------------------------------------------------------------
    */

    closeButton?.addEventListener(
        "click",
        closePdf
    );


    /*
    |--------------------------------------------------------------------------
    | BACKDROP
    |--------------------------------------------------------------------------
    */

    backdrop?.addEventListener(
        "click",
        closePdf
    );


    /*
    |--------------------------------------------------------------------------
    | ESCAPE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        "keydown",
        (event) => {

            if (
                event.key === "Escape" &&
                !modal.classList.contains("hidden")
            ) {

                closePdf();

            }

        }
    );

});