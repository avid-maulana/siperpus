<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ request('title', 'PDF Viewer') }}</title>

    @vite(['resources/css/app.css'])
</head>

<body class="bg-slate-100">

    <header class="sticky top-0 z-50 bg-white border-b border-slate-200 shadow-sm">

        <div class="h-16 px-6 flex items-center gap-4">

            <button
                onclick="history.back()"
                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"/>

                </svg>

                Kembali

            </button>

            <h1 class="text-lg font-semibold text-slate-800">
                {{ request('title', 'PDF Viewer') }}
            </h1>

        </div>

    </header>

    <iframe
        src="{{ asset($pdfPath) }}"
        class="w-full h-[calc(100vh-64px)] border-0">
    </iframe>

</body>

</html>