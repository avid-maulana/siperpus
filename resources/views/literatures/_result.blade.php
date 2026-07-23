<div class="flex items-center justify-between mb-4">
    <p class="text-sm text-slate-500">
        <span class="font-semibold text-slate-700">{{ $literatures->total() }}</span>
        literatur ditemukan

        @if(request('search'))
            untuk "<span class="font-medium text-slate-700">{{ request('search') }}</span>"
        @endif
    </p>

    @if(request('search') || request('type_id') || request('category_id'))
        <a href="{{ route('literatures.index') }}"
            data-ajax-page
            data-reset-filter
            class="text-xs font-medium text-red-500 hover:text-red-700 hover:underline">
            Reset filter
        </a>
    @endif
</div>

@if ($literatures->isEmpty())

    <div class="text-center py-16 border border-dashed border-slate-200 rounded-xl">
        <p class="text-slate-500 text-sm">
            Tidak ada literatur yang cocok dengan pencarianmu.
        </p>
    </div>

@else

    {{-- Desktop --}}
    @include('literatures._table')

    {{-- Mobile --}}
    @include('literatures._card')

    {{-- Pagination --}}
    @include('literatures._pagination')

@endif