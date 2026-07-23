@if ($skripsis->hasPages())
<nav class="mt-8 flex items-center justify-center">
    <ul class="inline-flex items-center gap-1.5 text-sm font-medium bg-white rounded-2xl shadow-sm border border-slate-200 p-1">
        
        {{-- Previous --}}
        @if ($skripsis->onFirstPage())
            <li>
                <span class="flex items-center justify-center px-4 py-2.5 rounded-xl text-slate-300 cursor-not-allowed">
                    <span class="text-lg leading-none">&laquo;</span>
                </span>
            </li>
        @else
            <li>
                <a href="{{ $skripsis->previousPageUrl() }}#top"
                   onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
                   class="pagination-link flex items-center justify-center px-4 py-2.5 rounded-xl text-slate-700 hover:text-white hover:bg-blue-600 transition-all duration-200">
                    <span class="text-lg leading-none">&laquo;</span>
                </a>
            </li>
        @endif

        {{-- Nomor Halaman --}}
        @foreach ($skripsis->getUrlRange(max(1, $skripsis->currentPage() - 2), min($skripsis->lastPage(), $skripsis->currentPage() + 2)) as $page => $url)
            @if ($page == $skripsis->currentPage())
                <li>
                    <span class="flex items-center justify-center px-4 py-2.5 rounded-xl bg-blue-600 text-white font-semibold shadow-sm">
                        {{ $page }}
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $url }}#top"
                       onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
                       class="pagination-link flex items-center justify-center px-4 py-2.5 rounded-xl text-slate-700 hover:bg-blue-600 hover:text-white transition-all duration-200">
                        {{ $page }}
                    </a>
                </li>
            @endif
        @endforeach

        {{-- Ellipsis & Last Page --}}
        @if ($skripsis->currentPage() + 2 < $skripsis->lastPage())
            <li>
                <span class="px-2 py-2.5 text-slate-400">...</span>
            </li>
            <li>
                <a href="{{ $skripsis->url($skripsis->lastPage()) }}#top"
                   onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
                   class="pagination-link flex items-center justify-center px-4 py-2.5 rounded-xl text-slate-700 hover:bg-blue-600 hover:text-white transition-all duration-200">
                    {{ $skripsis->lastPage() }}
                </a>
            </li>
        @endif

        {{-- Next --}}
        @if ($skripsis->hasMorePages())
            <li>
                <a href="{{ $skripsis->nextPageUrl() }}#top"
                   onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
                   class="pagination-link flex items-center justify-center px-4 py-2.5 rounded-xl text-slate-700 hover:text-white hover:bg-blue-600 transition-all duration-200">
                    <span class="text-lg leading-none">&raquo;</span>
                </a>
            </li>
        @else
            <li>
                <span class="flex items-center justify-center px-4 py-2.5 rounded-xl text-slate-300 cursor-not-allowed">
                    <span class="text-lg leading-none">&raquo;</span>
                </span>
            </li>
        @endif
    </ul>
</nav>
@endif