<!DOCTYPE html>
<html lang="id">

<head>

    @include('layouts.partials.head')

    {{-- Google Material Symbols --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0"
        rel="stylesheet">

</head>

<body class="bg-slate-50 font-sans antialiased text-slate-800">

    {{-- Navbar --}}
    @include('layouts.partials.navbar')

    <main id="page-content" class="pt-20 opacity-0 translate-y-3">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.partials.footer')
    @stack('scripts')
</body>

</html>