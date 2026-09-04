{{-- =========================================================
    SEARCH SKRIPSI
    ---------------------------------------------------------
    Filter utama: KBK (menggantikan sort).
    Optional variables:
      $kbks         -> collection KBK (id, nama_kbk)
      $totalResults -> int, total hasil yang cocok
========================================================= --}}

<style>
    input[type="search"]::-webkit-search-decoration,
    input[type="search"]::-webkit-search-cancel-button,
    input[type="search"]::-webkit-search-results-button,
    input[type="search"]::-webkit-search-results-decoration {
        -webkit-appearance: none;
        appearance: none;
    }

    input[type="search"]::-ms-clear,
    input[type="search"]::-ms-reveal {
        display: none;
        width: 0;
        height: 0;
    }

    #skripsiSubmit .sk-spinner { display: none; }
    #skripsiSubmit.is-loading .sk-label { display: none; }
    #skripsiSubmit.is-loading .sk-spinner { display: inline-flex; }
</style>

@php
    $activeSearch = request('search');
    $activeKbk    = request('kbk');

    $hasActive = filled($activeSearch) || filled($activeKbk);
@endphp

<div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

    <form
        id="skripsiSearchForm"
        action="{{ route('skripsi.index') }}"
        method="GET"
        class="w-full"
    >

        <div
            class="grid grid-cols-1 gap-3
                   @if(isset($kbks) && $kbks->count())
                   lg:grid-cols-[190px_minmax(0,1fr)_54px]
                   @else
                   lg:grid-cols-[minmax(0,1fr)_54px]
                   @endif
                   lg:items-end"
        >

            {{-- =================================================
                KBK (Filter Utama)
            ================================================== --}}

            @if (isset($kbks) && $kbks->count())
            <div>
                <label
                    for="skripsiKbkSelect"
                    class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500"
                >
                    KBK
                </label>

                <div class="relative">
                    <select
                        id="skripsiKbkSelect"
                        name="kbk"
                        class="h-[52px] w-full appearance-none rounded-xl border border-slate-300 bg-white
                               pl-4 pr-10 text-sm text-slate-700 shadow-sm outline-none
                               transition-all duration-200
                               focus:border-[#212A37] focus:ring-4 focus:ring-slate-100"
                    >
                        <option value="">Semua KBK</option>
                        @foreach ($kbks as $kbk)
                            <option value="{{ $kbk->id }}" {{ (string) $activeKbk === (string) $kbk->id ? 'selected' : '' }}>
                                {{ $kbk->nama_kbk }}
                            </option>
                        @endforeach
                    </select>

                    <span
                        class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2
                               -translate-y-1/2 text-[20px] text-slate-400"
                    >
                        keyboard_arrow_down
                    </span>
                </div>
            </div>
            @endif


            {{-- =================================================
                SEARCH
            ================================================== --}}

            <div>
                <label
                    for="skripsiSearchInput"
                    class="mb-1.5 block text-xs font-semibold uppercase tracking-wider text-slate-500"
                >
                    Pencarian
                </label>

                <div class="group relative">
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4"
                    >
                        <span
                            class="material-symbols-outlined text-[21px] text-slate-400
                                   transition-colors group-focus-within:text-[#212A37]"
                        >
                            search
                        </span>
                    </div>

                    <input
                        id="skripsiSearchInput"
                        type="search"
                        name="search"
                        value="{{ $activeSearch }}"
                        autocomplete="off"
                        spellcheck="false"
                        aria-label="Cari judul skripsi, NIM, atau nama mahasiswa"
                        placeholder="Cari judul, nama mahasiswa, atau NIM..."
                        class="h-[52px] w-full rounded-xl border border-slate-300 bg-white
                               pl-12 pr-28 text-sm text-slate-700 shadow-sm outline-none
                               transition-all duration-200 placeholder:text-slate-400
                               focus:border-[#212A37] focus:ring-4 focus:ring-slate-100"
                    >

                    <button
                        id="skripsiInlineClear"
                        type="button"
                        title="Hapus pencarian"
                        class="{{ filled($activeSearch) ? '' : 'hidden' }}
                               absolute right-[102px] top-1/2 -translate-y-1/2 rounded-full p-1
                               text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    >
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>

                    <button
                        id="skripsiSubmit"
                        type="submit"
                        class="absolute right-1.5 top-1/2 flex h-10 w-[72px] -translate-y-1/2
                               items-center justify-center rounded-lg bg-[#212A37] px-5
                               text-sm font-semibold text-white transition-all duration-200
                               hover:bg-[#18202b] active:scale-[0.98]
                               disabled:cursor-not-allowed disabled:opacity-70"
                    >
                        <span class="sk-label">Cari</span>
                        <span class="sk-spinner items-center justify-center">
                            <span class="h-4 w-4 animate-spin rounded-full border-2 border-white/30 border-t-white"></span>
                        </span>
                    </button>
                </div>
            </div>


            {{-- =================================================
                RESET
            ================================================== --}}

            <div>
                <span
                    class="mb-1.5 block text-center text-xs font-semibold uppercase tracking-wider text-slate-500"
                >
                    Reset
                </span>

                <button
                    type="button"
                    id="skripsiResetFilter"
                    title="Reset Filter"
                    class="relative flex h-[52px] w-[54px] items-center justify-center
                           rounded-xl border border-slate-300 bg-white text-slate-600
                           shadow-sm transition-all duration-200
                           hover:border-[#212A37] hover:bg-[#212A37] hover:text-white
                           active:scale-[0.98]"
                >
                    <span class="material-symbols-outlined text-[22px]">restart_alt</span>

                    @if ($hasActive)
                        <span
                            class="absolute -right-1 -top-1 h-3 w-3 rounded-full
                                   border-2 border-white bg-[#212A37]"
                        ></span>
                    @endif
                </button>
            </div>

        </div>


        {{-- ======================================================== --}}
        {{-- CHIP FILTER AKTIF --}}
        {{-- ======================================================== --}}

        @if ($hasActive)
            <div class="mt-3 flex flex-wrap items-center gap-2">

                @if (filled($activeSearch))
                    <a
                        href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                        class="inline-flex items-center gap-1.5 rounded-full bg-slate-100
                               py-1.5 pl-3 pr-2 text-xs font-medium text-slate-600 hover:bg-slate-200"
                    >
                        "{{ $activeSearch }}"
                        <span class="material-symbols-outlined text-[15px]">close</span>
                    </a>
                @endif

                @if (filled($activeKbk))
                    <a
                        href="{{ request()->fullUrlWithQuery(['kbk' => null]) }}"
                        class="inline-flex items-center gap-1.5 rounded-full bg-slate-100
                               py-1.5 pl-3 pr-2 text-xs font-medium text-slate-600 hover:bg-slate-200"
                    >
                        KBK: {{ optional(($kbks ?? collect())->firstWhere('id', $activeKbk))->nama_kbk ?? $activeKbk }}
                        <span class="material-symbols-outlined text-[15px]">close</span>
                    </a>
                @endif

            </div>
        @endif


        {{-- ======================================================== --}}
        {{-- DESKRIPSI / JUMLAH HASIL --}}
        {{-- ======================================================== --}}

        <div class="mt-3 flex items-center justify-between gap-2">
            <p class="text-xs leading-5 text-slate-500">
                Cari data skripsi berdasarkan judul, NIM, nama mahasiswa, maupun Kelompok Bidang Keahlian (KBK). Tekan
                <kbd class="rounded border border-slate-300 bg-slate-50 px-1 py-0.5 text-[10px]">/</kbd>
                untuk fokus ke pencarian.
            </p>

            @isset($totalResults)
                <span class="shrink-0 text-xs font-medium text-slate-400">
                    {{ number_format($totalResults) }} hasil
                </span>
            @endisset
        </div>

    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const form         = document.getElementById('skripsiSearchForm');
    const searchInput  = document.getElementById('skripsiSearchInput');
    const clearButton  = document.getElementById('skripsiInlineClear');
    const resetButton  = document.getElementById('skripsiResetFilter');
    const submitButton = document.getElementById('skripsiSubmit');
    const kbkSelect    = document.getElementById('skripsiKbkSelect');

    if (!form || !searchInput) return;

    const updateClearButton = () => {
        if (searchInput.value.trim() !== '') {
            clearButton?.classList.remove('hidden');
        } else {
            clearButton?.classList.add('hidden');
        }
    };

    const setLoading = () => {
        submitButton?.classList.add('is-loading');
        submitButton?.setAttribute('disabled', 'disabled');
    };

    searchInput.addEventListener('input', updateClearButton);

    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            searchInput.value = '';
            updateClearButton();
            searchInput.focus();
        }
    });

    clearButton?.addEventListener('click', () => {
        searchInput.value = '';
        updateClearButton();
        searchInput.focus();
    });

    resetButton?.addEventListener('click', () => {
        window.location.href = @json(route('skripsi.index'));
    });

    // KBK langsung submit saat dipilih
    kbkSelect?.addEventListener('change', () => {
        setLoading();
        form.submit();
    });

    form.addEventListener('submit', setLoading);

    document.addEventListener('keydown', (e) => {
        if (e.key === '/' && document.activeElement !== searchInput) {
            const tag = document.activeElement?.tagName || '';
            if (tag !== 'INPUT' && tag !== 'TEXTAREA' && tag !== 'SELECT') {
                e.preventDefault();
                searchInput.focus();
            }
        }
    });

    updateClearButton();

});
</script>