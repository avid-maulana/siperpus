<section>

    {{-- =========================================================
        RESULT HEADER
    ========================================================== --}}
    <div
        class="mb-6
               flex flex-col gap-2
               sm:flex-row
               sm:items-end
               sm:justify-between"
    >

        <div>

            <p
                class="text-sm
                       font-semibold
                       text-[#212A37]"
            >
                Repository
            </p>

            <h2
                class="mt-1
                       text-xl
                       font-bold
                       tracking-tight
                       text-slate-900"
            >
                Daftar Laporan Praktik Industri
            </h2>

        </div>


        <p
            class="text-sm
                   text-slate-500"
        >
            Menampilkan

            <span
                class="font-semibold
                       text-slate-700"
            >
                {{ $laporan->total() }}
            </span>

            laporan
        </p>

    </div>


    {{-- =========================================================
        DATA
    ========================================================== --}}
    @if ($laporan->count())

        <div
            class="grid
                   gap-5
                   md:grid-cols-2
                   xl:grid-cols-3"
        >

            @foreach ($laporan as $item)

                @include(
                    'praktik-industri._card',
                    [
                        'laporan' => $item,
                    ]
                )

            @endforeach

        </div>

    @else

        {{-- =====================================================
            EMPTY STATE
        ====================================================== --}}
        <div
            class="rounded-2xl
                   border
                   border-dashed
                   border-slate-300
                   bg-white
                   px-6
                   py-20
                   text-center"
        >

            <div
                class="mx-auto
                       flex
                       h-16
                       w-16
                       items-center
                       justify-center
                       rounded-2xl
                       bg-[#212A37]/5"
            >

                <span
                    class="material-symbols-outlined
                           text-[30px]
                           text-[#212A37]"
                >
                    description
                </span>

            </div>


            <h3
                class="mt-5
                       text-base
                       font-semibold
                       text-slate-900"
            >
                Laporan tidak ditemukan
            </h3>


            <p
                class="mx-auto
                       mt-2
                       max-w-md
                       text-sm
                       leading-6
                       text-slate-500"
            >
                Tidak ada laporan Praktik Industri yang sesuai
                dengan kata pencarian.
            </p>

        </div>

    @endif


    {{-- =========================================================
        PAGINATION
    ========================================================== --}}
    @if ($laporan->hasPages())

        @include(
            'praktik-industri._pagination',
            [
                'laporan' => $laporan,
            ]
        )

    @endif

</section>