{{-- Pagination --}}
@if ($literatures->hasPages())

    <div class="mt-6 flex items-center justify-between text-sm text-gray-700">

        {{-- Previous --}}
        @if ($literatures->onFirstPage())
            <span class="cursor-not-allowed opacity-50">
                ← Previous
            </span>
        @else
            <a
                href="{{ $literatures->previousPageUrl() }}"
                class="text-indigo-600 transition hover:underline"
            >
                ← Previous
            </a>
        @endif


        {{-- Page Information --}}
        <span>
            Halaman
            {{ $literatures->currentPage() }}
            dari
            {{ $literatures->lastPage() }}
        </span>


        {{-- Next --}}
        @if ($literatures->hasMorePages())
            <a
                href="{{ $literatures->nextPageUrl() }}"
                class="text-indigo-600 transition hover:underline"
            >
                Next →
            </a>
        @else
            <span class="cursor-not-allowed opacity-50">
                Next →
            </span>
        @endif

    </div>

@endif