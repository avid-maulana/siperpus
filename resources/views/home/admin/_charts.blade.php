{{-- =============================================================
    COLLECTION DISTRIBUTION CHARTS
============================================================= --}}
<section
    id="dashboardCharts"
    class="mt-8"
    data-kbk='@json($kbkChartData)'
    data-type='@json($typeChartData)'
    data-category='@json($categoryChartData)'>


    {{-- =========================================================
        SECTION HEADER
    ========================================================== --}}
    <div class="mb-5">

        <h2 class="text-lg font-semibold text-slate-900">
            Distribusi Literatur
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Ringkasan distribusi koleksi berdasarkan KBK, tipe, dan kategori.
        </p>

    </div>


    {{-- =========================================================
        CHART GRID
    ========================================================== --}}
    <div class="grid gap-6 lg:grid-cols-3">


        {{-- =====================================================
            KBK
        ====================================================== --}}
        <div
            class="flex h-full flex-col
                   rounded-2xl border border-slate-200
                   bg-white p-6 shadow-sm">

            {{-- Header --}}
            <div class="flex items-start justify-between gap-4">

                <div class="min-w-0">

                    <h3 class="font-semibold text-slate-900">
                        Berdasarkan KBK
                    </h3>

                    <p class="mt-1 text-xs text-slate-400">
                        Distribusi Kompetensi Bidang Keahlian
                    </p>

                </div>


                {{-- Icon --}}
                <div
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl
                           bg-violet-50
                           text-violet-600">

                    <span class="material-symbols-outlined text-[20px]">
                        school
                    </span>

                </div>

            </div>


            {{-- Chart --}}
            <div
                id="kbkChartWrapper"
                class="relative mx-auto mt-6
                       h-[240px] w-full">

                <canvas id="kbkChart"></canvas>

            </div>


            {{-- Legend --}}
            <div
                id="kbkLegend"
                class="mt-auto pt-4">
            </div>

        </div>



        {{-- =====================================================
            TYPE
        ====================================================== --}}
        <div
            class="flex h-full flex-col
                   rounded-2xl border border-slate-200
                   bg-white p-6 shadow-sm">

            {{-- Header --}}
            <div class="flex items-start justify-between gap-4">

                <div class="min-w-0">

                    <h3 class="font-semibold text-slate-900">
                        Berdasarkan Tipe
                    </h3>

                    <p class="mt-1 text-xs text-slate-400">
                        Distribusi tipe literatur
                    </p>

                </div>


                {{-- Icon --}}
                <div
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl
                           bg-blue-50
                           text-blue-600">

                    <span class="material-symbols-outlined text-[20px]">
                        sell
                    </span>

                </div>

            </div>


            {{-- Chart --}}
            <div
                id="typeChartWrapper"
                class="relative mx-auto mt-6
                       h-[240px] w-full">

                <canvas id="typeChart"></canvas>

            </div>


            {{-- Legend --}}
            <div
                id="typeLegend"
                class="mt-auto pt-4">
            </div>

        </div>



        {{-- =====================================================
            CATEGORY
        ====================================================== --}}
        <div
            class="flex h-full flex-col
                   rounded-2xl border border-slate-200
                   bg-white p-6 shadow-sm">

            {{-- Header --}}
            <div class="flex items-start justify-between gap-4">

                <div class="min-w-0">

                    <h3 class="font-semibold text-slate-900">
                        Berdasarkan Kategori
                    </h3>

                    <p class="mt-1 text-xs text-slate-400">
                        Distribusi kategori literatur
                    </p>

                </div>


                {{-- Icon --}}
                <div
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-xl
                           bg-emerald-50
                           text-emerald-600">

                    <span class="material-symbols-outlined text-[20px]">
                        category
                    </span>

                </div>

            </div>


            {{-- Chart --}}
            <div
                id="categoryChartWrapper"
                class="relative mx-auto mt-6
                       h-[240px] w-full">

                <canvas id="categoryChart"></canvas>

            </div>


            {{-- Legend --}}
            <div
                id="categoryLegend"
                class="mt-auto pt-4">
            </div>

        </div>

    </div>

</section>



{{-- =============================================================
    CHART DETAIL MODAL
============================================================= --}}
<div
    id="chartDetailModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="chartDetailTitle"
    class="fixed inset-0 z-[9999]
           hidden
           items-center justify-center
           overflow-hidden
           bg-slate-950/0
           p-4
           opacity-0
           backdrop-blur-none
           transition-all duration-300 ease-out
           sm:p-6">


    {{-- =========================================================
        MODAL CARD
    ========================================================== --}}
    <div
        id="chartDetailModalCard"
        class="relative
               flex
               max-h-[85vh]
               w-full max-w-2xl
               translate-y-4
               scale-95
               flex-col
               overflow-hidden
               rounded-2xl
               border border-slate-200
               bg-white
               opacity-0
               shadow-[0_24px_80px_rgba(15,23,42,0.28)]
               transition-all duration-300 ease-out">


        {{-- =====================================================
            MODAL HEADER
        ====================================================== --}}
        <div
            class="flex shrink-0
                   items-start justify-between
                   gap-4
                   border-b border-slate-100
                   bg-white
                   px-5 py-5
                   sm:px-6">

            {{-- Title --}}
            <div class="min-w-0">

                <div class="flex items-center gap-2">

                    <div
                        class="flex h-7 w-7 shrink-0
                               items-center justify-center
                               rounded-lg
                               bg-blue-50
                               text-blue-600">

                        <span class="material-symbols-outlined text-[16px]">
                            donut_large
                        </span>

                    </div>


                    <p
                        class="text-[10px]
                               font-semibold uppercase
                               tracking-[0.16em]
                               text-blue-600">

                        Distribusi Data

                    </p>

                </div>


                <h3
                    id="chartDetailTitle"
                    class="mt-3
                           text-lg font-semibold
                           text-slate-900">

                    Detail Distribusi

                </h3>


                <p
                    id="chartDetailSubtitle"
                    class="mt-1
                           text-xs leading-5
                           text-slate-400">

                    Informasi lengkap distribusi data.

                </p>

            </div>


            {{-- Close --}}
            <button
                type="button"
                onclick="closeChartModal()"
                title="Tutup"
                aria-label="Tutup modal"
                class="flex h-9 w-9
                       shrink-0
                       items-center justify-center
                       rounded-lg
                       border border-transparent
                       text-slate-400
                       transition-all duration-200
                       hover:border-slate-200
                       hover:bg-slate-100
                       hover:text-slate-700">

                <span
                    class="material-symbols-outlined text-[20px]"
                    style="font-variation-settings: 'wght' 300;">

                    close

                </span>

            </button>

        </div>



        {{-- =====================================================
            SUMMARY
        ====================================================== --}}
        <div
            class="grid shrink-0
                   grid-cols-2
                   border-b border-slate-100
                   bg-slate-50/70">


            {{-- Jumlah Data --}}
            <div
                class="border-r border-slate-100
                       px-5 py-4
                       sm:px-6">

                <div class="flex items-center gap-2">

                    <span
                        class="material-symbols-outlined
                               text-[16px]
                               text-slate-400">

                        format_list_bulleted

                    </span>

                    <p
                        class="text-[10px]
                               font-semibold uppercase
                               tracking-wider
                               text-slate-400">

                        Jumlah Data

                    </p>

                </div>


                <p
                    id="chartDetailCount"
                    class="mt-1.5
                           text-xl font-bold
                           tabular-nums
                           text-slate-900">

                    0

                </p>

            </div>


            {{-- Total --}}
            <div
                class="px-5 py-4
                       sm:px-6">

                <div class="flex items-center gap-2">

                    <span
                        class="material-symbols-outlined
                               text-[16px]
                               text-slate-400">

                        database

                    </span>

                    <p
                        class="text-[10px]
                               font-semibold uppercase
                               tracking-wider
                               text-slate-400">

                        Total

                    </p>

                </div>


                <p
                    id="chartDetailTotal"
                    class="mt-1.5
                           text-xl font-bold
                           tabular-nums
                           text-slate-900">

                    0

                </p>

            </div>

        </div>



        {{-- =====================================================
            TABLE HEADER
        ====================================================== --}}
        <div
            class="grid shrink-0
                   grid-cols-[minmax(0,1fr)_72px_58px]
                   gap-3
                   border-b border-slate-100
                   bg-white
                   px-5 py-3
                   sm:grid-cols-[minmax(0,1fr)_90px_70px]
                   sm:gap-4
                   sm:px-6">

            <p
                class="text-[10px]
                       font-semibold uppercase
                       tracking-wider
                       text-slate-400">

                Nama

            </p>

            <p
                class="text-right
                       text-[10px]
                       font-semibold uppercase
                       tracking-wider
                       text-slate-400">

                Jumlah

            </p>

            <p
                class="text-right
                       text-[10px]
                       font-semibold uppercase
                       tracking-wider
                       text-slate-400">

                %

            </p>

        </div>



        {{-- =====================================================
            SCROLLABLE CONTENT
        ====================================================== --}}
        <div
            id="chartDetailContent"
            class="min-h-0
                   flex-1
                   overflow-y-auto
                   overscroll-contain">

            {{-- Diisi oleh home.js --}}

        </div>



        {{-- =====================================================
            FOOTER
        ====================================================== --}}
        <div
            class="flex shrink-0
                   items-center justify-between
                   gap-4
                   border-t border-slate-100
                   bg-slate-50/70
                   px-5 py-4
                   sm:px-6">

            <p
                class="hidden text-xs
                       text-slate-400
                       sm:block">

                Klik area di luar popup atau tekan Esc untuk menutup.

            </p>


        </div>

    </div>

</div>