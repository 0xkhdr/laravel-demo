<section id="projects" class="bg-black text-white">
    <div class="container">
        @include('components.section-header', ['label' => 'Projects', 'title' => 'Selected Work'])
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @include('components.project-card', [
                'title' => 'Real-time Analytics Platform',
                'description' => 'Built a real-time data processing system handling 100K+ events/sec',
                'tags' => ['Go', 'PostgreSQL', 'Redis', 'Kafka'],
                'github' => '#',
                'demo' => '#'
            ])
            @include('components.project-card', [
                'title' => 'API Gateway Service',
                'description' => 'Developed rate limiting and authentication middleware for microservices',
                'tags' => ['Laravel', 'Docker', 'Kong'],
                'github' => '#',
                'demo' => '#'
            ])
        </div>
    </div>
</section>
