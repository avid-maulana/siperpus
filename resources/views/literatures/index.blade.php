@extends('layouts.app')

@section('title', 'Daftar Literatur')

@section('content')

<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="mb-8 border-b border-slate-200 pb-6">

        <h1 class="text-3xl font-bold text-slate-900">
            Daftar Literatur
        </h1>

        <p class="mt-2 text-slate-500">
            Cari literatur berdasarkan judul, penulis, atau kata kunci.
        </p>

    </div>

    {{-- Search --}}
    @include('literatures._search')

    {{-- Result --}}
    <section id="resultsContainer" class="mt-6">
        @include('literatures._result')
    </section>

</div>

@endsection