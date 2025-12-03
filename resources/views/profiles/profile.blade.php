@extends('layouts.master')

@section('title', 'App - Top Page')

@section('style-libraries')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
    
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
@stop

@section('styles')
    {{-- custom css item suggest search --}}
    <style>
        .autocomplete-group { padding: 2px 5px; }
    </style>
@stop

@section('breadcrumb')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Profile</h1>
    </div>
@stop

@section('content')
    @include('partial.userprofile')
@stop
    
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js"></script>
    {{-- jquery.autocomplete.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.10/jquery.autocomplete.min.js"></script>
    {{-- quick defined --}}
    <script>
        $(function () {
            // your custom javascript
        });
    </script>
@stop
