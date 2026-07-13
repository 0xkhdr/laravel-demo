@push('styles')
<style>
    #projects .project-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }
    @media (min-width: 768px) {
        #projects .project-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

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
