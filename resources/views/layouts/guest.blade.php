<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel').' v'.config('app.version', '1.0') }} - @yield('title')</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
        <!-- Custom Styles -->
        <link href="/css/custom.css" rel="stylesheet">
        <link href="/css/guest.css" rel="stylesheet">

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>

    <body>

        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">{{ config('app.name', 'Laravel') }} <span style="font-size: 12px;">v{{ config('app.version', 'Laravel') }}</span></h3>
                @section('sidelinks')
                @show
            </div>

            @yield('content')

            <footer class="footer">
                <p>&copy; 2017 Dreams Unlimited Marketing, LLC.</p>
            </footer>

        </div> <!-- /container -->

        <!-- Scripts -->
        <script src="/js/app.js"></script>

    </body>
</html>
