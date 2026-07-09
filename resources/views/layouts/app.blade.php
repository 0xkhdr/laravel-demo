<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0a0a0a">
        <title>@yield('title', config('portfolio.brand.name'))</title>
        <meta name="description" content="@yield('description', config('portfolio.brand.tagline'))">
        <style>{!! file_get_contents(resource_path('css/app.css')) !!}</style>
    </head>
    <body>
        <a class="skip-link" href="#content">Skip to content</a>
        <div class="page">
            <div class="page__inner">
                @yield('content')
            </div>
        </div>
    </body>
</html>
