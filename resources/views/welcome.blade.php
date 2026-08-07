<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $name }} — {{ $title }}">
    <title>{{ $name }} — {{ $title }}</title>
</head>
<body>
    <header>
        <nav aria-label="Primary navigation">
            <a href="{{ route('home') }}">{{ $name }}</a>
            <a href="#work">Work</a>
            <a href="#writing">Writing</a>
            <a href="#about">About</a>
            <a href="#contact">Contact</a>
        </nav>
    </header>

    <main>
        <section aria-labelledby="hero-title">
            <p>Portfolio / Blog</p>
            <h1 id="hero-title">{{ $name }}</h1>
            <p>{{ $title }}</p>
            <p>{{ $statement }}</p>
            <a href="#work">View work</a>
        </section>

        <section id="work" aria-labelledby="work-title">
            <h2 id="work-title">Work</h2>
            <p>Projects, systems, and open-source contributions.</p>
        </section>

        <section id="writing" aria-labelledby="writing-title">
            <h2 id="writing-title">Writing</h2>
            <p>Technical articles and lessons from building software.</p>
        </section>

        <section id="about" aria-labelledby="about-title">
            <h2 id="about-title">About</h2>
            <p>Experience, engineering focus, and skills.</p>
        </section>

        <section id="contact" aria-labelledby="contact-title">
            <h2 id="contact-title">Contact</h2>
            <p>Open to useful conversations and good engineering problems.</p>
        </section>
    </main>
</body>
</html>
