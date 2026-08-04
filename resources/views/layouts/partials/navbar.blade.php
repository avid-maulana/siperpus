<div id="logoutLoadingOverlay" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/70 backdrop-blur-sm opacity-0 transition-opacity duration-300">
    <div class="flex flex-col items-center rounded-3xl border border-white/10 bg-white/95 px-8 py-7 shadow-2xl">
        <div class="h-12 w-12 animate-spin rounded-full border-4 border-slate-200 border-t-blue-600"></div>
        <p class="mt-4 text-sm font-semibold text-slate-700">Sedang keluar...</p>
    </div>
</div>

{{-- Navbar: Default Putih, Jika di-scroll jadi #212A37 --}}
<header id="navbar" class="fixed top-0 left-0 z-50 w-full border-b transition-all duration-300 ease-in-out bg-[#212A37] border-transparent [&.scrolled]:bg-white [&.scrolled]:border-slate-200 [&.scrolled]:shadow-md">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
            <div class="hidden leading-tight sm:block">
                <h1 class="text-sm font-bold tracking-wide transition-colors duration-300 text-white [.scrolled_&]:text-slate-900">
                    PERPUSTAKAAN
                </h1>
                <p class="text-[11px] transition-colors duration-300 text-slate-300 [.scrolled_&]:text-slate-500">
                    Departemen Teknik Elektro dan Informatika
                </p>
            </div>
        </a>

        {{-- Menu --}}
        <nav class="hidden items-center md:flex">
            @auth
                
                {{-- Menu Admin / Level 6 --}}
                @if(Auth::user()->level == 6)
                    <div class="mr-10 flex items-center gap-8">
                        @foreach([
                            ['route'=>'library.index','label'=>'Kelola Tipe'],
                            ['route'=>'library.indexLiterature','label'=>'Literatur'],
                        ] as $item)
                            @php
                                $active = request()->routeIs($item['route']);
                            @endphp

                            <a href="{{ route($item['route']) }}"
                               class="group relative py-5 text-[15px] font-medium transition duration-300 {{ $active ? 'text-white [.scrolled_&]:text-slate-900' : 'text-slate-300 hover:text-white [.scrolled_&]:text-slate-600 [.scrolled_&]:hover:text-slate-900' }}">
                                
                                {{ $item['label'] }}

                                <span class="absolute bottom-0 left-1/2 h-[2.5px] w-0 -translate-x-1/2 rounded-full transition-all duration-300 ease-out bg-white [.scrolled_&]:bg-[#212A37] {{ $active ? '!left-0 !w-full !translate-x-0' : 'group-hover:left-0 group-hover:w-full group-hover:translate-x-0' }}">
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- Menu Umum --}}
                <div class="flex items-center gap-8">
                    @foreach([
                        ['route'=>'home','label'=>'Home'],
                        ['route'=>'literatures.index','label'=>'Literatur'],
                        ['route'=>'skripsi.index','label'=>'Skripsi'],
                    ] as $item)
                        @php
                            $active = request()->routeIs($item['route']);
                        @endphp

                        <a href="{{ route($item['route']) }}"
                           class="group relative py-5 text-[16px] font-medium transition-all duration-300 {{ $active ? 'text-white [.scrolled_&]:text-slate-900' : 'text-slate-300 hover:text-white [.scrolled_&]:text-slate-600 [.scrolled_&]:hover:text-slate-900' }}">
                           
                            {{ $item['label'] }}

                            <span class="absolute bottom-0 left-1/2 h-[2.5px] w-0 -translate-x-1/2 rounded-full transition-all duration-300 ease-out bg-white [.scrolled_&]:bg-[#212A37] {{ $active ? '!left-0 !w-full !translate-x-0' : 'group-hover:left-0 group-hover:w-full group-hover:translate-x-0' }}">
                            </span>
                        </a>
                    @endforeach
                </div>

                {{-- Profile menu --}}
                <div class="relative ml-8">
                    <button id="profileMenuButton" type="button" aria-expanded="false" aria-haspopup="true"
                            class="flex items-center gap-2 rounded-full border border-white/20 bg-slate-800 px-3 py-2 text-sm text-white transition hover:border-white/40 hover:bg-slate-700 [.scrolled_&]:border-slate-200 [.scrolled_&]:bg-white [.scrolled_&]:text-slate-900">
                        <span class="material-symbols-outlined text-[20px]">account_circle</span>
                        <span class="hidden sm:inline">Profil</span>
                    </button>

                    <div id="profileDropdown" class="absolute right-0 top-full z-50 mt-2 w-44 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-950/10 opacity-0 transition-all duration-200 invisible">
                        <a href="{{ route('profile.edit') }}" class="group flex items-center justify-between px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-100">
                            <span>Edit Profil</span>
                            <span class="material-symbols-outlined text-[18px] text-slate-400 ml-3 group-hover:-translate-y-[1px] group-hover:scale-[1.06] group-active:scale-[0.98]" style="transition: transform 0.45s cubic-bezier(0.25,0.8,0.25,1); will-change: transform;">person</span>
                        </a>
                        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="border-t border-slate-100">
                            @csrf
                            <button id="logoutButton" type="submit" class="group w-full flex items-center justify-between px-4 py-3 text-sm text-red-600 transition-colors duration-300 hover:bg-[#fee2e2] hover:text-[#ef4444]">
                                <span>Logout</span>
                                <span id="logoutIcon" class="material-symbols-outlined text-[18px] text-red-500 ml-3 logout-icon" style="will-change: transform, opacity;">logout</span>
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
            logoutForm.addEventListener('submit', function () {
                logoutButton.disabled = true;
                logoutButton.classList.add('opacity-70', 'cursor-not-allowed');
                showOverlay();
            });
        }

        const profileMenuButton = document.getElementById('profileMenuButton');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileMenuButton && profileDropdown) {
            profileMenuButton.addEventListener('click', function (event) {
                event.stopPropagation();
                const isOpen = profileDropdown.classList.contains('opacity-100');
                const logoutIcon = document.getElementById('logoutIcon');

                if (isOpen) {
                    profileDropdown.classList.add('invisible', 'opacity-0');
                    profileDropdown.classList.remove('opacity-100');
                    if (logoutIcon) {
                        logoutIcon.classList.remove('logout-enter');
                    }
                    profileMenuButton.setAttribute('aria-expanded', 'false');
                } else {
                    profileDropdown.classList.remove('invisible');
                    profileDropdown.classList.add('opacity-100');
                    if (logoutIcon) {
                        logoutIcon.classList.add('logout-enter');
                    }
                    profileMenuButton.setAttribute('aria-expanded', 'true');
                }
            });

            window.addEventListener('click', function () {
                profileDropdown.classList.add('invisible', 'opacity-0');
                profileDropdown.classList.remove('opacity-100');
                profileMenuButton.setAttribute('aria-expanded', 'false');
            });

            profileDropdown.addEventListener('click', function (event) {
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
        transition: transform 0.35s cubic-bezier(0.4,0,0.2,1), opacity 0.35s ease;
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