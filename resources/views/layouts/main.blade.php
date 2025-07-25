<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Моё приложение')</title>
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
    @vite(['resources/css/app.css','resources/css/main.css','resources/js/app.js'])
    @stack('head')
</head>
<body class="flex flex-col min-h-screen">

<x-header />

<main class="flex-1 main_content">
    @yield('content')
</main>

<x-footer />

@vite('resources/js/app.js')
@stack('scripts')
</body>
</html>
