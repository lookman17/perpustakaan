<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/people.png') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom-styles.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Inline Styles -->
    <style>
        .img-profile {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }
        h1 {
            color: #007bff;
        }
    </style>
</head>
<body>
    <header>
        @yield('header')
    </header>

    <main>
        @yield('main')
    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
