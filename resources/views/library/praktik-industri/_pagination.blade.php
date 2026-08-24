{{-- =========================================================
    PAGINATION
========================================================= --}}

@if ($laporan->hasPages())

    <div
        class="mt-6 flex items-center
               justify-between
               rounded-2xl
               border border-slate-200
               bg-white
               px-5 py-4
               shadow-sm"
    >

        {{-- =================================================
            INFORMATION
        ================================================== --}}

        <div
            class="flex items-center gap-2
                   text-xs text-slate-400"
        >

            <span
                class="material-symbols-outlined
                       text-[17px]"
            >
                info
            </span>

            <span>

                Menampilkan

                <span class="font-semibold text-slate-600">
                    {{ $laporan->firstItem() }}
                </span>

                sampai

                <span class="font-semibold text-slate-600">
                    {{ $laporan->lastItem() }}
                </span>

                dari

                <span class="font-semibold text-slate-600">
                    {{ $laporan->total() }}
                </span>

                kelompok

            </span>

        </div>


        {{-- =================================================
            BUTTONS
        ================================================== --}}

        <div class="flex items-center gap-1.5">

            {{-- PREVIOUS --}}

            @if ($laporan->onFirstPage())

                <span
                    class="inline-flex h-9 w-9
                           items-center justify-center
                           rounded-xl
                           border border-slate-200
                           bg-slate-50
                           text-slate-300"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        chevron_left
                    </span>
                </span>

            @else

                <a
                    href="{{ $laporan->appends(request()->query())->previousPageUrl() }}"
                    class="inline-flex h-9 w-9
                           items-center justify-center
                           rounded-xl
                           border border-slate-200
                           bg-white
                           text-slate-500
                           shadow-sm
                           transition-all
                           duration-200
                           hover:border-[#212A37]
                           hover:bg-[#212A37]
                           hover:text-white"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        chevron_left
                    </span>
                </a>

            @endif


            {{-- PAGE NUMBERS --}}

            @foreach (
                $laporan->appends(request()->query())->getUrlRange(
                    max(1, $laporan->currentPage() - 2),
                    min($laporan->lastPage(), $laporan->currentPage() + 2)
                ) as $page => $url
            )

                @if ($page === $laporan->currentPage())

                    <span
                        class="inline-flex h-9 min-w-9
                               items-center justify-center
                               rounded-xl
                               bg-[#212A37]
                               px-2.5
                               text-xs
                               font-semibold
                               text-white"
                    >
                        {{ $page }}
                    </span>

                @else

                    <a
                        href="{{ $url }}"
                        class="inline-flex h-9 min-w-9
                               items-center justify-center
                               rounded-xl
                               border border-slate-200
                               bg-white
                               px-2.5
                               text-xs
                               font-semibold
                               text-slate-500
                               shadow-sm
                               transition-all
                               duration-200
                               hover:border-[#212A37]/20
                               hover:bg-[#212A37]/5
                               hover:text-[#212A37]"
                    >
                        {{ $page }}
                    </a>

                @endif

            @endforeach


            {{-- NEXT --}}

            @if ($laporan->hasMorePages())

                <a
                    href="{{ $laporan->appends(request()->query())->nextPageUrl() }}"
                    class="inline-flex h-9 w-9
                           items-center justify-center
                           rounded-xl
                           border border-slate-200
                           bg-white
                           text-slate-500
                           shadow-sm
                           transition-all
                           duration-200
                           hover:border-[#212A37]
                           hover:bg-[#212A37]
                           hover:text-white"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        chevron_right
                    </span>
                </a>

            @else

                <span
                    class="inline-flex h-9 w-9
                           items-center justify-center
                           rounded-xl
                           border border-slate-200
                           bg-slate-50
                           text-slate-300"
                >
                    <span class="material-symbols-outlined text-[18px]">
                        chevron_right
                    </span>
                </span>

            @endif

        </div>

    </div>

@endif