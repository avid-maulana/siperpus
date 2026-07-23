@extends('layouts.app')

@section('title', 'Daftar Literatur')

@section('content')
@vite([
    'resources/css/app.css',
    'resources/js/app.js'
])

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="mb-8 border-b border-slate-200 pb-6">
        <h2 class="text-3xl font-bold text-slate-900">
            Daftar Literatur
        </h2>
    </div>

    {{-- Search & Filter --}}
    @include('literatures._search')

    {{-- Loading Bar --}}
    <div
        id="loadingBar"
        class="fixed top-0 left-0 h-[3px] bg-blue-600 z-[9999] w-0 opacity-0 transition-[width,opacity] duration-300 ease-out">
    </div>

    {{-- Result --}}
    <div class="relative">
        <div id="resultsContainer">
            @include('literatures._result')
        </div>
    </div>

</div>

@include('literatures._style')

@endsection