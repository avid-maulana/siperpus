@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 mt-8">
    <h1 class="text-2xl font-bold mb-4">Daftar Literatur</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($literatures as $literature)
            <div class="p-4 border rounded-lg shadow">
                <h2 class="text-lg font-semibold">{{ $literature->title }}</h2>
                <p>Author: {{ $literature->author }}</p>
                <p>Category: {{ $literature->category->name ?? 'N/A' }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
