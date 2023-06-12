<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- Scripts And Style-->
    @vite(['resources/js/assets/scss/style.scss', 'resources/js/app.js'])
</head>
<body>
<div id="app">
    @yield('content')
</div>
<div class="modals">

</div>
</body>
</html>
