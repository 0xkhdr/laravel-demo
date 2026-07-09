@props(['headline' => 'Welcome', 'subheading' => null, 'ctaText' => 'Get Started', 'ctaUrl' => '#'])

{{-- Hero: full viewport height (100vh), text-5xl headline with Space Mono --}}
<article {{ $attributes->class([
    'min-h-screen',
    'flex',
    'items-center',
    'justify-center',
    'bg-gradient-to-br',
    'from-accent',
    'to-ink',
    'p-8'
]) }}>
    <div class="max-w-3xl text-center space-y-8">
        {{-- Space Mono font family for headline --}}
        <h1 class="text-5xl font-semibold leading-tight" style="font-family: 'Space Mono', monospace">
            {{ $headline }}
        </h1>
        @if ($subheading)
            <p class="text-3xl font-medium tracking-widest text-surface-strong max-w-2xl leading-relaxed">
                {{ $subheading }}
            </p>
        @endif
        <a href="{{ $ctaUrl }}" class="inline-block px-6 py-4 border-2 border-accent bg-transparent text-accent hover:bg-accent hover:text-ink transition-all duration-300 rounded font-semibold">
            {{ $ctaText }}
        </a>
    </div>
</article>
