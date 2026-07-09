<section class="section" id="skills">
    <x-section-heading
        eyebrow="Skills"
        title="Capabilities tuned for durable portfolio experiences."
        description="The stack favors maintainability, accessibility, and calm presentation over noise."
    />

    <div class="skills-grid">
        @foreach ($portfolio['skills'] as $skill)
            <x-skill-chip :skill="$skill" />
        @endforeach
    </div>
</section>
