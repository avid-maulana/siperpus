<div id="logoutLoadingOverlay" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/70 backdrop-blur-sm opacity-0 transition-opacity duration-300">
    <div class="flex flex-col items-center rounded-3xl border border-white/10 bg-white/95 px-8 py-7 shadow-2xl">
        <div class="h-12 w-12 animate-spin rounded-full border-4 border-slate-200 border-t-blue-600"></div>
        <p class="mt-4 text-sm font-semibold text-slate-700">Sedang keluar...</p>
    </div>
</div>

{{-- Navbar: #212A37, shadow/border pas discroll --}}
<header id="navbar" class="fixed top-0 left-0 z-50 w-full border-b transition-all duration-300 ease-in-out bg-[#212A37] border-transparent [&.scrolled]:border-slate-700/50 [&.scrolled]:shadow-lg">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
            <div class="hidden leading-tight sm:block">
                <h1 class="text-sm font-bold tracking-wide text-white">
                    PERPUSTAKAAN
                </h1>
                <p class="text-[11px] text-slate-300">
                    Departemen Teknik Elektro dan Informatika
                </p>
            </div>
        </a>

        {{-- Menu --}}
        <nav class="hidden items-center md:flex">
            @auth

            {{-- Navigation Links --}}
            <div class="flex items-center gap-10">

                {{-- Home --}}
                @php
                $activeHome = request()->routeIs('home');
                @endphp

                <a
                    href="{{ route('home') }}"
                    class="group relative flex h-[72px] items-center
                       text-[16px] font-medium
                       transition-colors duration-300
                       {{ $activeHome
                            ? 'text-white'
                            : 'text-slate-300 hover:text-white'
                       }}">
                    Home

                    <span
                        class="absolute bottom-0 left-1/2
                           h-[3px] w-0
                           -translate-x-1/2
                           rounded-full bg-white
                           transition-all duration-300 ease-out
                           {{ $activeHome
                                ? '!left-0 !w-full !translate-x-0'
                                : 'group-hover:left-0 group-hover:w-full group-hover:translate-x-0'
                           }}"></span>
                </a>


                {{-- Manage Dropdown --}}
                @if(Auth::user()->level == 6)
                @php
                $manageActive =
                request()->routeIs('library.index') ||
                request()->routeIs('library.indexLiterature');
                @endphp

                <div
                    id="manageMenuWrapper"
                    class="group/manage relative flex h-[72px] items-center">
                    {{-- Manage Button --}}
                    <button
                        id="manageMenuButton"
                        type="button"
                        aria-expanded="false"
                        aria-haspopup="true"
                        class="group relative flex h-full items-center gap-2
                               text-[16px] font-medium
                               transition-colors duration-300
                               {{ $manageActive
                                    ? 'text-white'
                                    : 'text-slate-300 hover:text-white'
                               }}">
                        <span>Manage</span>

                        {{-- Active Line --}}
                        <span
                            class="absolute bottom-0 left-1/2
                                   h-[3px] w-0
                                   -translate-x-1/2
                                   rounded-full bg-white
                                   transition-all duration-300 ease-out
                                   {{ $manageActive
                                        ? '!left-0 !w-full !translate-x-0'
                                        : 'group-hover:left-0 group-hover:w-full group-hover:translate-x-0'
                                   }}"></span>
                    </button>


                    {{-- Dropdown --}}
                    <div
                        id="manageDropdown"
                        class="invisible absolute
                               left-1/2 top-full z-50
                               w-56
                               -translate-x-1/2
                               translate-y-2
                               opacity-0
                               transition-all duration-200 ease-out

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
                                   shadow-xl shadow-slate-950/10">

                            {{-- Kelola Literatur --}}
                            <a
                                href="{{ route('library.indexLiterature') }}"
                                class="flex items-center gap-3
                                       rounded-xl px-3 py-2.5
                                       text-sm
                                       transition-colors duration-200
                                       {{ request()->routeIs('library.indexLiterature')
                                            ? 'bg-slate-100 font-semibold text-slate-900'
                                            : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900'
                                       }}">
                                <span
                                    class="material-symbols-outlined text-[20px]">
                                    library_books
                                </span>

                                <span>Kelola Literatur</span>
                            </a>


                            {{-- Kelola Tipe --}}
                            <a
                                href="{{ route('library.index') }}"
                                class="flex items-center gap-3
                                       rounded-xl px-3 py-2.5
                                       text-sm
                                       transition-colors duration-200
                                       {{ request()->routeIs('library.index')
                                            ? 'bg-slate-100 font-semibold text-slate-900'
                                            : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900'
                                       }}">
                                <span
                                    class="material-symbols-outlined text-[20px]">
                                    category
                                </span>

                                <span>Kelola Tipe</span>
                            </a>

                        </div>
                    </div>
                </div>
                @endif


                {{-- Literatur --}}
                @php
                $activeLiteratur = request()->routeIs('literatures.index');
                @endphp

                <a
                    href="{{ route('literatures.index') }}"
                    class="group relative flex h-[72px] items-center
                       text-[16px] font-medium
                       transition-colors duration-300
                       {{ $activeLiteratur
                            ? 'text-white'
                            : 'text-slate-300 hover:text-white'
                       }}">
                    Literatur

                    <span
                        class="absolute bottom-0 left-1/2
                           h-[3px] w-0
                           -translate-x-1/2
                           rounded-full bg-white
                           transition-all duration-300 ease-out
                           {{ $activeLiteratur
                                ? '!left-0 !w-full !translate-x-0'
                                : 'group-hover:left-0 group-hover:w-full group-hover:translate-x-0'
                           }}"></span>
                </a>


                {{-- Skripsi --}}
                @php
                $activeSkripsi = request()->routeIs('skripsi.index');
                @endphp

                <a
                    href="{{ route('skripsi.index') }}"
                    class="group relative flex h-[72px] items-center
                       text-[16px] font-medium
                       transition-colors duration-300
                       {{ $activeSkripsi
                            ? 'text-white'
                            : 'text-slate-300 hover:text-white'
                       }}">
                    Skripsi

                    <span
                        class="absolute bottom-0 left-1/2
                           h-[3px] w-0
                           -translate-x-1/2
                           rounded-full bg-white
                           transition-all duration-300 ease-out
                           {{ $activeSkripsi
                                ? '!left-0 !w-full !translate-x-0'
                                : 'group-hover:left-0 group-hover:w-full group-hover:translate-x-0'
                           }}"></span>
                </a>

            </div>


            {{-- Divider --}}
            <div class="mx-7 h-7 w-px bg-white/15"></div>


            {{-- Profile Menu --}}
            <div class="relative flex h-[72px] items-center">
                <button
                    id="profileMenuButton"
                    type="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                    class="flex h-11 items-center gap-2
                       rounded-full
                       border border-white/20
                       bg-slate-800
                       px-4
                       text-[15px] font-medium text-white
                       transition-all duration-300
                       hover:border-white/40
                       hover:bg-slate-700">
                    <span class="material-symbols-outlined text-[22px]">
                        account_circle
                    </span>

                    <span>Profil</span>
                </button>

                <div id="profileDropdown" class="invisible absolute right-0 top-full z-50 mt-2 w-56 translate-y-2 rounded-2xl border border-slate-200 bg-white p-1.5 opacity-0 shadow-xl shadow-slate-950/10 transition-all duration-200 ease-out">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-700 transition-colors duration-200 hover:bg-slate-100 hover:text-slate-900">
                        <span class="material-symbols-outlined text-[20px]">
                            person
                        </span>
                        <span>Edit Profil</span>
                    </a>

                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button id="logoutButton" type="submit" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-red-600 transition-colors duration-200 hover:bg-red-50 hover:text-red-700">
                            <span id="logoutIcon" class="material-symbols-outlined text-[20px] text-red-500 logout-icon">
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const logoutForm = document.getElementById('logoutForm');
        const logoutButton = document.getElementById('logoutButton');
        const logoutOverlay = document.getElementById('logoutLoadingOverlay');
        let overlayTimer = null;

        const showOverlay = () => {
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
            clearTimeout(overlayTimer);
            logoutOverlay.classList.remove('opacity-100');
            logoutOverlay.classList.add('opacity-0');
            setTimeout(() => {
                logoutOverlay.classList.add('hidden');
                logoutOverlay.classList.remove('flex');
            }, 300);
        };

        if (logoutForm && logoutButton && logoutOverlay) {
            logoutForm.addEventListener('submit', function() {
                logoutButton.disabled = true;
                logoutButton.classList.add('opacity-70', 'cursor-not-allowed');
                showOverlay();
            });
        }

        const profileMenuButton = document.getElementById('profileMenuButton');
        const profileDropdown = document.getElementById('profileDropdown');

        const openProfileDropdown = () => {
            const logoutIcon = document.getElementById('logoutIcon');
            profileDropdown.classList.remove('invisible', 'opacity-0', 'translate-y-2');
            profileDropdown.classList.add('opacity-100', 'translate-y-0');
            if (logoutIcon) logoutIcon.classList.add('logout-enter');
            profileMenuButton.setAttribute('aria-expanded', 'true');
        };

        const closeProfileDropdown = () => {
            const logoutIcon = document.getElementById('logoutIcon');
            profileDropdown.classList.add('invisible', 'opacity-0', 'translate-y-2');
            profileDropdown.classList.remove('opacity-100', 'translate-y-0');
            if (logoutIcon) logoutIcon.classList.remove('logout-enter');
            profileMenuButton.setAttribute('aria-expanded', 'false');
        };

        if (profileMenuButton && profileDropdown) {
            profileMenuButton.addEventListener('click', function(event) {
                event.stopPropagation();
                const isOpen = profileDropdown.classList.contains('opacity-100');

                if (isOpen) {
                    closeProfileDropdown();
                } else {
                    openProfileDropdown();
                }
            });

            window.addEventListener('click', function() {
                closeProfileDropdown();
            });

            profileDropdown.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }

        window.addEventListener('pageshow', () => {
            hideOverlay();
        });
    });
</script>

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