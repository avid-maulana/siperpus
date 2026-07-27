<div class="relative z-20 mx-auto -mt-14 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="relative overflow-hidden rounded-[28px] border border-slate-200/80 bg-gradient-to-br from-white via-slate-50 to-[#f8fafc] p-6 shadow-[0_25px_80px_-25px_rgba(15,23,42,0.35)] ring-1 ring-slate-100 sm:p-8">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(33,42,55,0.10),_transparent_45%)]"></div>

        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between lg:gap-8">

            {{-- Statistik --}}
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#212A37] text-white shadow-lg shadow-slate-900/20">
                    <span class="material-symbols-outlined text-3xl leading-none">
                        menu_book
                    </span>
                </div>

                <div class="shrink-0">
                    <p class="text-sm font-semibold text-slate-500">
                        Total Repository
                    </p>

                    <h2 id="result-info" class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($skripsis->total(), 0, ',', '.') }}
                        <span class="text-lg font-medium text-slate-500">
                            Skripsi
                        </span>
                    </h2>
                </div>
            </div>

            {{-- Search & Filter --}}
<div class="w-full lg:flex-1">
    <div class="grid grid-cols-1 gap-3 lg:grid-cols-[1fr_280px_auto]">

        {{-- Search --}}
        <div class="group relative">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                <svg
                    class="h-5 w-5 text-slate-400 transition-colors duration-300 group-focus-within:text-[#212A37]"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-4.35-4.35m1.1-5.15a6.5 6.5 0 11-13 0a6.5 6.5 0 0113 0z"/>
                </svg>
            </div>

            <input
                id="search"
                name="search"
                type="text"
                autocomplete="off"
                spellcheck="false"
                value="{{ request('search') }}"
                placeholder="Cari judul, nama mahasiswa, atau NIM..."
                class="w-full rounded-2xl border border-slate-300 bg-white py-3.5 pl-12 pr-4 text-slate-700 shadow-sm transition-all duration-300 placeholder:text-slate-400 focus:border-[#212A37] focus:outline-none focus:ring-4 focus:ring-slate-200">
        </div>

        {{-- Dropdown KBK --}}
        <div>
            <select
                id="kbk"
                name="kbk"
                class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3.5 text-slate-700 shadow-sm transition-all duration-300 focus:border-[#212A37] focus:outline-none focus:ring-4 focus:ring-slate-200">

                <option value="">
                    Semua KBK
                </option>

                @foreach ($kbks as $kbk)
                    <option
                        value="{{ $kbk->id }}"
                        @selected(request('kbk') == $kbk->id)>
                        {{ $kbk->nama_kbk }}
                    </option>
                @endforeach

            </select>
        </div>

        {{-- Button --}}
        <button
            id="search-button"
            type="button"
            class="rounded-2xl bg-slate-950 px-6 py-3.5 font-semibold text-white shadow-lg transition hover:bg-slate-800">
            Search
        </button>

    </div>

    <p class="mt-3 text-sm text-slate-500">
        Cari referensi berdasarkan judul, penulis, NIM, maupun KBK.
    </p>
</div>

        </div>
    </div>
</div>