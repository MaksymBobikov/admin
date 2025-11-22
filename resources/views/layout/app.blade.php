<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ًApplication</title>
    @vite('resources/admin/css/app.scss')
    @vite(['resources/admin/js/app.js'])
</head>
<body class="antialiased">
<div id="app">
    @include('maksb/admin::components.header')
    <div class="app-main-container">
        @yield('content')
    </div>
    <snackbar></snackbar>
    <loading-overlay></loading-overlay>
</div>
</body>
</html>
