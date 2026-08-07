{{-- =========================================================
    STATISTICS
========================================================== --}}

<style>
    .stat-card {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 2px;
        border-radius: 1rem;
        background: #e2e8f0;

        transition:
            transform 0.48s cubic-bezier(0.23, 1, 0.32, 1),
            box-shadow 0.48s cubic-bezier(0.23, 1, 0.32, 1);
    }

    /* Rotating border */
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
            #2563eb 170deg,
            #2563eb 200deg,
            transparent 280deg,
            transparent 360deg
        );

        transform: translate(-50%, -50%) rotate(0deg);

        opacity: 0;

        animation: stat-border-spin 3s linear infinite;
        animation-play-state: paused;

        transition: opacity 0.3s ease;
    }

    /* Card background */
    .stat-card::after {
        content: "";
        position: absolute;
        z-index: -1;

        inset: 2px;

        border-radius: calc(1rem - 2px);
        background: #ffffff;
    }

    /* Hover */
    .stat-card:hover::before {
        opacity: 1;
        animation-play-state: running;
    }

    .stat-card:hover {
        transform: translateY(-5px) scale(1.015);

        box-shadow:
            0 8px 20px rgba(37, 99, 235, 0.16),
            0 20px 40px rgba(15, 23, 42, 0.06);
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

    <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">


        {{-- Total Literatur --}}
        <div class="stat-card group">

            <div class="relative z-10 rounded-[14px] bg-white p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Literatur
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">
                            @if ($literatureCount >= 1000000)
                                {{ rtrim(rtrim(number_format($literatureCount / 1000000, 1, ',', ''), '0'), ',') }}M
                            @elseif ($literatureCount >= 1000)
                                {{ rtrim(rtrim(number_format($literatureCount / 1000, 1, ',', ''), '0'), ',') }}K
                            @else
                                {{ $literatureCount }}
                            @endif
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-xl bg-blue-50 text-blue-600
                               transition-all duration-300
                               group-hover:scale-110
                               group-hover:bg-blue-600
                               group-hover:text-white">

                        <span class="material-symbols-outlined">
                            library_books
                        </span>

                    </div>

                </div>

                <div class="mt-5 flex items-center gap-2">

                    <span
                        class="h-1.5 w-1.5 rounded-full bg-blue-500
                               transition-transform duration-300
                               group-hover:scale-150">
                    </span>

                    <p class="text-xs font-medium text-slate-400">
                        Seluruh koleksi literatur
                    </p>

                </div>

            </div>

        </div>


        {{-- Total Kategori --}}
        <div class="stat-card group">

            <div class="relative z-10 rounded-[14px] bg-white p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total Kategori
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">
                            @if ($categoryCount >= 1000000)
                                {{ rtrim(rtrim(number_format($categoryCount / 1000000, 1, ',', ''), '0'), ',') }}M
                            @elseif ($categoryCount >= 1000)
                                {{ rtrim(rtrim(number_format($categoryCount / 1000, 1, ',', ''), '0'), ',') }}K
                            @else
                                {{ $categoryCount }}
                            @endif
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-xl bg-blue-50 text-blue-600
                               transition-all duration-300
                               group-hover:scale-110
                               group-hover:bg-blue-600
                               group-hover:text-white">

                        <span class="material-symbols-outlined">
                            category
                        </span>

                    </div>

                </div>

                <div class="mt-5 flex items-center gap-2">

                    <span
                        class="h-1.5 w-1.5 rounded-full bg-blue-500
                               transition-transform duration-300
                               group-hover:scale-150">
                    </span>

                    <p class="text-xs font-medium text-slate-400">
                        Kategori literatur tersedia
                    </p>

                </div>

            </div>

        </div>


        {{-- Total KBK --}}
        <div class="stat-card group">

            <div class="relative z-10 rounded-[14px] bg-white p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Total KBK
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">
                            @if ($kbkCount >= 1000000)
                                {{ rtrim(rtrim(number_format($kbkCount / 1000000, 1, ',', ''), '0'), ',') }}M
                            @elseif ($kbkCount >= 1000)
                                {{ rtrim(rtrim(number_format($kbkCount / 1000, 1, ',', ''), '0'), ',') }}K
                            @else
                                {{ $kbkCount }}
                            @endif
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-xl bg-blue-50 text-blue-600
                               transition-all duration-300
                               group-hover:scale-110
                               group-hover:bg-blue-600
                               group-hover:text-white">

                        <span class="material-symbols-outlined">
                            school
                        </span>

                    </div>

                </div>

                <div class="mt-5 flex items-center gap-2">

                    <span
                        class="h-1.5 w-1.5 rounded-full bg-blue-500
                               transition-transform duration-300
                               group-hover:scale-150">
                    </span>

                    <p class="text-xs font-medium text-slate-400">
                        Kompetensi Bidang Keahlian
                    </p>

                </div>

            </div>

        </div>


        {{-- Anggota Terdaftar --}}
        <div class="stat-card group">

            <div class="relative z-10 rounded-[14px] bg-white p-6">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Anggota Terdaftar
                        </p>

                        <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">
                            @if ($userCount >= 1000000)
                                {{ rtrim(rtrim(number_format($userCount / 1000000, 1, ',', ''), '0'), ',') }}M
                            @elseif ($userCount >= 1000)
                                {{ rtrim(rtrim(number_format($userCount / 1000, 1, ',', ''), '0'), ',') }}K
                            @else
                                {{ $userCount }}
                            @endif
                        </p>
                    </div>

                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-xl bg-blue-50 text-blue-600
                               transition-all duration-300
                               group-hover:scale-110
                               group-hover:bg-blue-600
                               group-hover:text-white">

                        <span class="material-symbols-outlined">
                            group
                        </span>

                    </div>

                </div>

                <div class="mt-5 flex items-center gap-2">

                    <span
                        class="h-1.5 w-1.5 rounded-full bg-blue-500
                               transition-transform duration-300
                               group-hover:scale-150">
                    </span>

                    <p class="text-xs font-medium text-slate-400">
                        Pengguna SIPERPUS
                    </p>

                </div>

            </div>

        </div>


    </div>

</section>