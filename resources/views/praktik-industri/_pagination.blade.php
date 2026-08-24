@if ($laporan->hasPages())

    <nav class="mt-10 flex items-center justify-center" aria-label="Pagination">

        <div
            class="inline-flex
                   items-center
                   gap-1
                   rounded-xl
                   border
                   border-slate-200
                   bg-white
                   p-1
                   shadow-sm">

            {{-- Previous --}}
            @if ($laporan->onFirstPage())
                <span
                    class="flex
                           h-9
                           min-w-9
                           items-center
                           justify-center
                           rounded-lg
                           text-slate-300">
                    <span class="material-symbols-outlined text-[18px]">
                        chevron_left
                    </span>
                </span>
            @else
                <a href="{{ $laporan->previousPageUrl() }}"
                    class="flex
                           h-9
                           min-w-9
                           items-center
                           justify-center
                           rounded-lg
                           text-slate-500
                           transition
                           hover:bg-[#212A37]/5
                           hover:text-[#212A37]">
                    <span class="material-symbols-outlined text-[18px]">
                        chevron_left
                    </span>
                </a>
            @endif


            {{-- Pages --}}
            @foreach ($laporan->getUrlRange(max(1, $laporan->currentPage() - 2), min($laporan->lastPage(), $laporan->currentPage() + 2)) as $page => $url)
                @if ($page == $laporan->currentPage())
                    <span
                        class="flex
                               h-9
                               min-w-9
                               items-center
                               justify-center
                               rounded-lg
                               bg-[#212A37]
                               px-2
                               text-sm
                               font-semibold
                               text-white">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                        class="flex
                               h-9
                               min-w-9
                               items-center
                               justify-center
                               rounded-lg
                               px-2
                               text-sm
                               font-medium
                               text-slate-600
                               transition
                               hover:bg-[#212A37]/5
                               hover:text-[#212A37]">
                        {{ $page }}
                    </a>
                @endif
            @endforeach


            {{-- Next --}}
            @if ($laporan->hasMorePages())
                <a href="{{ $laporan->nextPageUrl() }}"
                    class="flex
                           h-9
                           min-w-9
                           items-center
                           justify-center
                           rounded-lg
                           text-slate-500
                           transition
                           hover:bg-[#212A37]/5
                           hover:text-[#212A37]">
                    <span class="material-symbols-outlined text-[18px]">
                        chevron_right
                    </span>
                </a>
            @else
                <span
                    class="flex
                           h-9
                           min-w-9
                           items-center
                           justify-center
                           rounded-lg
                           text-slate-300">
                    <span class="material-symbols-outlined text-[18px]">
                        chevron_right
                    </span>
                </span>
            @endif

        </div>

    </nav>

@endif
