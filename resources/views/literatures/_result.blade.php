{{-- Metadata AJAX --}}
<div
    id="result-meta"
    data-total="{{ $literatures->total() }}"
    data-current-page="{{ $literatures->currentPage() }}"
    data-last-page="{{ $literatures->lastPage() }}"
    hidden>
</div>

<div class="rounded-[2rem] border border-slate-200 bg-white p-4 shadow-sm sm:p-6">
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <p class="text-sm font-medium uppercase text-slate-500">Hasil pencarian</p>
            <h2 class="mt-1 text-2xl font-semibold text-slate-900">
                {{ $literatures->total() }} literatur tersedia
            </h2>
        </div>

        @if(request()->hasAny(['search', 'type_id', 'category_id']))
            <div class="flex flex-wrap gap-2">
                @if(request('search'))
                    <span class="rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-sm text-blue-700">
                        Pencarian: {{ request('search') }}
                    </span>
                @endif

                @if(request('type'))
                    <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-sm text-slate-700">
                        Tipe: {{ ucfirst(request('type')) }}
                    </span>
                @endif

                @if(request('category_id'))
                    <span class="rounded-full border border-slate-200 bg-slate-50 px-3 py-1 text-sm text-slate-700">
                        Kategori: {{ $categories->firstWhere('id', request('category_id'))?->name ?? '-' }}
                    </span>
                @endif
            </div>
        @endif
    </div>

    @if($literatures->isEmpty())
        <div class="rounded-[1.5rem] border border-dashed border-slate-200 bg-slate-50 p-12 text-center">
            <span class="material-symbols-outlined text-5xl text-slate-400">search_off</span>
            <h3 class="mt-4 text-lg font-semibold text-slate-900">Literatur tidak ditemukan</h3>
            <p class="mt-2 text-sm text-slate-500">Coba ubah kata kunci, tipe, atau kategori untuk menemukan koleksi yang Anda cari.</p>
        </div>
    @else
        @include('literatures._card')
        @include('literatures._pagination')
    @endif
</div>
