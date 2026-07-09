<section class="section" id="about">
    <x-section-heading
        :eyebrow="$portfolio['about']['eyebrow']"
        :title="$portfolio['about']['title']"
        :description="$portfolio['about']['description']"
    />

    <div class="about-grid">
        @foreach ($portfolio['about']['highlights'] as $highlight)
            <article class="info-card">
                <p>{{ $highlight }}</p>
            </article>
        @endforeach
    </div>
</section>
