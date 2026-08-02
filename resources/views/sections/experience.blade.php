<section id="experience" class="bg-white">
    <div class="container">
        @include('components.section-header', ['label' => 'Experience', 'title' => 'Career Timeline'])
        <div class="space-y-8">
            <div class="border-l-2 border-black pl-8 pb-8">
                <p class="font-mono text-sm text-muted mb-2">2023 - Present</p>
                <h3 class="font-display text-2xl font-bold mb-2">Senior Backend Engineer</h3>
                <p class="text-secondary mb-4">Tech Company</p>
                <ul class="text-secondary space-y-2 text-sm">
                    <li>• Led architecture redesign resulting in 40% performance improvement</li>
                    <li>• Mentored junior developers on system design and best practices</li>
                    <li>• Implemented automated deployment pipeline reducing release time by 50%</li>
                </ul>
            </div>
            <div class="border-l-2 border-black pl-8 pb-8">
                <p class="font-mono text-sm text-muted mb-2">2020 - 2023</p>
                <h3 class="font-display text-2xl font-bold mb-2">Backend Engineer</h3>
                <p class="text-secondary mb-4">Another Company</p>
                <ul class="text-secondary space-y-2 text-sm">
                    <li>• Built REST APIs serving millions of requests daily</li>
                    <li>• Developed real-time notification system using WebSockets</li>
                    <li>• Optimized database queries reducing average response time by 60%</li>
                </ul>
            </div>
        </div>
    </div>
</section>
