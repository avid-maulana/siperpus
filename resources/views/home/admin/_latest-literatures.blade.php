{{-- Latest Literatures --}}
<section
    class="rounded-2xl border border-slate-200
           bg-white shadow-sm">

    {{-- Header --}}
    <div
        class="flex items-center justify-between gap-4
               border-b border-slate-100 px-6 py-5">

        <div>
            <h2 class="font-semibold text-slate-900">
                Literatur Terbaru
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Koleksi literatur yang baru ditambahkan.
            </p>
        </div>


        {{-- See All --}}
        <a
            href="{{ route('literatures.index') }}"
            class="inline-flex shrink-0 items-center gap-1
                   text-sm font-semibold text-blue-600
                   transition hover:text-blue-700">

            Lihat Semua

            <span class="material-symbols-outlined text-[18px]">
                arrow_forward
            </span>

        </a>

    </div>


    {{-- Content --}}
    <div class="divide-y divide-slate-100">

        @forelse ($latestLiteratures as $literature)

            <a
                href="{{ route('literatures.index', ['search' => $literature->title]) }}"
                class="group flex items-center gap-4
                       px-6 py-4
                       transition hover:bg-slate-50">

                {{-- Cover --}}
                <div
                    class="flex h-14 w-11 shrink-0
                           items-center justify-center
                           overflow-hidden rounded-lg
                           border border-slate-200
                           bg-slate-100">

                    @if ($literature->cover_url)

                        <img
                            src="{{ $literature->cover_url }}"
                            alt="{{ $literature->title }}"
                            class="h-full w-full object-cover">

                    @else

                        <span
                            class="material-symbols-outlined
                                   text-xl text-slate-400">
                            menu_book
                        </span>

                    @endif

                </div>


                {{-- Information --}}
                <div class="min-w-0 flex-1">

                    {{-- Category --}}
                    <div class="mb-1 flex items-center gap-2">

                        @if ($literature->category)

                            <span
                                class="max-w-[180px] truncate
                                       rounded-md bg-blue-50
                                       px-2 py-0.5
                                       text-[10px] font-semibold
                                       uppercase tracking-wide
                                       text-blue-600">

                                {{ $literature->category->name }}

                            </span>

                        @endif


                        @if ($literature->year)

                            <span class="text-xs text-slate-400">
                                {{ $literature->year }}
                            </span>

                        @endif

                    </div>


                    {{-- Title --}}
                    <h3
                        class="truncate text-sm font-semibold
                               text-slate-800
                               transition
                               group-hover:text-blue-600">

                        {{ $literature->title }}

                    </h3>


                    {{-- Author --}}
                    <p class="mt-1 truncate text-xs text-slate-500">

                        {{ $literature->author ?? 'Penulis tidak tersedia' }}

                    </p>

                </div>


                {{-- Arrow --}}
                <div
                    class="flex h-8 w-8 shrink-0
                           items-center justify-center
                           rounded-lg text-slate-300
                           transition-all duration-200
                           group-hover:bg-blue-50
                           group-hover:text-blue-600">

                    <span class="material-symbols-outlined text-[18px]">
                        chevron_right
                    </span>

                </div>

            </a>

        @empty

            {{-- Empty State --}}
            <div
                class="flex min-h-[280px]
                       flex-col items-center
                       justify-center px-6 py-12
                       text-center">

                <div
                    class="flex h-14 w-14
                           items-center justify-center
                           rounded-2xl bg-slate-100
                           text-slate-400">

                    <span class="material-symbols-outlined text-2xl">
                        library_books
                    </span>

                </div>

                <h3 class="mt-4 text-sm font-semibold text-slate-700">
                    Belum ada literatur
                </h3>

                <p class="mt-1 max-w-xs text-xs leading-5 text-slate-400">
                    Literatur yang baru ditambahkan akan ditampilkan di sini.
                </p>

            </div>

        @endforelse

    </div>

</section>