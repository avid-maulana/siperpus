{{-- =========================================================
    SEARCH TESIS
    ---------------------------------------------------------
    Desain disamakan dengan search disertasi & praktik industri.
    Optional variables (component tetap jalan normal jika tidak
    dikirim dari controller):
      $tahunOptions  -> collection/array tahun yang tersedia
      $statusOptions -> collection/array ['value' => 'Label']
      $totalResults  -> int, total hasil yang cocok
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

    #thesisSubmit .ts-spinner { display: none; }
    #thesisSubmit.is-loading .ts-label { display: none; }
    #thesisSubmit.is-loading .ts-spinner { display: inline-flex; }
</style>

@php
    $activeSearch = request('search');
    $activeTahun  = request('tahun');
    $activeStatus = request('status');
    $activeSort   = request('sort', 'terbaru');

    $sortLabels = [
        'terbaru'  => 'Terbaru',
        'terlama'  => 'Terlama',
        'judul_az' => 'Judul A-Z',
        'judul_za' => 'Judul Z-A',
    ];

    $hasAdvanced = filled($activeTahun) || filled($activeStatus);
    $hasActive   = filled($activeSearch) || $hasAdvanced || $activeSort !== 'terbaru';
@endphp

<div
    class="rounded-2xl
           border border-slate-200
           bg-white
           p-5
           shadow-sm"
>

    <form
        id="thesisSearchForm"
        action="{{ route('tesis.index') }}"
        method="GET"
        class="w-full"
    >

        <div
            class="grid grid-cols-1 gap-3
                   lg:grid-cols-[190px_minmax(0,1fr)_54px]
                   lg:items-end"
        >

            {{-- =================================================
                URUTKAN
            ================================================== --}}

            <div>

                <label
                    for="thesisSortSelect"
                    class="mb-1.5 block
                           text-xs
                           font-semibold
                           uppercase
                           tracking-wider
                           text-slate-500"
                >
                    Urutkan
                </label>

                <div class="relative">

                    <select
                        id="thesisSortSelect"
                        name="sort"
                        class="h-[52px]
                               w-full
                               appearance-none
                               rounded-xl
                               border border-slate-300
                               bg-white
                               pl-4
                               pr-10
                               text-sm
                               text-slate-700
                               shadow-sm
                               outline-none
                               transition-all
                               duration-200
                               focus:border-[#212A37]
                               focus:ring-4
                               focus:ring-slate-100"
                    >
                        @foreach ($sortLabels as $value => $label)
                            <option value="{{ $value }}" {{ $activeSort === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <span
                        class="material-symbols-outlined
                               pointer-events-none
                               absolute
                               right-3
                               top-1/2
                               -translate-y-1/2
                               text-[20px]
                               text-slate-400"
                    >
                        keyboard_arrow_down
                    </span>

                </div>

            </div>


            {{-- =================================================
                SEARCH
            ================================================== --}}

            <div>

                <label
                    for="thesisSearchInput"
                    class="mb-1.5 block
                           text-xs
                           font-semibold
                           uppercase
                           tracking-wider
                           text-slate-500"
                >
                    Pencarian
                </label>

                <div class="group relative">

                    <div
                        class="pointer-events-none
                               absolute
                               inset-y-0
                               left-0
                               flex
                               items-center
                               pl-4"
                    >
                        <span
                            class="material-symbols-outlined
                                   text-[21px]
                                   text-slate-400
                                   transition-colors
                                   group-focus-within:text-[#212A37]"
                        >
                            search
                        </span>
                    </div>

                    <input
                        id="thesisSearchInput"
                        type="search"
                        name="search"
                        value="{{ $activeSearch }}"
                        autocomplete="off"
                        spellcheck="false"
                        aria-label="Cari judul tesis, NIM, atau nama mahasiswa"
                        placeholder="Cari judul tesis, NIM, atau nama mahasiswa..."
                        class="h-[52px]
                               w-full
                               rounded-xl
                               border border-slate-300
                               bg-white
                               pl-12
                               pr-28
                               text-sm
                               text-slate-700
                               shadow-sm
                               outline-none
                               transition-all
                               duration-200
                               placeholder:text-slate-400
                               focus:border-[#212A37]
                               focus:ring-4
                               focus:ring-slate-100"
                    >

                    <button
                        id="thesisInlineClear"
                        type="button"
                        title="Hapus pencarian"
                        class="{{ filled($activeSearch) ? '' : 'hidden' }}
                               absolute
                               right-[102px]
                               top-1/2
                               -translate-y-1/2
                               rounded-full
                               p-1
                               text-slate-400
                               transition
                               hover:bg-slate-100
                               hover:text-slate-700"
                    >
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>

                    <button
                        id="thesisSubmit"
                        type="submit"
                        class="absolute
                               right-1.5
                               top-1/2
                               flex
                               h-10
                               w-[72px]
                               -translate-y-1/2
                               items-center
                               justify-center
                               rounded-lg
                               bg-[#212A37]
                               px-5
                               text-sm
                               font-semibold
                               text-white
                               transition-all
                               duration-200
                               hover:bg-[#18202b]
                               active:scale-[0.98]
                               disabled:cursor-not-allowed
                               disabled:opacity-70"
                    >
                        <span class="ts-label">Cari</span>
                        <span class="ts-spinner items-center justify-center">
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
                    class="mb-1.5 block
                           text-center
                           text-xs
                           font-semibold
                           uppercase
                           tracking-wider
                           text-slate-500"
                >
                    Reset
                </span>

                <button
                    type="button"
                    id="thesisResetFilter"
                    title="Reset Filter"
                    class="relative flex
                           h-[52px]
                           w-[54px]
                           items-center
                           justify-center
                           rounded-xl
                           border border-slate-300
                           bg-white
                           text-slate-600
                           shadow-sm
                           transition-all
                           duration-200
                           hover:border-[#212A37]
                           hover:bg-[#212A37]
                           hover:text-white
                           active:scale-[0.98]"
                >
                    <span class="material-symbols-outlined text-[22px]">restart_alt</span>

                    @if ($hasActive)
                        <span
                            class="absolute -right-1 -top-1
                                   h-3 w-3
                                   rounded-full
                                   border-2 border-white
                                   bg-[#212A37]"
                        ></span>
                    @endif
                </button>

            </div>

        </div>


        {{-- ======================================================== --}}
        {{-- FILTER LANJUTAN (Tahun / Status) --}}
        {{-- ======================================================== --}}

        @if (isset($tahunOptions) || isset($statusOptions))

            <button
                type="button"
                id="thesisAdvancedToggle"
                class="mt-3 inline-flex items-center gap-1.5
                       text-xs font-semibold text-slate-500
                       hover:text-[#212A37]"
            >
                <span class="material-symbols-outlined text-[16px]">tune</span>
                Filter lanjutan
                <span class="material-symbols-outlined text-[16px]" id="thesisAdvancedChevron">expand_more</span>
            </button>

            <div
                id="thesisAdvancedPanel"
                class="{{ $hasAdvanced ? '' : 'hidden' }}
                       mt-3 flex flex-col
                       gap-3 rounded-xl
                       border border-slate-200
                       bg-slate-50/70
                       p-4
                       sm:flex-row sm:flex-wrap"
            >

                @if (isset($tahunOptions))
                    <label class="flex flex-1 min-w-[10rem] flex-col gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Tahun</span>
                        <select
                            name="tahun"
                            class="h-[44px] rounded-lg border border-slate-300 bg-white
                                   px-3 text-sm text-slate-700
                                   outline-none focus:border-[#212A37]
                                   focus:ring-4 focus:ring-slate-100"
                        >
                            <option value="">Semua tahun</option>
                            @foreach ($tahunOptions as $tahun)
                                <option value="{{ $tahun }}" {{ (string) $activeTahun === (string) $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                @endif

                @if (isset($statusOptions))
                    <label class="flex flex-1 min-w-[10rem] flex-col gap-1">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Status</span>
                        <select
                            name="status"
                            class="h-[44px] rounded-lg border border-slate-300 bg-white
                                   px-3 text-sm text-slate-700
                                   outline-none focus:border-[#212A37]
                                   focus:ring-4 focus:ring-slate-100"
                        >
                            <option value="">Semua status</option>
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ (string) $activeStatus === (string) $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </label>
                @endif

                <div class="flex items-end">
                    <button
                        type="submit"
                        class="h-[44px] rounded-lg bg-[#212A37] px-4
                               text-sm font-semibold text-white
                               transition-colors hover:bg-[#18202b]"
                    >
                        Terapkan
                    </button>
                </div>

            </div>
        @endif


        {{-- ======================================================== --}}
        {{-- CHIP FILTER AKTIF --}}
        {{-- ======================================================== --}}

        @if ($hasActive)
            <div class="mt-3 flex flex-wrap items-center gap-2">

                @if (filled($activeSearch))
                    <a
                        href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                        class="inline-flex items-center gap-1.5
                               rounded-full bg-slate-100
                               py-1.5 pl-3 pr-2
                               text-xs font-medium text-slate-600
                               hover:bg-slate-200"
                    >
                        "{{ $activeSearch }}"
                        <span class="material-symbols-outlined text-[15px]">close</span>
                    </a>
                @endif

                @if (filled($activeTahun))
                    <a
                        href="{{ request()->fullUrlWithQuery(['tahun' => null]) }}"
                        class="inline-flex items-center gap-1.5
                               rounded-full bg-slate-100
                               py-1.5 pl-3 pr-2
                               text-xs font-medium text-slate-600
                               hover:bg-slate-200"
                    >
                        Tahun: {{ $activeTahun }}
                        <span class="material-symbols-outlined text-[15px]">close</span>
                    </a>
                @endif

                @if (filled($activeStatus))
                    <a
                        href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
                        class="inline-flex items-center gap-1.5
                               rounded-full bg-slate-100
                               py-1.5 pl-3 pr-2
                               text-xs font-medium text-slate-600
                               hover:bg-slate-200"
                    >
                        Status: {{ $statusOptions[$activeStatus] ?? $activeStatus }}
                        <span class="material-symbols-outlined text-[15px]">close</span>
                    </a>
                @endif

                @if ($activeSort !== 'terbaru')
                    <a
                        href="{{ request()->fullUrlWithQuery(['sort' => null]) }}"
                        class="inline-flex items-center gap-1.5
                               rounded-full bg-slate-100
                               py-1.5 pl-3 pr-2
                               text-xs font-medium text-slate-600
                               hover:bg-slate-200"
                    >
                        Urutkan: {{ $sortLabels[$activeSort] ?? $activeSort }}
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
                Cari data tesis berdasarkan judul, NIM, atau nama mahasiswa. Tekan
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

    const form          = document.getElementById('thesisSearchForm');
    const searchInput   = document.getElementById('thesisSearchInput');
    const clearButton   = document.getElementById('thesisInlineClear');
    const resetButton   = document.getElementById('thesisResetFilter');
    const submitButton  = document.getElementById('thesisSubmit');
    const sortSelect    = document.getElementById('thesisSortSelect');
    const advToggle      = document.getElementById('thesisAdvancedToggle');
    const advPanel        = document.getElementById('thesisAdvancedPanel');
    const advChevron       = document.getElementById('thesisAdvancedChevron');

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

    // Ketik tidak langsung mencari — hasil baru muncul saat user
    // menekan Enter atau klik tombol "Cari".
    searchInput.addEventListener('input', () => {
        updateClearButton();
    });

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
        window.location.href = @json(route('tesis.index'));
    });

    sortSelect?.addEventListener('change', () => {
        setLoading();
        form.submit();
    });

    advToggle?.addEventListener('click', () => {
        advPanel?.classList.toggle('hidden');
        if (advChevron) {
            advChevron.textContent = advPanel?.classList.contains('hidden') ? 'expand_more' : 'expand_less';
        }
    });

    form.addEventListener('submit', () => {
        setLoading();
    });

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