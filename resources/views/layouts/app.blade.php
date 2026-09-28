<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $intro }}"><title>{{ $name }} — {{ $role }}</title>
    <style>{!! file_get_contents(resource_path('css/app.css')) !!}</style>
</head>
<body>
    <header class="site-header"><a class="logo" href="{{ route('portfolio.home') }}">{{ $name }}</a><div class="header-actions"><button class="menu-toggle" type="button" data-menu aria-controls="primary-nav" aria-expanded="false">Menu</button><nav id="primary-nav" data-nav aria-label="Primary navigation"><a href="#about">About</a><a href="#experience">Experience</a><a href="#projects">Projects</a><a href="#skills">Skills</a><a href="#contact">Contact</a></nav><button class="theme-toggle" type="button" data-theme-toggle aria-pressed="false">Theme</button></div></header>
    @yield('content')
    <script>{!! file_get_contents(resource_path('js/app.js')) !!}</script>
</body>
</html>
