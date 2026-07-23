<header id="navbar"
    class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200 transition-transform duration-300">

    <div class="max-w-6xl mx-auto px-5 lg:px-8 h-16 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('asset/logo.png') }}" class="w-9 h-9 object-contain">

            <div class="leading-tight">
                <p class="text-sm font-semibold tracking-wide text-slate-900">
                    PERPUSTAKAAN
                </p>

                <p class="text-[11px] text-slate-500">
                    Departemen Teknik Elektro dan Informatika
                </p>
            </div>
        </a>

        {{-- Menu --}}
        <nav class="hidden md:flex items-center gap-1 text-sm">

            @auth

                @if(Auth::user()->level == 6)

                    @foreach([
                        ['route' => 'library.index', 'label' => 'Kelola Tipe'],
                        ['route' => 'library.indexLiterature', 'label' => 'Literatur'],
                    ] as $item)

                        <a href="{{ route($item['route']) }}"
                            class="px-3 py-2 rounded-lg font-medium transition
                            {{ request()->routeIs($item['route'])
                                ? 'text-blue-600 bg-blue-50'
                                : 'text-slate-600 hover:text-slate-900' }}">

                            {{ $item['label'] }}

                        </a>

                    @endforeach

                @endif

                @foreach([
                    ['route' => 'home', 'label' => 'Home'],
                    ['route' => 'literatures.index', 'label' => 'Literatur'],
                    ['route' => 'skripsi.index', 'label' => 'Skripsi'],
                ] as $item)

                    <a href="{{ route($item['route']) }}"
                        class="px-3 py-2 rounded-lg font-medium transition
                        {{ request()->routeIs($item['route'])
                            ? 'text-blue-600 bg-blue-50'
                            : 'text-slate-600 hover:text-slate-900' }}">

                        {{ $item['label'] }}

                    </a>

                @endforeach

                <form action="{{ route('logout') }}"
                    method="POST"
                    class="ml-2">

                    @csrf

                    <button
                        class="px-4 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition">

                        Logout

                    </button>

                </form>

            @endauth

        </nav>

    </div>

</header>