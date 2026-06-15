<section id="about" class="py-24 px-6 md:px-12 bg-[#000000] text-white border-y border-neutral-900 overflow-hidden relative">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-center relative z-10">
        <!-- Text details -->
        <div class="lg:col-span-7 flex flex-col justify-center reveal">
            <span class="text-xs font-mono uppercase tracking-widest text-[var(--color-accent)] mb-3">
                SEC_01 // BACKGROUND
            </span>
            <h2 class="text-3xl sm:text-4xl font-display font-bold uppercase tracking-wider text-white mb-8">
                ABOUT ME
            </h2>
            
            <div class="font-body text-base text-neutral-400 space-y-6 max-w-xl leading-relaxed">
                @if(!empty($portfolio['about']['paragraphs']))
                    @foreach($portfolio['about']['paragraphs'] as $para)
                        <p>{{ $para }}</p>
                    @endforeach
                @else
                    <p>I design and implement high-performance backend systems, distributed architectures, and robust APIs. My engineering focus is on simplicity, scalability, and code discipline.</p>
                @endif
            </div>
        </div>

        <!-- Minimal architectural SVG -->
        <div class="lg:col-span-5 flex justify-center reveal">
            <svg class="w-full max-w-[320px] aspect-square text-neutral-800" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="0.5">
                <!-- Outer borders -->
                <rect x="5" y="5" width="90" height="90" stroke-dasharray="1 2" />
                <rect x="15" y="15" width="70" height="70" />
                <rect x="25" y="25" width="50" height="50" stroke-dasharray="2 1" />
                <!-- Diagonals -->
                <line x1="5" y1="5" x2="95" y2="95" />
                <line x1="95" y1="5" x2="5" y2="95" />
                <!-- Coordinates or text -->
                <circle cx="50" cy="50" r="10" stroke="currentColor" stroke-width="0.75" />
                <text x="18" y="22" fill="currentColor" font-family="monospace" font-size="3" letter-spacing="0.5">SYS_INIT_v1.0</text>
                <text x="62" y="81" fill="currentColor" font-family="monospace" font-size="3" letter-spacing="0.5">LAT_30.0444</text>
            </svg>
        </div>
    </div>
</section>
