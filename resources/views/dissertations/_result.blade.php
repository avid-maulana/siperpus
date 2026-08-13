{{-- ================================================================ --}}
{{-- HASIL DISERTASI --}}
{{-- ================================================================ --}}

@if($dissertations->isEmpty())

    {{-- ============================================================ --}}
    {{-- EMPTY STATE --}}
    {{-- ============================================================ --}}

    <div
        class="rounded-2xl
               border border-slate-200
               bg-white
               px-6 py-20
               text-center
               shadow-sm">

        <div
            class="mx-auto
                   flex h-16 w-16
                   items-center justify-center
                   rounded-2xl
                   bg-slate-100">

            <span
                class="material-symbols-outlined
                       text-[32px]
                       text-slate-400">

                search_off

            </span>

        </div>


        <h3
            class="mt-5
                   text-lg
                   font-bold
                   text-slate-800">

            Disertasi Tidak Ditemukan

        </h3>


        <p
            class="mx-auto mt-2
                   max-w-md
                   text-sm
                   leading-6
                   text-slate-500">

            Tidak ada disertasi yang sesuai dengan
            pencarian yang kamu masukkan.

        </p>


        @if(request('search'))

            <a
                href="{{ route('disertasi.index') }}"
                class="mt-6 inline-flex
                       items-center gap-2
                       rounded-xl
                       bg-slate-900
                       px-5 py-3
                       text-sm font-semibold
                       text-white
                       transition
                       hover:bg-slate-700">

                <span
                    class="material-symbols-outlined
                           text-[18px]">

                    refresh

                </span>

                Tampilkan Semua Disertasi

            </a>

        @endif

    </div>

@else

    {{-- ============================================================ --}}
    {{-- RESULT HEADER --}}
    {{-- ============================================================ --}}

    <div
        class="mb-5
               flex flex-col
               gap-2
               sm:flex-row
               sm:items-center
               sm:justify-between">

        <div>

            <p
                class="text-sm
                       font-semibold
                       text-slate-700">

                Koleksi Disertasi

            </p>


            <p
                class="mt-1
                       text-xs
                       text-slate-400">

                Menampilkan

                <span
                    data-result-count="{{ $dissertations->count() }}"
                    class="font-semibold
                           text-slate-600">

                    {{ $dissertations->count() }}

                </span>

                dari

                <span
                    data-result-total="{{ $total }}"
                    class="font-semibold
                           text-slate-600">

                    {{ $total }}

                </span>

                disertasi

            </p>

        </div>


        {{-- Badge --}}

        <div
            class="inline-flex
                   w-fit
                   items-center
                   gap-2
                   rounded-full
                   border border-slate-200
                   bg-white
                   px-3 py-1.5
                   text-xs
                   font-medium
                   text-slate-500">

            <span
                class="h-2 w-2
                       rounded-full
                       bg-emerald-500">
            </span>

            Repository Aktif

        </div>

    </div>


    {{-- ============================================================ --}}
    {{-- CARD GRID --}}
    {{-- ============================================================ --}}

    <div
        class="grid
               grid-cols-1
               gap-5
               md:grid-cols-2
               xl:grid-cols-3">

        @foreach($dissertations as $dissertation)

            @include(
                'dissertations._card',
                [
                    'dissertation' => $dissertation
                ]
            )

        @endforeach

    </div>


    {{-- ============================================================ --}}
    {{-- PAGINATION --}}
    {{-- ============================================================ --}}

    @if($lastPage > 1)

        <div class="mt-8">

            @include(
                'dissertations._pagination',
                [
                    'currentPage' => $currentPage,
                    'lastPage' => $lastPage,
                ]
            )

        </div>

    @endif

@endif