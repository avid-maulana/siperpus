@extends('layouts.app')

@section('title', 'Repository Tesis')

@section('content')

<div class="min-h-screen bg-slate-50">

    {{-- ============================================================ --}}
    {{-- HERO --}}
    {{-- ============================================================ --}}

    <section class="relative overflow-hidden bg-slate-900">

        {{-- Background --}}

        <div class="absolute inset-0">

            <img
                src="{{ asset('gambar/rak 3.png') }}"
                alt=""
                class="h-full w-full object-cover opacity-30">

            <div
                class="absolute inset-0
                       bg-gradient-to-r
                       from-slate-950
                       via-slate-900/90
                       to-slate-900/50">
            </div>

        </div>


        <div
            class="relative mx-auto
                   max-w-7xl
                   px-6 py-20
                   lg:px-8">

            <div class="max-w-3xl">

                {{-- Label --}}

                <div
                    class="mb-5 inline-flex
                           items-center gap-2
                           rounded-full
                           border border-white/10
                           bg-white/10
                           px-4 py-2
                           text-sm font-medium
                           text-white
                           backdrop-blur">

                    <span
                        class="material-symbols-outlined
                               text-[18px]">

                        school

                    </span>

                    Pascasarjana

                </div>


                {{-- Title --}}

                <h1
                    class="text-4xl
                           font-bold
                           tracking-tight
                           text-white
                           sm:text-5xl">

                    Repository Tesis

                </h1>


                {{-- Description --}}

                <p
                    class="mt-5
                           max-w-2xl
                           text-base
                           leading-7
                           text-slate-300
                           sm:text-lg">

                    Temukan dan akses koleksi tesis
                    yang telah tersedia di repository
                    perpustakaan.

                </p>

            </div>

        </div>

    </section>


    {{-- ============================================================ --}}
    {{-- CONTENT --}}
    {{-- ============================================================ --}}

    <section
        class="mx-auto
               max-w-7xl
               px-6 py-10
               lg:px-8">


        {{-- ======================================================== --}}
        {{-- FILTER --}}
        {{-- ======================================================== --}}

        @include('theses._filter')


        {{-- ======================================================== --}}
        {{-- RESULT --}}
        {{-- ======================================================== --}}

        <div
            id="thesisResult"
            class="mt-8">

            @include(
            'theses._result',
            [
            'theses' => $theses,
            'currentPage' => $currentPage,
            'lastPage' => $lastPage,
            'total' => $total,
            ]
            )

        </div>

    </section>

</div>

@endsection


{{-- ================================================================ --}}
{{-- JAVASCRIPT --}}
{{-- ================================================================ --}}

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', () => {

        /*
        |--------------------------------------------------------------------------
        | ELEMENT
        |--------------------------------------------------------------------------
        */

        const form =
            document.getElementById(
                'thesisSearchForm'
            );

        const input =
            document.getElementById(
                'thesisSearchInput'
            );

        const result =
            document.getElementById(
                'thesisResult'
            );

        const loading =
            document.getElementById(
                'thesisSearchLoading'
            );

        const clearButton =
            document.getElementById(
                'thesisClearSearch'
            );


        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */

        if (
            !form ||
            !input ||
            !result
        ) {

            return;

        }


        let searchTimer = null;


        /*
        |--------------------------------------------------------------------------
        | SHOW LOADING
        |--------------------------------------------------------------------------
        */

        function showLoading() {

            if (!loading) {
                return;
            }


            loading.classList.remove(
                'hidden'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | HIDE LOADING
        |--------------------------------------------------------------------------
        */

        function hideLoading() {

            if (!loading) {
                return;
            }


            loading.classList.add(
                'hidden'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | LOAD TESIS
        |--------------------------------------------------------------------------
        */

        async function loadTheses(
            page = 1,
            updateUrl = true
        ) {

            const search =
                input.value.trim();


            const params =
                new URLSearchParams();


            /*
            |--------------------------------------------------------------------------
            | Search
            |--------------------------------------------------------------------------
            */

            if (search.length > 0) {

                params.set(
                    'search',
                    search
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Page
            |--------------------------------------------------------------------------
            */

            params.set(
                'page',
                page
            );


            /*
            |--------------------------------------------------------------------------
            | Loading
            |--------------------------------------------------------------------------
            */

            showLoading();


            result.classList.add(
                'opacity-50',
                'pointer-events-none',
                'transition-opacity',
                'duration-200'
            );


            try {

                const response =
                    await fetch(
                        `${form.action}?${params.toString()}`, {
                            method: 'GET',

                            headers: {

                                'X-Requested-With': 'XMLHttpRequest',

                                'Accept': 'text/html',

                            },

                        }
                    );


                /*
                |--------------------------------------------------------------------------
                | HTTP ERROR
                |--------------------------------------------------------------------------
                */

                if (!response.ok) {

                    throw new Error(
                        `HTTP ${response.status}`
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | HTML
                |--------------------------------------------------------------------------
                */

                const html =
                    await response.text();


                /*
                |--------------------------------------------------------------------------
                | Update Result
                |--------------------------------------------------------------------------
                */

                result.innerHTML =
                    html;


                /*
                |--------------------------------------------------------------------------
                | Update URL
                |--------------------------------------------------------------------------
                */

                if (updateUrl) {

                    const newUrl =
                        `${form.action}?${params.toString()}`;


                    window.history.replaceState({},
                        '',
                        newUrl
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Scroll
                |--------------------------------------------------------------------------
                |
                | Setelah pagination/search, kita tidak
                | scroll sampai atas halaman.
                |
                | Cukup sedikit menuju area hasil.
                |
                */

                if (page > 1) {

                    result.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                }


            } catch (error) {

                console.error(
                    'Gagal mengambil data tesis:',
                    error
                );


                /*
                |--------------------------------------------------------------------------
                | Error State
                |--------------------------------------------------------------------------
                */

                result.innerHTML = `

                <div
                    class="rounded-2xl
                           border border-red-200
                           bg-red-50
                           px-6 py-12
                           text-center">

                    <span
                        class="material-symbols-outlined
                               text-[32px]
                               text-red-400">

                        error

                    </span>


                    <h3
                        class="mt-4
                               text-base
                               font-bold
                               text-red-800">

                        Gagal memuat data tesis

                    </h3>


                    <p
                        class="mt-2
                               text-sm
                               text-red-600">

                        Silakan coba lagi beberapa saat.

                    </p>

                </div>

            `;

            } finally {

                hideLoading();


                result.classList.remove(
                    'opacity-50',
                    'pointer-events-none'
                );

            }

        }


        /*
        |--------------------------------------------------------------------------
        | SEARCH DEBOUNCE
        |--------------------------------------------------------------------------
        */

        input.addEventListener(
            'input',
            () => {

                clearTimeout(
                    searchTimer
                );


                searchTimer =
                    setTimeout(
                        () => {

                            loadTheses(
                                1
                            );

                        },
                        400
                    );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        |
        | _pagination.blade.php menggunakan:
        |
        | data-thesis-page="..."
        |
        */

        result.addEventListener(
            'click',
            (event) => {

                const button =
                    event.target.closest(
                        '[data-thesis-page]'
                    );


                if (!button) {
                    return;
                }


                event.preventDefault();


                const page =
                    parseInt(
                        button.dataset.thesisPage,
                        10
                    );


                if (
                    !page ||
                    page < 1
                ) {

                    return;

                }


                loadTheses(
                    page
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | CLEAR SEARCH
        |--------------------------------------------------------------------------
        */

        if (clearButton) {

            clearButton.addEventListener(
                'click',
                () => {

                    input.value = '';

                    loadTheses(
                        1
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | ENTER
        |--------------------------------------------------------------------------
        |
        | Mencegah form melakukan reload halaman.
        |
        */

        form.addEventListener(
            'submit',
            (event) => {

                event.preventDefault();


                clearTimeout(
                    searchTimer
                );


                loadTheses(
                    1
                );

            }
        );


    });
</script>

@endpush