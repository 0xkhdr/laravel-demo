<nav class="fixed top-0 left-0 right-0 h-16 border-b border-[var(--color-border)] bg-[var(--color-bg)]/80 backdrop-blur-md flex items-center justify-between px-6 md:px-12 z-50 transition-colors duration-500">
    <!-- Logo -->
    <a href="#" class="font-display font-bold text-sm tracking-widest text-[var(--color-text-primary)] hover:text-[var(--color-accent)] transition-colors duration-300">
        {{ $portfolio['name'] ?? 'MOHAMED KHEDR' }}
    </a>

    <!-- Navigation Links -->
    <div class="hidden md:flex items-center space-x-8">
        <a href="#about" class="text-xs uppercase tracking-widest font-mono text-[var(--color-text-secondary)] hover:text-[var(--color-text-primary)] transition-colors duration-300">
            ABOUT
        </a>
        <a href="#experience" class="text-xs uppercase tracking-widest font-mono text-[var(--color-text-secondary)] hover:text-[var(--color-text-primary)] transition-colors duration-300">
            EXPERIENCE
        </a>
        <a href="#projects" class="text-xs uppercase tracking-widest font-mono text-[var(--color-text-secondary)] hover:text-[var(--color-text-primary)] transition-colors duration-300">
            PROJECTS
        </a>
        <a href="#skills" class="text-xs uppercase tracking-widest font-mono text-[var(--color-text-secondary)] hover:text-[var(--color-text-primary)] transition-colors duration-300">
            SKILLS
        </a>
        <a href="#contact" class="text-xs uppercase tracking-widest font-mono text-[var(--color-text-secondary)] hover:text-[var(--color-text-primary)] transition-colors duration-300">
            CONTACT
        </a>
    </div>

    <!-- Theme Switcher & Actions -->
    <div class="flex items-center space-x-4">
        <button id="theme-toggle" class="relative w-10 h-10 border border-[var(--color-border)] hover:border-[var(--color-text-primary)] transition-colors duration-300 flex items-center justify-center" aria-label="Toggle Theme">
            <!-- Sun Icon (shown in dark theme) -->
            <svg class="w-4 h-4 text-[var(--color-text-primary)] dark:block hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="5"></circle>
                <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"></path>
            </svg>
            <!-- Moon Icon (shown in light theme) -->
            <svg class="w-4 h-4 text-[var(--color-text-primary)] dark:hidden block" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        </button>
    </div>
</nav>
