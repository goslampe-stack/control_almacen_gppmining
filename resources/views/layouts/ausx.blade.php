<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link type="image/png" rel="icon" href="{{ asset('dist/img/goslam_viajes.jpg') }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <!-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> -->

    <!-- ==================== CSS ==================== -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/latform/dist/vendor/bootstrap-4.5.3/css/bootstrap.min.css') }}" type="text/css">
    <!-- Material design icons -->
    <link rel="stylesheet" href="{{ asset('plugins/latform/dist/icons/material-design-icons/css/mdi.min.css') }}" type="text/css">
    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400" rel="stylesheet">
    <!-- Latform styles -->
    <link rel="stylesheet" href="{{ asset('plugins/latform/dist/css/latform-style-6.min.css') }}" type="text/css">
    <!-- Goslam -->
    <link rel="stylesheet" href="{{ asset('plugins/latform/dist/css/goslam.min.css') }}" type="text/css">

    <!-- ==================== CSS ==================== -->

    <!-- Scripts -->
    <!-- <script src="{{ mix('js/app.js') }}" defer></script> -->

</head>

<body data-spy="scroll" data-target="#pb-navbar" data-offset="200">

    {{ $slot }}

    <!-- ===================== JS ==================== -->

    <!-- Jquery -->
    <script src="{{ asset('plugins/latform/dist/vendor/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/latform/dist/vendor/bootstrap-4.5.3/js/bootstrap.min.js') }}"></script>
    <!-- Latform scripts -->
    <script src="{{ asset('plugins/latform/dist/js/latform.min.js') }}"></script>

    <!-- ===================== JS ==================== -->

</body>

</html>