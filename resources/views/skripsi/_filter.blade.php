<div class="relative z-20 mx-auto -mt-14 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div
        class="relative overflow-hidden rounded-[30px] border border-slate-200/70 bg-white/95 p-6 shadow-[0_25px_70px_-20px_rgba(15,23,42,.28)] backdrop-blur-xl sm:p-8">

        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-white to-slate-100"></div>
        <div
            class="absolute -top-32 -left-24 h-72 w-72 rounded-full bg-slate-200/30 blur-3xl">
        </div>

        <div class="relative flex flex-col gap-8 lg:flex-row lg:items-center">

            {{-- Statistik --}}
            <div class="flex items-center gap-4 lg:min-w-[250px]">

                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#212A37] text-white shadow-lg">

                    <span class="material-symbols-outlined text-3xl">
                        menu_book
                    </span>

                </div>

                <div>

                    <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                        Repository
                    </p>

                    <h2
                        id="result-info"
                        class="mt-1 text-3xl font-bold text-slate-900">

                        {{ number_format($skripsis->total(),0,',','.') }}

                        <span class="text-lg font-medium text-slate-500">
                            Skripsi
                        </span>

                    </h2>

                </div>

            </div>

            {{-- Search Area --}}
            <div class="flex-1">

                <div class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_300px_auto]">

                    {{-- Search --}}
                    <div class="relative group">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400 transition group-focus-within:text-[#212A37]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-4.35-4.35m1.1-5.15a6.5 6.5 0 11-13 0a6.5 6.5 0 0113 0z" />

                        </svg>

                        <input
                            id="search"
                            name="search"
                            type="text"
                            autocomplete="off"
                            spellcheck="false"
                            value="{{ request('search') }}"
                            placeholder="Cari judul, nama mahasiswa, atau NIM..."
                            class="h-14 w-full rounded-2xl border border-slate-300 bg-white pl-14 pr-5 text-[15px] text-slate-700 shadow-sm transition focus:border-[#212A37] focus:ring-4 focus:ring-slate-200 focus:outline-none">

                    </div>

                    {{-- KBK --}}
                    <div class="relative">

                        <label
                            class="absolute left-5 top-2 text-[10px] font-semibold uppercase tracking-widest text-slate-400">
                            KBK
                        </label>

                        <select
                            id="kbk"
                            name="kbk"
                            class="peer h-14 w-full appearance-none rounded-2xl border border-slate-300 bg-white px-5 pt-4 text-slate-700 shadow-sm transition focus:border-[#212A37] focus:ring-4 focus:ring-slate-200 focus:outline-none">

                            <option value="">Semua KBK</option>

                            @foreach($kbks as $kbk)

                            <option
                                value="{{ $kbk->id }}"
                                @selected(request('kbk')==$kbk->id)>

                                {{ $kbk->nama_kbk }}

                            </option>

                            @endforeach

                        </select>

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="pointer-events-none absolute right-5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-500"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7" />

                        </svg>

                    </div>

                    {{-- Button --}}
                    <button
                        id="search-button"
                        type="button"
                        class="flex h-14 items-center justify-center gap-2 rounded-2xl bg-[#212A37] px-8 font-semibold text-white shadow-lg transition-all duration-300 hover:-translate-y-0.5 hover:bg-slate-800 hover:shadow-xl">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-4.35-4.35m1.1-5.15a6.5 6.5 0 11-13 0a6.5 6.5 0 0113 0z" />

                        </svg>

                        Search

                    </button>

                </div>

                <p class="mt-4 text-sm text-slate-500">
                    Temukan referensi skripsi berdasarkan <span class="font-medium">judul</span>,
                    <span class="font-medium">nama mahasiswa</span>,
                    <span class="font-medium">NIM</span>,
                    maupun <span class="font-medium">Kelompok Bidang Keahlian (KBK)</span>.
                </p>

            </div>

        </div>

    </div>
</div>