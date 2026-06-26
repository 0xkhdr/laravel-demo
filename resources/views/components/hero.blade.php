@props([
    'eyebrow',
    'title',
    'description',
    'ctaHref' => null,
    'ctaLabel' => null,
])

<section class="hero reveal" data-reveal>
    <div class="page">
        <p class="hero__eyebrow">{{ $eyebrow }}</p>
        <h1 class="hero__title">{{ $title }}</h1>
        <p class="hero__description">{{ $description }}</p>

        @if ($ctaHref && $ctaLabel)
            <a class="button" href="{{ $ctaHref }}">{{ $ctaLabel }}</a>
        @endif
    </div>
</section>
