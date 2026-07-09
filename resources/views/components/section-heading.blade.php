@props(['eyebrow', 'title', 'description' => null])

<div class="section-heading">
    <p class="section-heading__eyebrow">{{ $eyebrow }}</p>
    <h2 class="section-heading__title">{{ $title }}</h2>
    @if ($description)
        <p class="section-heading__description">{{ $description }}</p>
    @endif
</div>
