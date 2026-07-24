{{-- Metadata untuk AJAX --}}
<div
    id="result-meta"
    data-total="{{ $skripsis->total() }}"
    data-current-page="{{ $skripsis->currentPage() }}"
    data-last-page="{{ $skripsis->lastPage() }}"
    hidden>
</div>

@if($skripsis->count())

    <div class="grid grid-cols-3 gap-6">

        @foreach($skripsis as $skripsi)

            @include('skripsi._card')

        @endforeach

    </div>

@else

    <div class="rounded-2xl border border-slate-200 bg-white py-20 text-center shadow-sm">

        <div
            class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-slate-100">

            <svg
                class="h-10 w-10 text-slate-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15a7.5 7.5 0 000 15z"/>

            </svg>

        </div>

        <h3 class="mt-6 text-xl font-semibold text-slate-800">
            Skripsi tidak ditemukan
        </h3>

        <p class="mt-2 text-slate-500">
            Coba gunakan kata kunci lain.
        </p>

    </div>

@endif

@if($skripsis->hasPages())

    <div class="mt-10 flex justify-center">

        @include('skripsi._pagination')

    </div>

@endif