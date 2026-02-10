<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('dist/img/GMaranonLogo.png') }}" />

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- ========== APOLO CSS ========== -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"></link>

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('plugins/theme/css/adminlte.min.css') }}">

    <!-- Apolo -->
    <link rel="stylesheet" href="{{ asset('plugins/apolo/css/apolo.min.css') }}">

    <!-- ========== END APOLO CSS ========== -->

       <!-- Latform styles -->
       <link rel="stylesheet" href="{{ asset('plugins/latform/dist/css/latform-style-6.min.css') }}" type="text/css">
    <!-- Goslam -->
    <link rel="stylesheet" href="{{ asset('plugins/latform/dist/css/goslam.min.css') }}" type="text/css">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="hold-transition sidebar-collapse particles-js-bg" style="background: url(https://res.cloudinary.com/velasquez-paz/image/upload/v1618348553/vfb20gpmymp8rhbrpr81.jpg);background-size: cover;">
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}

        <!-- ========== APOLO JS ========== -->

        <!-- Theme style -->
        <script src="{{ asset('plugins/theme/js/adminlte.min.js') }}"></script>

        <script src="{{ asset('plugins/particles/particles.js') }}"></script>
        <script src="{{ asset('plugins/particles/app.js') }}"></script>

        <!-- ========== END APOLO JS ========== -->
        
    </div>
</body>
</html>
