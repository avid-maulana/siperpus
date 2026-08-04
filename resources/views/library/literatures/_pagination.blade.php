{{-- Pagination --}}
@if ($literatures->hasPages())
    <div class="flex flex-col gap-4 border-t border-[#E5E7EB] px-5 py-5 md:flex-row md:items-center md:justify-between">
        <div class="text-sm text-slate-500">
            Menampilkan {{ $literatures->firstItem() ?: 0 }}–{{ $literatures->lastItem() ?: 0 }} dari {{ $literatures->total() }} data
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($literatures->onFirstPage())
                <span class="cursor-not-allowed rounded-lg border border-[#E5E7EB] bg-slate-100 px-3 py-2 text-sm text-slate-400">
                    ←
                </span>
            @else
                <a
                    href="{{ $literatures->previousPageUrl() }}"
                    class="rounded-lg border border-[#E5E7EB] px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-50"
                >
                    ←
                </a>
            @endif

            @foreach ($literatures->getUrlRange(1, $literatures->lastPage()) as $page => $url)
                <a
                    href="{{ $url }}"
                    class="rounded-lg px-3 py-2 text-sm font-medium transition {{ $page == $literatures->currentPage() ? 'bg-[#2563EB] text-white' : 'border border-[#E5E7EB] text-slate-600 hover:bg-slate-50' }}"
                >
                    {{ $page }}
                </a>
            @endforeach

            @if ($literatures->hasMorePages())
                <a
                    href="{{ $literatures->nextPageUrl() }}"
                    class="rounded-lg border border-[#E5E7EB] px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-50"
                >
                    →
                </a>
            @else
                <span class="cursor-not-allowed rounded-lg border border-[#E5E7EB] bg-slate-100 px-3 py-2 text-sm text-slate-400">
                    →
                </span>
            @endif
        </div>
    </div>
@endif