@extends('layouts.app')

@section('title', 'Home')

@section('content')

    @auth

        @if(Auth::user()->level == 6)

            {{-- Admin Dashboard --}}
            @include('home.admin')

        @else

            {{-- User Homepage --}}
            @include('home.user')

        @endif

    @endauth

@endsection