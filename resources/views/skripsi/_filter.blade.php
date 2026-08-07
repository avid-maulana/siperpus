{{-- Search & Filter --}}
<div
    class="relative overflow-hidden
           rounded-[24px]
           border border-slate-200
           bg-white
           px-6 py-5
           shadow-[0_20px_60px_-30px_rgba(15,23,42,0.30)]
           sm:px-7">

    <div class="relative">

        <div class="grid grid-cols-1 gap-3
                    lg:grid-cols-[minmax(0,1fr)_260px_120px]
                    lg:items-end">


            {{-- =====================================================
                SEARCH
            ====================================================== --}}
            <div>

                <label
                    for="search"
                    class="mb-1.5 block text-xs font-semibold
                           uppercase tracking-wider text-slate-500">

                    Pencarian

                </label>

                <div class="group relative">

                    {{-- Search Icon --}}
                    <div
                        class="pointer-events-none absolute inset-y-0 left-0
                               flex items-center pl-4">

                        <span
                            class="material-symbols-outlined
                                   text-[21px] text-slate-400
                                   transition-colors
                                   group-focus-within:text-[#212A37]">

                            search

                        </span>

                    </div>


                    {{-- Search Input --}}
                    <input
                        id="search"
                        name="search"
                        type="text"
                        autocomplete="off"
                        spellcheck="false"
                        value="{{ request('search') }}"
                        placeholder="Cari judul, nama mahasiswa, atau NIM..."
                        class="h-[52px] w-full
                               rounded-xl
                               border border-slate-300
                               bg-white
                               pl-12 pr-4
                               text-sm text-slate-700
                               shadow-sm
                               outline-none
                               transition-all duration-200
                               placeholder:text-slate-400
                               focus:border-[#212A37]
                               focus:ring-4
                               focus:ring-slate-100">

                </div>

            </div>


            {{-- =====================================================
                KBK
            ====================================================== --}}
            <div>

                <label
                    for="kbk"
                    class="mb-1.5 block text-xs font-semibold
                           uppercase tracking-wider text-slate-500">

                    KBK

                </label>

                <div class="relative">

                    <select
                        id="kbk"
                        name="kbk"
                        class="h-[52px] w-full
                               appearance-none
                               rounded-xl
                               border border-slate-300
                               bg-white
                               pl-4 pr-10
                               text-sm text-slate-700
                               shadow-sm
                               outline-none
                               transition-all duration-200
                               focus:border-[#212A37]
                               focus:ring-4
                               focus:ring-slate-100">

                        <option value="">
                            Semua KBK
                        </option>

                        @foreach($kbks as $kbk)

                            <option
                                value="{{ $kbk->id }}"
                                @selected(request('kbk') == $kbk->id)>

                                {{ $kbk->nama_kbk }}

                            </option>

                        @endforeach

                    </select>


                    <span
                        class="material-symbols-outlined
                               pointer-events-none
                               absolute right-3 top-1/2
                               -translate-y-1/2
                               text-[20px] text-slate-400">

                        keyboard_arrow_down

                    </span>

                </div>

            </div>


            {{-- =====================================================
                SEARCH BUTTON
            ====================================================== --}}
            <div>

                <button
                    id="search-button"
                    type="button"
                    class="flex h-[52px] w-full
                           items-center justify-center gap-2
                           rounded-xl
                           bg-[#212A37]
                           px-5
                           text-sm font-semibold text-white
                           shadow-sm
                           transition-all duration-200
                           hover:bg-[#18202b]">

                    <span class="material-symbols-outlined text-[20px]">
                        search
                    </span>

                    <span>
                        Search
                    </span>

                </button>

            </div>

        </div>


        {{-- =========================================================
            DESCRIPTION
        ========================================================== --}}
        <p class="mt-3 text-xs leading-5 text-slate-500">

            Temukan referensi skripsi berdasarkan
            <span class="font-medium">judul</span>,
            <span class="font-medium">nama mahasiswa</span>,
            <span class="font-medium">NIM</span>,
            maupun
            <span class="font-medium">
                Kelompok Bidang Keahlian (KBK)
            </span>.

        </p>

    </div>

</div>