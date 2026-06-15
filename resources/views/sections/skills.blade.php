<section id="skills" class="py-24 px-6 md:px-12 bg-[var(--color-bg)] transition-colors duration-500 overflow-hidden">
    <div class="max-w-7xl mx-auto w-full">
        <div class="reveal mb-16">
            <span class="text-xs font-mono uppercase tracking-widest text-[var(--color-accent)] mb-3 block">
                SEC_04 // CAPABILITIES
            </span>
            <h2 class="text-3xl sm:text-4xl font-display font-bold uppercase tracking-wider text-[var(--color-text-primary)]">
                SKILLS
            </h2>
        </div>

        <!-- Skills Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @if(!empty($portfolio['skills']))
                @foreach($portfolio['skills'] as $category => $skillList)
                    <div class="border border-[var(--color-border)] p-6 md:p-8 reveal flex flex-col justify-between hover:border-[var(--color-text-primary)] transition-colors duration-300">
                        <div>
                            <h3 class="font-display font-bold text-sm uppercase tracking-widest text-[var(--color-text-primary)] mb-6 border-b border-[var(--color-border)] pb-2">
                                // {{ $category }}
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($skillList as $skill)
                                    <x-skill-tag :name="$skill" />
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
