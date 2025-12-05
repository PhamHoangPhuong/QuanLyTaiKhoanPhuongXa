<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', '@Master Layout'))</title>

    {{--Styles css common--}}
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">


    @yield('style-libraries')
    {{--Styles custom--}}
    @yield('styles')
</head>
<body id ="page-top">
    <div id="wrapper">
        @include('partial.sidebar')

        <div id="content-wrapper" class="d-flex flex-column min-vh-100">
            <div id="content">
                @include('partial.header')
                <div class="container-fluid">
                    {{-- Breadcrumb --}}
                    @yield('breadcrumb')

                    {{-- Nội dung chính --}}
                    @yield('content')
                </div>
            </div>
            {{-- footer phải ở đây: ngoài #content --}}
            @include('partial.footer')
        </div>
    </div>
    {{--Scripts js common--}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    {{--Scripts highcharts common--}}


    <!-- Page level plugins -->

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-column-demo.js"></script>
    <script src="js/demo/chart-circle-demo.js"></script>
    {{--Scripts link to file or js custom--}}
    @yield('scripts')
</body>
</html>
