<section class="section hero" id="hero">
    <div class="hero__copy">
        <p class="hero__eyebrow">{{ $portfolio['hero']['eyebrow'] }}</p>
        <h1 class="hero__title">{{ $portfolio['hero']['title'] }}</h1>
        <p class="hero__description">{{ $portfolio['hero']['description'] }}</p>

        <div class="hero__actions">
            <a class="button button--primary" href="{{ $portfolio['hero']['primary_cta']['href'] }}">
                {{ $portfolio['hero']['primary_cta']['label'] }}
            </a>
            <a class="button button--ghost" href="{{ $portfolio['hero']['secondary_cta']['href'] }}">
                {{ $portfolio['hero']['secondary_cta']['label'] }}
            </a>
        </div>
    </div>

    <aside class="hero__meta" aria-label="Profile details">
        @foreach ($portfolio['hero']['details'] as $detail)
            <div class="meta-card">
                <p class="meta-card__label">{{ $detail['label'] }}</p>
                <p class="meta-card__value">{{ $detail['value'] }}</p>
            </div>
        @endforeach
    </aside>
</section>
