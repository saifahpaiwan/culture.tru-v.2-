<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title> สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี</title>
    @yield('meta')
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- App css -->
    <link href="{{ asset('template-end/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('template-end/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template-end/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-stylesheet" />

    <style>
        body {
            font-family: 'IBM Plex Sans Thai', sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.5;
            background-color: #ffd28f;  
            -webkit-text-size-adjust: 100%;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
        }
        main {
            margin-top: 150px;
        }
    </style>
    @yield('style')
</head>

<body>
    <main>
        @yield('content')
    </main>
    <script src="{{ asset('template-end/js/vendor.min.js') }}"></script>
    <script src="{{ asset('template-end/js/app.min.js') }}"></script>
</body>
<script>
    $("form").submit(function(event) {
        $('.text-submit').html('<i class="mdi mdi-spin mdi-loading"></i> กรุณารอสักครู่...');
        $("form").submit();
    });
</script>

</html>