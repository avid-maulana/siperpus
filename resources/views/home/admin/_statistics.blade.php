{{-- Statistics --}}
<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

    {{-- Total Literatur --}}
    <div
        class="group relative overflow-hidden rounded-2xl
               border border-slate-200 bg-white p-6
               shadow-sm transition-all duration-300
               hover:-translate-y-1 hover:border-blue-200
               hover:shadow-lg">

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
                       group-hover:bg-blue-600 group-hover:text-white">

                <span class="material-symbols-outlined">
                    library_books
                </span>

            </div>

        </div>

        <div class="mt-5 flex items-center gap-2">

            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span>

            <p class="text-xs font-medium text-slate-400">
                Seluruh koleksi literatur
            </p>

        </div>

    </div>


    {{-- Total Kategori --}}
    <div
        class="group relative overflow-hidden rounded-2xl
               border border-slate-200 bg-white p-6
               shadow-sm transition-all duration-300
               hover:-translate-y-1 hover:border-emerald-200
               hover:shadow-lg">

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
                       rounded-xl bg-emerald-50 text-emerald-600
                       transition-all duration-300
                       group-hover:bg-emerald-600 group-hover:text-white">

                <span class="material-symbols-outlined">
                    category
                </span>

            </div>

        </div>

        <div class="mt-5 flex items-center gap-2">

            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

            <p class="text-xs font-medium text-slate-400">
                Kategori literatur tersedia
            </p>

        </div>

    </div>


    {{-- Total KBK --}}
    <div
        class="group relative overflow-hidden rounded-2xl
               border border-slate-200 bg-white p-6
               shadow-sm transition-all duration-300
               hover:-translate-y-1 hover:border-violet-200
               hover:shadow-lg">

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
                       rounded-xl bg-violet-50 text-violet-600
                       transition-all duration-300
                       group-hover:bg-violet-600 group-hover:text-white">

                <span class="material-symbols-outlined">
                    school
                </span>

            </div>

        </div>

        <div class="mt-5 flex items-center gap-2">

            <span class="h-1.5 w-1.5 rounded-full bg-violet-500"></span>

            <p class="text-xs font-medium text-slate-400">
                Kompetensi Bidang Keahlian
            </p>

        </div>

    </div>


    {{-- Anggota Terdaftar --}}
    <div
        class="group relative overflow-hidden rounded-2xl
               border border-slate-200 bg-white p-6
               shadow-sm transition-all duration-300
               hover:-translate-y-1 hover:border-amber-200
               hover:shadow-lg">

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
                       rounded-xl bg-amber-50 text-amber-600
                       transition-all duration-300
                       group-hover:bg-amber-500 group-hover:text-white">

                <span class="material-symbols-outlined">
                    group
                </span>

            </div>

        </div>

        <div class="mt-5 flex items-center gap-2">

            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

            <p class="text-xs font-medium text-slate-400">
                Pengguna SIPERPUS
            </p>

        </div>

    </div>

</div>