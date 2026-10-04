@extends('layouts.app')

@section('content')
<main id="main-content">
    <section class="hero" aria-labelledby="hero-title">
        <div class="container">
            <p class="eyebrow">{{ $portfolio['status'] }}</p>
            <p class="hero-name">{{ $portfolio['name'] }} · {{ $portfolio['location'] }}</p>
            <h1 id="hero-title">Reliable systems.<br>Clear ownership.</h1>
            <p class="lead">{{ $portfolio['intro'] }}</p>
            <div class="contact-actions"><a class="button" href="mailto:{{ $portfolio['email'] }}">Let’s talk about your project</a><a class="text-link" href="#work">Explore my work ↓</a></div>
            <ul class="proof-list">@foreach ($portfolio['proof'] as $proof)<li>{{ $proof }}</li>@endforeach</ul>
        </div>
    </section>
    <section id="about" class="soft" aria-labelledby="about-title">
        <div class="container">
            <p class="eyebrow">01 / How I can help</p><h2 id="about-title">Your business, backed by thoughtful engineering.</h2>
            <p class="lead">{{ $portfolio['about'] }}</p>
            <div class="cards services">@foreach ($portfolio['services'] as $service)<article class="card"><h3>{{ $service['title'] }}</h3><p>{{ $service['text'] }}</p></article>@endforeach</div>
            <p class="section-note">You’ll work with someone who follows through: clear requirements, careful implementation, testing, and support after release.</p>
        </div>
    </section>
    <section id="work" aria-labelledby="work-title">
        <div class="container">
            <p class="eyebrow">02 / Selected work</p><h2 id="work-title">Reliability in practice.</h2>
            <p class="section-intro">Real business problems, the work I owned, and what changed. Expand a case study for the engineering details.</p>
            <div class="cards work-cards">@foreach ($portfolio['work'] as $item)
                <article class="card">
                    <p class="meta">{{ $item['label'] }}</p><h3>{{ $item['title'] }}</h3><p>{{ $item['text'] }}</p>
                    <p class="outcome"><strong>Result</strong> {{ $item['outcome'] }}</p>
                    <details><summary>Ownership & engineering details</summary><p><strong>My contribution.</strong> {{ $item['ownership'] }}</p><p>{{ $item['detail'] }}</p><p class="stack">{{ $item['stack'] }}</p></details>
                </article>
            @endforeach</div>
            <p class="section-note">Project descriptions use confidentiality-safe aliases. Outcomes reflect documented experience; unmeasured scale and performance figures are not presented as results.</p>
        </div>
    </section>
    <section id="experience" class="soft" aria-labelledby="experience-title">
        <div class="container"><p class="eyebrow">03 / Experience</p><h2 id="experience-title">From features to full product ownership.</h2>
            <div class="timeline">@foreach ($portfolio['experience'] as $item)<article><p class="meta">{{ $item['period'] }} · {{ $item['company'] }}</p><h3>{{ $item['title'] }}</h3><p>{{ $item['text'] }}</p></article>@endforeach</div>
            <div class="education"><h3>Education</h3><p>{{ $portfolio['education'] }}</p></div>
        </div>
    </section>
    <section id="skills" aria-labelledby="skills-title">
        <div class="container"><p class="eyebrow">04 / Capabilities</p><h2 id="skills-title">The engineering behind the outcome.</h2><p class="section-intro">PHP and Laravel are my core professional strengths. Here’s how the rest of my experience supports dependable delivery.</p>
            <div class="capability-grid">@foreach ($portfolio['skills'] as $skill)<details class="capability"><summary>{{ $skill['name'] }}<span>{{ $skill['level'] }}</span></summary><p>{{ $skill['description'] }}</p></details>@endforeach</div>
        </div>
    </section>
    <section id="projects" class="soft" aria-labelledby="projects-title">
        <div class="container"><p class="eyebrow">05 / Public engineering</p><h2 id="projects-title">Reusable tools. Deliberate design.</h2><div class="cards project-cards">@foreach ($portfolio['projects'] as $project)<article class="card"><p class="meta">{{ $project['evidence'] }}</p><h3><a href="{{ $project['url'] }}">{{ $project['name'] }} ↗</a></h3><p>{{ $project['text'] }}</p></article>@endforeach</div>
            <p class="section-note">For Pathframe and Revive, I own product definition, requirements, workflows, architecture direction, validation, and release direction. Their implementation is substantially AI-assisted; they demonstrate systems thinking rather than equivalent direct Go implementation depth. No external adoption figures are claimed.</p>
        </div>
    </section>
    <section id="contact" aria-labelledby="contact-title"><div class="container"><p class="eyebrow">06 / Let’s work together</p><h2 id="contact-title">Tell me what you’re building.</h2><p class="lead">Starting a product, connecting a provider, or untangling a production issue? Share your goals and where things stand. We can work out a practical next step together.</p><div class="contact-actions"><a class="button" href="mailto:{{ $portfolio['email'] }}">{{ $portfolio['email'] }}</a><a class="text-link" href="tel:{{ $portfolio['phone'] }}">{{ $portfolio['phone'] }}</a><a class="text-link" href="{{ $portfolio['github'] }}">GitHub ↗</a></div><p class="section-note">Based in {{ $portfolio['location'] }}.</p></div></section>
</main>
<footer><span>{{ $portfolio['name'] }} · {{ $portfolio['role'] }}</span><a href="#main-content">Back to top ↑</a></footer>
@endsection
