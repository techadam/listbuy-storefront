<html>
    @yield('meta')
    <head>
        <title>List buy store front - @yield('title')</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>