@php
$repository = $dissertation->repository ?? null;

/*
|--------------------------------------------------------------------------
| Bersihkan judul dari HTML
|--------------------------------------------------------------------------
*/

$judulRaw = $dissertation->judul_karya ?? '-';

$judul = html_entity_decode(
$judulRaw,
ENT_QUOTES | ENT_HTML5,
'UTF-8'
);

$judul = strip_tags($judul);

$judul = trim(
preg_replace(
'/\s+/',
' ',
$judul
)
);


$nama = $dissertation->nama ?? '-';

$nim = $dissertation->nim ?? '-';

$tanggalSidang =
$dissertation->tgl_sidang ?? null;

$repositoryUrl =
$repository?->repository_url ?? null;
@endphp


<article
    class="group flex h-full flex-col overflow-hidden
           rounded-2xl border border-slate-200
           bg-white shadow-sm
           transition-all duration-300
           hover:-translate-y-1
           hover:shadow-lg">


    {{-- HEADER --}}

    <div
        class="relative overflow-hidden
               bg-gradient-to-br
               from-slate-800
               to-slate-950
               px-6 py-6">

        <div
            class="absolute -right-10 -top-10
                   h-32 w-32 rounded-full
                   bg-white/5">
        </div>


        <div
            class="relative flex items-start
                   justify-between gap-4">

            <div
                class="flex h-11 w-11 shrink-0
                       items-center justify-center
                       rounded-xl
                       bg-white/10
                       text-white
                       backdrop-blur">

                <span
                    class="material-symbols-outlined text-[23px]">

                    school

                </span>

            </div>


            <span
                class="rounded-full
                       bg-white/10
                       px-3 py-1.5
                       text-xs font-semibold
                       text-white
                       backdrop-blur">

                Disertasi

            </span>

        </div>

    </div>


    {{-- CONTENT --}}

    <div
        class="flex flex-1 flex-col p-6">


        {{-- JUDUL --}}

        <h3
            class="line-clamp-3
                   text-base font-bold
                   leading-6
                   text-slate-800">

            {{ $judul }}

        </h3>


        {{-- DETAIL --}}

        <div class="mt-6 space-y-4">


            {{-- MAHASISWA --}}

            <div
                class="flex items-start gap-3">

                <div
                    class="flex h-9 w-9 shrink-0
                           items-center justify-center
                           rounded-lg bg-slate-100">

                    <span
                        class="material-symbols-outlined
                               text-[19px]
                               text-slate-500">

                        person

                    </span>

                </div>


                <div class="min-w-0">

                    <p
                        class="text-xs font-medium
                               text-slate-400">

                        Mahasiswa

                    </p>


                    <p
                        class="mt-0.5 truncate
                               text-sm font-semibold
                               text-slate-700">

                        {{ $nama }}

                    </p>

                </div>

            </div>


            {{-- NIM --}}

            <div
                class="flex items-start gap-3">

                <div
                    class="flex h-9 w-9 shrink-0
                           items-center justify-center
                           rounded-lg bg-slate-100">

                    <span
                        class="material-symbols-outlined
                               text-[19px]
                               text-slate-500">

                        badge

                    </span>

                </div>


                <div>

                    <p
                        class="text-xs font-medium
                               text-slate-400">

                        NIM

                    </p>


                    <p
                        class="mt-0.5
                               text-sm font-semibold
                               text-slate-700">

                        {{ $nim }}

                    </p>

                </div>

            </div>


            {{-- TANGGAL SIDANG --}}

            <div
                class="flex items-start gap-3">

                <div
                    class="flex h-9 w-9 shrink-0
                           items-center justify-center
                           rounded-lg bg-slate-100">

                    <span
                        class="material-symbols-outlined
                               text-[19px]
                               text-slate-500">

                        calendar_month

                    </span>

                </div>


                <div>

                    <p
                        class="text-xs font-medium
                               text-slate-400">

                        Tanggal Sidang

                    </p>


                    <p
                        class="mt-0.5
                               text-sm font-semibold
                               text-slate-700">

                        @if($tanggalSidang)

                        {{ \Carbon\Carbon::parse(
                                $tanggalSidang
                            )->locale('id')->translatedFormat('d F Y') }}

                        @else

                        -

                        @endif

                    </p>

                </div>

            </div>

        </div>


        {{-- REPOSITORY --}}

        <div class="mt-auto pt-6">

            @if($repositoryUrl)

            <a
                href="{{ $repositoryUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                class="flex w-full
                           items-center justify-center
                           gap-2 rounded-xl
                           bg-slate-900
                           px-4 py-3
                           text-sm font-semibold
                           text-white
                           transition-all duration-200
                           hover:bg-slate-700
                           group-hover:shadow-md">

                <span
                    class="material-symbols-outlined
                               text-[19px]">

                    open_in_new

                </span>

                Lihat Repository

            </a>

            @else

            <div
                class="flex w-full
                           items-center justify-center
                           gap-2 rounded-xl
                           bg-slate-100
                           px-4 py-3
                           text-sm font-semibold
                           text-slate-400">

                <span
                    class="material-symbols-outlined
                               text-[19px]">

                    link_off

                </span>

                Repository Tidak Tersedia

            </div>

            @endif

        </div>

    </div>

</article>