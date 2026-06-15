<section id="projects" class="py-24 px-6 md:px-12 bg-[#000000] text-white border-t border-neutral-900 overflow-hidden">
    <div class="max-w-7xl mx-auto w-full">
        <div class="reveal mb-16">
            <span class="text-xs font-mono uppercase tracking-widest text-[var(--color-accent)] mb-3 block">
                SEC_03 // CODE
            </span>
            <h2 class="text-3xl sm:text-4xl font-display font-bold uppercase tracking-wider text-white">
                PROJECTS
            </h2>
        </div>

        <!-- Projects Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 reveal">
            @forelse($projects as $project)
                <x-project-card :project="$project" />
            @empty
                <div class="col-span-full border border-neutral-800 p-8 text-center text-neutral-500 font-mono text-sm">
                    No projects found. RUN `php artisan db:seed` TO POPULATE.
                </div>
            @endforelse
        </div>
    </div>
</section>
