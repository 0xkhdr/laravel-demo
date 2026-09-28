@extends('layouts.app')

@section('content')
<main>
    <section class="hero" aria-labelledby="hero-title"><div class="container"><p class="eyebrow">{{ $status }}</p><h1 id="hero-title">{{ $name }}</h1><p class="lead"><strong>{{ $role }}</strong>. {{ $intro }}</p><a class="button" href="#projects">View work</a></div></section>
    <section id="about" class="dark" aria-labelledby="about-title"><div class="container copy"><p class="eyebrow">01 / About</p><h2 id="about-title">About</h2><p>{{ $intro }}</p></div></section>
    <section id="experience" aria-labelledby="experience-title"><div class="container"><p class="eyebrow">02 / Experience</p><h2 id="experience-title">Experience</h2><p class="empty">Experience details are not available yet.</p></div></section>
    <section id="projects" class="dark" aria-labelledby="projects-title"><div class="container"><p class="eyebrow">03 / Projects</p><h2 id="projects-title">Selected work</h2><p class="empty">Projects will appear here when they are available.</p></div></section>
    <section id="skills" aria-labelledby="skills-title"><div class="container"><p class="eyebrow">04 / Skills</p><h2 id="skills-title">Skills</h2><p class="empty">Skills details are not available yet.</p></div></section>
    <section id="contact" class="dark" aria-labelledby="contact-title"><div class="container copy"><p class="eyebrow">05 / Contact</p><h2 id="contact-title">Let’s build something.</h2><p class="empty">Contact details are not available yet.</p></div></section>
</main>
<footer><span>{{ $name }}</span></footer>
@endsection
