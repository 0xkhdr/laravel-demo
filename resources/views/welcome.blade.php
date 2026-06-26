<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    @vite(['resources/css/design-system.css', 'resources/js/nav.js', 'resources/js/menu.js'])
</head>
<body>
    <section id="hero" class="hero">
        <div class="hero-content">
            <h1 class="text-hero">{{ config('app.name') }}</h1>
            <p class="text-body-large">Welcome to our platform. Explore features and start building today.</p>
            <div class="hero-actions">
                <a href="/api/users" class="btn btn-primary" role="button">API Documentation</a>
                <a href="/horizon" class="btn btn-secondary" role="button">View Horizon</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </div>
    </section>

    <section class="section">
        <div class="section-container">
            <div class="card">
                <h2 class="section-title">Platform Features</h2>
                <p class="text-body-large">Build and scale with our design system. Explore our API and monitoring tools.</p>
            </div>
        </div>
    </section>
</body>
</html>
