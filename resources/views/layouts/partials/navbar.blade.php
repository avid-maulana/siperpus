{{-- ================================================================
    LOGOUT LOADING OVERLAY
================================================================ --}}

<div
    id="logoutLoadingOverlay"
    class="fixed inset-0 z-[9999] hidden items-center justify-center
           bg-slate-950/70 backdrop-blur-sm
           opacity-0 transition-opacity duration-300"
>
    <div
        class="flex flex-col items-center
               rounded-3xl
               border border-white/10
               bg-white/95
               px-8 py-7
               shadow-2xl"
    >

        <div
            class="h-12 w-12
                   animate-spin
                   rounded-full
                   border-4
                   border-slate-200
                   border-t-[#212A37]"
        ></div>

        <p
            class="mt-4
                   text-sm
                   font-semibold
                   text-slate-700"
        >
            Sedang keluar...
        </p>

    </div>
</div>


{{-- ================================================================
    ================================================================
    ADMIN SIDEBAR
    ================================================================
================================================================ --}}

@auth

@if (Auth::user()->level == 6)

<aside
    id="adminSidebar"
    class="fixed left-0 top-0 z-[9998]
           flex h-screen
           w-[270px]
           flex-col
           border-r border-slate-700/60
           bg-[#182131]
           text-white
           shadow-xl
           transition-[width]
           duration-300
           ease-in-out"
>

    {{-- ============================================================
        SIDEBAR HEADER
    ============================================================= --}}

    <div
        class="flex h-20 shrink-0
               items-center
               border-b border-white/10
               px-5"
    >

        {{-- LOGO --}}

        <a
            href="{{ route('home') }}"
            class="flex min-w-0
                   items-center gap-3"
        >

            <div
                class="flex h-10 w-10 shrink-0
                       items-center justify-center
                       rounded-xl
                       bg-white/10"
            >
                <img
                    src="{{ asset('asset/logo.png') }}"
                    alt="Logo"
                    class="h-8 w-8 object-contain"
                >
            </div>

            <div
                class="sidebar-label
                       min-w-0
                       overflow-hidden
                       whitespace-nowrap
                       transition-all
                       duration-200"
            >

                <h1
                    class="text-sm
                           font-bold
                           tracking-wide
                           text-white"
                >
                    PERPUSTAKAAN
                </h1>

                <p
                    class="mt-0.5
                           text-[10px]
                           text-slate-400"
                >
                    Departemen TEI
                </p>

            </div>

        </a>


        {{-- COLLAPSE BUTTON --}}

        <button
            id="adminSidebarToggle"
            type="button"
            title="Minimize sidebar"
            class="ml-auto
                   flex h-9 w-9
                   shrink-0
                   items-center justify-center
                   rounded-lg
                   text-slate-400
                   transition-all
                   duration-200
                   hover:bg-white/10
                   hover:text-white"
        >

            <span
                id="adminSidebarToggleIcon"
                class="material-symbols-outlined
                       text-[21px]"
            >
                left_panel_close
            </span>

        </button>

    </div>


    {{-- ============================================================
        SIDEBAR MENU
    ============================================================= --}}

    <div
        class="flex-1
               overflow-y-auto
               overflow-x-hidden
               px-3 py-5"
    >

        {{-- MENU LABEL --}}

        <p
            class="sidebar-label
                   mb-3
                   px-3
                   text-[10px]
                   font-bold
                   uppercase
                   tracking-[0.15em]
                   text-slate-500
                   transition-all
                   duration-200"
        >
            Menu
        </p>


        {{-- ========================================================
            HOME
        ========================================================= --}}

        @php
            $activeAdminHome =
                request()->routeIs('home');
        @endphp

        <a
            href="{{ route('home') }}"
            title="Home"
            class="admin-sidebar-link group
                   {{ $activeAdminHome
                       ? 'bg-white/10 text-white'
                       : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
        >

            <span
                class="material-symbols-outlined
                       admin-sidebar-icon
                       shrink-0
                       text-[21px]"
            >
                home
            </span>

            <span
                class="sidebar-label
                       whitespace-nowrap
                       transition-all
                       duration-200"
            >
                Home
            </span>

            @if ($activeAdminHome)

                <span
                    class="sidebar-active-dot
                           ml-auto
                           h-1.5 w-1.5
                           shrink-0
                           rounded-full
                           bg-white"
                ></span>

            @endif

        </a>


        {{-- ========================================================
            MANAGE
        ========================================================= --}}

        @php
            $manageActive =
                request()->routeIs('library.index') ||
                request()->routeIs('library.indexLiterature') ||
                request()->routeIs('library.repositories') ||
                request()->routeIs('library.praktik-industri');
        @endphp

        <div class="mt-1">

            <button
                id="adminManageButton"
                type="button"
                title="Manage"
                class="admin-sidebar-link group w-full
                       {{ $manageActive
                           ? 'bg-white/5 text-white'
                           : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >

                <span
                    class="material-symbols-outlined
                           admin-sidebar-icon
                           shrink-0
                           text-[21px]"
                >
                    settings
                </span>

                <span
                    class="sidebar-label
                           flex-1
                           text-left
                           whitespace-nowrap
                           transition-all
                           duration-200"
                >
                    Manage
                </span>

                <span
                    id="adminManageArrow"
                    class="sidebar-label
                           material-symbols-outlined
                           text-[19px]
                           transition-transform
                           duration-200"
                >
                    expand_more
                </span>

            </button>


            {{-- MANAGE SUBMENU --}}

            <div
                id="adminManageSubmenu"
                class="mt-1
                       space-y-1
                       overflow-hidden
                       transition-all
                       duration-300
                       {{ $manageActive ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}"
            >

                {{-- LITERATUR --}}

                <a
                    href="{{ route('library.indexLiterature') }}"
                    title="Kelola Literatur"
                    class="admin-sidebar-submenu
                           {{ request()->routeIs('library.indexLiterature')
                               ? 'bg-white/10 text-white'
                               : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                >
                    <span
                        class="material-symbols-outlined text-[18px]"
                    >
                        library_books
                    </span>

                    <span class="sidebar-label whitespace-nowrap">
                        Kelola Literatur
                    </span>
                </a>


                {{-- TIPE --}}

                <a
                    href="{{ route('library.index') }}"
                    title="Kelola Tipe"
                    class="admin-sidebar-submenu
                           {{ request()->routeIs('library.index')
                               ? 'bg-white/10 text-white'
                               : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                >
                    <span
                        class="material-symbols-outlined text-[18px]"
                    >
                        category
                    </span>

                    <span class="sidebar-label whitespace-nowrap">
                        Kelola Tipe
                    </span>
                </a>


                {{-- PASCASARJANA --}}

                <a
                    href="{{ route('library.repositories') }}"
                    title="Kelola Pascasarjana"
                    class="admin-sidebar-submenu
                           {{ request()->routeIs('library.repositories')
                               ? 'bg-white/10 text-white'
                               : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                >
                    <span
                        class="material-symbols-outlined text-[18px]"
                    >
                        school
                    </span>

                    <span class="sidebar-label whitespace-nowrap">
                        Kelola Pascasarjana
                    </span>
                </a>


                {{-- PRAKTIK INDUSTRI --}}

                <a
                    href="{{ route('library.praktik-industri') }}"
                    title="Kelola Praktik Industri"
                    class="admin-sidebar-submenu
                           {{ request()->routeIs('library.praktik-industri')
                               ? 'bg-white/10 text-white'
                               : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                >
                    <span
                        class="material-symbols-outlined text-[18px]"
                    >
                        business_center
                    </span>

                    <span class="sidebar-label whitespace-nowrap">
                        Kelola Praktik Industri
                    </span>
                </a>

            </div>

        </div>


        {{-- ========================================================
            USER PAGE
        ========================================================= --}}

        @php
            $userPageActive =
                request()->routeIs('literatures.index') ||
                request()->routeIs('praktik-industri.index') ||
                request()->routeIs('skripsi.index') ||
                request()->routeIs('tesis.index') ||
                request()->routeIs('disertasi.index');
        @endphp

        <div class="mt-1">

            <button
                id="adminUserPageButton"
                type="button"
                title="User Page"
                class="admin-sidebar-link group w-full
                       {{ $userPageActive
                           ? 'bg-white/5 text-white'
                           : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
            >

                <span
                    class="material-symbols-outlined
                           admin-sidebar-icon
                           shrink-0
                           text-[21px]"
                >
                    visibility
                </span>

                <span
                    class="sidebar-label
                           flex-1
                           text-left
                           whitespace-nowrap
                           transition-all
                           duration-200"
                >
                    User Page
                </span>

                <span
                    id="adminUserPageArrow"
                    class="sidebar-label
                           material-symbols-outlined
                           text-[19px]
                           transition-transform
                           duration-200"
                >
                    expand_more
                </span>

            </button>


            {{-- USER PAGE SUBMENU --}}

            <div
                id="adminUserPageSubmenu"
                class="mt-1
                       space-y-1
                       overflow-hidden
                       transition-all
                       duration-300
                       {{ $userPageActive ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }}"
            >

                {{-- LITERATUR --}}

                <a
                    href="{{ route('literatures.index') }}"
                    title="Literatur"
                    class="admin-sidebar-submenu
                           {{ request()->routeIs('literatures.index')
                               ? 'bg-white/10 text-white'
                               : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                >
                    <span
                        class="material-symbols-outlined text-[18px]"
                    >
                        library_books
                    </span>

                    <span class="sidebar-label whitespace-nowrap">
                        Literatur
                    </span>
                </a>


                {{-- PRAKTIK INDUSTRI --}}

                <a
                    href="{{ route('praktik-industri.index') }}"
                    title="Praktik Industri"
                    class="admin-sidebar-submenu
                           {{ request()->routeIs('praktik-industri.index')
                               ? 'bg-white/10 text-white'
                               : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                >
                    <span
                        class="material-symbols-outlined text-[18px]"
                    >
                        business_center
                    </span>

                    <span class="sidebar-label whitespace-nowrap">
                        Praktik Industri
                    </span>
                </a>


                {{-- SKRIPSI --}}

                <a
                    href="{{ route('skripsi.index') }}"
                    title="Skripsi"
                    class="admin-sidebar-submenu
                           {{ request()->routeIs('skripsi.index')
                               ? 'bg-white/10 text-white'
                               : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                >
                    <span
                        class="material-symbols-outlined text-[18px]"
                    >
                        description
                    </span>

                    <span class="sidebar-label whitespace-nowrap">
                        Skripsi
                    </span>
                </a>


                {{-- TESIS --}}

                <a
                    href="{{ route('tesis.index') }}"
                    title="Tesis"
                    class="admin-sidebar-submenu
                           {{ request()->routeIs('tesis.index')
                               ? 'bg-white/10 text-white'
                               : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                >
                    <span
                        class="material-symbols-outlined text-[18px]"
                    >
                        school
                    </span>

                    <span class="sidebar-label whitespace-nowrap">
                        Tesis
                    </span>
                </a>


                {{-- DISERTASI --}}

                <a
                    href="{{ route('disertasi.index') }}"
                    title="Disertasi"
                    class="admin-sidebar-submenu
                           {{ request()->routeIs('disertasi.index')
                               ? 'bg-white/10 text-white'
                               : 'text-slate-400 hover:bg-white/5 hover:text-white' }}"
                >
                    <span
                        class="material-symbols-outlined text-[18px]"
                    >
                        auto_stories
                    </span>

                    <span class="sidebar-label whitespace-nowrap">
                        Disertasi
                    </span>
                </a>

            </div>

        </div>

    </div>


    {{-- ============================================================
        SIDEBAR BOTTOM
    ============================================================= --}}

    <div
        class="shrink-0
               border-t border-white/10
               p-3"
    >

        {{-- PROFILE --}}

        <a
            href="{{ route('profile.edit') }}"
            title="Profil"
            class="admin-sidebar-link
                   text-slate-300
                   hover:bg-white/5
                   hover:text-white"
        >

            <span
                class="material-symbols-outlined
                       admin-sidebar-icon
                       shrink-0
                       text-[21px]"
            >
                account_circle
            </span>

            <span
                class="sidebar-label whitespace-nowrap"
            >
                Profil
            </span>

        </a>


        {{-- LOGOUT --}}

        <form
            id="logoutForm"
            action="{{ route('logout') }}"
            method="POST"
        >

            @csrf

            <button
                id="logoutButton"
                type="submit"
                title="Logout"
                class="admin-sidebar-link
                       w-full
                       text-red-400
                       hover:bg-red-500/10
                       hover:text-red-300"
            >

                <span
                    id="logoutIcon"
                    class="material-symbols-outlined
                           admin-sidebar-icon
                           shrink-0
                           text-[21px]
                           logout-icon"
                >
                    logout
                </span>

                <span
                    class="sidebar-label whitespace-nowrap"
                >
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>


{{-- ================================================================
    ADMIN CONTENT SPACER
================================================================ --}}

<div
    id="adminSidebarSpacer"
    class="hidden md:block
           w-[270px]
           shrink-0"
></div>


@else


{{-- ================================================================
    ================================================================
    USER NAVBAR
    ================================================================
================================================================ --}}

<header
    id="navbar"
    class="fixed left-0 top-0 z-50 w-full
           border-b
           border-transparent
           bg-[#212A37]
           transition-all
           duration-300
           ease-in-out
           [&.scrolled]:border-slate-700/50
           [&.scrolled]:shadow-lg"
>

    <div
        class="mx-auto flex h-20 max-w-7xl
               items-center
               justify-between
               px-6
               lg:px-8"
    >

        {{-- ========================================================
            LOGO
        ========================================================= --}}

        <a
            href="{{ route('home') }}"
            class="flex items-center gap-3"
        >

            <img
                src="{{ asset('asset/logo.png') }}"
                alt="Logo"
                class="h-10 w-10 object-contain"
            >

            <div
                class="hidden leading-tight sm:block"
            >

                <h1
                    class="text-sm
                           font-bold
                           tracking-wide
                           text-white"
                >
                    PERPUSTAKAAN
                </h1>

                <p
                    class="text-[11px]
                           text-slate-300"
                >
                    Departemen Teknik Elektro dan Informatika
                </p>

            </div>

        </a>


        {{-- ========================================================
            USER MENU
        ========================================================= --}}

        <nav
            class="hidden items-center md:flex"
        >

            <div
                class="flex items-center gap-8"
            >

                {{-- HOME --}}

                @php
                    $activeHome =
                        request()->routeIs('home');
                @endphp

                <a
                    href="{{ route('home') }}"
                    class="user-nav-link
                           {{ $activeHome
                               ? 'text-white'
                               : 'text-slate-300 hover:text-white' }}"
                >
                    Home

                    <span
                        class="user-nav-line
                               {{ $activeHome ? 'active' : '' }}"
                    ></span>
                </a>


                {{-- LITERATUR --}}

                @php
                    $activeLiteratur =
                        request()->routeIs('literatures.index');
                @endphp

                <a
                    href="{{ route('literatures.index') }}"
                    class="user-nav-link
                           {{ $activeLiteratur
                               ? 'text-white'
                               : 'text-slate-300 hover:text-white' }}"
                >
                    Literatur

                    <span
                        class="user-nav-line
                               {{ $activeLiteratur ? 'active' : '' }}"
                    ></span>
                </a>


                {{-- PRAKTIK INDUSTRI --}}

                @php
                    $activePraktikIndustri =
                        request()->routeIs('praktik-industri.index');
                @endphp

                <a
                    href="{{ route('praktik-industri.index') }}"
                    class="user-nav-link
                           {{ $activePraktikIndustri
                               ? 'text-white'
                               : 'text-slate-300 hover:text-white' }}"
                >
                    Praktik Industri

                    <span
                        class="user-nav-line
                               {{ $activePraktikIndustri ? 'active' : '' }}"
                    ></span>
                </a>


                {{-- SKRIPSI --}}

                @php
                    $activeSkripsi =
                        request()->routeIs('skripsi.index');
                @endphp

                <a
                    href="{{ route('skripsi.index') }}"
                    class="user-nav-link
                           {{ $activeSkripsi
                               ? 'text-white'
                               : 'text-slate-300 hover:text-white' }}"
                >
                    Skripsi

                    <span
                        class="user-nav-line
                               {{ $activeSkripsi ? 'active' : '' }}"
                    ></span>
                </a>


                {{-- TESIS --}}

                @php
                    $activeTesis =
                        request()->routeIs('tesis.index');
                @endphp

                <a
                    href="{{ route('tesis.index') }}"
                    class="user-nav-link
                           {{ $activeTesis
                               ? 'text-white'
                               : 'text-slate-300 hover:text-white' }}"
                >
                    Tesis

                    <span
                        class="user-nav-line
                               {{ $activeTesis ? 'active' : '' }}"
                    ></span>
                </a>


                {{-- DISERTASI --}}

                @php
                    $activeDisertasi =
                        request()->routeIs('disertasi.index');
                @endphp

                <a
                    href="{{ route('disertasi.index') }}"
                    class="user-nav-link
                           {{ $activeDisertasi
                               ? 'text-white'
                               : 'text-slate-300 hover:text-white' }}"
                >
                    Disertasi

                    <span
                        class="user-nav-line
                               {{ $activeDisertasi ? 'active' : '' }}"
                    ></span>
                </a>

            </div>


            {{-- DIVIDER --}}

            <div
                class="mx-6 h-7 w-px
                       bg-white/15"
            ></div>


            {{-- ====================================================
                PROFILE
            ===================================================== --}}

            <div
                class="relative flex h-[72px]
                       items-center"
            >

                <button
                    id="profileMenuButton"
                    type="button"
                    aria-expanded="false"
                    aria-haspopup="true"
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
                           hover:bg-slate-700"
                >

                    <span
                        class="material-symbols-outlined
                               text-[22px]"
                    >
                        account_circle
                    </span>

                    <span>
                        Profil
                    </span>

                </button>


                {{-- PROFILE DROPDOWN --}}

                <div
                    id="profileDropdown"
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
                           ease-out"
                >

                    {{-- EDIT PROFILE --}}

                    <a
                        href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3
                               rounded-xl
                               px-3 py-2.5
                               text-sm
                               text-slate-700
                               transition-colors
                               duration-200
                               hover:bg-slate-100
                               hover:text-slate-900"
                    >

                        <span
                            class="material-symbols-outlined
                                   text-[20px]"
                        >
                            person
                        </span>

                        <span>
                            Edit Profil
                        </span>

                    </a>


                    {{-- LOGOUT --}}

                    <form
                        id="logoutForm"
                        action="{{ route('logout') }}"
                        method="POST"
                    >

                        @csrf

                        <button
                            id="logoutButton"
                            type="submit"
                            class="flex w-full
                                   items-center gap-3
                                   rounded-xl
                                   px-3 py-2.5
                                   text-sm
                                   text-red-600
                                   transition-colors
                                   duration-200
                                   hover:bg-red-50
                                   hover:text-red-700"
                        >

                            <span
                                id="logoutIcon"
                                class="material-symbols-outlined
                                       text-[20px]
                                       text-red-500
                                       logout-icon"
                            >
                                logout
                            </span>

                            <span>
                                Logout
                            </span>

                        </button>

                    </form>

                </div>

            </div>

        </nav>

    </div>

</header>

@endif

@endauth


{{-- ================================================================
    ================================================================
    JAVASCRIPT
    ================================================================
================================================================ --}}

<script>

document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDEBAR
    |--------------------------------------------------------------------------
    */

    const sidebar =
        document.getElementById('adminSidebar');

    const sidebarToggle =
        document.getElementById('adminSidebarToggle');

    const sidebarToggleIcon =
        document.getElementById('adminSidebarToggleIcon');

    const sidebarSpacer =
        document.getElementById('adminSidebarSpacer');


    let sidebarCollapsed =
        localStorage.getItem(
            'adminSidebarCollapsed'
        ) === 'true';


    const updateSidebar = () => {

        if (
            !sidebar ||
            !sidebarSpacer
        ) {
            return;
        }


        if (sidebarCollapsed) {

            sidebar.classList.remove(
                'w-[270px]'
            );

            sidebar.classList.add(
                'w-[76px]'
            );


            sidebarSpacer.classList.remove(
                'w-[270px]'
            );

            sidebarSpacer.classList.add(
                'w-[76px]'
            );


            document
                .querySelectorAll('.sidebar-label')
                .forEach(element => {

                    element.classList.add(
                        'hidden'
                    );

                });


            document
                .querySelectorAll('.sidebar-active-dot')
                .forEach(element => {

                    element.classList.add(
                        'hidden'
                    );

                });


            if (sidebarToggleIcon) {

                sidebarToggleIcon.textContent =
                    'left_panel_open';

            }


            if (sidebarToggle) {

                sidebarToggle.title =
                    'Maximize sidebar';

            }


            /*
            | Tooltip-style alignment
            */

            document
                .querySelectorAll('.admin-sidebar-link')
                .forEach(element => {

                    element.classList.add(
                        'justify-center'
                    );

                });


        } else {

            sidebar.classList.remove(
                'w-[76px]'
            );

            sidebar.classList.add(
                'w-[270px]'
            );


            sidebarSpacer.classList.remove(
                'w-[76px]'
            );

            sidebarSpacer.classList.add(
                'w-[270px]'
            );


            document
                .querySelectorAll('.sidebar-label')
                .forEach(element => {

                    element.classList.remove(
                        'hidden'
                    );

                });


            document
                .querySelectorAll('.sidebar-active-dot')
                .forEach(element => {

                    element.classList.remove(
                        'hidden'
                    );

                });


            if (sidebarToggleIcon) {

                sidebarToggleIcon.textContent =
                    'left_panel_close';

            }


            if (sidebarToggle) {

                sidebarToggle.title =
                    'Minimize sidebar';

            }


            document
                .querySelectorAll('.admin-sidebar-link')
                .forEach(element => {

                    element.classList.remove(
                        'justify-center'
                    );

                });

        }

    };


    updateSidebar();


    if (sidebarToggle) {

        sidebarToggle.addEventListener(
            'click',
            () => {

                sidebarCollapsed =
                    !sidebarCollapsed;


                localStorage.setItem(
                    'adminSidebarCollapsed',
                    sidebarCollapsed
                );


                updateSidebar();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MANAGE SUBMENU
    |--------------------------------------------------------------------------
    */

    const manageButton =
        document.getElementById(
            'adminManageButton'
        );

    const manageSubmenu =
        document.getElementById(
            'adminManageSubmenu'
        );

    const manageArrow =
        document.getElementById(
            'adminManageArrow'
        );


    if (
        manageButton &&
        manageSubmenu
    ) {

        manageButton.addEventListener(
            'click',
            () => {

                const isOpen =
                    manageSubmenu.classList.contains(
                        'max-h-96'
                    );


                if (isOpen) {

                    manageSubmenu.classList.remove(
                        'max-h-96',
                        'opacity-100'
                    );

                    manageSubmenu.classList.add(
                        'max-h-0',
                        'opacity-0'
                    );


                    if (manageArrow) {

                        manageArrow.classList.remove(
                            'rotate-180'
                        );

                    }

                } else {

                    manageSubmenu.classList.remove(
                        'max-h-0',
                        'opacity-0'
                    );

                    manageSubmenu.classList.add(
                        'max-h-96',
                        'opacity-100'
                    );


                    if (manageArrow) {

                        manageArrow.classList.add(
                            'rotate-180'
                        );

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | USER PAGE SUBMENU
    |--------------------------------------------------------------------------
    */

    const userPageButton =
        document.getElementById(
            'adminUserPageButton'
        );

    const userPageSubmenu =
        document.getElementById(
            'adminUserPageSubmenu'
        );

    const userPageArrow =
        document.getElementById(
            'adminUserPageArrow'
        );


    if (
        userPageButton &&
        userPageSubmenu
    ) {

        userPageButton.addEventListener(
            'click',
            () => {

                const isOpen =
                    userPageSubmenu.classList.contains(
                        'max-h-96'
                    );


                if (isOpen) {

                    userPageSubmenu.classList.remove(
                        'max-h-96',
                        'opacity-100'
                    );

                    userPageSubmenu.classList.add(
                        'max-h-0',
                        'opacity-0'
                    );


                    if (userPageArrow) {

                        userPageArrow.classList.remove(
                            'rotate-180'
                        );

                    }

                } else {

                    userPageSubmenu.classList.remove(
                        'max-h-0',
                        'opacity-0'
                    );

                    userPageSubmenu.classList.add(
                        'max-h-96',
                        'opacity-100'
                    );


                    if (userPageArrow) {

                        userPageArrow.classList.add(
                            'rotate-180'
                        );

                    }

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | PROFILE DROPDOWN
    |--------------------------------------------------------------------------
    */

    const profileMenuButton =
        document.getElementById(
            'profileMenuButton'
        );

    const profileDropdown =
        document.getElementById(
            'profileDropdown'
        );


    const openProfileDropdown = () => {

        if (
            !profileMenuButton ||
            !profileDropdown
        ) {
            return;
        }


        profileDropdown.classList.remove(
            'invisible',
            'opacity-0',
            'translate-y-2'
        );


        profileDropdown.classList.add(
            'opacity-100',
            'translate-y-0'
        );


        profileMenuButton.setAttribute(
            'aria-expanded',
            'true'
        );

    };


    const closeProfileDropdown = () => {

        if (
            !profileMenuButton ||
            !profileDropdown
        ) {
            return;
        }


        profileDropdown.classList.add(
            'invisible',
            'opacity-0',
            'translate-y-2'
        );


        profileDropdown.classList.remove(
            'opacity-100',
            'translate-y-0'
        );


        profileMenuButton.setAttribute(
            'aria-expanded',
            'false'
        );

    };


    if (
        profileMenuButton &&
        profileDropdown
    ) {

        profileMenuButton.addEventListener(
            'click',
            (event) => {

                event.stopPropagation();


                const isOpen =
                    profileDropdown.classList.contains(
                        'opacity-100'
                    );


                if (isOpen) {

                    closeProfileDropdown();

                } else {

                    openProfileDropdown();

                }

            }
        );


        window.addEventListener(
            'click',
            () => {

                closeProfileDropdown();

            }
        );


        profileDropdown.addEventListener(
            'click',
            (event) => {

                event.stopPropagation();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    const logoutForm =
        document.getElementById(
            'logoutForm'
        );

    const logoutButton =
        document.getElementById(
            'logoutButton'
        );

    const logoutOverlay =
        document.getElementById(
            'logoutLoadingOverlay'
        );

    let overlayTimer = null;


    const showOverlay = () => {

        if (!logoutOverlay) {
            return;
        }


        clearTimeout(
            overlayTimer
        );


        overlayTimer = setTimeout(
            () => {

                logoutOverlay.classList.remove(
                    'hidden'
                );

                logoutOverlay.classList.add(
                    'flex'
                );


                requestAnimationFrame(
                    () => {

                        logoutOverlay.classList.remove(
                            'opacity-0'
                        );

                        logoutOverlay.classList.add(
                            'opacity-100'
                        );

                    }
                );

            },
            180
        );

    };


    const hideOverlay = () => {

        if (!logoutOverlay) {
            return;
        }


        clearTimeout(
            overlayTimer
        );


        logoutOverlay.classList.remove(
            'opacity-100'
        );

        logoutOverlay.classList.add(
            'opacity-0'
        );


        setTimeout(
            () => {

                logoutOverlay.classList.add(
                    'hidden'
                );

                logoutOverlay.classList.remove(
                    'flex'
                );

            },
            300
        );

    };


    if (
        logoutForm &&
        logoutButton &&
        logoutOverlay
    ) {

        logoutForm.addEventListener(
            'submit',
            () => {

                logoutButton.disabled =
                    true;


                logoutButton.classList.add(
                    'opacity-70',
                    'cursor-not-allowed'
                );


                showOverlay();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | PAGE SHOW
    |--------------------------------------------------------------------------
    */

    window.addEventListener(
        'pageshow',
        () => {

            hideOverlay();

        }
    );

});
</script>


{{-- ================================================================
    STYLE
================================================================ --}}

<style>

    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDEBAR
    |--------------------------------------------------------------------------
    */

    .admin-sidebar-link {

        display: flex;

        align-items: center;

        gap: 12px;

        min-height: 44px;

        border-radius: 10px;

        padding:
            0 12px;

        font-size: 14px;

        font-weight: 500;

        transition:
            background-color 0.2s ease,
            color 0.2s ease;

    }


    .admin-sidebar-submenu {

        display: flex;

        align-items: center;

        gap: 12px;

        min-height: 40px;

        margin-left: 12px;

        border-radius: 9px;

        padding:
            0 12px;

        font-size: 13px;

        transition:
            background-color 0.2s ease,
            color 0.2s ease;

    }


    #adminSidebar {

        scrollbar-width:
            thin;

        scrollbar-color:
            rgba(255,255,255,.15)
            transparent;

    }


    #adminSidebar::-webkit-scrollbar {

        width: 5px;

    }


    #adminSidebar::-webkit-scrollbar-track {

        background:
            transparent;

    }


    #adminSidebar::-webkit-scrollbar-thumb {

        background:
            rgba(255,255,255,.15);

        border-radius:
            999px;

    }


    /*
    |--------------------------------------------------------------------------
    | USER NAVBAR
    |--------------------------------------------------------------------------
    */

    .user-nav-link {

        position:
            relative;

        display:
            flex;

        height:
            72px;

        align-items:
            center;

        font-size:
            16px;

        font-weight:
            500;

        transition:
            color 0.3s ease;

    }


    .user-nav-line {

        position:
            absolute;

        bottom:
            0;

        left:
            50%;

        height:
            3px;

        width:
            0;

        transform:
            translateX(-50%);

        border-radius:
            999px;

        background:
            white;

        transition:
            width 0.3s ease,
            left 0.3s ease,
            transform 0.3s ease;

    }


    .user-nav-link:hover
    .user-nav-line {

        left:
            0;

        width:
            100%;

        transform:
            translateX(0);

    }


    .user-nav-line.active {

        left:
            0;

        width:
            100%;

        transform:
            translateX(0);

    }


    /*
    |--------------------------------------------------------------------------
    | LOGOUT ICON
    |--------------------------------------------------------------------------
    */

    .logout-icon {

        opacity:
            0;

        transform:
            translateX(-8px);

        transition:
            transform 0.35s cubic-bezier(
                0.4,
                0,
                0.2,
                1
            ),
            opacity 0.35s ease;

    }


    #logoutButton:hover
    .logout-icon {

        opacity:
            1;

        transform:
            translateX(5px);

    }

</style>