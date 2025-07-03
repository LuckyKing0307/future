{{-- resources/views/layouts/app.blade.php --}}
    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Моё приложение')</title>

    @vite(['resources/css/app.css','resources/css/main.css'])     {{-- Tailwind / любой CSS --}}
    @stack('head')                    {{-- для страниц, которым нужен extra-CSS --}}
</head>
<body class="flex flex-col min-h-screen">
<main class="flex-1">
    @yield('content')
</main>
@vite('resources/js/app.js')
@stack('scripts')
</body>
</html>
