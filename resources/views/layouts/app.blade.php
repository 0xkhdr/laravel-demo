<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $portfolio['intro'] }}"><title>{{ $portfolio['name'] }} — {{ $portfolio['role'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="portfolioUi">
    <header class="site-header"><a class="logo" href="{{ route('portfolio.home') }}">{{ $portfolio['name'] }}</a><div class="header-actions"><button class="menu-toggle" type="button" aria-controls="primary-nav" :aria-expanded="menuOpen" @click="menuOpen = !menuOpen">Menu</button><nav id="primary-nav" aria-label="Primary navigation" :class="{ 'is-open': menuOpen }"><a href="#about" @click="menuOpen = false">About</a><a href="#experience" @click="menuOpen = false">Experience</a><a href="#projects" @click="menuOpen = false">Projects</a><a href="#skills" @click="menuOpen = false">Skills</a><a href="#contact" @click="menuOpen = false">Contact</a></nav><button class="theme-toggle" type="button" :aria-pressed="theme === 'dark'" @click="toggleTheme">Theme</button></div></header>
    @yield('content')
</body>
</html>
