@php($profile = config('portfolio'))

<footer class="site-footer" aria-label="Site footer">
    <div class="page">
        <p>{{ $profile['owner']['name'] }} · {{ $profile['owner']['title'] }}</p>

        <nav class="site-footer__links" aria-label="Contact links">
            @foreach ($profile['contact'] as $link)
                <a href="{{ $link['href'] }}">{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <p class="hero__eyebrow">{{ config('app.name') }}</p>
    </div>
</footer>
