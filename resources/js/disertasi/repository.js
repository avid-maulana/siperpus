document.addEventListener("DOMContentLoaded", () => {
    /*
    |--------------------------------------------------------------------------
    | ELEMENTS
    |--------------------------------------------------------------------------
    */

    const modal = document.getElementById("repositoryModal");
    const modalPanel = document.getElementById("repositoryModalPanel");
    const modalBackdrop = document.getElementById("repositoryModalBackdrop");

    const modalClose = document.getElementById("repositoryModalClose");

    const modalCancel = document.getElementById("repositoryCancelBtn");

    /*
    |--------------------------------------------------------------------------
    | MODAL CONTENT
    |--------------------------------------------------------------------------
    */

    const modalTitle = document.getElementById("repositoryModalTitle");

    const modalSubtitle = document.getElementById("repositoryModalSubtitle");

    const modalJudul = document.getElementById("repositoryModalJudul");

    const modalJenis = document.getElementById("repositoryModalJenis");

    const modalNim = document.getElementById("repositoryModalNim");

    const modalNama = document.getElementById("repositoryModalNama");

    const modalIdPengajuan = document.getElementById(
        "repositoryModalIdPengajuan",
    );

    const sourceLink = document.getElementById("repositorySourceLink");

    /*
    |--------------------------------------------------------------------------
    | FORM
    |--------------------------------------------------------------------------
    */

    const form = document.getElementById("repositoryForm");

    const formMethod = document.getElementById("repositoryFormMethod");

    const idPengajuanInput = document.getElementById("repositoryIdPengajuan");

    /*
    |--------------------------------------------------------------------------
    | JENIS KARYA
    |--------------------------------------------------------------------------
    */

    const jenisThesis = document.getElementById("repositoryJenisThesis");

    const jenisDissertation = document.getElementById(
        "repositoryJenisDissertation",
    );

    const jenisError = document.getElementById("repositoryJenisError");

    /*
    |--------------------------------------------------------------------------
    | REPOSITORY
    |--------------------------------------------------------------------------
    */

    const repositoryUrl = document.getElementById("repositoryUrl");

    const repositoryTypeFile = document.getElementById("repositoryTypeFile");

    const repositoryTypeFolder = document.getElementById(
        "repositoryTypeFolder",
    );

    /*
    |--------------------------------------------------------------------------
    | BUTTONS
    |--------------------------------------------------------------------------
    */

    const saveButton = document.getElementById("repositorySaveBtn");

    const saveText = document.getElementById("repositorySaveText");

    const deleteButton = document.getElementById("repositoryDeleteBtn");

    const activateButton = document.getElementById("repositoryActivateBtn");

    /*
    |--------------------------------------------------------------------------
    | STATUS
    |--------------------------------------------------------------------------
    */

    const statusInfo = document.getElementById("repositoryStatusInfo");

    const statusIcon = document.getElementById("repositoryStatusIcon");

    const statusTitle = document.getElementById("repositoryStatusTitle");

    const statusDescription = document.getElementById(
        "repositoryStatusDescription",
    );

    /*
    |--------------------------------------------------------------------------
    | DELETE MODAL
    |--------------------------------------------------------------------------
    */

    const deleteModal = document.getElementById("repositoryDeleteModal");

    const deleteBackdrop = document.getElementById("repositoryDeleteBackdrop");

    const deleteCancelButton = document.getElementById(
        "repositoryDeleteCancelBtn",
    );

    const deleteConfirmButton = document.getElementById(
        "repositoryDeleteConfirmBtn",
    );

    /*
    |--------------------------------------------------------------------------
    | STATE
    |--------------------------------------------------------------------------
    */

    let currentRepositoryId = null;
    let currentMode = "create";
    let currentStatus = null;

    /*
    |--------------------------------------------------------------------------
    | MOVE MODAL TO BODY
    |--------------------------------------------------------------------------
    |
    | Hanya memindahkan DOM modal.
    |
    | Tidak mengubah form, event, atau logic repository.
    |
    */

    if (modal && modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    if (deleteModal && deleteModal.parentElement !== document.body) {
        document.body.appendChild(deleteModal);
    }

    /*
    |--------------------------------------------------------------------------
    | CSRF
    |--------------------------------------------------------------------------
    */

    const getCsrfToken = () => {
        const meta = document.querySelector('meta[name="csrf-token"]');

        return meta ? meta.getAttribute("content") : null;
    };

    /*
    |--------------------------------------------------------------------------
    | BODY SCROLL
    |--------------------------------------------------------------------------
    */

    const lockBody = () => {
        document.body.classList.add("overflow-hidden");
    };

    const unlockBody = () => {
        document.body.classList.remove("overflow-hidden");
    };

    /*
    |--------------------------------------------------------------------------
    | BUTTON LOADING
    |--------------------------------------------------------------------------
    */

    const setButtonLoading = (button, textElement, text) => {
        if (!button) {
            return;
        }

        button.disabled = true;

        button.classList.add("cursor-not-allowed", "opacity-70");

        if (textElement) {
            textElement.textContent = text;
        }
    };

    const resetButton = (button, textElement, text) => {
        if (!button) {
            return;
        }

        button.disabled = false;

        button.classList.remove("cursor-not-allowed", "opacity-70");

        if (textElement) {
            textElement.textContent = text;
        }
    };

    /*
    |--------------------------------------------------------------------------
    | OPEN MODAL
    |--------------------------------------------------------------------------
    */

    const openModal = () => {
        if (!modal || !modalPanel || !modalBackdrop) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan modal visible
        |--------------------------------------------------------------------------
        */

        modal.classList.remove("hidden");

        modal.classList.add("flex");

        /*
        |--------------------------------------------------------------------------
        | State awal animasi
        |--------------------------------------------------------------------------
        */

        modalBackdrop.classList.remove("opacity-100");

        modalBackdrop.classList.add("opacity-0");

        modalPanel.classList.remove(
            "translate-y-0",
            "scale-100",
            "opacity-100",
        );

        modalPanel.classList.add("translate-y-4", "scale-95", "opacity-0");

        /*
        |--------------------------------------------------------------------------
        | Force browser reflow
        |--------------------------------------------------------------------------
        */

        void modal.offsetWidth;

        /*
        |--------------------------------------------------------------------------
        | Animasi masuk
        |--------------------------------------------------------------------------
        */

        requestAnimationFrame(() => {
            modalBackdrop.classList.remove("opacity-0");

            modalBackdrop.classList.add("opacity-100");

            modalPanel.classList.remove(
                "translate-y-4",
                "scale-95",
                "opacity-0",
            );

            modalPanel.classList.add(
                "translate-y-0",
                "scale-100",
                "opacity-100",
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Lock page
        |--------------------------------------------------------------------------
        */

        lockBody();
    };

    /*
    |--------------------------------------------------------------------------
    | CLOSE MODAL
    |--------------------------------------------------------------------------
    */

    const closeModal = () => {
        if (!modal || !modalPanel || !modalBackdrop) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Animasi keluar
        |--------------------------------------------------------------------------
        */

        modalBackdrop.classList.remove("opacity-100");

        modalBackdrop.classList.add("opacity-0");

        modalPanel.classList.remove(
            "translate-y-0",
            "scale-100",
            "opacity-100",
        );

        modalPanel.classList.add("translate-y-4", "scale-95", "opacity-0");

        /*
        |--------------------------------------------------------------------------
        | Tunggu animasi selesai
        |--------------------------------------------------------------------------
        */

        setTimeout(() => {
            modal.classList.add("hidden");

            modal.classList.remove("flex");

            unlockBody();

            currentRepositoryId = null;
            currentMode = "create";
            currentStatus = null;
        }, 300);
    };

    /*
    |--------------------------------------------------------------------------
    | DELETE MODAL
    |--------------------------------------------------------------------------
    */

    const openDeleteModal = () => {
        if (!deleteModal) {
            return;
        }

        deleteModal.classList.remove("hidden");

        deleteModal.classList.add("flex");
    };

    const closeDeleteModal = () => {
        if (!deleteModal) {
            return;
        }

        deleteModal.classList.add("hidden");

        deleteModal.classList.remove("flex");
    };

    /*
    |--------------------------------------------------------------------------
    | SOURCE LINK
    |--------------------------------------------------------------------------
    */

    const setSourceLink = (url) => {
        if (!sourceLink) {
            return;
        }

        if (url) {
            sourceLink.href = url;

            sourceLink.classList.remove("pointer-events-none", "opacity-50");

            return;
        }

        sourceLink.href = "#";

        sourceLink.classList.add("pointer-events-none", "opacity-50");
    };

    /*
    |--------------------------------------------------------------------------
    | JENIS KARYA
    |--------------------------------------------------------------------------
    */

    const clearJenisKarya = () => {
        if (jenisThesis) {
            jenisThesis.checked = false;
        }

        if (jenisDissertation) {
            jenisDissertation.checked = false;
        }

        hideJenisError();
    };

    const getJenisKarya = () => {
        if (jenisThesis && jenisThesis.checked) {
            return "thesis";
        }

        if (jenisDissertation && jenisDissertation.checked) {
            return "dissertation";
        }

        return null;
    };

    const setJenisKarya = (jenis) => {
        clearJenisKarya();

        if (jenis === "thesis") {
            jenisThesis.checked = true;

            if (modalJenis) {
                modalJenis.textContent = "Tesis";
            }

            return;
        }

        if (jenis === "dissertation") {
            jenisDissertation.checked = true;

            if (modalJenis) {
                modalJenis.textContent = "Disertasi";
            }

            return;
        }

        if (modalJenis) {
            modalJenis.textContent = "Belum Ditentukan";
        }
    };

    const showJenisError = () => {
        if (!jenisError) {
            return;
        }

        jenisError.classList.remove("hidden");
    };

    const hideJenisError = () => {
        if (!jenisError) {
            return;
        }

        jenisError.classList.add("hidden");
    };

    /*
    |--------------------------------------------------------------------------
    | JENIS EVENT
    |--------------------------------------------------------------------------
    */

    jenisThesis?.addEventListener("change", () => {
        hideJenisError();

        if (jenisThesis.checked && modalJenis) {
            modalJenis.textContent = "Tesis";
        }
    });

    jenisDissertation?.addEventListener("change", () => {
        hideJenisError();

        if (jenisDissertation.checked && modalJenis) {
            modalJenis.textContent = "Disertasi";
        }
    });

    /*
    |--------------------------------------------------------------------------
    | STATUS UI
    |--------------------------------------------------------------------------
    */

    const setStatusUI = (status) => {
        currentStatus = status;

        if (!statusInfo) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | BELUM ADA
        |--------------------------------------------------------------------------
        */

        if (!status) {
            statusInfo.className =
                "rounded-2xl border border-amber-100 bg-amber-50 p-4";

            statusIcon.textContent = "link_off";

            statusIcon.className =
                "material-symbols-outlined mt-0.5 text-[20px] text-amber-500";

            statusTitle.textContent = "Belum Ada Repository";

            statusTitle.className = "text-sm font-semibold text-amber-800";

            statusDescription.textContent =
                "Repository belum tersedia. Tambahkan URL repository untuk memulai proses penanganan.";

            statusDescription.className =
                "mt-1 text-xs leading-5 text-amber-700";

            activateButton?.classList.add("hidden");

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | NEEDS ACTION
        |--------------------------------------------------------------------------
        */

        if (status === "needs_action") {
            statusInfo.className =
                "rounded-2xl border border-orange-100 bg-orange-50 p-4";

            statusIcon.textContent = "pending";

            statusIcon.className =
                "material-symbols-outlined mt-0.5 text-[20px] text-orange-500";

            statusTitle.textContent = "Perlu Ditangani";

            statusTitle.className = "text-sm font-semibold text-orange-800";

            statusDescription.textContent =
                "Repository sudah tersimpan, tetapi belum diverifikasi.";

            statusDescription.className =
                "mt-1 text-xs leading-5 text-orange-700";

            activateButton?.classList.remove("hidden");

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | ACTIVE
        |--------------------------------------------------------------------------
        */

        if (status === "active") {
            statusInfo.className =
                "rounded-2xl border border-emerald-100 bg-emerald-50 p-4";

            statusIcon.textContent = "check_circle";

            statusIcon.className =
                "material-symbols-outlined mt-0.5 text-[20px] text-emerald-500";

            statusTitle.textContent = "Repository Aktif";

            statusTitle.className = "text-sm font-semibold text-emerald-800";

            statusDescription.textContent =
                "Repository sudah diverifikasi dan dapat digunakan.";

            statusDescription.className =
                "mt-1 text-xs leading-5 text-emerald-700";

            activateButton?.classList.add("hidden");

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | UNKNOWN
        |--------------------------------------------------------------------------
        */

        statusInfo.className =
            "rounded-2xl border border-slate-200 bg-slate-50 p-4";

        statusIcon.textContent = "help";

        statusIcon.className =
            "material-symbols-outlined mt-0.5 text-[20px] text-slate-400";

        statusTitle.textContent = "Status Tidak Diketahui";

        statusTitle.className = "text-sm font-semibold text-slate-700";

        statusDescription.textContent =
            "Status repository belum dikenali oleh sistem.";

        statusDescription.className = "mt-1 text-xs leading-5 text-slate-500";

        activateButton?.classList.add("hidden");
    };

    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    const resetForm = () => {
        if (!form) {
            return;
        }

        form.reset();

        repositoryUrl.value = "";

        idPengajuanInput.value = "";

        clearJenisKarya();

        if (repositoryTypeFile) {
            repositoryTypeFile.checked = false;
        }

        if (repositoryTypeFolder) {
            repositoryTypeFolder.checked = false;
        }

        if (formMethod) {
            formMethod.value = "POST";
        }

        form.action = "/library/repository";

        currentRepositoryId = null;

        currentMode = "create";

        currentStatus = null;

        if (modalJenis) {
            modalJenis.textContent = "Belum Ditentukan";
        }

        setStatusUI(null);

        resetButton(saveButton, saveText, "Simpan Repository");

        deleteButton?.classList.add("hidden");

        activateButton?.classList.add("hidden");
    };

    /*
    |--------------------------------------------------------------------------
    | BASIC INFORMATION
    |--------------------------------------------------------------------------
    */

    const setBasicInformation = (data) => {
        if (modalJudul) {
            modalJudul.textContent = data.judul || "-";
        }

        if (modalNim) {
            modalNim.textContent = data.nim || "-";
        }

        if (modalNama) {
            modalNama.textContent = data.nama || "-";
        }

        if (modalIdPengajuan) {
            modalIdPengajuan.textContent = data.idPengajuan || "-";
        }

        if (idPengajuanInput) {
            idPengajuanInput.value = data.idPengajuan || "";
        }

        setJenisKarya(data.jenisKarya || null);

        setSourceLink(data.sourceUrl || "");
    };

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    const openCreateModal = (button) => {
        resetForm();

        currentMode = "create";

        currentRepositoryId = null;

        modalTitle.textContent = "Atur Repository";

        modalSubtitle.textContent =
            "Tentukan jenis karya dan tambahkan repository ke SIPERPUS.";

        saveText.textContent = "Simpan Repository";

        deleteButton?.classList.add("hidden");

        activateButton?.classList.add("hidden");

        setBasicInformation({
            idPengajuan: button.dataset.idPengajuan || "",

            jenisKarya: null,

            judul: button.dataset.judul || "",

            nim: button.dataset.nim || "",

            nama: button.dataset.nama || "",

            sourceUrl: button.dataset.sourceUrl || "",
        });

        clearJenisKarya();

        if (modalJenis) {
            modalJenis.textContent = "Belum Ditentukan";
        }

        repositoryUrl.value = "";

        setStatusUI(null);

        openModal();
    };

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    const openEditModal = (button) => {
        currentMode = "edit";

        currentRepositoryId = button.dataset.id || null;

        modalTitle.textContent = "Kelola Repository";

        modalSubtitle.textContent =
            "Perbarui jenis karya dan repository SIPERPUS.";

        saveText.textContent = "Simpan Perubahan";

        deleteButton?.classList.remove("hidden");

        setBasicInformation({
            idPengajuan: button.dataset.idPengajuan || "",

            jenisKarya: button.dataset.jenisKarya || null,

            judul: button.dataset.judul || "",

            nim: button.dataset.nim || "",

            nama: button.dataset.nama || "",

            sourceUrl: button.dataset.sourceUrl || "",
        });

        repositoryUrl.value = button.dataset.repositoryUrl || "";

        const repositoryType = button.dataset.repositoryType || "";

        if (repositoryTypeFile) {
            repositoryTypeFile.checked = repositoryType === "file";
        }

        if (repositoryTypeFolder) {
            repositoryTypeFolder.checked = repositoryType === "folder";
        }

        if (currentRepositoryId) {
            form.action = `/library/repository/${currentRepositoryId}`;
        }

        if (formMethod) {
            formMethod.value = "PUT";
        }

        setStatusUI(button.dataset.status || null);

        openModal();
    };

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    const validateRepositoryForm = () => {
        let valid = true;

        /*
        |--------------------------------------------------------------------------
        | Jenis wajib
        |--------------------------------------------------------------------------
        */

        if (!getJenisKarya()) {
            showJenisError();

            valid = false;
        } else {
            hideJenisError();
        }

        /*
        |--------------------------------------------------------------------------
        | URL optional
        |--------------------------------------------------------------------------
        */

        const urlValue = repositoryUrl.value.trim();

        repositoryUrl.value = urlValue;

        if (urlValue !== "") {
            try {
                new URL(urlValue);

                repositoryUrl.classList.remove(
                    "border-red-400",
                    "ring-2",
                    "ring-red-100",
                );
            } catch (error) {
                repositoryUrl.focus();

                repositoryUrl.classList.add(
                    "border-red-400",
                    "ring-2",
                    "ring-red-100",
                );

                valid = false;
            }
        } else {
            repositoryUrl.classList.remove(
                "border-red-400",
                "ring-2",
                "ring-red-100",
            );
        }

        return valid;
    };

    /*
    |--------------------------------------------------------------------------
    | SAVE
    |--------------------------------------------------------------------------
    */

    const submitRepositoryForm = () => {
        if (!form) {
            return;
        }

        if (!validateRepositoryForm()) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        if (currentMode === "create") {
            form.action = "/library/repository";

            formMethod.value = "POST";
        }

        /*
        |--------------------------------------------------------------------------
        | EDIT
        |--------------------------------------------------------------------------
        */

        if (currentMode === "edit" && currentRepositoryId) {
            form.action = `/library/repository/${currentRepositoryId}`;

            formMethod.value = "PUT";
        }

        /*
        |--------------------------------------------------------------------------
        | Loading
        |--------------------------------------------------------------------------
        */

        setButtonLoading(saveButton, saveText, "Menyimpan...");

        /*
        |--------------------------------------------------------------------------
        | Submit
        |--------------------------------------------------------------------------
        */

        HTMLFormElement.prototype.submit.call(form);
    };

    /*
    |--------------------------------------------------------------------------
    | ACTIVATE
    |--------------------------------------------------------------------------
    */

    const activateRepository = () => {
        if (!currentRepositoryId) {
            return;
        }

        if (!repositoryUrl.value.trim()) {
            repositoryUrl.focus();

            repositoryUrl.classList.add(
                "border-red-400",
                "ring-2",
                "ring-red-100",
            );

            return;
        }

        if (!getJenisKarya()) {
            showJenisError();

            return;
        }

        const csrfToken = getCsrfToken();

        if (!csrfToken) {
            alert("CSRF token tidak ditemukan. Silakan refresh halaman.");

            return;
        }

        const activateForm = document.createElement("form");

        activateForm.method = "POST";

        activateForm.action = `/library/repository/${currentRepositoryId}/activate`;

        activateForm.style.display = "none";

        /*
        |--------------------------------------------------------------------------
        | CSRF
        |--------------------------------------------------------------------------
        */

        const tokenInput = document.createElement("input");

        tokenInput.type = "hidden";

        tokenInput.name = "_token";

        tokenInput.value = csrfToken;

        activateForm.appendChild(tokenInput);

        /*
        |--------------------------------------------------------------------------
        | PATCH
        |--------------------------------------------------------------------------
        */

        const methodInput = document.createElement("input");

        methodInput.type = "hidden";

        methodInput.name = "_method";

        methodInput.value = "PATCH";

        activateForm.appendChild(methodInput);

        setButtonLoading(activateButton, null, "Mengaktifkan...");

        document.body.appendChild(activateForm);

        activateForm.submit();
    };

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    const deleteRepository = () => {
        if (!currentRepositoryId) {
            return;
        }

        const csrfToken = getCsrfToken();

        if (!csrfToken) {
            alert("CSRF token tidak ditemukan. Silakan refresh halaman.");

            return;
        }

        const deleteForm = document.createElement("form");

        deleteForm.method = "POST";

        deleteForm.action = `/library/repository/${currentRepositoryId}`;

        deleteForm.style.display = "none";

        /*
        |--------------------------------------------------------------------------
        | CSRF
        |--------------------------------------------------------------------------
        */

        const tokenInput = document.createElement("input");

        tokenInput.type = "hidden";

        tokenInput.name = "_token";

        tokenInput.value = csrfToken;

        deleteForm.appendChild(tokenInput);

        /*
        |--------------------------------------------------------------------------
        | DELETE
        |--------------------------------------------------------------------------
        */

        const methodInput = document.createElement("input");

        methodInput.type = "hidden";

        methodInput.name = "_method";

        methodInput.value = "DELETE";

        deleteForm.appendChild(methodInput);

        setButtonLoading(deleteConfirmButton, null, "Menghapus...");

        document.body.appendChild(deleteForm);

        deleteForm.submit();
    };

    /*
    |--------------------------------------------------------------------------
    | BUTTON EVENTS
    |--------------------------------------------------------------------------
    */

    saveButton?.addEventListener("click", submitRepositoryForm);

    activateButton?.addEventListener("click", activateRepository);

    deleteButton?.addEventListener("click", () => {
        if (!currentRepositoryId) {
            return;
        }

        openDeleteModal();
    });

    deleteConfirmButton?.addEventListener("click", deleteRepository);

    /*
    |--------------------------------------------------------------------------
    | CLOSE EVENTS
    |--------------------------------------------------------------------------
    */

    modalClose?.addEventListener("click", closeModal);

    modalCancel?.addEventListener("click", closeModal);

    modalBackdrop?.addEventListener("click", closeModal);

    deleteCancelButton?.addEventListener("click", closeDeleteModal);

    deleteBackdrop?.addEventListener("click", closeDeleteModal);

    /*
    |--------------------------------------------------------------------------
    | ESCAPE
    |--------------------------------------------------------------------------
    */

    document.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") {
            return;
        }

        if (deleteModal && !deleteModal.classList.contains("hidden")) {
            closeDeleteModal();

            return;
        }

        if (modal && !modal.classList.contains("hidden")) {
            closeModal();
        }
    });

    /*
    |--------------------------------------------------------------------------
    | TABLE BUTTONS
    |--------------------------------------------------------------------------
    |
    | Event delegation agar tombol tetap bekerja
    | walaupun tabel berubah.
    |
    */

    document.addEventListener("click", (event) => {
        const addButton = event.target.closest(".repository-add-btn");

        if (addButton) {
            event.preventDefault();

            openCreateModal(addButton);

            return;
        }

        const editButton = event.target.closest(".repository-edit-btn");

        if (editButton) {
            event.preventDefault();

            openEditModal(editButton);

            return;
        }
    });

    /*
    |--------------------------------------------------------------------------
    | REPOSITORY TABLE ACCORDION
    |--------------------------------------------------------------------------
    */

    const repositorySections = document.querySelectorAll(
        "[data-repository-section]",
    );

    repositorySections.forEach((section) => {
        const toggle = section.querySelector("[data-repository-toggle]");

        const content = section.querySelector("[data-repository-content]");

        const icon = section.querySelector("[data-repository-icon]");

        if (!toggle || !content || !icon) {
            return;
        }

        /*
    |--------------------------------------------------------------------------
    | DEFAULT STATE
    |--------------------------------------------------------------------------
    |
    | Belum Ada Repository  -> terbuka
    | Perlu Ditangani       -> terbuka
    | Aktif                 -> tertutup
    |
    */

        const sectionType = section.dataset.repositorySection;

        if (sectionType === "active") {
            content.style.maxHeight = "0px";

            icon.textContent = "expand_more";
        } else {
            content.style.maxHeight = content.scrollHeight + "px";

            icon.textContent = "expand_less";
        }

        /*
    |--------------------------------------------------------------------------
    | TOGGLE
    |--------------------------------------------------------------------------
    */

        toggle.addEventListener("click", () => {
            const isOpen = content.style.maxHeight !== "0px";

            if (isOpen) {
                content.style.maxHeight = "0px";

                icon.textContent = "expand_more";
            } else {
                content.style.maxHeight = content.scrollHeight + "px";

                icon.textContent = "expand_less";
            }
        });
    });

    /*
    |--------------------------------------------------------------------------
    | URL ERROR RESET
    |--------------------------------------------------------------------------
    */

    repositoryUrl?.addEventListener("input", () => {
        repositoryUrl.classList.remove(
            "border-red-400",
            "ring-2",
            "ring-red-100",
        );
    });
});
