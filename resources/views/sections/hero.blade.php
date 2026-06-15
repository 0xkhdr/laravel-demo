<section class="min-h-screen flex flex-col justify-center relative px-6 md:px-12 bg-[var(--color-bg)] transition-colors duration-500 overflow-hidden">
    <div class="max-w-7xl mx-auto w-full z-10">
        <!-- Section tag -->
        <span class="text-xs font-mono uppercase tracking-widest text-[var(--color-accent)] mb-4 block">
            [ INITIALIZE SYSTEM ]
        </span>
        
        <!-- Large dot matrix display name -->
        <h1 class="text-4xl sm:text-6xl md:text-8xl font-display font-bold uppercase tracking-wider text-[var(--color-text-primary)] leading-[1.0] mb-6">
            {{ $portfolio['name'] ?? 'MOHAMED KHEDR' }}
        </h1>

        <!-- Role Subtitle -->
        <div class="font-mono text-sm sm:text-lg md:text-xl uppercase tracking-widest text-[var(--color-text-secondary)] mb-6">
            // {{ $portfolio['role'] ?? 'BACKEND ENGINEER' }}
        </div>

        <!-- Tagline / Bio -->
        <p class="font-body text-base sm:text-lg text-[var(--color-text-secondary)] max-w-2xl leading-relaxed mb-12">
            {{ $portfolio['tagline'] ?? 'I build systems that scale. Clean architecture. Clean code.' }}
        </p>

        <!-- CTA Action -->
        <div class="flex items-center gap-6">
            <a href="#projects" class="btn text-center hover:bg-[var(--color-text-primary)] hover:text-[var(--color-bg)] transition-all duration-300">
                VIEW WORK
            </a>
            <a href="#contact" class="text-xs uppercase font-mono tracking-widest text-[var(--color-text-secondary)] hover:text-[var(--color-accent)] transition-colors duration-300">
                GET IN TOUCH &rarr;
            </a>
        </div>
    </div>
</section>
