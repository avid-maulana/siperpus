{{-- Metadata untuk AJAX --}}
<div
    id="result-meta"
    data-total="{{ $skripsis->total() }}"
    data-current-page="{{ $skripsis->currentPage() }}"
    data-last-page="{{ $skripsis->lastPage() }}"
    hidden>
</div>

@if($skripsis->count())

    <div class="space-y-5">

        @foreach($skripsis as $skripsi)

            @include('skripsi._card')

        @endforeach

    </div>

@else

    <div
        class="bg-white border border-slate-200 rounded-2xl py-16 px-6 text-center">

        <svg class="w-14 h-14 mx-auto text-slate-300"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor">

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="1.5"
                d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15a7.5 7.5 0 000 15z" />

        </svg>

        <h3 class="mt-4 text-lg font-semibold text-slate-700">
            Skripsi tidak ditemukan
        </h3>

        <p class="mt-2 text-slate-500">
            Coba gunakan kata kunci lain atau ubah filter pencarian.
        </p>

    </div>

@endif

@if($skripsis->hasPages())

    <div class="mt-8 pagination">

        @include('skripsi._pagination')

    </div>

@endif