document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('captchaCanvas');
    const refresh = document.getElementById('captchaRefresh');
    const expected = document.getElementById('captchaExpected');
    const input = document.getElementById('captcha');
    const validationBox = document.getElementById('captchaValidation');
    const validationText = document.getElementById('captchaValidationText');

    if (!canvas || !refresh || !expected || !input) {
        return;
    }

    const ctx = canvas.getContext('2d');

    if (!ctx) {
        return;
    }

    const rand = (min, max) => {
        return Math.floor(
            Math.random() * (max - min + 1)
        ) + min;
    };

    const clearCanvas = () => {
        ctx.clearRect(
            0,
            0,
            canvas.width,
            canvas.height
        );
    };

    const drawNoise = () => {
        for (let i = 0; i < 4; i++) {
            ctx.beginPath();

            ctx.strokeStyle = `rgba(
                17,
                24,
                39,
                ${(Math.random() * 0.06 + 0.02).toFixed(3)}
            )`;

            ctx.lineWidth = rand(1, 2);

            ctx.moveTo(
                rand(0, canvas.width),
                rand(0, canvas.height)
            );

            ctx.lineTo(
                rand(0, canvas.width),
                rand(0, canvas.height)
            );

            ctx.stroke();
        }

        for (let i = 0; i < 24; i++) {
            ctx.fillStyle = `rgba(
                17,
                24,
                39,
                ${(Math.random() * 0.06 + 0.02).toFixed(3)}
            )`;

            ctx.beginPath();

            ctx.arc(
                rand(0, canvas.width),
                rand(0, canvas.height),
                Math.random() * 1.2,
                0,
                Math.PI * 2
            );

            ctx.fill();
        }
    };

    const drawText = (expression) => {
        const fontSize = 24;
        const text = `${expression} = ?`;

        // Jarak aman dari tepi kiri/kanan canvas supaya karakter
        // (termasuk saat dirotasi) tidak pernah menyentuh batas.
        const padding = 12;
        const availableWidth = canvas.width - padding * 2;

        // Spacing antar karakter menyesuaikan lebar yang tersedia,
        // bukan nilai tetap -- ini kunci fix-nya. Sebelumnya spacing
        // tetap (fontSize * 0.55) membuat total lebar teks nyaris
        // sama/lebih besar dari canvas, jadi karakter pertama & terakhir
        // selalu mepet/keluar tepi.
        const spacing = Math.min(
            fontSize * 0.6,
            availableWidth / (text.length - 1)
        );

        const totalWidth = spacing * (text.length - 1);
        const startX = (canvas.width - totalWidth) / 2;
        const centerY = canvas.height / 2;

        ctx.save();

        ctx.textBaseline = 'middle';
        ctx.textAlign = 'center';

        for (let i = 0; i < text.length; i++) {
            const character = text[i];

            const baseX = startX + i * spacing;

            // Clamp: posisi akhir (termasuk jitter) tidak pernah
            // boleh melewati area padding, apa pun yang terjadi.
            const x = Math.min(
                canvas.width - padding,
                Math.max(padding, baseX + rand(-2, 2))
            );

            const y = centerY + rand(-3, 3);

            ctx.save();

            ctx.translate(x, y);

            ctx.rotate(
                (rand(-6, 6) * Math.PI) / 180
            );

            ctx.font =
                `600 ${fontSize + rand(-1, 1)}px ` +
                'Inter, Arial, sans-serif';

            ctx.fillStyle = '#111827';

            ctx.fillText(
                character,
                0,
                0
            );

            ctx.restore();
        }

        ctx.restore();
    };

    const renderCaptcha = (expression) => {
        clearCanvas();
        drawNoise();
        drawText(expression);
    };

    const showValidation = (message) => {
        validationText.textContent = message;
        validationBox.classList.remove('hidden');
    };

    const hideValidation = () => {
        validationBox.classList.add('hidden');
    };

    /**
     * Render CAPTCHA pertama yang dibuat Laravel.
     */
    const initialExpression = expected.dataset.expr;

    if (initialExpression) {
        renderCaptcha(initialExpression);
    }

    /**
     * Validasi input: hanya boleh angka.
     */
    input.addEventListener('input', () => {
        if (input.value !== '' && !/^\d*$/.test(input.value)) {
            input.value = input.value.replace(/\D/g, '');
            showValidation('Hanya angka yang diperbolehkan');
        } else {
            hideValidation();
        }
    });

    /**
     * Refresh CAPTCHA — fetch ulang halaman supaya session
     * di server ikut ter-update, lalu render ulang canvas
     * dari data-expr yang baru.
     */
    refresh.addEventListener('click', () => {
        fetch(window.location.href, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then((res) => res.text())
        .then((html) => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newExpected = doc.getElementById('captchaExpected');

            if (!newExpected) {
                return;
            }

            const newExpression = newExpected.dataset.expr;

            expected.dataset.expr = newExpression;

            renderCaptcha(newExpression);

            input.value = '';
            hideValidation();
            input.focus();

            if (typeof refresh.animate === 'function') {
                refresh.animate(
                    [
                        { transform: 'scale(0.96)' },
                        { transform: 'scale(1)' },
                    ],
                    {
                        duration: 220,
                        easing: 'ease-out',
                    }
                );
            }
        })
        .catch(() => {
            showValidation('Gagal memuat captcha baru, coba lagi');
        });
    });
});