<style>
    .captcha-box {
        border-radius: 12px;
        padding: 6px;
    }

    .captcha-card {
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 12px;
        padding: 10px 12px;
        box-shadow: 0 10px 24px rgba(17, 24, 39, 0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 200px;
    }

    .captcha-canvas {
        border-radius: 8px;
        background: transparent;
        display: block;
    }

    .captcha-refresh {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #111827;
        border: none;
        box-shadow: 0 10px 24px rgba(17, 24, 39, 0.12);
        cursor: pointer;
        transition: transform .18s ease, filter .18s ease;
    }

    .captcha-refresh:hover {
        transform: translateY(-2px) scale(1.02);
        filter: brightness(1.06);
    }

    .captcha-refresh .icon {
        color: #ffffff;
        font-size: 18px;
        line-height: 1;
    }

    .captcha-input {
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid #D1D5DB;
        padding: 16px 16px 12px;
        outline: none;
        color: #111827;
        box-shadow: none;
        font-family: Inter, Poppins, sans-serif;
        font-size: 1rem;
        transition:
            border-color 0.3s ease,
            box-shadow 0.3s ease,
            background-color 0.3s ease;
    }

    .captcha-input::placeholder {
        color: #94a3b8;
        font-size: 1rem;
        opacity: 1;
    }

    .captcha-input:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        background: #ffffff;
    }

    .captcha-input+label {
        pointer-events: none;
        position: absolute;
        left: 18px;
        top: 16px;
        color: #64748b;
        font-size: 1rem;
        transition: all 0.2s ease;
        background: white;
        padding: 0 6px;
    }

    .captcha-input:focus+label,
    .captcha-input:not(:placeholder-shown)+label {
        top: 5px;
        left: 16px;
        font-size: 0.75rem;
        color: #2563EB;
    }

    .captcha-row {
        gap: 12px;
        align-items: center;
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
        cursor: pointer;

        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn-primary:hover {
        background: #212A37;
        color: #ffffff;
    }

    .btn-press {
        transform: scale(0.98) !important;
        box-shadow: 0 6px 18px rgba(33, 42, 55, 0.08) !important;
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
</style>