<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>KC Blue Wall - Generate your twitter profile's picture</title>
    <meta name="description" content="To show your support to the KCorp Team around the world, you can add a blue wall to your twitter profiles picture, that you can create here !">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="icon" type="image/x-icon" href="{{asset('img/logo.ico')}}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Finger+Paint&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RE4SDXFTHP"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
      
        gtag('config', 'G-RE4SDXFTHP');
      </script>
</head>
<body class="vw-100 bg-secondary" style="overflow-x: hidden;" >
    @yield('content')
    @yield('scripts')
</body>
</html>


