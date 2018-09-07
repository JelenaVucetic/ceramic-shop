<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ URL::to('src/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('src/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ URL::to('src/css/responsiveslides.css') }}">
    <link rel="stylesheet" href="{{ URL::to('src/css/datatable.css') }}">
    <link rel="stylesheet" href="{{ URL::to('src/css/random.css') }}">
    <link rel="stylesheet" href="{{ URL::to('src/css/main.css') }}">
<style>
    .has-error {
        border-color: red;
    }

</style>

</head>
<body>
    @include('includes.header')
<div class="">
    @yield('content')
</div>
    <script src="{{ URL::to('src/js/jquery.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/jquery-ui.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/responsiveslides.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('src/js/datatable.js') }}" type="text/javascript"></script>
    {{--<script src="{{ URL::to('src/js/app.js') }}" type="text/javascript"></script>--}}

    @yield('js-end')
</body>
</html>
