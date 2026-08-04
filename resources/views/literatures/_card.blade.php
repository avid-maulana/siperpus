<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
@foreach ($literatures as $literature)

<article class="group flex h-full flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:border-slate-300 hover:shadow-xl">

    {{-- Cover + Title Overlay --}}
    <div class="relative overflow-hidden">
        <img
            src="{{ $literature->cover_url ?: asset('asset/cover.jpg') }}"
            alt="{{ $literature->title }}"
            class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">

        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/25 to-transparent"></div>

        <div class="absolute inset-x-0 bottom-0 p-5">
            @if($literature->category)
                <div class="mb-3 inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-[10px] font-semibold uppercase tracking-widest text-slate-600 shadow-sm backdrop-blur">
                    {{ $literature->category->name }}
                </div>
            @endif

            <h2 class="line-clamp-2 text-[18px] font-semibold leading-tight text-white transition-all duration-300 group-hover:line-clamp-none">
                {{ $literature->title }}
            </h2>
        </div>
    </div>

    {{-- Content --}}
    <div class="flex flex-1 flex-col p-6">

        <div class="space-y-5">
            @if($literature->author)
            <div class="flex items-start gap-3">
                <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 ring-1 ring-inset ring-slate-200">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                </div>

                <div>
                    <div class="text-[10px] uppercase tracking-widest text-slate-400">
                        Penulis
                    </div>

                    <div class="text-sm font-semibold text-slate-700">
                        {{ $literature->author }}
                    </div>
                </div>
            </div>
            @endif

            @if($literature->publisher || $literature->year)
            <div class="flex items-start gap-3">
                <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-500 ring-1 ring-inset ring-slate-200">
                    <span class="material-symbols-outlined text-[20px]">menu_book</span>
                </div>

                <div>
                    <div class="text-[10px] uppercase tracking-widest text-slate-400">
                        Publikasi
                    </div>

                    <div class="text-sm font-semibold text-slate-700">
                        {{ $literature->publisher }}
                        @if($literature->year)
                            • {{ $literature->year }}
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Deskripsi --}}
        <div class="mt-6 border-t border-slate-100 pt-5">
            <h4 class="mb-3 text-xs font-semibold uppercase tracking-widest text-slate-500">
                Deskripsi
            </h4>

            <p class="line-clamp-4 text-sm leading-7 text-slate-600">
                {{
                    $literature->description
                        ? \Illuminate\Support\Str::limit($literature->description,150)
                        : 'Tidak ada deskripsi untuk literatur ini.'
                }}
            </p>
        </div>

        {{-- Footer --}}
        <div class="mt-auto pt-6">
    @if($literature->file_url)
        <a
            href="{{ asset($literature->file_url) }}"
            target="_blank"
            class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition-all duration-300 hover:border-[#212A37] hover:bg-[#212A37] hover:text-white hover:shadow-lg">
            <span class="material-symbols-outlined text-[20px]">download</span>
            Unduh
        </a>
    @else
        <button
            disabled
            class="inline-flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-2xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-400">
            <span class="material-symbols-outlined text-[20px]">block</span>
            Belum tersedia
        </button>
    @endif
</div>

    </div>
</article>

@endforeach
</div>