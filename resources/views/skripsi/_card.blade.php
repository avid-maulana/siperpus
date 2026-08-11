@php
    $babList = [
        'bab1' => 'BAB I',
        'bab2' => 'BAB II',
        'bab3' => 'BAB III',
        'bab4' => 'BAB IV',
        'bab5' => 'BAB V',
        'bab6' => 'BAB VI',
        'daftar_pustaka' => 'Daftar Pustaka',
    ];

    $judul = strip_tags($skripsi->judul ?? '');

    $namaMahasiswa = $skripsi->user->nama_lengkap ?? '-';
    $nimMahasiswa = $skripsi->user->nomor_induk ?? '-';
@endphp


<div class="group flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:border-slate-300 hover:shadow-xl">


    {{-- =========================================================
        HEADER
    ========================================================== --}}

    <div class="relative overflow-hidden border-b border-slate-200 bg-[#1b2330] px-6 py-6">


        {{-- Background --}}

        <div class="pointer-events-none absolute inset-0
            bg-gradient-to-br
            from-[#263241]
            via-[#212A37]
            to-[#1b2430]">
        </div>


        {{-- Glow --}}

        <div class="pointer-events-none absolute -right-16 -top-16
                h-48 w-48 rounded-full bg-white/[0.04] blur-3xl">
        </div>


        {{-- Content --}}

        <div class="relative z-10">


            {{-- Label --}}

            <div class="inline-flex items-center gap-2 text-white/60">

                <span class="material-symbols-outlined text-[16px]">
                    school
                </span>

                <span class="text-[10px] font-semibold uppercase tracking-[0.18em]">
                    Skripsi
                </span>

            </div>


            {{-- Title --}}

            <div class="relative mt-4">

                <h2
                    class="max-h-[4.5em] overflow-hidden
                    text-[16px] font-semibold leading-[1.5]
                    text-white
                    transition-[max-height] duration-500 ease-in-out
                    group-hover:max-h-[500px]"
                    title="{{ $judul }}">

                    {{ $judul }}

                </h2>


                {{-- Fade --}}

                <div
                    class="pointer-events-none absolute
                    inset-x-0 bottom-0
                    h-8
                    bg-gradient-to-t
                    from-[#212A37]
                    via-[#212A37]/75
                    to-transparent
                    transition-opacity duration-300
                    group-hover:opacity-0">
                </div>

            </div>


            {{-- KBK --}}

            <div class="mt-5">

                <div class="inline-flex max-w-full items-center gap-3
                        rounded-xl border border-white/15
                        bg-white/[0.08]
                        px-3.5 py-2.5
                        transition-colors duration-300
                        group-hover:bg-white/[0.12]">


                    <div class="flex h-8 w-8 shrink-0 items-center justify-center
                            rounded-lg bg-white/10 text-white/70">

                        <span class="material-symbols-outlined text-[18px]">
                            account_tree
                        </span>

                    </div>


                    <div class="min-w-0">

                        <div class="text-[9px] font-semibold uppercase
                                tracking-[0.15em] text-white/40">

                            KBK

                        </div>


                        <div
                            class="mt-0.5 truncate text-xs font-semibold text-white/85"
                            title="{{ data_get($skripsi, 'user.dataJudul.kbk.nama_kbk', '-') }}">

                            {{ data_get($skripsi, 'user.dataJudul.kbk.nama_kbk', '-') }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
        CONTENT
    ========================================================== --}}

    <div class="flex flex-1 flex-col p-6">


        {{-- =====================================================
            INFO MAHASISWA
        ====================================================== --}}

        <div class="space-y-5">


            {{-- Nama --}}

            <div class="flex items-start gap-3">

                <div
                    class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center
                    rounded-2xl bg-slate-100 text-slate-500
                    ring-1 ring-inset ring-slate-200">

                    <span class="material-symbols-outlined text-[20px]">
                        person
                    </span>

                </div>


                <div class="min-w-0 flex-1">

                    <div class="text-[10px] font-medium uppercase tracking-widest text-slate-400">
                        Nama
                    </div>

                    <div class="truncate text-sm font-semibold text-slate-700">

                        {{ $namaMahasiswa }}

                    </div>

                </div>

            </div>


            {{-- NIM --}}

            <div class="flex items-start gap-3">

                <div
                    class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center
                    rounded-2xl bg-slate-100 text-slate-500
                    ring-1 ring-inset ring-slate-200">

                    <span class="material-symbols-outlined text-[20px]">
                        badge
                    </span>

                </div>


                <div class="min-w-0 flex-1">

                    <div class="text-[10px] font-medium uppercase tracking-widest text-slate-400">
                        NIM
                    </div>

                    <div class="truncate text-sm font-semibold text-slate-700">

                        {{ $nimMahasiswa }}

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
            DIUNGGAH
        ====================================================== --}}

        <div class="mt-5 flex items-start gap-3">

            <div
                class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center
                rounded-2xl bg-slate-100 text-slate-500
                ring-1 ring-inset ring-slate-200">

                <span class="material-symbols-outlined text-[20px]">
                    upload_file
                </span>

            </div>


            <div class="min-w-0 flex-1">

                <div class="text-[10px] font-medium uppercase tracking-widest text-slate-400">
                    Diunggah
                </div>


                <div class="text-sm font-semibold text-slate-700">

                    @if($skripsi->isi && $skripsi->isi->created_at)

                        {{ \Carbon\Carbon::parse($skripsi->isi->created_at)->locale('id')->translatedFormat('d F Y') }}

                    @else

                        -

                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
            REPOSITORY DOCUMENTS
        ====================================================== --}}

        <div class="mt-8 border-t border-slate-100 pt-6">

            <div class="grid grid-cols-1 gap-2.5 sm:grid-cols-2">


                @foreach ($babList as $key => $label)

                    @php
                        $available = $skripsi->isi && $skripsi->isi->$key;
                        $icon = $key === 'daftar_pustaka'
                            ? 'menu_book'
                            : 'description';

                        $isDaftarPustaka = $key === 'daftar_pustaka';
                    @endphp


                    @if ($available)

                        {{-- =================================================
                            PDF AVAILABLE
                        ================================================== --}}

                        <a
                            href="{{ route('pdf.viewer', [
                                'path' => $skripsi->isi->$key,
                                'title' => $label,
                                'skripsi' => $judul,

                                /*
                                 * Data mahasiswa untuk PDF Viewer
                                 */
                                'nama' => $namaMahasiswa,
                                'nim' => $nimMahasiswa,

                                /*
                                 * Bagian / BAB yang sedang dibuka
                                 */
                                'bab' => $label,
                            ]) }}"
                            class="group/link flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm transition-all duration-300 hover:border-[#212A37] hover:bg-[#212A37] hover:text-white hover:shadow-lg {{ $isDaftarPustaka ? 'sm:col-span-2 sm:justify-center sm:px-6' : '' }}">


                            <span
                                class="flex min-w-0 items-center gap-3 {{ $isDaftarPustaka ? 'sm:justify-center sm:w-full' : '' }}">


                                <span
                                    class="material-symbols-outlined text-[18px] text-slate-400 transition-colors duration-300 group-hover/link:text-white">

                                    {{ $icon }}

                                </span>


                                <span
                                    class="truncate {{ $isDaftarPustaka ? 'sm:text-center' : '' }}">

                                    {{ $label }}

                                </span>

                            </span>


                            <span
                                class="material-symbols-outlined text-[18px] text-slate-300 transition-colors duration-300 group-hover/link:text-white {{ $isDaftarPustaka ? 'sm:hidden' : '' }}">

                                open_in_new

                            </span>

                        </a>


                    @else

                        {{-- =================================================
                            PDF NOT AVAILABLE
                        ================================================== --}}

                        <div
                            class="flex items-center justify-between rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-400 {{ $isDaftarPustaka ? 'sm:col-span-2 sm:justify-center sm:px-6' : '' }}">


                            <span
                                class="flex min-w-0 items-center gap-3 {{ $isDaftarPustaka ? 'sm:justify-center sm:w-full' : '' }}">


                                <span class="material-symbols-outlined text-[18px] text-slate-300">

                                    {{ $icon }}

                                </span>


                                <span
                                    class="truncate {{ $isDaftarPustaka ? 'sm:text-center' : '' }}">

                                    {{ $label }}

                                </span>

                            </span>


                            <span
                                class="text-[10px] font-medium {{ $isDaftarPustaka ? 'sm:hidden' : '' }}">

                                Belum ada

                            </span>

                        </div>

                    @endif

                @endforeach

            </div>

        </div>


    </div>

</div>