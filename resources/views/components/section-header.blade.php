@props(['title', 'subtitle' => null, 'description' => null, 'align' => 'center'])

<div class="section-header section-header--{{ $align }}">
    @if ($subtitle)
        <p class="section-header__subtitle">{{ $subtitle }}</p>
    @endif

    <h2 class="section-header__title">{{ $title }}</h2>

    @if ($description)
        <p class="section-header__description">{{ $description }}</p>
    @endif
</div>
