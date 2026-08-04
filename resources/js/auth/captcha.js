document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('captchaCanvas');
    const refresh = document.getElementById('captchaRefresh');
    const expected = document.getElementById('captchaExpected');
    const input = document.getElementById('captcha');

    if (!canvas || !refresh || !expected || !input) {
        return;
    }

    const ctx = canvas.getContext('2d');

    if (!ctx) {
        return;
    }

    /**
     * Membuat angka random.
     */
    const rand = (min, max) => {
        return Math.floor(
            Math.random() * (max - min + 1)
        ) + min;
    };

    /**
     * Membersihkan canvas.
     */
    const clearCanvas = () => {
        ctx.clearRect(
            0,
            0,
            canvas.width,
            canvas.height
        );
    };

    /**
     * Membuat noise CAPTCHA.
     */
    const drawNoise = () => {
        // Garis acak
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

        // Titik acak
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

    /**
     * Menggambar teks CAPTCHA.
     */
    const drawText = (expression) => {
        const fontSize = 30;
        const text = `${expression} = ?`;

        const centerX = canvas.width / 2;
        const centerY = canvas.height / 2;

        ctx.save();

        ctx.textBaseline = 'middle';
        ctx.textAlign = 'center';

        for (let i = 0; i < text.length; i++) {
            const character = text[i];

            const offset =
                (i - text.length / 2) *
                (fontSize * 0.55);

            const x =
                centerX +
                offset +
                rand(-4, 4);

            const y =
                centerY +
                rand(-3, 3);

            ctx.save();

            ctx.translate(x, y);

            ctx.rotate(
                (rand(-8, 8) * Math.PI) / 180
            );

            ctx.font =
                `600 ${fontSize + rand(-2, 2)}px ` +
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

    /**
     * Render CAPTCHA ke canvas.
     */
    const renderCaptcha = (expression) => {
        clearCanvas();
        drawNoise();
        drawText(expression);
    };

    /**
     * Menghitung hasil expression.
     */
    const computeAnswer = (expression) => {
        const match = expression.match(
            /(-?\d+)\s*([+\-xX*])\s*(-?\d+)/
        );

        if (!match) {
            return null;
        }

        const firstNumber = parseInt(match[1], 10);
        const operator = match[2];
        const secondNumber = parseInt(match[3], 10);

        switch (operator) {
            case '+':
                return firstNumber + secondNumber;

            case '-':
                return firstNumber - secondNumber;

            case '*':
            case 'x':
            case 'X':
                return firstNumber * secondNumber;

            default:
                return null;
        }
    };

    /**
     * Render CAPTCHA pertama yang dibuat Laravel.
     */
    const initialExpression =
        expected.dataset.expr;

    if (initialExpression) {
        renderCaptcha(initialExpression);
    }

    /**
     * Refresh CAPTCHA.
     */
    refresh.addEventListener('click', () => {
        const firstNumber = rand(1, 20);
        const secondNumber = rand(1, 30);

        const operators = ['+', '-'];

        const operator =
            operators[
                rand(0, operators.length - 1)
            ];

        const expression =
            `${firstNumber} ${operator} ${secondNumber}`;

        const answer =
            computeAnswer(expression);

        expected.value = answer ?? '';

        expected.dataset.expr =
            expression;

        renderCaptcha(expression);

        input.value = '';
        input.focus();

        /**
         * Animasi tombol refresh.
         */
        if (typeof refresh.animate === 'function') {
            refresh.animate(
                [
                    {
                        transform: 'scale(0.96)',
                    },
                    {
                        transform: 'scale(1)',
                    },
                ],
                {
                    duration: 220,
                    easing: 'ease-out',
                }
            );
        }
    });
});