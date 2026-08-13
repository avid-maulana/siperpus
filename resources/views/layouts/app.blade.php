<!DOCTYPE html>
<html lang="id">

<head>

    @include('layouts.partials.head')

    {{-- ============================================================ --}}
    {{-- CSRF TOKEN --}}
    {{-- ============================================================ --}}

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}">


    {{-- ============================================================ --}}
    {{-- Google Material Symbols --}}
    {{-- ============================================================ --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"
        rel="stylesheet">


    {{-- ============================================================ --}}
    {{-- Vite --}}
    {{-- ============================================================ --}}

    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])

</head>


<body class="bg-slate-50 font-sans antialiased text-slate-800">


    {{-- ============================================================ --}}
    {{-- NAVBAR --}}
    {{-- ============================================================ --}}

    @include('layouts.partials.navbar')


    {{-- ============================================================ --}}
    {{-- MAIN CONTENT --}}
    {{-- ============================================================ --}}

    <main
        id="page-content"
        class="translate-y-3 opacity-0 pt-20">

        @yield('content')

    </main>


    {{-- ============================================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================================ --}}

    @include('layouts.partials.footer')


    {{-- ============================================================ --}}
    {{-- PAGE SCRIPTS --}}
    {{-- ============================================================ --}}

    @stack('scripts')

</body>

</html>