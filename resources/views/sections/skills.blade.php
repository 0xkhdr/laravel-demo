<section id="skills" class="bg-white">
    <div class="container">
        @include('components.section-header', ['label' => 'Skills', 'title' => 'Technical Expertise'])
        <div class="space-y-8">
            <div>
                <h3 class="font-display text-xl font-bold mb-4 uppercase">Languages</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach (['PHP', 'Go', 'JavaScript', 'Python', 'SQL'] as $skill)
                        @include('components.skill-tag', ['skill' => $skill])
                    @endforeach
                </div>
            </div>
            <div>
                <h3 class="font-display text-xl font-bold mb-4 uppercase">Frameworks & Tools</h3>
                <div class="flex flex-wrap gap-3">
                    @foreach (['Laravel', 'Docker', 'Kubernetes', 'PostgreSQL', 'Redis'] as $skill)
                        @include('components.skill-tag', ['skill' => $skill])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
