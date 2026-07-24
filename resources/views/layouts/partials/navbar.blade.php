<div id="logoutLoadingOverlay" class="fixed inset-0 z-[60] hidden items-center justify-center bg-slate-950/70 backdrop-blur-sm opacity-0 transition-opacity duration-300">
    <div class="flex flex-col items-center rounded-3xl border border-white/10 bg-white/95 px-8 py-7 shadow-2xl">
        <div class="h-12 w-12 animate-spin rounded-full border-4 border-slate-200 border-t-blue-600"></div>
        <p class="mt-4 text-sm font-semibold text-slate-700">Sedang keluar...</p>
    </div>
</div>

{{-- Navbar: Default Putih, Jika di-scroll jadi #212A37 --}}
<header id="navbar" class="fixed top-0 left-0 z-50 w-full border-b transition-all duration-300 ease-in-out bg-white border-slate-200 [&.scrolled]:bg-[#212A37] [&.scrolled]:border-transparent [&.scrolled]:shadow-md">
    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('asset/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
            <div class="hidden leading-tight sm:block">
                {{-- Default: Teks Gelap, Scrolled: Teks Putih --}}
                <h1 class="text-sm font-bold tracking-wide transition-colors duration-300 text-slate-900 [.scrolled_&]:text-white">
                    PERPUSTAKAAN
                </h1>
                <p class="text-[11px] transition-colors duration-300 text-slate-500 [.scrolled_&]:text-slate-300">
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
                               class="group relative py-5 text-[15px] font-medium transition duration-300 {{ $active ? 'text-slate-900 [.scrolled_&]:text-white' : 'text-slate-600 hover:text-slate-900 [.scrolled_&]:text-slate-300 [.scrolled_&]:hover:text-white' }}">
                                
                                {{ $item['label'] }}

                                {{-- Garis Bawah: Default Gelap, Scrolled Putih --}}
                                <span class="absolute bottom-0 left-1/2 h-[2.5px] w-0 -translate-x-1/2 rounded-full transition-all duration-300 ease-out bg-[#212A37] [.scrolled_&]:bg-white {{ $active ? '!left-0 !w-full !translate-x-0' : 'group-hover:left-0 group-hover:w-full group-hover:translate-x-0' }}">
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
                           class="group relative py-5 text-[16px] font-medium transition-all duration-300 {{ $active ? 'text-slate-900 [.scrolled_&]:text-white' : 'text-slate-600 hover:text-slate-900 [.scrolled_&]:text-slate-300 [.scrolled_&]:hover:text-white' }}">
                           
                            {{ $item['label'] }}

                            <span class="absolute bottom-0 left-1/2 h-[2.5px] w-0 -translate-x-1/2 rounded-full transition-all duration-300 ease-out bg-[#212A37] [.scrolled_&]:bg-white {{ $active ? '!left-0 !w-full !translate-x-0' : 'group-hover:left-0 group-hover:w-full group-hover:translate-x-0' }}">
                            </span>
                        </a>
                    @endforeach
                </div>

                {{-- Logout --}}
                {{-- Border Default: abu-abu, Scrolled: putih transparan --}}
                <div class="ml-8 border-l pl-6 transition-colors duration-300 border-slate-200 [.scrolled_&]:border-white/20">
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button id="logoutButton" type="submit"
                                class="group flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium transition-all duration-300 text-slate-500 hover:bg-red-50 hover:text-red-600 [.scrolled_&]:text-slate-300 [.scrolled_&]:hover:bg-red-500/20 [.scrolled_&]:hover:text-red-400">
                            
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
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

        window.addEventListener('pageshow', () => {
            hideOverlay();
        });
    });
</script>