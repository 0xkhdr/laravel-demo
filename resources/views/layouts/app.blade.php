<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="color-scheme" content="light dark">
        <title>@yield('title', config('app.name'))</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="app-shell">
        <a class="skip-link" href="#content">Skip to content</a>

        <header class="site-header">
            <div class="page site-nav">
                <a href="{{ route('home') }}">{{ config('app.name') }}</a>

                <nav class="site-nav__links" aria-label="Primary">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('articles.index') }}">Articles</a>
                </nav>
            </div>
        </header>

        <main id="content">
            @yield('content')
        </main>

        <x-footer />
    </body>
</html>
