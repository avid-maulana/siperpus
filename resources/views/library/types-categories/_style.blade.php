<style>
    /* =========================================================
       EDIT ANIMATION
    ========================================================== */

    .edit-content {
        transition:
            opacity 220ms ease,
            transform 220ms ease,
            max-height 220ms ease;
    }

    .edit-hidden {
        opacity: 0;
        transform: translateY(-6px);
        pointer-events: none;
        max-height: 0;
        overflow: hidden;
    }

    .edit-visible {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
        max-height: 100px;
    }


    /* =========================================================
       ROW TRANSITION
    ========================================================== */

    .literature-row {
        transition:
            background-color 200ms ease,
            box-shadow 200ms ease;
    }

    .literature-row:hover {
        background-color: rgba(248, 250, 252, 0.8);
    }

    .literature-row.editing {
        background-color: rgba(239, 246, 255, 0.35);
    }


    /* =========================================================
       BUTTON ANIMATION
    ========================================================== */

    .action-button {
        transition:
            color 180ms ease,
            background-color 180ms ease,
            border-color 180ms ease,
            transform 180ms ease,
            opacity 180ms ease;
    }

    .action-button:hover {
        transform: translateY(-1px);
    }

    .action-button:active {
        transform: translateY(0) scale(0.97);
    }


    /* =========================================================
       INPUT ANIMATION
    ========================================================== */

    .edit-input {
        transition:
            border-color 180ms ease,
            box-shadow 180ms ease,
            background-color 180ms ease;
    }

    .edit-input:focus {
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.10);
    }


    /* =========================================================
       SAVE BUTTON
    ========================================================== */

    /* =========================================================
   SAVE BUTTON
========================================================== */

    .save-button {
        transition:
            color 180ms ease,
            background-color 180ms ease,
            border-color 180ms ease,
            transform 180ms ease,
            box-shadow 180ms ease;
    }

    .save-button:hover {
        color: white;
        background-color: rgb(16 185 129);
        border-color: rgb(16 185 129);
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(16, 185, 129, 0.18);
    }

    .save-button:active {
        transform: translateY(0) scale(0.97);
    }


    /* =========================================================
   CANCEL BUTTON
========================================================== */

    .cancel-button {
        transition:
            color 180ms ease,
            background-color 180ms ease,
            border-color 180ms ease,
            transform 180ms ease,
            box-shadow 180ms ease;
    }

    .cancel-button:hover {
        color: white;
        background-color: rgb(100 116 139);
        border-color: rgb(100 116 139);
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(100, 116, 139, 0.18);
    }

    .cancel-button:active {
        transform: translateY(0) scale(0.97);
    }


    /* =========================================================
       CANCEL BUTTON
    ========================================================== */

    .cancel-button {
        transition:
            transform 180ms ease,
            background-color 180ms ease,
            color 180ms ease;
    }

    .cancel-button:hover {
        transform: translateY(-1px);
    }


    /* =========================================================
       TABLE
    ========================================================== */

    .literature-table {
        table-layout: fixed;
        width: 100%;
    }

    .literature-table .col-name {
        width: 34%;
    }

    .literature-table .col-type {
        width: 34%;
    }

    .literature-table .col-action {
        width: 32%;
    }


    /* =========================================================
       RESPONSIVE TABLE
    ========================================================== */

    @media (max-width: 768px) {

        .literature-table {
            min-width: 760px;
        }

        .literature-table .col-name {
            width: 32%;
        }

        .literature-table .col-type {
            width: 32%;
        }

        .literature-table .col-action {
            width: 36%;
        }
    }
</style>