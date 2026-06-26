@props([
    'id' => null,
    'eyebrow' => 'Section',
    'title',
    'description' => null,
])

<header class="section-header reveal" data-reveal>
    @if ($id)
        <p class="section-header__eyebrow">{{ $eyebrow }}</p>
        <h2 id="{{ $id }}" class="section-header__title">{{ $title }}</h2>
    @else
        <p class="section-header__eyebrow">{{ $eyebrow }}</p>
        <h2 class="section-header__title">{{ $title }}</h2>
    @endif

    @if ($description)
        <p class="section-header__description">{{ $description }}</p>
    @endif
</header>
