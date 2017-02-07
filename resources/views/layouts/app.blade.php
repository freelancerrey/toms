<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="toms_icon.ico">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel').' v'.config('app.version', '1.0') }} - @yield('title')</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
        <!-- Custom Styles -->
        <link href="/css/custom.css" rel="stylesheet">

        @section('pagecss')
        <!-- Page Styles -->
        @show

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }} <span style="font-size: 12px;">v{{ config('app.version', '1.0') }}</span></a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Dashboard</a></li>
                        <li><a href="#about">Docs</a></li>
                        <li><a href="#contact">Report a Bug</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Howdy, {{ explode(' ', Auth::user()->name)[0] }}! &nbsp;&nbsp;&nbsp;&nbsp;<span class="caret"></span></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/logout') }}">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
            <div class="starter-template">
                @yield('content')
            </div>
        </div><!-- /.container -->


        <!-- Scripts -->
        <script src="/js/app.js"></script>
    </body>
</html>
