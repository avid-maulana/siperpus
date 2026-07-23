<!DOCTYPE html>
<html lang="id">

@include('layouts.partials.head')

<body class="bg-slate-50 text-slate-800 font-sans antialiased">
    
    @include('layouts.partials.navbar')

    <main class="pt-20">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

</body>

</html>