<style>
    html,
    body {
        height: 100%;
        overflow: hidden;
    }

    #pdf-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
        width: 100%;
        min-height: 100%;
        padding: 24px 16px 96px;
    }

    .pdf-page {
        display: block;
        max-width: 100%;
        height: auto;
        background: white;
        box-shadow: 0 3px 14px rgba(15, 23, 42, 0.14);
    }

    #pdf-container::-webkit-scrollbar {
        width: 8px;
    }

    #pdf-container::-webkit-scrollbar-track {
        background: transparent;
    }

    #pdf-container::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }
</style>