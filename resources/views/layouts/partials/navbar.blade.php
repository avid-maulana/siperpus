<header id="navbar"
    class="fixed top-0 left-0 z-50 w-full border-b border-slate-200 bg-white/90 backdrop-blur-md transition-transform duration-300 ease-in-out">

    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 lg:px-10">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">

            <img
                src="{{ asset('asset/logo.png') }}"
                alt="Logo"
                class="h-10 w-10 object-contain">

            <div class="hidden sm:block leading-tight">

                <h1 class="text-sm font-bold tracking-wide text-slate-900">
                    PERPUSTAKAAN
                </h1>

                <p class="text-[11px] text-slate-500">
                    Departemen Teknik Elektro dan Informatasi
                </p>

            </div>

        </a>

        {{-- Menu --}}
        <nav class="hidden md:flex items-center">

            @auth

                @if(Auth::user()->level == 6)

                    <div class="mr-10 flex items-center gap-8">

                        @foreach([
                            ['route'=>'library.index','label'=>'Kelola Tipe'],
                            ['route'=>'library.indexLiterature','label'=>'Literatur'],
                        ] as $item)

                            @php
                                $active = request()->routeIs($item['route']);
                            @endphp

                            <a
                                href="{{ route($item['route']) }}"
                                class="group relative py-5 text-[15px] font-medium transition duration-300
                                {{ $active
                                    ? 'text-slate-900'
                                    : 'text-slate-600 hover:text-slate-900' }}">

                                {{ $item['label'] }}

                                <span
                                    class="absolute bottom-0 left-1/2 h-[2.5px] w-0 rounded-full bg-[#212A37] transition-all duration-300 ease-out -translate-x-1/2
                                    {{ $active
                                        ? '!left-0 !w-full !translate-x-0'
                                        : 'group-hover:left-0 group-hover:w-full group-hover:translate-x-0' }}">
                                </span>

                            </a>

                        @endforeach

                    </div>

                @endif

                <div class="flex items-center gap-8">

                    @foreach([
                        ['route'=>'home','label'=>'Home'],
                        ['route'=>'literatures.index','label'=>'Literatur'],
                        ['route'=>'skripsi.index','label'=>'Skripsi'],
                    ] as $item)

                        @php
                            $active = request()->routeIs($item['route']);
                        @endphp

                        <a
                            href="{{ route($item['route']) }}"
                            class="group relative py-5 text-[16px] font-medium transition-all duration-300
                            {{ $active
                                ? 'text-slate-900'
                                : 'text-slate-600 hover:text-slate-900' }}">

                            {{ $item['label'] }}

                            <span
                                class="absolute bottom-0 left-1/2 h-[2.5px] w-0 rounded-full bg-[#212A37] transition-all duration-300 ease-out -translate-x-1/2
                                {{ $active
                                    ? '!left-0 !w-full !translate-x-0'
                                    : 'group-hover:left-0 group-hover:w-full group-hover:translate-x-0' }}">
                            </span>

                        </a>

                    @endforeach

                </div>

                {{-- Logout --}}
                <div class="ml-8 border-l border-slate-200 pl-6">

                    <form action="{{ route('logout') }}" method="POST">

                        @csrf

                        <button
                            type="submit"
                            class="group flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-500 transition-all duration-300 hover:bg-red-50 hover:text-red-600">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>

                            </svg>

                            Logout

                        </button>

                    </form>

                </div>

            @endauth

        </nav>

    </div>

</header>

{{-- Script untuk Animasi Hide/Show Navbar --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navbar = document.getElementById('navbar');
        let lastScrollTop = 0;

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Cek apakah scroll ke bawah dan sudah melewati tinggi navbar (64px / h-16)
            if (scrollTop > lastScrollTop && scrollTop > 64) {
                // Scroll down - Sembunyikan navbar (geser ke atas 100%)
                navbar.classList.add('-translate-y-full');
            } else {
                // Scroll up - Tampilkan kembali navbar (kembali ke posisi awal)
                navbar.classList.remove('-translate-y-full');
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Hindari bug di perangkat mobile
        });
    });
</script>