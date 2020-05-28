<!DOCTYPE html>
<html @yield('fixed-navbar', 'class=has-navbar-fixed-top')>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        @section('head_css')
            <link rel="stylesheet" href="/css/bulma.min.css">
            <link rel="stylesheet" href="/css/style.css">
        @show
    </head>
    <body>
        @section('header')
            @include('components.header')
        @show

        <div class="main-container main">
            @yield('content')
        </div>

         @section('script_js')
         @show
    </body>
    <footer>
        @include("footer")
    </footer>
</html>
