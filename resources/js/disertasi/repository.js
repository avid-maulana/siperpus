import { createModalController, createSimpleModal, moveToBody } from "./repository/modal.js";
import { createRepositoryForm } from "./repository/form.js";
import { initRepositoryTable } from "./repository/table.js";

document.addEventListener("DOMContentLoaded", () => {
    const get = (id) => document.getElementById(id);
    const modal = get("repositoryModal");
    const deleteModal = get("repositoryDeleteModal");

    if (!modal || !deleteModal) return;

    moveToBody(modal);
    moveToBody(deleteModal);

    const modalController = createModalController({
        modal,
        panel: get("repositoryModalPanel"),
        backdrop: get("repositoryModalBackdrop"),
    });
    const deleteController = createSimpleModal(deleteModal);

    const form = createRepositoryForm(
        {
            modalTitle: get("repositoryModalTitle"),
            modalSubtitle: get("repositoryModalSubtitle"),
            modalJudul: get("repositoryModalJudul"),
            modalJenis: get("repositoryModalJenis"),
            modalNim: get("repositoryModalNim"),
            modalNama: get("repositoryModalNama"),
            modalIdPengajuan: get("repositoryModalIdPengajuan"),
            sourceLink: get("repositorySourceLink"),
            form: get("repositoryForm"),
            formMethod: get("repositoryFormMethod"),
            idPengajuanInput: get("repositoryIdPengajuan"),
            jenisThesis: get("repositoryJenisThesis"),
            jenisDissertation: get("repositoryJenisDissertation"),
            jenisError: get("repositoryJenisError"),
            repositoryUrl: get("repositoryUrl"),
            repositoryTypeFile: get("repositoryTypeFile"),
            repositoryTypeFolder: get("repositoryTypeFolder"),
            saveButton: get("repositorySaveBtn"),
            saveText: get("repositorySaveText"),
            deleteButton: get("repositoryDeleteBtn"),
            activateButton: get("repositoryActivateBtn"),
            statusInfo: get("repositoryStatusInfo"),
            statusIcon: get("repositoryStatusIcon"),
            statusTitle: get("repositoryStatusTitle"),
            statusDescription: get("repositoryStatusDescription"),
            deleteConfirmButton: get("repositoryDeleteConfirmBtn"),
        },
        modalController,
        deleteController,
    );

    get("repositoryModalClose")?.addEventListener("click", () => modalController.close(form.resetForm));
    get("repositoryCancelBtn")?.addEventListener("click", () => modalController.close(form.resetForm));
    get("repositoryModalBackdrop")?.addEventListener("click", () => modalController.close(form.resetForm));
    get("repositoryDeleteCancelBtn")?.addEventListener("click", deleteController.close);
    get("repositoryDeleteBackdrop")?.addEventListener("click", deleteController.close);

    document.addEventListener("click", (event) => {
        const addButton = event.target.closest(".repository-add-btn");
        if (addButton) {
            event.preventDefault();
            form.openCreate(addButton);
            return;
        }

        const editButton = event.target.closest(".repository-edit-btn");
        if (editButton) {
            event.preventDefault();
            form.openEdit(editButton);
        }
    });

    document.addEventListener("keydown", (event) => {
        if (event.key !== "Escape") return;
        if (!deleteModal.classList.contains("hidden")) {
            deleteController.close();
        } else if (!modal.classList.contains("hidden")) {
            modalController.close(form.resetForm);
        }
    });

    initRepositoryTable();
});
