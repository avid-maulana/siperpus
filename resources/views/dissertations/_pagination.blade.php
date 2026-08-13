{{-- ================================================================ --}}
{{-- PAGINATION DISERTASI --}}
{{-- ================================================================ --}}

@if($lastPage > 1)

    <div
        class="flex flex-col
               items-center
               justify-between
               gap-4
               sm:flex-row">


        {{-- ======================================================== --}}
        {{-- INFO --}}
        {{-- ======================================================== --}}

        <p
            class="text-xs
                   text-slate-400">

            Halaman

            <span
                class="font-semibold
                       text-slate-600">

                {{ $currentPage }}

            </span>

            dari

            <span
                class="font-semibold
                       text-slate-600">

                {{ $lastPage }}

            </span>

        </p>


        {{-- ======================================================== --}}
        {{-- BUTTON --}}
        {{-- ======================================================== --}}

        <div
            class="flex
                   items-center
                   gap-1.5">


            {{-- ==================================================== --}}
            {{-- PREVIOUS --}}
            {{-- ==================================================== --}}

            @if($currentPage > 1)

                <button
                    type="button"
                    data-dissertation-page="{{ $currentPage - 1 }}"
                    aria-label="Halaman sebelumnya"
                    class="inline-flex
                           h-10 w-10
                           items-center
                           justify-center
                           rounded-xl
                           border border-slate-200
                           bg-white
                           text-slate-600
                           shadow-sm
                           transition-all
                           duration-200
                           hover:border-slate-300
                           hover:bg-slate-50
                           hover:text-slate-900">

                    <span
                        class="material-symbols-outlined
                               text-[19px]">

                        chevron_left

                    </span>

                </button>

            @else

                <span
                    class="inline-flex
                           h-10 w-10
                           cursor-not-allowed
                           items-center
                           justify-center
                           rounded-xl
                           border border-slate-100
                           bg-slate-50
                           text-slate-300">

                    <span
                        class="material-symbols-outlined
                               text-[19px]">

                        chevron_left

                    </span>

                </span>

            @endif


            {{-- ==================================================== --}}
            {{-- NOMOR HALAMAN --}}
            {{-- ==================================================== --}}

            @php

                $startPage =
                    max(
                        1,
                        $currentPage - 2
                    );

                $endPage =
                    min(
                        $lastPage,
                        $currentPage + 2
                    );

            @endphp


            {{-- HALAMAN PERTAMA --}}

            @if($startPage > 1)

                <button
                    type="button"
                    data-dissertation-page="1"
                    aria-label="Halaman 1"
                    class="inline-flex
                           h-10 min-w-10
                           items-center
                           justify-center
                           rounded-xl
                           border border-slate-200
                           bg-white
                           px-3
                           text-sm
                           font-semibold
                           text-slate-600
                           shadow-sm
                           transition-all
                           duration-200
                           hover:border-slate-300
                           hover:bg-slate-50
                           hover:text-slate-900">

                    1

                </button>


                @if($startPage > 2)

                    <span
                        class="flex h-10 w-8
                               items-center
                               justify-center
                               text-sm
                               text-slate-400">

                        ...

                    </span>

                @endif

            @endif


            {{-- HALAMAN SEKITAR AKTIF --}}

            @for(
                $page = $startPage;
                $page <= $endPage;
                $page++
            )

                @if($page === $currentPage)

                    <span
                        aria-current="page"
                        class="inline-flex
                               h-10 min-w-10
                               items-center
                               justify-center
                               rounded-xl
                               bg-slate-900
                               px-3
                               text-sm
                               font-semibold
                               text-white
                               shadow-sm">

                        {{ $page }}

                    </span>

                @else

                    <button
                        type="button"
                        data-dissertation-page="{{ $page }}"
                        aria-label="Halaman {{ $page }}"
                        class="inline-flex
                               h-10 min-w-10
                               items-center
                               justify-center
                               rounded-xl
                               border border-slate-200
                               bg-white
                               px-3
                               text-sm
                               font-semibold
                               text-slate-600
                               shadow-sm
                               transition-all
                               duration-200
                               hover:border-slate-300
                               hover:bg-slate-50
                               hover:text-slate-900">

                        {{ $page }}

                    </button>

                @endif

            @endfor


            {{-- HALAMAN TERAKHIR --}}

            @if($endPage < $lastPage)

                @if($endPage < $lastPage - 1)

                    <span
                        class="flex h-10 w-8
                               items-center
                               justify-center
                               text-sm
                               text-slate-400">

                        ...

                    </span>

                @endif


                <button
                    type="button"
                    data-dissertation-page="{{ $lastPage }}"
                    aria-label="Halaman {{ $lastPage }}"
                    class="inline-flex
                           h-10 min-w-10
                           items-center
                           justify-center
                           rounded-xl
                           border border-slate-200
                           bg-white
                           px-3
                           text-sm
                           font-semibold
                           text-slate-600
                           shadow-sm
                           transition-all
                           duration-200
                           hover:border-slate-300
                           hover:bg-slate-50
                           hover:text-slate-900">

                    {{ $lastPage }}

                </button>

            @endif


            {{-- ==================================================== --}}
            {{-- NEXT --}}
            {{-- ==================================================== --}}

            @if($currentPage < $lastPage)

                <button
                    type="button"
                    data-dissertation-page="{{ $currentPage + 1 }}"
                    aria-label="Halaman berikutnya"
                    class="inline-flex
                           h-10 w-10
                           items-center
                           justify-center
                           rounded-xl
                           border border-slate-200
                           bg-white
                           text-slate-600
                           shadow-sm
                           transition-all
                           duration-200
                           hover:border-slate-300
                           hover:bg-slate-50
                           hover:text-slate-900">

                    <span
                        class="material-symbols-outlined
                               text-[19px]">

                        chevron_right

                    </span>

                </button>

            @else

                <span
                    class="inline-flex
                           h-10 w-10
                           cursor-not-allowed
                           items-center
                           justify-center
                           rounded-xl
                           border border-slate-100
                           bg-slate-50
                           text-slate-300">

                    <span
                        class="material-symbols-outlined
                               text-[19px]">

                        chevron_right

                    </span>

                </span>

            @endif

        </div>

    </div>

@endif