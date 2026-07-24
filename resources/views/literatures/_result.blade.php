<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">

    <p class="text-sm text-slate-500">
        <span class="font-semibold text-slate-700">
            {{ $literatures->total() }}
        </span>

        literatur ditemukan

        @if(request('search'))
            untuk
            <span class="font-semibold text-slate-800">
                "{{ request('search') }}"
            </span>
        @endif
    </p>

    @if(request('search'))
        <button
            type="button"
            id="resetSearch"
            class="self-start text-sm font-medium text-red-500 hover:text-red-600 transition-colors">

            Reset Pencarian

        </button>
    @endif

</div>

@if($literatures->isEmpty())

    <div class="rounded-xl border border-dashed border-slate-300 py-16 text-center">

        <svg
            class="mx-auto w-12 h-12 text-slate-300"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M21 21l-4.35-4.35m1.35-5.15a6.5 6.5 0 11-13 0a6.5 6.5 0 0113 0z"/>

        </svg>

        <h3 class="mt-4 text-lg font-semibold text-slate-700">
            Literatur tidak ditemukan
        </h3>

        <p class="mt-2 text-sm text-slate-500">
            Coba gunakan kata kunci yang berbeda.
        </p>

    </div>

@else

    @include('literatures._table')

    @include('literatures._card')

    @include('literatures._pagination')

@endif