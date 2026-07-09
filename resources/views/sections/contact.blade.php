<section class="section" id="contact">
    <x-section-heading
        :eyebrow="$portfolio['contact']['eyebrow']"
        :title="$portfolio['contact']['title']"
        :description="$portfolio['contact']['description']"
    />

    <div class="contact-grid">
        <div class="contact-grid__copy">
            @foreach ($portfolio['contact']['links'] as $link)
                <x-contact-link :link="$link" />
            @endforeach
        </div>
        <a class="button button--primary button--wide" href="{{ $portfolio['hero']['secondary_cta']['href'] }}">
            {{ $portfolio['hero']['secondary_cta']['label'] }}
        </a>
    </div>
</section>
