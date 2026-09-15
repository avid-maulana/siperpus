export function createRepositoryForm(elements, modal, deleteModal) {
    const {
        modalTitle, modalSubtitle, modalJudul, modalJenis, modalNim, modalNama,
        modalIdPengajuan, sourceLink, form, formMethod, idPengajuanInput,
        jenisThesis, jenisDissertation, jenisError, repositoryUrl,
        repositoryTypeFile, repositoryTypeFolder, saveButton, saveText,
        deleteButton, activateButton, statusInfo, statusIcon, statusTitle,
        statusDescription, deleteConfirmButton,
    } = elements;

    let currentRepositoryId = null;
    let currentMode = "create";
    let currentStatus = null;

    const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content;
    const setLoading = (button, textElement, text) => {
        if (!button) return;
        button.disabled = true;
        button.classList.add("cursor-not-allowed", "opacity-70");
        if (textElement) textElement.textContent = text;
    };
    const resetButton = (button, textElement, text) => {
        if (!button) return;
        button.disabled = false;
        button.classList.remove("cursor-not-allowed", "opacity-70");
        if (textElement) textElement.textContent = text;
    };
    const showJenisError = () => jenisError?.classList.remove("hidden");
    const hideJenisError = () => jenisError?.classList.add("hidden");

    const setSourceLink = (url) => {
        if (!sourceLink) return;
        sourceLink.href = url || "#";
        sourceLink.classList.toggle("pointer-events-none", !url);
        sourceLink.classList.toggle("opacity-50", !url);
    };

    const clearJenisKarya = () => {
        if (jenisThesis) jenisThesis.checked = false;
        if (jenisDissertation) jenisDissertation.checked = false;
        hideJenisError();
    };
    const getJenisKarya = () => jenisThesis?.checked ? "thesis" : jenisDissertation?.checked ? "dissertation" : null;
    const setJenisKarya = (jenis) => {
        clearJenisKarya();
        if (jenis === "thesis") {
            jenisThesis.checked = true;
            if (modalJenis) modalJenis.textContent = "Tesis";
        } else if (jenis === "dissertation") {
            jenisDissertation.checked = true;
            if (modalJenis) modalJenis.textContent = "Disertasi";
        } else if (modalJenis) {
            modalJenis.textContent = "Belum Ditentukan";
        }
    };

    const setStatusUI = (status) => {
        currentStatus = status;
        if (!statusInfo) return;
        const states = {
            null: {
                container: "rounded-2xl border border-amber-100 bg-amber-50 p-4",
                icon: "material-symbols-outlined mt-0.5 text-[20px] text-amber-500",
                title: "text-sm font-semibold text-amber-800",
                description: "mt-1 text-xs leading-5 text-amber-700",
                iconName: "link_off",
                titleText: "Belum Ada Repository",
                descriptionText: "Repository belum tersedia. Tambahkan URL repository untuk memulai proses penanganan.",
            },
            needs_action: {
                container: "rounded-2xl border border-orange-100 bg-orange-50 p-4",
                icon: "material-symbols-outlined mt-0.5 text-[20px] text-orange-500",
                title: "text-sm font-semibold text-orange-800",
                description: "mt-1 text-xs leading-5 text-orange-700",
                iconName: "pending",
                titleText: "Perlu Ditangani",
                descriptionText: "Repository sudah tersimpan, tetapi belum diverifikasi.",
            },
            active: {
                container: "rounded-2xl border border-emerald-100 bg-emerald-50 p-4",
                icon: "material-symbols-outlined mt-0.5 text-[20px] text-emerald-500",
                title: "text-sm font-semibold text-emerald-800",
                description: "mt-1 text-xs leading-5 text-emerald-700",
                iconName: "check_circle",
                titleText: "Repository Aktif",
                descriptionText: "Repository sudah diverifikasi dan dapat digunakan.",
            },
        };
        const fallback = {
            container: "rounded-2xl border border-slate-200 bg-slate-50 p-4",
            icon: "material-symbols-outlined mt-0.5 text-[20px] text-slate-400",
            title: "text-sm font-semibold text-slate-700",
            description: "mt-1 text-xs leading-5 text-slate-500",
            iconName: "help",
            titleText: "Status Tidak Diketahui",
            descriptionText: "Status repository belum dikenali oleh sistem.",
        };
        const state = states[status] || fallback;
        statusInfo.className = state.container;
        statusIcon.textContent = state.iconName;
        statusIcon.className = state.icon;
        statusTitle.textContent = state.titleText;
        statusTitle.className = state.title;
        statusDescription.textContent = state.descriptionText;
        statusDescription.className = state.description;
        activateButton?.classList.toggle("hidden", status !== "needs_action");
    };

    const setBasicInformation = (data) => {
        if (modalJudul) modalJudul.textContent = data.judul || "-";
        if (modalNim) modalNim.textContent = data.nim || "-";
        if (modalNama) modalNama.textContent = data.nama || "-";
        if (modalIdPengajuan) modalIdPengajuan.textContent = data.idPengajuan || "-";
        if (idPengajuanInput) idPengajuanInput.value = data.idPengajuan || "";
        setJenisKarya(data.jenisKarya || null);
        setSourceLink(data.sourceUrl || "");
    };

    const resetForm = () => {
        form?.reset();
        if (repositoryUrl) repositoryUrl.value = "";
        if (idPengajuanInput) idPengajuanInput.value = "";
        clearJenisKarya();
        if (repositoryTypeFile) repositoryTypeFile.checked = false;
        if (repositoryTypeFolder) repositoryTypeFolder.checked = false;
        if (formMethod) formMethod.value = "POST";
        if (form) form.action = "/library/repository";
        currentRepositoryId = null;
        currentMode = "create";
        currentStatus = null;
        if (modalJenis) modalJenis.textContent = "Belum Ditentukan";
        setStatusUI(null);
        resetButton(saveButton, saveText, "Simpan Repository");
        deleteButton?.classList.add("hidden");
        activateButton?.classList.add("hidden");
    };

    const openCreate = (button) => {
        resetForm();
        modalTitle.textContent = "Atur Repository";
        modalSubtitle.textContent = "Tentukan jenis karya dan tambahkan repository ke SIPERPUS.";
        saveText.textContent = "Simpan Repository";
        setBasicInformation({ idPengajuan: button.dataset.idPengajuan, judul: button.dataset.judul, nim: button.dataset.nim, nama: button.dataset.nama, sourceUrl: button.dataset.sourceUrl });
        setStatusUI(null);
        modal.open();
    };

    const openEdit = (button) => {
        currentMode = "edit";
        currentRepositoryId = button.dataset.id || null;
        modalTitle.textContent = "Kelola Repository";
        modalSubtitle.textContent = "Perbarui jenis karya dan repository SIPERPUS.";
        saveText.textContent = "Simpan Perubahan";
        deleteButton?.classList.remove("hidden");
        setBasicInformation({ idPengajuan: button.dataset.idPengajuan, jenisKarya: button.dataset.jenisKarya, judul: button.dataset.judul, nim: button.dataset.nim, nama: button.dataset.nama, sourceUrl: button.dataset.sourceUrl });
        if (repositoryUrl) repositoryUrl.value = button.dataset.repositoryUrl || "";
        if (repositoryTypeFile) repositoryTypeFile.checked = button.dataset.repositoryType === "file";
        if (repositoryTypeFolder) repositoryTypeFolder.checked = button.dataset.repositoryType === "folder";
        if (form) form.action = `/library/repository/${currentRepositoryId}`;
        if (formMethod) formMethod.value = "PUT";
        setStatusUI(button.dataset.status || null);
        modal.open();
    };

    const validate = () => {
        let valid = true;
        if (!getJenisKarya()) {
            showJenisError();
            valid = false;
        } else hideJenisError();
        const value = repositoryUrl?.value.trim() || "";
        if (repositoryUrl) repositoryUrl.value = value;
        if (value) {
            try { new URL(value); repositoryUrl.classList.remove("border-red-400", "ring-2", "ring-red-100"); }
            catch { repositoryUrl.focus(); repositoryUrl.classList.add("border-red-400", "ring-2", "ring-red-100"); valid = false; }
        } else repositoryUrl?.classList.remove("border-red-400", "ring-2", "ring-red-100");
        return valid;
    };

    const submit = () => {
        if (!form || !validate()) return;
        form.action = currentMode === "edit" && currentRepositoryId ? `/library/repository/${currentRepositoryId}` : "/library/repository";
        formMethod.value = currentMode === "edit" ? "PUT" : "POST";
        setLoading(saveButton, saveText, "Menyimpan...");
        HTMLFormElement.prototype.submit.call(form);
    };

    const submitAction = (method, suffix, button, label, requiresRepository = true) => {
        if (!currentRepositoryId) return;
        const token = csrf();
        if (!token) return alert("CSRF token tidak ditemukan. Silakan refresh halaman.");
        if (requiresRepository && (!repositoryUrl?.value.trim() || !getJenisKarya())) return validate();
        const actionForm = document.createElement("form");
        actionForm.method = "POST";
        actionForm.action = `/library/repository/${currentRepositoryId}${suffix}`;
        actionForm.style.display = "none";
        actionForm.innerHTML = `<input type="hidden" name="_token" value="${token}"><input type="hidden" name="_method" value="${method}">`;
        setLoading(button, null, label);
        document.body.appendChild(actionForm);
        actionForm.submit();
    };

    jenisThesis?.addEventListener("change", () => { hideJenisError(); if (jenisThesis.checked && modalJenis) modalJenis.textContent = "Tesis"; });
    jenisDissertation?.addEventListener("change", () => { hideJenisError(); if (jenisDissertation.checked && modalJenis) modalJenis.textContent = "Disertasi"; });
    repositoryUrl?.addEventListener("input", () => repositoryUrl.classList.remove("border-red-400", "ring-2", "ring-red-100"));
    saveButton?.addEventListener("click", submit);
    activateButton?.addEventListener("click", () => submitAction("PATCH", "/activate", activateButton, "Mengaktifkan..."));
    deleteButton?.addEventListener("click", () => currentRepositoryId && deleteModal.open());
    deleteConfirmButton?.addEventListener("click", () => submitAction("DELETE", "", deleteConfirmButton, "Menghapus...", false));

    return { openCreate, openEdit, resetForm };
}
