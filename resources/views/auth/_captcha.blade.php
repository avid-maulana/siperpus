@php
// hasil selalu >= 0 supaya cocok dengan input numeric-only
$angka1 = rand(1, 9);
$angka2 = rand(1, 9);

if ($angka1 < $angka2) {
    [$angka1, $angka2]=[$angka2, $angka1];
    }

    $ops=['+', '-' ];
    $op=$ops[array_rand($ops)];

    $hasil=$op==='+'
    ? $angka1 + $angka2
    : $angka1 - $angka2;

    session(['captcha_hasil'=> $hasil]);

    $expr = "$angka1 $op $angka2";
    @endphp

    <div class="captcha-box">

        <div class="captcha-row">

            <div class="captcha-card">
                <canvas id="captchaCanvas" width="130" height="46" class="captcha-canvas"></canvas>
            </div>

            <button type="button" id="captchaRefresh" class="captcha-refresh" aria-label="Refresh Captcha">
                <span class="icon">↻</span>
            </button>

            <div class="relative captcha-field">

                <input id="captcha" name="captcha" type="text" required inputmode="numeric" pattern="[0-9]*"
                    autocomplete="off" placeholder=" " class="w-full captcha-input">

                <label
                    for="captcha"
                    class="mb-2 block text-sm font-medium text-slate-700">
                    Jawaban
                </label>

            </div>

        </div>

        <div id="captchaValidation" class="validation-tooltip hidden" role="alert" aria-live="polite">
            <span class="validation-icon">!</span>
            <span id="captchaValidationText">Hanya angka yang diperbolehkan</span>
        </div>

        <input id="captchaExpected" type="hidden" data-expr="{{ $expr }}">

    </div>