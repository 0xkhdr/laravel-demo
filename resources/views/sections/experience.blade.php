<section id="experience" class="py-24 px-6 md:px-12 bg-[var(--color-bg)] transition-colors duration-500 overflow-hidden">
    <div class="max-w-7xl mx-auto w-full">
        <div class="reveal mb-16">
            <span class="text-xs font-mono uppercase tracking-widest text-[var(--color-accent)] mb-3 block">
                SEC_02 // TIMELINE
            </span>
            <h2 class="text-3xl sm:text-4xl font-display font-bold uppercase tracking-wider text-[var(--color-text-primary)]">
                EXPERIENCE
            </h2>
        </div>

        <!-- Timeline Container -->
        <div class="relative pl-6 md:pl-12 border-l border-[var(--color-border)] max-w-4xl mx-auto">
            @if(!empty($portfolio['experience']))
                @foreach($portfolio['experience'] as $index => $exp)
                    <div class="relative reveal mb-16 last:mb-0">
                        <!-- Timeline node indicator -->
                        <div class="absolute -left-[31px] md:-left-[55px] top-1.5 w-[9px] h-[9px] bg-[var(--color-bg)] border-2 border-[var(--color-text-primary)] rounded-none"></div>

                        <!-- Date range (Monospace) -->
                        <span class="text-xs font-mono tracking-widest text-[var(--color-accent)] uppercase block mb-2">
                            {{ $exp['duration'] }}
                        </span>

                        <!-- Role & Company -->
                        <h3 class="text-xl font-display font-bold uppercase tracking-wide text-[var(--color-text-primary)]">
                            {{ $exp['role'] }}
                        </h3>
                        <span class="text-sm font-mono text-[var(--color-text-secondary)] block mb-4">
                            @ {{ $exp['company'] }}
                        </span>

                        <!-- Bullet Points -->
                        <ul class="font-body text-sm text-[var(--color-text-secondary)] list-none space-y-3 pl-0 leading-relaxed max-w-2xl">
                            @foreach($exp['points'] as $point)
                                <li class="relative pl-6">
                                    <span class="absolute left-0 top-0 text-[var(--color-accent)] select-none">&bull;</span>
                                    {{ $point }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
