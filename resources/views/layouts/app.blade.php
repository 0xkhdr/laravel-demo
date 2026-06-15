<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $portfolio['name'] ?? 'Developer Portfolio' }} — {{ $portfolio['role'] ?? 'Portfolio' }}</title>
    
    <!-- SEO & Metadata -->
    <meta name="description" content="{{ $portfolio['tagline'] ?? 'Minimalist Developer Portfolio' }}">
    <meta name="author" content="{{ $portfolio['name'] ?? 'Developer' }}">
    
    <!-- Inline Theme Script (Avoids Flash) -->
    <script>
        (function () {
            const savedTheme = localStorage.getItem('portfolio-theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            } else if (window.matchMedia('(prefers-color-scheme: light)').matches) {
                document.documentElement.setAttribute('data-theme', 'light');
            } else {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[var(--color-bg)] text-[var(--color-text-primary)] transition-colors duration-500 ease-in-out font-body antialiased">
    <!-- Background Canvas -->
    <canvas id="canvas-grid" class="fixed inset-0 pointer-events-none z-0 opacity-[0.05] dark:opacity-[0.08]"></canvas>

    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- Navigation -->
        @include('components.nav')

        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('components.footer')
    </div>
</body>
</html>
