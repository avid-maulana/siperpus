{{-- =============================================================
    LOGIN ACTIVITY
============================================================= --}}

<div
    id="loginActivity"
    class="flex h-full flex-col
           rounded-2xl border border-slate-200
           bg-white shadow-sm">

    {{-- =========================================================
        HEADER
    ========================================================== --}}
    <div
        class="flex items-start justify-between gap-4
               border-b border-slate-100
               px-6 py-5">

        <div class="min-w-0">

            <h2 class="font-semibold text-slate-900">
                Aktivitas Login
            </h2>

            <p class="mt-1 text-xs text-slate-400">
                Pengguna yang terakhir masuk ke SIPERPUS.
            </p>

        </div>


        <div
            class="flex h-10 w-10 shrink-0
                   items-center justify-center
                   rounded-xl bg-blue-50
                   text-blue-600">

            <span class="material-symbols-outlined text-[20px]">
                login
            </span>

        </div>

    </div>


    {{-- =========================================================
        LOGIN LIST
    ========================================================== --}}
    <div class="flex-1">

        @forelse ($latestLoginActivities as $activity)

            @php
                $name = $activity->nama_lengkap ?? 'Pengguna tidak ditemukan';

                /*
                |--------------------------------------------------------------------------
                | Initial
                |--------------------------------------------------------------------------
                */

                $words = preg_split('/\s+/', trim($name));

                $initial = collect($words)
                    ->filter()
                    ->take(2)
                    ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
                    ->implode('');


                /*
                |--------------------------------------------------------------------------
                | Date
                |--------------------------------------------------------------------------
                */

                $loginDate = $activity->created_at
                    ? \Carbon\Carbon::parse($activity->created_at)
                    : null;
            @endphp


            <div
                class="group flex items-center gap-4
                       border-b border-slate-100
                       px-6 py-4
                       transition-colors duration-200
                       last:border-b-0
                       hover:bg-slate-50/70">

                {{-- Avatar --}}
                <div
                    class="flex h-10 w-10 shrink-0
                           items-center justify-center
                           rounded-full
                           bg-blue-50
                           text-xs font-semibold
                           text-blue-600">

                    {{ $initial ?: '?' }}

                </div>


                {{-- User --}}
                <div class="min-w-0 flex-1">

                    <p
                        class="truncate text-sm font-semibold
                               text-slate-700"
                        title="{{ $name }}">

                        {{ ucwords(strtolower($name)) }}

                    </p>


                    <div
                        class="mt-1 flex flex-wrap
                               items-center gap-x-2 gap-y-1">

                        @if (!empty($activity->nomor_induk))

                            <span class="text-xs text-slate-400">
                                {{ $activity->nomor_induk }}
                            </span>

                            <span
                                class="h-1 w-1 rounded-full
                                       bg-slate-300">
                            </span>

                        @endif


                        <span
                            class="inline-flex items-center gap-1
                                   text-xs text-emerald-600">

                            <span
                                class="h-1.5 w-1.5
                                       rounded-full bg-emerald-500">
                            </span>

                            Login

                        </span>

                    </div>

                </div>


                {{-- Time --}}
                <div class="shrink-0 text-right">

                    @if ($loginDate)

                        <p
                            class="text-xs font-medium
                                   text-slate-600">

                            {{ $loginDate->format('H:i') }}

                        </p>

                        <p
                            class="mt-1 text-[11px]
                                   text-slate-400">

                            @if ($loginDate->isToday())

                                Hari ini

                            @elseif ($loginDate->isYesterday())

                                Kemarin

                            @else

                                {{ $loginDate->translatedFormat('d M') }}

                            @endif

                        </p>

                    @else

                        <span class="text-xs text-slate-400">
                            -
                        </span>

                    @endif

                </div>

            </div>

        @empty

            {{-- Empty State --}}
            <div
                class="flex min-h-[280px]
                       flex-col items-center
                       justify-center
                       px-6 py-10
                       text-center">

                <div
                    class="flex h-12 w-12
                           items-center justify-center
                           rounded-full bg-slate-100
                           text-slate-400">

                    <span
                        class="material-symbols-outlined
                               text-[24px]">
                        history
                    </span>

                </div>

                <p
                    class="mt-3 text-sm font-medium
                           text-slate-600">
                    Belum ada aktivitas login
                </p>

                <p
                    class="mt-1 text-xs
                           text-slate-400">
                    Aktivitas pengguna akan tampil di sini.
                </p>

            </div>

        @endforelse

    </div>


    {{-- =========================================================
        FOOTER
    ========================================================== --}}
    <div
        class="border-t border-slate-100
               px-6 py-4">

        <button
            type="button"
            id="openLoginActivityModal"
            class="inline-flex w-full
                   items-center justify-center
                   gap-1.5 rounded-lg
                   border border-transparent
                   px-3 py-2
                   text-xs font-medium
                   text-blue-600
                   transition-all duration-200
                   hover:border-blue-600
                   hover:bg-blue-600
                   hover:text-white
                   active:scale-[0.98]">

            <span>
                Lihat Semua Aktivitas
            </span>

            <span
                class="material-symbols-outlined
                       text-[16px]"
                style="font-variation-settings: 'wght' 300;">
                open_in_new
            </span>

        </button>

    </div>

</div>



{{-- =============================================================
    LOGIN ACTIVITY MODAL
============================================================= --}}

<div
    id="loginActivityModal"
    class="fixed inset-0 z-[9999]
           hidden items-center justify-center
           overflow-y-auto
           bg-slate-950/0
           px-4 py-6
           opacity-0
           backdrop-blur-none
           transition-all duration-300 ease-out">

    {{-- Modal Card --}}
    <div
        id="loginActivityModalCard"
        class="relative flex
               max-h-[85vh]
               w-full max-w-4xl
               flex-col overflow-hidden
               rounded-2xl
               border border-slate-200
               bg-white
               shadow-2xl
               opacity-0
               scale-95
               translate-y-4
               transition-all duration-300 ease-out">


        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div
            class="flex shrink-0
                   items-start justify-between
                   gap-4
                   border-b border-slate-100
                   px-6 py-5">

            <div class="min-w-0">

                <p
                    class="text-[10px] font-semibold
                           uppercase tracking-[0.16em]
                           text-blue-600">
                    SIPERPUS DTEI
                </p>

                <h3
                    class="mt-1 text-lg font-semibold
                           text-slate-900">
                    Riwayat Aktivitas
                </h3>

                <p
                    class="mt-1 text-xs
                           text-slate-400">
                    Aktivitas login dan logout selama 14 hari terakhir.
                </p>

            </div>


            {{-- Close --}}
            <button
                type="button"
                data-close-login-modal
                title="Tutup"
                class="flex h-9 w-9 shrink-0
                       items-center justify-center
                       rounded-lg
                       border border-transparent
                       text-slate-400
                       transition-all duration-200
                       hover:border-slate-200
                       hover:bg-slate-100
                       hover:text-slate-700">

                <span
                    class="material-symbols-outlined text-[20px]"
                    style="font-variation-settings: 'wght' 300;">
                    close
                </span>

            </button>

        </div>


        {{-- =====================================================
            SUMMARY
        ====================================================== --}}
        <div
            class="grid shrink-0
                   grid-cols-2
                   border-b border-slate-100
                   bg-slate-50/70">

            {{-- Total Activity --}}
            <div
                class="border-r border-slate-100
                       px-6 py-4">

                <p
                    class="text-[10px] font-semibold
                           uppercase tracking-wider
                           text-slate-400">
                    Total Aktivitas
                </p>

                <p
                    class="mt-1 text-xl font-bold
                           text-slate-900">
                    {{ number_format($loginActivities->count(), 0, ',', '.') }}
                </p>

            </div>


            {{-- Login --}}
            <div class="px-6 py-4">

                <p
                    class="text-[10px] font-semibold
                           uppercase tracking-wider
                           text-slate-400">
                    Total Login
                </p>

                <p
                    class="mt-1 text-xl font-bold
                           text-slate-900">
                    {{ number_format(
                        $loginActivities->where('status', 0)->count(),
                        0,
                        ',',
                        '.'
                    ) }}
                </p>

            </div>

        </div>


        {{-- =====================================================
            TABLE HEADER
        ====================================================== --}}
        <div
            class="hidden shrink-0
                   grid-cols-[minmax(0,1fr)_100px_150px_130px]
                   gap-4
                   border-b border-slate-100
                   bg-white
                   px-6 py-3
                   md:grid">

            <p
                class="text-[10px] font-semibold
                       uppercase tracking-wider
                       text-slate-400">
                Pengguna
            </p>

            <p
                class="text-[10px] font-semibold
                       uppercase tracking-wider
                       text-slate-400">
                Status
            </p>

            <p
                class="text-[10px] font-semibold
                       uppercase tracking-wider
                       text-slate-400">
                IP
            </p>

            <p
                class="text-right
                       text-[10px] font-semibold
                       uppercase tracking-wider
                       text-slate-400">
                Waktu
            </p>

        </div>


        {{-- =====================================================
            ACTIVITY CONTENT
        ====================================================== --}}
        <div
            class="min-h-0 flex-1
                   overflow-y-auto">

            @forelse ($loginActivities as $activity)

                @php
                    $name = $activity->nama_lengkap
                        ?? 'Pengguna tidak ditemukan';

                    $activityDate = $activity->created_at
                        ? \Carbon\Carbon::parse($activity->created_at)
                        : null;

                    $isLogin = (int) $activity->status === 0;
                @endphp


                <div
                    class="grid gap-3
                           border-b border-slate-100
                           px-6 py-4
                           last:border-b-0
                           hover:bg-slate-50/70
                           md:grid-cols-[minmax(0,1fr)_100px_150px_130px]
                           md:items-center md:gap-4">

                    {{-- User --}}
                    <div class="min-w-0">

                        <p
                            class="truncate
                                   text-sm font-semibold
                                   text-slate-700"
                            title="{{ $name }}">

                            {{ ucwords(strtolower($name)) }}

                        </p>

                        @if (!empty($activity->nomor_induk))

                            <p
                                class="mt-1 truncate
                                       text-xs text-slate-400">
                                {{ $activity->nomor_induk }}
                            </p>

                        @endif

                    </div>


                    {{-- Status --}}
                    <div>

                        @if ($isLogin)

                            <span
                                class="inline-flex items-center
                                       gap-1.5 rounded-full
                                       bg-emerald-50
                                       px-2.5 py-1
                                       text-[11px] font-medium
                                       text-emerald-600">

                                <span
                                    class="h-1.5 w-1.5
                                           rounded-full
                                           bg-emerald-500">
                                </span>

                                Login

                            </span>

                        @else

                            <span
                                class="inline-flex items-center
                                       gap-1.5 rounded-full
                                       bg-slate-100
                                       px-2.5 py-1
                                       text-[11px] font-medium
                                       text-slate-500">

                                <span
                                    class="h-1.5 w-1.5
                                           rounded-full
                                           bg-slate-400">
                                </span>

                                Logout

                            </span>

                        @endif

                    </div>


                    {{-- IP --}}
                    <div
                        class="min-w-0
                               text-xs text-slate-500">

                        <span
                            class="md:hidden
                                   text-slate-400">
                            IP:
                        </span>

                        <span
                            class="font-mono"
                            title="{{ $activity->ip_pengakses ?? '-' }}">

                            {{ $activity->ip_pengakses ?? '-' }}

                        </span>

                    </div>


                    {{-- Time --}}
                    <div class="md:text-right">

                        @if ($activityDate)

                            <p
                                class="text-xs font-medium
                                       text-slate-600">

                                {{ $activityDate->translatedFormat('d M Y') }}

                            </p>

                            <p
                                class="mt-1 text-[11px]
                                       text-slate-400">

                                {{ $activityDate->format('H:i:s') }}

                            </p>

                        @else

                            <span class="text-xs text-slate-400">
                                -
                            </span>

                        @endif

                    </div>

                </div>

            @empty

                <div
                    class="flex min-h-[260px]
                           flex-col items-center
                           justify-center
                           px-6 py-10
                           text-center">

                    <span
                        class="material-symbols-outlined
                               text-4xl text-slate-300">
                        history
                    </span>

                    <p
                        class="mt-3 text-sm font-medium
                               text-slate-500">
                        Belum ada aktivitas
                    </p>

                    <p
                        class="mt-1 text-xs
                               text-slate-400">
                        Tidak ada aktivitas selama 14 hari terakhir.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- =====================================================
            FOOTER
        ====================================================== --}}
        <div
            class="flex shrink-0
                   items-center justify-between
                   gap-4
                   border-t border-slate-100
                   bg-slate-50/60
                   px-6 py-4">

            <p
                class="hidden text-xs
                       text-slate-400
                       sm:block">
                Klik di luar popup untuk menutup.
            </p>


            <button
                type="button"
                data-close-login-modal
                class="ml-auto inline-flex
                       items-center gap-1.5
                       rounded-lg
                       border border-slate-300
                       bg-white
                       px-4 py-2
                       text-xs font-medium
                       text-slate-700
                       shadow-sm
                       transition-all duration-200
                       hover:border-slate-400
                       hover:bg-slate-100">

                <span
                    class="material-symbols-outlined
                           text-[16px]"
                    style="font-variation-settings: 'wght' 300;">
                    close
                </span>

                Tutup

            </button>

        </div>

    </div>

</div>