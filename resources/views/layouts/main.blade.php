<html>
    @yield('meta')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <head>
        <meta name="viewport" content="width=device-width">
        <title>List buy store front - @yield('title')</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,700&display=swap" rel="stylesheet">
        @yield('style')
    </head>
    <body>
            <div class="container">
                @yield('content')
            </div>

            <div class="container-fluid">
                @yield('fullcontent')
            </div>

        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/jquery.steps.min.js') }}"></script>
        
        @yield('scripts')
    </body>
</html>