<style>
    .captcha-box {
        border-radius: 12px;
        padding: 6px;
    }

    .captcha-row {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    /* FIX: card ini sebelumnya punya min-width:200px yang di-override jadi
       min-width:0 oleh definisi kedua di bawahnya. Di dalam flex row,
       min-width:0 membuat elemen boleh menyusut lebih kecil dari kontennya
       sendiri -- sementara <canvas> di dalamnya tetap 130x46px tetap, jadi
       gambar captcha ke-clip/kepotong saat card menyempit (misal di layar
       kecil). flex-shrink:0 + width eksplisit mencegah itu. */
    .captcha-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        padding: 8px 10px;
        box-shadow: 0 10px 24px rgba(17, 24, 39, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: fit-content;
    }

    .captcha-canvas {
        border-radius: 8px;
        background: transparent;
        display: block;
        width: 130px;
        height: 46px;
    }

    .captcha-refresh {
        width: 46px;
        height: 46px;
        min-width: 46px;
        flex-shrink: 0;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #2563EB;
        border: none;
        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.2);
        cursor: pointer;
        transition: transform .18s ease, filter .18s ease, background-color .18s ease;
    }

    .captcha-refresh:hover {
        background: #1D4ED8;
        transform: translateY(-2px) scale(1.02);
        filter: brightness(1.06);
    }

    .captcha-refresh .icon {
        color: #ffffff;
        font-size: 18px;
        line-height: 1;
    }

    .captcha-field {
        flex: 1;
        min-width: 0;
    }

    .btn-primary {
        width: 100%;
        height: 50px;
        border-radius: 14px;

        background: #F1F4F8;
        color: #46566D;

        border: none;
        box-shadow: none;

        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;

        font-weight: 600;

        transition:
            background-color 0.3s ease,
            color 0.3s ease,
            box-shadow 0.3s ease,
            transform 0.2s ease;
    }


    /* =========================
   BUTTON BELUM AKTIF
========================= */

    .btn-primary:disabled {
        background: #F1F4F8;
        color: #94A3B8;

        cursor: not-allowed;
        box-shadow: none;
    }


    /* Hilangkan hover ketika disabled */
    .btn-primary:disabled:hover {
        background: #F1F4F8;
        color: #94A3B8;

        box-shadow: none;
        transform: none;
    }


    /* =========================
   BUTTON SUDAH AKTIF
========================= */

    .btn-primary:not(:disabled) {
        background: #2563EB;
        color: #ffffff;

        cursor: pointer;

        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.20);
    }


    /* Hover hanya ketika aktif */
    .btn-primary:not(:disabled):hover {
        background: #1D4ED8;

        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.30);
    }


    /* Loading */
    .btn-primary.btn-loading {
        background: #1D4ED8;
        color: #ffffff;

        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.25);
    }

    .btn-press {
        transform: scale(0.98) !important;
    }

    .signin-helper {
        margin-top: 12px;
        text-align: center;
        color: #94a3b8;
        font-size: 0.875rem;
    }

    .signin-link {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
        margin-left: 6px;
    }

    .signin-link:hover {
        text-decoration: underline;
    }

    footer.login-footer {
        margin-top: 18px;
        text-align: center;
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .validation-tooltip {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        margin-top: 10px;
        text-align: center;
        color: #dc2626;
        font-size: 0.8rem;
    }

    .validation-tooltip.hidden {
        display: none;
    }

    .validation-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #dc2626;
        color: #fff;
        font-size: 0.65rem;
        font-weight: bold;
        flex-shrink: 0;
    }
</style>