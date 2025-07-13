<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('welcome.title') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <style>/* стили не трогаем */</style>
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
<div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                <div class="flex lg:justify-center lg:col-start-2">
                    <svg class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]">...</svg>
                </div>
                @if (Route::has('login'))
                    <nav class="-mx-3 flex flex-1 justify-end gap-2">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-md px-3 py-2">{{ __('welcome.dashboard') }}</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-md px-3 py-2">{{ __('welcome.login') }}</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-md px-3 py-2">{{ __('welcome.register') }}</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <div class="text-right mb-4">
                <a href="/en" class="underline text-sm">EN</a> | <a href="/ru" class="underline text-sm">RU</a>
            </div>

            <main class="mt-6">
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                    <a href="https://laravel.com/docs" class="rounded-lg bg-white p-6 dark:bg-zinc-900">
                        <h2 class="text-xl font-semibold">{{ __('welcome.documentation') }}</h2>
                        <p class="mt-4 text-sm">{{ __('welcome.documentation_text') }}</p>
                    </a>

                    <a href="https://laracasts.com" class="rounded-lg bg-white p-6 dark:bg-zinc-900">
                        <h2 class="text-xl font-semibold">{{ __('welcome.laracasts') }}</h2>
                        <p class="mt-4 text-sm">{{ __('welcome.laracasts_text') }}</p>
                    </a>

                    <a href="https://laravel-news.com" class="rounded-lg bg-white p-6 dark:bg-zinc-900">
                        <h2 class="text-xl font-semibold">{{ __('welcome.laravel_news') }}</h2>
                        <p class="mt-4 text-sm">{{ __('welcome.laravel_news_text') }}</p>
                    </a>

                    <div class="rounded-lg bg-white p-6 dark:bg-zinc-900">
                        <h2 class="text-xl font-semibold">{{ __('welcome.ecosystem') }}</h2>
                        <p class="mt-4 text-sm">{!! __('welcome.ecosystem_text') !!}</p>
                    </div>
                </div>
            </main>

            <footer class="py-16 text-center text-sm">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </footer>
        </div>
    </div>
</div>
</body>
</html>
