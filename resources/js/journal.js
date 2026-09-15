document.addEventListener('DOMContentLoaded', () => {
    const overlay   = document.getElementById('journalModalOverlay');
    const box       = document.getElementById('journalModalBox');
    const closeBtn  = document.getElementById('journalModalClose');
    const logo      = document.getElementById('journalModalLogo');
    const title     = document.getElementById('journalModalTitle');
    const openLink  = document.getElementById('journalModalOpenLink');
    const copyBtn   = document.getElementById('journalModalCopyLink');
    const copyLabel = document.getElementById('journalModalCopyLabel');

    if (!overlay) return;

    const openModal = ({ name, logo: logoUrl, url }) => {
        logo.src = logoUrl;
        logo.alt = name;
        title.textContent = name;
        openLink.href = url;
        copyBtn.dataset.url = url;

        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        requestAnimationFrame(() => {
            overlay.classList.remove('opacity-0');
            overlay.classList.add('opacity-100');
            box.classList.remove('translate-y-2');
        });
    };

    const closeModal = () => {
        overlay.classList.add('opacity-0');
        box.classList.add('translate-y-2');
        setTimeout(() => {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }, 300);
    };

    document.querySelectorAll('.journal-item').forEach((item) => {
        item.addEventListener('click', () => {
            openModal({
                name: item.dataset.name,
                logo: item.dataset.logo,
                url: item.dataset.url,
            });
        });
    });

    closeBtn?.addEventListener('click', closeModal);

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
            closeModal();
        }
    });

    copyBtn?.addEventListener('click', async () => {
        const url = copyBtn.dataset.url;
        if (!url) return;

        try {
            await navigator.clipboard.writeText(url);
        } catch {
            const temp = document.createElement('input');
            temp.value = url;
            document.body.appendChild(temp);
            temp.select();
            document.execCommand('copy');
            document.body.removeChild(temp);
        }

        const original = copyLabel.textContent;
        copyLabel.textContent = 'Tersalin!';
        setTimeout(() => (copyLabel.textContent = original), 1500);
    });
});