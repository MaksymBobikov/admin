<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ًApplication</title>
    @vite('resources/css/app.css')
    @vite(['resources/js/app.js'])
</head>
<body class="antialiased">
<div id="app">
    <v-app>
        <app-header></app-header>
        <v-main class="app-main-container">
            @yield('content')
        </v-main>
        <snackbar></snackbar>
        <loading-overlay></loading-overlay>
    </v-app>
</div>
</body>
</html>
