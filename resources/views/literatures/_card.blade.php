<div class="md:hidden space-y-3">

    @foreach ($literatures as $literature)

    <div class="flex gap-3 p-3 border border-slate-200 rounded-xl">

        <img
            src="{{ $literature->cover_url ?: asset('asset/default-cover.jpg') }}"
            alt="Cover {{ $literature->title }}"
            class="w-16 h-24 object-cover rounded-md border border-slate-200 flex-shrink-0">

        <div class="min-w-0 flex-1">

            <p class="font-medium text-slate-800 leading-snug">
                {{ $literature->title ?? '-' }}
            </p>

            <p class="text-xs text-slate-500 mt-1">
                {{ $literature->author ?? '-' }}
            </p>

            <p class="text-xs text-slate-400">
                {{ $literature->publisher ?? '-' }}
                &middot;
                {{ $literature->year ?? '-' }}
            </p>

            @if ($literature->file_url)

            <a
                href="{{ asset($literature->file_url) }}"
                target="_blank"
                class="inline-block mt-2 text-xs font-medium text-blue-500 hover:text-blue-700">

                Unduh

            </a>

            @endif

        </div>

    </div>

    @endforeach

</div>