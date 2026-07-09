<section class="section" id="experience">
    <x-section-heading
        eyebrow="Experience"
        title="Senior roles across design, engineering, and content systems."
        description="The through line is the same: structure first, then refinement."
    />

    <div class="timeline">
        @foreach ($portfolio['experience'] as $entry)
            <x-timeline-entry :entry="$entry" />
        @endforeach
    </div>
</section>
