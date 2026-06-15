<footer class="pt-24 pb-12 px-6 md:px-12 border-t border-[var(--color-border)] bg-[var(--color-bg-alt)] transition-colors duration-500">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 font-mono">
        <!-- Brand / Copyright -->
        <div class="text-left">
            <span class="text-sm font-bold tracking-widest block text-[var(--color-text-primary)]">
                {{ $portfolio['name'] ?? 'MOHAMED KHEDR' }}
            </span>
            <span class="text-xs text-[var(--color-text-muted)] mt-1 block">
                &copy; {{ date('Y') }}. ALL RIGHTS RESERVED.
            </span>
        </div>

        <!-- Direct Social Links -->
        <div class="flex flex-wrap justify-center gap-6 text-xs uppercase tracking-widest">
            @if(!empty($portfolio['contact']['email']))
                <a href="mailto:{{ $portfolio['contact']['email'] }}" class="text-[var(--color-text-secondary)] hover:text-[var(--color-accent)] transition-colors duration-300">
                    EMAIL
                </a>
            @endif
            @if(!empty($portfolio['contact']['github']))
                <a href="{{ $portfolio['contact']['github'] }}" target="_blank" rel="noopener noreferrer" class="text-[var(--color-text-secondary)] hover:text-[var(--color-accent)] transition-colors duration-300">
                    GITHUB
                </a>
            @endif
            @if(!empty($portfolio['contact']['linkedin']))
                <a href="{{ $portfolio['contact']['linkedin'] }}" target="_blank" rel="noopener noreferrer" class="text-[var(--color-text-secondary)] hover:text-[var(--color-accent)] transition-colors duration-300">
                    LINKEDIN
                </a>
            @endif
            @if(!empty($portfolio['contact']['twitter']))
                <a href="{{ $portfolio['contact']['twitter'] }}" target="_blank" rel="noopener noreferrer" class="text-[var(--color-text-secondary)] hover:text-[var(--color-accent)] transition-colors duration-300">
                    TWITTER
                </a>
            @endif
        </div>
    </div>
</footer>
