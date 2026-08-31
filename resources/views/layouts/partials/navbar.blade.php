{{-- ================================================================
    LOGOUT LOADING OVERLAY
================================================================ --}}

<div id="logoutLoadingOverlay"
    class="fixed inset-0 z-[60] hidden items-center justify-center
           bg-slate-950/70 backdrop-blur-sm
           opacity-0 transition-opacity duration-300">

    <div
        class="flex flex-col items-center
               rounded-3xl
               border border-white/10
               bg-white/95
               px-8 py-7
               shadow-2xl">

        <div
            class="h-12 w-12
                   animate-spin
                   rounded-full
                   border-4
                   border-slate-200
                   border-t-[#212A37]">
        </div>

        <p class="mt-4
                  text-sm
                  font-semibold
                  text-slate-700">
            Sedang keluar...
        </p>

    </div>

</div>


{{-- ================================================================
    NAVBAR
================================================================ --}}

<header id="navbar"
    class="fixed left-0 top-0 z-50 w-full
           border-b
           border-transparent
           bg-[#212A37]
           transition-all
           duration-300
           ease-in-out
           [&.scrolled]:border-slate-700/50
           [&.scrolled]:shadow-lg">

    <div
        class="mx-auto flex h-20 max-w-7xl
               items-center
               justify-between
               px-6
               lg:px-8">

        {{-- ========================================================
            LOGO
        ========================================================= --}}

        <a href="{{ route('home') }}" class="flex items-center gap-3">

            <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">

            <div class="hidden leading-tight sm:block">

                <h1
                    class="text-sm
                           font-bold
                           tracking-wide
                           text-white">
                    PERPUSTAKAAN
                </h1>

                <p class="text-[11px]
                          text-slate-300">
                    Departemen Teknik Elektro dan Informatika
                </p>

            </div>

        </a>


        {{-- ========================================================
            DESKTOP MENU
        ========================================================= --}}

        <nav class="hidden items-center md:flex">

            @auth

                <div class="flex items-center gap-10">

                    {{-- =================================================
                        HOME
                    ================================================== --}}

                    @php
                        $activeHome = request()->routeIs('home');
                    @endphp

                    <a href="{{ route('home') }}"
                        class="group relative flex h-[72px]
                               items-center
                               text-[16px]
                               font-medium
                               transition-colors
                               duration-300
                               {{ $activeHome ? 'text-white' : 'text-slate-300 hover:text-white' }}">

                        Home

                        <span
                            class="absolute bottom-0 left-1/2
                                   h-[3px] w-0
                                   -translate-x-1/2
                                   rounded-full
                                   bg-white
                                   transition-all
                                   duration-300
                                   ease-out
                                   {{ $activeHome
                                       ? '!left-0 !w-full !translate-x-0'
                                       : 'group-hover:left-0
                                          group-hover:w-full
                                          group-hover:translate-x-0' }}">
                        </span>

                    </a>

                    @if (Auth::user()->level == 6)
                        {{-- =================================================
                            MANAGE ADMIN (HANYA ADMIN)
                        ================================================== --}}
                        @php
                            $manageActive =
                                request()->routeIs('library.index') ||
                                request()->routeIs('library.indexLiterature') ||
                                request()->routeIs('library.repositories') ||
                                request()->routeIs('library.praktik-industri');
                        @endphp

                        <div id="manageMenuWrapper"
                            class="group/manage relative
                                   flex h-[72px]
                                   items-center">

                            {{-- BUTTON --}}
                            <button id="manageMenuButton" type="button" aria-expanded="false" aria-haspopup="true"
                                class="group relative flex h-full
                                       items-center gap-2
                                       text-[16px]
                                       font-medium
                                       transition-colors
                                       duration-300
                                       {{ $manageActive ? 'text-white' : 'text-slate-300 hover:text-white' }}">

                                <span>
                                    Manage
                                </span>

                                {{-- ACTIVE LINE --}}
                                <span
                                    class="absolute bottom-0 left-1/2
                                           h-[3px] w-0
                                           -translate-x-1/2
                                           rounded-full
                                           bg-white
                                           transition-all
                                           duration-300
                                           ease-out
                                           {{ $manageActive
                                               ? '!left-0 !w-full !translate-x-0'
                                               : 'group-hover:left-0
                                                  group-hover:w-full
                                                  group-hover:translate-x-0' }}">
                                </span>
                            </button>

                            {{-- DROPDOWN --}}
                            <div id="manageDropdown"
                                class="invisible absolute
                                       left-1/2
                                       top-full
                                       z-50
                                       w-72
                                       -translate-x-1/2
                                       translate-y-2
                                       opacity-0
                                       transition-all
                                       duration-200
                                       ease-out
                                       group-hover/manage:visible
                                       group-hover/manage:translate-y-0
                                       group-hover/manage:opacity-100">

                                {{-- Hover bridge --}}
                                <div class="h-2"></div>

                                <div
                                    class="rounded-2xl
                                           border border-slate-200
                                           bg-white
                                           p-1.5
                                           shadow-xl
                                           shadow-slate-950/10">

                                    {{-- KELOLA LITERATUR --}}
                                    <a href="{{ route('library.indexLiterature') }}"
                                        class="flex items-center gap-3
                                               rounded-xl
                                               px-3 py-2.5
                                               text-sm
                                               transition-colors
                                               duration-200
                                               {{ request()->routeIs('library.indexLiterature')
                                                   ? 'bg-slate-100 font-semibold text-slate-900'
                                                   : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">

                                        <span class="material-symbols-outlined text-[20px]">library_books</span>
                                        <span>Kelola Literatur</span>
                                    </a>

                                    {{-- KELOLA TIPE --}}
                                    <a href="{{ route('library.index') }}"
                                        class="flex items-center gap-3
                                               rounded-xl
                                               px-3 py-2.5
                                               text-sm
                                               transition-colors
                                               duration-200
                                               {{ request()->routeIs('library.index')
                                                   ? 'bg-slate-100 font-semibold text-slate-900'
                                                   : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">

                                        <span class="material-symbols-outlined text-[20px]">category</span>
                                        <span>Kelola Tipe</span>
                                    </a>

                                    {{-- KELOLA PASCASARJANA --}}
                                    <a href="{{ route('library.repositories') }}"
                                        class="flex items-center gap-3
                                               rounded-xl
                                               px-3 py-2.5
                                               text-sm
                                               transition-colors
                                               duration-200
                                               {{ request()->routeIs('library.repositories')
                                                   ? 'bg-slate-100 font-semibold text-slate-900'
                                                   : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">

                                        <span class="material-symbols-outlined text-[20px]">school</span>
                                        <span class="flex-1">Kelola Pascasarjana</span>

                                        @if (($pascasarjanaBadgeCount ?? 0) > 0)
                                            <span
                                                class="inline-flex h-5 min-w-[20px]
                                                       shrink-0
                                                       items-center justify-center
                                                       rounded-full
                                                       bg-red-500
                                                       px-1.5
                                                       text-[10px]
                                                       font-bold
                                                       text-white">
                                                {{ $pascasarjanaBadgeCount > 99 ? '99+' : $pascasarjanaBadgeCount }}
                                            </span>
                                        @endif
                                    </a>

                                    {{-- KELOLA PRAKTIK INDUSTRI --}}
                                    <a href="{{ route('library.praktik-industri') }}"
                                        class="flex items-center gap-3
                                               rounded-xl
                                               px-3 py-2.5
                                               text-sm
                                               transition-colors
                                               duration-200
                                               {{ request()->routeIs('library.praktik-industri')
                                                   ? 'bg-slate-100 font-semibold text-slate-900'
                                                   : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">

                                        <span class="material-symbols-outlined text-[20px]">business_center</span>
                                        <span>Kelola Praktik Industri</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- =================================================
                            TAMPILAN USER DROPDOWN (HANYA ADMIN)
                        ================================================== --}}
                        @php
                            $activeUserView =
                                request()->routeIs('literatures.index') ||
                                request()->routeIs('praktik-industri.index') ||
                                request()->routeIs('skripsi.index') ||
                                request()->routeIs('tesis.index') ||
                                request()->routeIs('disertasi.index');
                        @endphp

                        <div id="userViewMenuWrapper"
                            class="group/userview relative
                                   flex h-[72px]
                                   items-center">

                            {{-- BUTTON --}}
                            <button id="userViewMenuButton" type="button" aria-expanded="false" aria-haspopup="true"
                                class="group relative flex h-full
                                       items-center gap-2
                                       text-[16px]
                                       font-medium
                                       transition-colors
                                       duration-300
                                       {{ $activeUserView ? 'text-white' : 'text-slate-300 hover:text-white' }}">

                                <span>
                                    Tampilan User
                                </span>

                                {{-- ACTIVE LINE --}}
                                <span
                                    class="absolute bottom-0 left-1/2
                                           h-[3px] w-0
                                           -translate-x-1/2
                                           rounded-full
                                           bg-white
                                           transition-all
                                           duration-300
                                           ease-out
                                           {{ $activeUserView
                                               ? '!left-0 !w-full !translate-x-0'
                                               : 'group-hover:left-0
                                                  group-hover:w-full
                                                  group-hover:translate-x-0' }}">
                                </span>
                            </button>

                            {{-- DROPDOWN --}}
                            <div id="userViewDropdown"
                                class="invisible absolute
                                       left-1/2
                                       top-full
                                       z-50
                                       w-56
                                       -translate-x-1/2
                                       translate-y-2
                                       opacity-0
                                       transition-all
                                       duration-200
                                       ease-out
                                       group-hover/userview:visible
                                       group-hover/userview:translate-y-0
                                       group-hover/userview:opacity-100">

                                {{-- Hover bridge --}}
                                <div class="h-2"></div>

                                <div
                                    class="rounded-2xl
                                           border border-slate-200
                                           bg-white
                                           p-1.5
                                           shadow-xl
                                           shadow-slate-950/10">

                                    {{-- LITERATUR --}}
                                    <a href="{{ route('literatures.index') }}"
                                        class="flex items-center gap-3
                                               rounded-xl
                                               px-3 py-2.5
                                               text-sm
                                               transition-colors
                                               duration-200
                                               {{ request()->routeIs('literatures.index')
                                                   ? 'bg-slate-100 font-semibold text-slate-900'
                                                   : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">

                                        <span class="material-symbols-outlined text-[20px]">library_books</span>
                                        <span>Literatur</span>
                                    </a>

                                    {{-- PRAKTIK INDUSTRI --}}
                                    <a href="{{ route('praktik-industri.index') }}"
                                        class="flex items-center gap-3
                                               rounded-xl
                                               px-3 py-2.5
                                               text-sm
                                               transition-colors
                                               duration-200
                                               {{ request()->routeIs('praktik-industri.index')
                                                   ? 'bg-slate-100 font-semibold text-slate-900'
                                                   : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">

                                        <span class="material-symbols-outlined text-[20px]">business_center</span>
                                        <span>Praktik Industri</span>
                                    </a>

                                    {{-- SKRIPSI --}}
                                    <a href="{{ route('skripsi.index') }}"
                                        class="flex items-center gap-3
                                               rounded-xl
                                               px-3 py-2.5
                                               text-sm
                                               transition-colors
                                               duration-200
                                               {{ request()->routeIs('skripsi.index')
                                                   ? 'bg-slate-100 font-semibold text-slate-900'
                                                   : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">

                                        <span class="material-symbols-outlined text-[20px]">menu_book</span>
                                        <span>Skripsi</span>
                                    </a>

                                    {{-- TESIS --}}
                                    <a href="{{ route('tesis.index') }}"
                                        class="flex items-center gap-3
                                               rounded-xl
                                               px-3 py-2.5
                                               text-sm
                                               transition-colors
                                               duration-200
                                               {{ request()->routeIs('tesis.index')
                                                   ? 'bg-slate-100 font-semibold text-slate-900'
                                                   : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">

                                        <span class="material-symbols-outlined text-[20px]">description</span>
                                        <span>Tesis</span>
                                    </a>

                                    {{-- DISERTASI --}}
                                    <a href="{{ route('disertasi.index') }}"
                                        class="flex items-center gap-3
                                               rounded-xl
                                               px-3 py-2.5
                                               text-sm
                                               transition-colors
                                               duration-200
                                               {{ request()->routeIs('disertasi.index')
                                                   ? 'bg-slate-100 font-semibold text-slate-900'
                                                   : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">

                                        <span class="material-symbols-outlined text-[20px]">school</span>
                                        <span>Disertasi</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    @else
                        {{-- =================================================
                            TAMPILAN MENU REGULAR USER (TIDAK ADA DROPDOWN)
                        ================================================== --}}

                        {{-- LITERATUR --}}
                        @php
                            $activeLiteratur = request()->routeIs('literatures.index');
                        @endphp
                        <a href="{{ route('literatures.index') }}"
                            class="group relative flex h-[72px]
                                   items-center
                                   text-[16px]
                                   font-medium
                                   transition-colors
                                   duration-300
                                   {{ $activeLiteratur ? 'text-white' : 'text-slate-300 hover:text-white' }}">

                            Literatur

                            <span
                                class="absolute bottom-0 left-1/2
                                       h-[3px] w-0
                                       -translate-x-1/2
                                       rounded-full
                                       bg-white
                                       transition-all
                                       duration-300
                                       ease-out
                                       {{ $activeLiteratur
                                           ? '!left-0 !w-full !translate-x-0'
                                           : 'group-hover:left-0
                                              group-hover:w-full
                                              group-hover:translate-x-0' }}">
                            </span>
                        </a>

                        {{-- PRAKTIK INDUSTRI --}}
                        @php
                            $activePraktikIndustri = request()->routeIs('praktik-industri.index');
                        @endphp
                        <a href="{{ route('praktik-industri.index') }}"
                            class="group relative flex h-[72px]
                                   items-center
                                   text-[16px]
                                   font-medium
                                   transition-colors
                                   duration-300
                                   {{ $activePraktikIndustri ? 'text-white' : 'text-slate-300 hover:text-white' }}">

                            Praktik Industri

                            <span
                                class="absolute bottom-0 left-1/2
                                       h-[3px] w-0
                                       -translate-x-1/2
                                       rounded-full
                                       bg-white
                                       transition-all
                                       duration-300
                                       ease-out
                                       {{ $activePraktikIndustri
                                           ? '!left-0 !w-full !translate-x-0'
                                           : 'group-hover:left-0
                                              group-hover:w-full
                                              group-hover:translate-x-0' }}">
                            </span>
                        </a>

                        {{-- SKRIPSI --}}
                        @php
                            $activeSkripsi = request()->routeIs('skripsi.index');
                        @endphp
                        <a href="{{ route('skripsi.index') }}"
                            class="group relative flex h-[72px]
                                   items-center
                                   text-[16px]
                                   font-medium
                                   transition-colors
                                   duration-300
                                   {{ $activeSkripsi ? 'text-white' : 'text-slate-300 hover:text-white' }}">

                            Skripsi

                            <span
                                class="absolute bottom-0 left-1/2
                                       h-[3px] w-0
                                       -translate-x-1/2
                                       rounded-full
                                       bg-white
                                       transition-all
                                       duration-300
                                       ease-out
                                       {{ $activeSkripsi
                                           ? '!left-0 !w-full !translate-x-0'
                                           : 'group-hover:left-0
                                              group-hover:w-full
                                              group-hover:translate-x-0' }}">
                            </span>
                        </a>

                        {{-- TESIS --}}
                        @php
                            $activeTesis = request()->routeIs('tesis.index');
                        @endphp
                        <a href="{{ route('tesis.index') }}"
                            class="group relative flex h-[72px]
                                   items-center
                                   text-[16px]
                                   font-medium
                                   transition-colors
                                   duration-300
                                   {{ $activeTesis ? 'text-white' : 'text-slate-300 hover:text-white' }}">

                            Tesis

                            <span
                                class="absolute bottom-0 left-1/2
                                       h-[3px] w-0
                                       -translate-x-1/2
                                       rounded-full
                                       bg-white
                                       transition-all
                                       duration-300
                                       ease-out
                                       {{ $activeTesis
                                           ? '!left-0 !w-full !translate-x-0'
                                           : 'group-hover:left-0
                                              group-hover:w-full
                                              group-hover:translate-x-0' }}">
                            </span>
                        </a>

                        {{-- DISERTASI --}}
                        @php
                            $activeDisertasi = request()->routeIs('disertasi.index');
                        @endphp
                        <a href="{{ route('disertasi.index') }}"
                            class="group relative flex h-[72px]
                                   items-center
                                   text-[16px]
                                   font-medium
                                   transition-colors
                                   duration-300
                                   {{ $activeDisertasi ? 'text-white' : 'text-slate-300 hover:text-white' }}">

                            Disertasi

                            <span
                                class="absolute bottom-0 left-1/2
                                       h-[3px] w-0
                                       -translate-x-1/2
                                       rounded-full
                                       bg-white
                                       transition-all
                                       duration-300
                                       ease-out
                                       {{ $activeDisertasi
                                           ? '!left-0 !w-full !translate-x-0'
                                           : 'group-hover:left-0
                                              group-hover:w-full
                                              group-hover:translate-x-0' }}">
                            </span>
                        </a>

                    @endif

                </div>


                {{-- =================================================
                    DIVIDER
                ================================================== --}}

                <div class="mx-7 h-7 w-px bg-white/15"></div>


                {{-- =================================================
                    PROFILE
                ================================================== --}}

                <div class="relative flex h-[72px] items-center">

                    <button id="profileMenuButton" type="button" aria-expanded="false" aria-haspopup="true"
                        class="flex h-11
                               items-center gap-2
                               rounded-full
                               border border-white/20
                               bg-slate-800
                               px-4
                               text-[15px]
                               font-medium
                               text-white
                               transition-all
                               duration-300
                               hover:border-white/40
                               hover:bg-slate-700">

                        <span class="material-symbols-outlined text-[22px]">account_circle</span>
                        <span>Profil</span>
                    </button>


                    {{-- PROFILE DROPDOWN --}}
                    <div id="profileDropdown"
                        class="invisible absolute
                               right-0
                               top-full
                               z-50
                               mt-2
                               w-56
                               translate-y-2
                               rounded-2xl
                               border border-slate-200
                               bg-white
                               p-1.5
                               opacity-0
                               shadow-xl
                               shadow-slate-950/10
                               transition-all
                               duration-200
                               ease-out">

                        {{-- EDIT PROFILE --}}
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3
                                   rounded-xl
                                   px-3 py-2.5
                                   text-sm
                                   text-slate-700
                                   transition-colors
                                   duration-200
                                   hover:bg-slate-100
                                   hover:text-slate-900">

                            <span class="material-symbols-outlined text-[20px]">person</span>
                            <span>Edit Profil</span>
                        </a>


                        {{-- LOGOUT --}}
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button id="logoutButton" type="submit"
                                class="flex w-full
                                       items-center gap-3
                                       rounded-xl
                                       px-3 py-2.5
                                       text-sm
                                       text-red-600
                                       transition-colors
                                       duration-200
                                       hover:bg-red-50
                                       hover:text-red-700">

                                <span id="logoutIcon"
                                    class="material-symbols-outlined
                                           text-[20px]
                                           text-red-500
                                           logout-icon">
                                    logout
                                </span>
                                <span>Logout</span>
                            </button>
                        </form>

                    </div>
                </div>

            @endauth

        </nav>
    </div>
</header>


{{-- ================================================================
    NAVBAR SCRIPT
================================================================ --}}

<script>
    document.addEventListener('DOMContentLoaded', () => {

        /*
        |--------------------------------------------------------------------------
        | Logout
        |--------------------------------------------------------------------------
        */
        const logoutForm = document.getElementById('logoutForm');
        const logoutButton = document.getElementById('logoutButton');
        const logoutOverlay = document.getElementById('logoutLoadingOverlay');

        let overlayTimer = null;

        const showOverlay = () => {
            if (!logoutOverlay) return;
            clearTimeout(overlayTimer);
            overlayTimer = setTimeout(() => {
                logoutOverlay.classList.remove('hidden');
                logoutOverlay.classList.add('flex');
                requestAnimationFrame(() => {
                    logoutOverlay.classList.remove('opacity-0');
                    logoutOverlay.classList.add('opacity-100');
                });
            }, 180);
        };

        const hideOverlay = () => {
            if (!logoutOverlay) return;
            clearTimeout(overlayTimer);
            logoutOverlay.classList.remove('opacity-100');
            logoutOverlay.classList.add('opacity-0');
            setTimeout(() => {
                logoutOverlay.classList.add('hidden');
                logoutOverlay.classList.remove('flex');
            }, 300);
        };

        if (logoutForm && logoutButton && logoutOverlay) {
            logoutForm.addEventListener('submit', () => {
                logoutButton.disabled = true;
                logoutButton.classList.add('opacity-70', 'cursor-not-allowed');
                showOverlay();
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Profile Dropdown
        |--------------------------------------------------------------------------
        */
        const profileMenuButton = document.getElementById('profileMenuButton');
        const profileDropdown = document.getElementById('profileDropdown');

        const openProfileDropdown = () => {
            if (!profileMenuButton || !profileDropdown) return;
            const logoutIcon = document.getElementById('logoutIcon');
            
            profileDropdown.classList.remove('invisible', 'opacity-0', 'translate-y-2');
            profileDropdown.classList.add('opacity-100', 'translate-y-0');

            if (logoutIcon) logoutIcon.classList.add('logout-enter');
            profileMenuButton.setAttribute('aria-expanded', 'true');
        };

        const closeProfileDropdown = () => {
            if (!profileMenuButton || !profileDropdown) return;
            const logoutIcon = document.getElementById('logoutIcon');

            profileDropdown.classList.add('invisible', 'opacity-0', 'translate-y-2');
            profileDropdown.classList.remove('opacity-100', 'translate-y-0');

            if (logoutIcon) logoutIcon.classList.remove('logout-enter');
            profileMenuButton.setAttribute('aria-expanded', 'false');
        };

        if (profileMenuButton && profileDropdown) {
            profileMenuButton.addEventListener('click', (event) => {
                event.stopPropagation();
                const isOpen = profileDropdown.classList.contains('opacity-100');
                if (isOpen) {
                    closeProfileDropdown();
                } else {
                    openProfileDropdown();
                }
            });

            window.addEventListener('click', () => {
                closeProfileDropdown();
            });

            profileDropdown.addEventListener('click', (event) => {
                event.stopPropagation();
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Pageshow
        |--------------------------------------------------------------------------
        */
        window.addEventListener('pageshow', () => {
            hideOverlay();
        });

    });
</script>


{{-- ================================================================
    STYLE
================================================================ --}}

<style>
    .logout-icon {
        opacity: 0;
        transform: translateX(-8px);
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.35s ease;
    }

    .logout-icon.logout-enter {
        opacity: 1;
        transform: translateX(0);
    }

    #logoutButton:hover .logout-icon {
        transform: translateX(5px);
    }

    #logoutButton:hover {
        background-color: #fee2e2;
        color: #ef4444;
    }
</style>