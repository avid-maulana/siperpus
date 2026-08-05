@if ($literatures->hasPages())
    <nav class="mt-8 flex items-center justify-center">
        <ul class="inline-flex items-center gap-1.5 rounded-2xl border border-slate-200 bg-white p-1 text-sm font-medium text-slate-700 shadow-sm">
            @if ($literatures->onFirstPage())
                <li>
                    <span class="flex cursor-not-allowed items-center justify-center rounded-xl px-4 py-2.5 text-slate-500">
                        <span class="text-lg leading-none">&laquo;</span>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $literatures->appends(request()->except('page'))->previousPageUrl() }}"
                        data-ajax-page
                        class="flex items-center justify-center rounded-xl px-4 py-2.5 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                        <span class="text-lg leading-none">&laquo;</span>
                    </a>
                </li>
            @endif

            @foreach ($literatures->getUrlRange(
                max(1, $literatures->currentPage() - 2),
                min($literatures->lastPage(), $literatures->currentPage() + 2)
            ) as $page => $url)
                @if ($page == $literatures->currentPage())
                    <li>
                        <span class="flex items-center justify-center rounded-xl bg-[#212A37] px-4 py-2.5 font-semibold text-white">
                            {{ $page }}
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $literatures->appends(request()->except('page'))->url($page) }}"
                            data-ajax-page
                            class="flex items-center justify-center rounded-xl px-4 py-2.5 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                            {{ $page }}
                        </a>
                    </li>
                @endif
            @endforeach

            @if ($literatures->currentPage() + 2 < $literatures->lastPage())
                <li>
                    <span class="px-2 py-2.5 text-slate-500">...</span>
                </li>

                <li>
                    <a href="{{ $literatures->appends(request()->except('page'))->url($literatures->lastPage()) }}"
                        data-ajax-page
                        class="flex items-center justify-center rounded-xl px-4 py-2.5 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                        {{ $literatures->lastPage() }}
                    </a>
                </li>
            @endif

            @if ($literatures->hasMorePages())
                <li>
                    <a href="{{ $literatures->appends(request()->except('page'))->nextPageUrl() }}"
                        data-ajax-page
                        class="flex items-center justify-center rounded-xl px-4 py-2.5 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">
                        <span class="text-lg leading-none">&raquo;</span>
                    </a>
                </li>
            @else
                <li>
                    <span class="flex cursor-not-allowed items-center justify-center rounded-xl px-4 py-2.5 text-slate-500">
                        <span class="text-lg leading-none">&raquo;</span>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif