<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ request('title', 'PDF Viewer') }}
    </title>


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    @include('pdf-viewer._styles')

</head>


<body class="h-screen
           overflow-hidden
           bg-white
           text-slate-800">


    {{-- =========================================================
    VIEWER ROOT
    FULLSCREEN / READ ONLY / PDF.JS / DETAIL PANEL
    ========================================================== --}}

    <div id="pdfViewer" class="relative
               flex
               h-screen
               w-screen
               flex-col
               bg-white">


        @include('pdf-viewer._header')



        @include('pdf-viewer._workspace')

    </div>



    {{-- =========================================================
    PDF CONFIG
    ========================================================== --}}

    @include('pdf-viewer._config')

</body>

</html>