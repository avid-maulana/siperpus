@php
$angka1 = rand(1, 20);
$angka2 = rand(1, 30);

$ops = ['+', '-'];
$op = $ops[array_rand($ops)];

$hasil = $op === '+'
? $angka1 + $angka2
: $angka1 - $angka2;

session(['captcha_hasil' => $hasil]);

$expr = "$angka1 $op $angka2";
@endphp

<div class="captcha-box">

    <div class="flex items-center captcha-row">

        <div class="captcha-card">
            <canvas
                id="captchaCanvas"
                width="220"
                height="72"
                class="captcha-canvas"></canvas>
        </div>

        <button
            type="button"
            id="captchaRefresh"
            class="captcha-refresh"
            aria-label="Refresh Captcha">
            <span class="icon">↻</span>
        </button>

    </div>

    <div class="relative mt-4 captcha-field">

        <input
            id="captcha"
            name="captcha"
            type="text"
            required
            inputmode="text"
            autocomplete="off"
            placeholder=" "
            class="w-full captcha-input">

        <label
            for="captcha"
            class="captcha-label">
            Masukkan Jawaban
        </label>

        <input
            id="captchaExpected"
            type="hidden"
            value="{{ session('captcha_hasil') }}"
            data-expr="{{ $expr }}">

    </div>

</div>