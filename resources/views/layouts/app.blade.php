<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/design-system.css', 'resources/js/nav.js', 'resources/js/menu.js'])
</head>
<body>
    <nav class="section" style="background-color: var(--color-surface); border-bottom: 1px solid var(--color-border);">
        <div style="display: flex; align-items: center; padding: var(--space-4); max-width: 1200px; margin: 0 auto;">
            <a href="{{ route('profile.show') }}" style="font-size: var(--type-h3); font-weight: var(--font-weight-bold); color: var(--color-text-primary); text-decoration: none;">{{ config('app.name') }}</a>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
