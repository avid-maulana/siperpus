<div class="hidden md:block overflow-hidden border border-slate-200 rounded-xl">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-slate-50 text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                <th class="w-24 px-4 py-3">Cover</th>
                <th class="px-4 py-3">Judul</th>
                <th class="w-56 px-4 py-3">Penulis</th>
                <th class="w-56 px-4 py-3">Penerbit</th>
                <th class="w-24 px-4 py-3">Tahun</th>
                <th class="w-28 px-4 py-3 text-center">Berkas</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-slate-100">
            @foreach ($literatures as $literature)
            <tr class="hover:bg-slate-50/70 transition-colors">

                <td class="px-4 py-3">
                    <img
                        src="{{ $literature->cover_url ?: asset('asset/default-cover.jpg') }}"
                        alt="Cover {{ $literature->title }}"
                        class="w-14 h-20 object-cover rounded-md border border-slate-200">
                </td>

                <td class="px-4 py-3 font-medium text-slate-800">
                    {{ $literature->title ?? '-' }}
                </td>

                <td class="px-4 py-3 text-slate-600">
                    {{ $literature->author ?? '-' }}
                </td>

                <td class="px-4 py-3 text-slate-600">
                    {{ $literature->publisher ?? '-' }}
                </td>

                <td class="px-4 py-3">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-xs font-medium">
                        {{ $literature->year ?? '-' }}
                    </span>
                </td>

                <td class="px-4 py-3 text-center">
                    @if ($literature->file_url)

                    <a href="{{ asset($literature->file_url) }}"
                        target="_blank"
                        class="inline-flex items-center gap-1 text-blue-500 hover:text-blue-700 font-medium text-xs">
                        Unduh
                    </a>

                    @else

                    <span class="text-slate-300 text-xs">
                        -
                    </span>

                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>