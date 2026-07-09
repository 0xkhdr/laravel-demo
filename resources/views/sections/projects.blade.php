<section class="section" id="projects">
    <x-section-heading
        eyebrow="Projects"
        title="Selected work built around shared data and editorial precision."
        description="Each piece is intentionally short on decoration and long on structure."
    />

    <div class="project-grid">
        @foreach ($portfolio['projects'] as $project)
            <x-project-card :project="$project" />
        @endforeach
    </div>
</section>
