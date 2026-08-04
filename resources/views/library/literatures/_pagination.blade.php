{{-- Pagination --}}
@if ($literatures->hasPages())

    <div class="mt-6 flex flex-col items-center justify-between gap-4 sm:flex-row">

        {{-- Info halaman --}}
        <p class="text-sm text-gray-600 order-2 sm:order-1">
            Halaman
            <span class="font-medium text-gray-900">{{ $literatures->currentPage() }}</span>
            dari
            <span class="font-medium text-gray-900">{{ $literatures->lastPage() }}</span>
            <span class="hidden sm:inline">
                &middot; {{ $literatures->total() }} data
            </span>
        </p>

        {{-- Navigasi --}}
        <div class="order-1 flex items-center gap-2 sm:order-2">

            {{-- Previous --}}
            @if ($literatures->onFirstPage())
                <span class="inline-flex cursor-not-allowed items-center gap-1 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                </span>
            @else
                <a href="{{ $literatures->previousPageUrl() }}" class="inline-flex items-center gap-1 rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-indigo-400 hover:bg-indigo-50 hover:text-indigo-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Previous
                </a>
            @endif

            {{-- Nomor halaman --}}
            <div class="hidden items-center gap-1 sm:flex">
                @foreach ($literatures->getUrlRange(max(1, $literatures->currentPage() - 1), min($literatures->lastPage(), $literatures->currentPage() + 1)) as $page => $url)
                    @php
                        $isActive = $page == $literatures->currentPage();
                        $pageClass = $isActive
                            ? 'bg-indigo-600 text-white'
                            : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600';
                    @endphp
                    <a href="{{ $url }}" class="{{ $pageClass }} flex h-9 w-9 items-center justify-center rounded-lg text-sm font-medium transition">
                        {{ $page }}
                    </a>
                @endforeach
            </div>

            {{-- Next --}}
            @if ($literatures->hasMorePages())
                <a href="{{ $literatures->nextPageUrl() }}" class="inline-flex items-center gap-1 rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 transition hover:border-indigo-400 hover:bg-indigo-50 hover:text-indigo-600">
                    Next
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <span class="inline-flex cursor-not-allowed items-center gap-1 rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-400">
                    Next
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif

        </div>

    </div>

@endif