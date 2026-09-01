{{-- =========================================================
    STATISTICS
========================================================= --}}

<style>
    .stat-card {
        position: relative;
        isolation: isolate;
        overflow: hidden;

        padding: 2px;
        border-radius: 1rem;

        background: #334155;

        transition:
            transform 0.48s cubic-bezier(0.23, 1, 0.32, 1),
            box-shadow 0.48s cubic-bezier(0.23, 1, 0.32, 1);
    }


    /* Rotating Border */
    .stat-card::before {
        content: "";
        position: absolute;
        z-index: -2;

        top: 50%;
        left: 50%;

        width: 160%;
        aspect-ratio: 1;

        background: conic-gradient(
            from 0deg,
            transparent 0deg,
            transparent 90deg,
            rgba(255, 255, 255, 0.9) 170deg,
            rgba(255, 255, 255, 0.9) 200deg,
            transparent 280deg,
            transparent 360deg
        );

        transform: translate(-50%, -50%) rotate(0deg);

        opacity: 0;

        animation: stat-border-spin 3s linear infinite;
        animation-play-state: paused;

        transition: opacity 0.3s ease;
    }


    /* Card Background */
    .stat-card::after {
        content: "";
        position: absolute;
        z-index: -1;

        inset: 2px;

        border-radius: calc(1rem - 2px);

        background: #212A37;
    }


    /* Hover */
    .stat-card:hover::before {
        opacity: 1;
        animation-play-state: running;
    }


    .stat-card:hover {
        transform: scale(1.015);

        box-shadow:
            0 12px 28px rgba(15, 23, 42, 0.18),
            0 24px 48px rgba(15, 23, 42, 0.12);
    }


    @keyframes stat-border-spin {
        from {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        to {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }
</style>


<section>

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">


        {{-- =====================================================
            TOTAL LITERATUR
        ====================================================== --}}
        <div class="stat-card group">

            <div class="relative z-10 rounded-[14px] bg-[#212A37] p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-sm font-medium text-slate-300">
                            Total Literatur
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-white">

                            @if ($literatureCount >= 1000000)

                                {{ rtrim(rtrim(number_format($literatureCount / 1000000, 1, ',', ''), '0'), ',') }}M

                            @elseif ($literatureCount >= 1000)

                                {{ rtrim(rtrim(number_format($literatureCount / 1000, 1, ',', ''), '0'), ',') }}K

                            @else

                                {{ $literatureCount }}

                            @endif

                        </p>

                    </div>


                    {{-- Icon --}}
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-xl
                               bg-white/10
                               text-white
                               ring-1 ring-inset ring-white/10
                               transition-all duration-300
                               group-hover:scale-110
                               group-hover:bg-white
                               group-hover:text-[#212A37]">

                        <span class="material-symbols-outlined">
                            library_books
                        </span>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="mt-5 flex items-center gap-2">

                    <span
                        class="h-1.5 w-1.5 rounded-full
                               bg-white/70
                               transition-transform duration-300
                               group-hover:scale-150">
                    </span>

                    <p class="text-xs font-medium text-slate-400">
                        Seluruh koleksi literatur
                    </p>

                </div>

            </div>

        </div>



        {{-- =====================================================
            TOTAL KATEGORI
        ====================================================== --}}
        <div class="stat-card group">

            <div class="relative z-10 rounded-[14px] bg-[#212A37] p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-sm font-medium text-slate-300">
                            Total Kategori
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-white">

                            @if ($categoryCount >= 1000000)

                                {{ rtrim(rtrim(number_format($categoryCount / 1000000, 1, ',', ''), '0'), ',') }}M

                            @elseif ($categoryCount >= 1000)

                                {{ rtrim(rtrim(number_format($categoryCount / 1000, 1, ',', ''), '0'), ',') }}K

                            @else

                                {{ $categoryCount }}

                            @endif

                        </p>

                    </div>


                    {{-- Icon --}}
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-xl
                               bg-white/10
                               text-white
                               ring-1 ring-inset ring-white/10
                               transition-all duration-300
                               group-hover:scale-110
                               group-hover:bg-white
                               group-hover:text-[#212A37]">

                        <span class="material-symbols-outlined">
                            category
                        </span>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="mt-5 flex items-center gap-2">

                    <span
                        class="h-1.5 w-1.5 rounded-full
                               bg-white/70
                               transition-transform duration-300
                               group-hover:scale-150">
                    </span>

                    <p class="text-xs font-medium text-slate-400">
                        Kategori literatur tersedia
                    </p>

                </div>

            </div>

        </div>



        {{-- =====================================================
            TOTAL KBK
        ====================================================== --}}
        <div class="stat-card group">

            <div class="relative z-10 rounded-[14px] bg-[#212A37] p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-sm font-medium text-slate-300">
                            Total KBK
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-white">

                            @if ($kbkCount >= 1000000)

                                {{ rtrim(rtrim(number_format($kbkCount / 1000000, 1, ',', ''), '0'), ',') }}M

                            @elseif ($kbkCount >= 1000)

                                {{ rtrim(rtrim(number_format($kbkCount / 1000, 1, ',', ''), '0'), ',') }}K

                            @else

                                {{ $kbkCount }}

                            @endif

                        </p>

                    </div>


                    {{-- Icon --}}
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-xl
                               bg-white/10
                               text-white
                               ring-1 ring-inset ring-white/10
                               transition-all duration-300
                               group-hover:scale-110
                               group-hover:bg-white
                               group-hover:text-[#212A37]">

                        <span class="material-symbols-outlined">
                            school
                        </span>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="mt-5 flex items-center gap-2">

                    <span
                        class="h-1.5 w-1.5 rounded-full
                               bg-white/70
                               transition-transform duration-300
                               group-hover:scale-150">
                    </span>

                    <p class="text-xs font-medium text-slate-400">
                        Kompetensi Bidang Keahlian
                    </p>

                </div>

            </div>

        </div>



        {{-- =====================================================
            ANGGOTA TERDAFTAR
        ====================================================== --}}
        <div class="stat-card group">

            <div class="relative z-10 rounded-[14px] bg-[#212A37] p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-sm font-medium text-slate-300">
                            Anggota Terdaftar
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-white">

                            @if ($userCount >= 1000000)

                                {{ rtrim(rtrim(number_format($userCount / 1000000, 1, ',', ''), '0'), ',') }}M

                            @elseif ($userCount >= 1000)

                                {{ rtrim(rtrim(number_format($userCount / 1000, 1, ',', ''), '0'), ',') }}K

                            @else

                                {{ $userCount }}

                            @endif

                        </p>

                    </div>


                    {{-- Icon --}}
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-xl
                               bg-white/10
                               text-white
                               ring-1 ring-inset ring-white/10
                               transition-all duration-300
                               group-hover:scale-110
                               group-hover:bg-white
                               group-hover:text-[#212A37]">

                        <span class="material-symbols-outlined">
                            group
                        </span>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="mt-5 flex items-center gap-2">

                    <span
                        class="h-1.5 w-1.5 rounded-full
                               bg-white/70
                               transition-transform duration-300
                               group-hover:scale-150">
                    </span>

                    <p class="text-xs font-medium text-slate-400">
                        Pengguna SIPERPUS
                    </p>

                </div>

            </div>

        </div>



        {{-- =====================================================
            REPOSITORY AKTIF (KELOLA PASCASARJANA)
        ====================================================== --}}
        <div class="stat-card group">

            <div class="relative z-10 rounded-[14px] bg-[#212A37] p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-sm font-medium text-slate-300">
                            Repository Aktif
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-white">

                            @if ($repositoryActiveCount >= 1000000)

                                {{ rtrim(rtrim(number_format($repositoryActiveCount / 1000000, 1, ',', ''), '0'), ',') }}M

                            @elseif ($repositoryActiveCount >= 1000)

                                {{ rtrim(rtrim(number_format($repositoryActiveCount / 1000, 1, ',', ''), '0'), ',') }}K

                            @else

                                {{ $repositoryActiveCount }}

                            @endif

                        </p>

                    </div>


                    {{-- Icon --}}
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-xl
                               bg-white/10
                               text-white
                               ring-1 ring-inset ring-white/10
                               transition-all duration-300
                               group-hover:scale-110
                               group-hover:bg-white
                               group-hover:text-[#212A37]">

                        <span class="material-symbols-outlined">
                            task_alt
                        </span>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="mt-5 flex items-center gap-2">

                    <span
                        class="h-1.5 w-1.5 rounded-full
                               bg-white/70
                               transition-transform duration-300
                               group-hover:scale-150">
                    </span>

                    <p class="text-xs font-medium text-slate-400">
                        Repository tesis &amp; disertasi aktif
                    </p>

                </div>

            </div>

        </div>



        {{-- =====================================================
            TOTAL KELOMPOK PRAKTIK INDUSTRI
        ====================================================== --}}
        <div class="stat-card group">

            <div class="relative z-10 rounded-[14px] bg-[#212A37] p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p class="text-sm font-medium text-slate-300">
                            Total Kelompok
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-white">

                            @if ($totalKelompokPraktikIndustri >= 1000000)

                                {{ rtrim(rtrim(number_format($totalKelompokPraktikIndustri / 1000000, 1, ',', ''), '0'), ',') }}M

                            @elseif ($totalKelompokPraktikIndustri >= 1000)

                                {{ rtrim(rtrim(number_format($totalKelompokPraktikIndustri / 1000, 1, ',', ''), '0'), ',') }}K

                            @else

                                {{ $totalKelompokPraktikIndustri }}

                            @endif

                        </p>

                    </div>


                    {{-- Icon --}}
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-xl
                               bg-white/10
                               text-white
                               ring-1 ring-inset ring-white/10
                               transition-all duration-300
                               group-hover:scale-110
                               group-hover:bg-white
                               group-hover:text-[#212A37]">

                        <span class="material-symbols-outlined">
                            groups
                        </span>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="mt-5 flex items-center gap-2">

                    <span
                        class="h-1.5 w-1.5 rounded-full
                               bg-white/70
                               transition-transform duration-300
                               group-hover:scale-150">
                    </span>

                    <p class="text-xs font-medium text-slate-400">
                        Kelompok Praktik Industri
                    </p>

                </div>

            </div>

        </div>


    </div>

</section>