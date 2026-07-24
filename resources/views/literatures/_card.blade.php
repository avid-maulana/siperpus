<div class="md:hidden space-y-3">

    @foreach ($literatures as $literature)

    <div class="flex gap-3 p-3 border border-slate-200 rounded-xl bg-white shadow-sm hover:shadow-md transition">

        <img
            src="{{ $literature->cover_url ?: asset('asset/default-cover.jpg') }}"
            alt="Cover {{ $literature->title }}"
            class="w-16 h-24 object-cover rounded-md border border-slate-200 flex-shrink-0">

        <div class="min-w-0 flex-1">

            {{-- Judul --}}
            <p class="font-semibold text-slate-800 leading-snug line-clamp-2">
                {{ $literature->title ?? '-' }}
            </p>

            {{-- Penulis --}}
            <p class="text-xs text-slate-500 mt-1">
                {{ $literature->author ?? '-' }}
            </p>

            {{-- Prodi --}}
            @if(!empty($literature->prodi))
                <span class="inline-flex items-center mt-2 px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-[11px] font-semibold">
                    🎓 {{ $literature->prodi }}
                </span>
            @endif

            {{-- Penerbit & Tahun --}}
            <p class="text-xs text-slate-400 mt-2">
                {{ $literature->publisher ?? '-' }}
                &middot;
                {{ $literature->year ?? '-' }}
            </p>

            @if ($literature->file_url)

                <a
                    href="{{ asset($literature->file_url) }}"
                    target="_blank"
                    class="inline-flex items-center mt-3 text-xs font-semibold text-blue-600 hover:text-blue-800">

                    📄 Unduh

                </a>

            @endif

        </div>

    </div>

    @endforeach

</div>