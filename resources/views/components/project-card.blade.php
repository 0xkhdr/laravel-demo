@props(['project'])

<div class="project-card flex flex-col justify-between h-full bg-[var(--color-bg)] border border-[var(--color-border)] hover:border-[var(--color-text-primary)] hover:-translate-y-1 transition-all duration-300 p-6 md:p-8">
    <div>
        <!-- Title -->
        <h3 class="font-display font-bold text-lg md:text-xl uppercase tracking-wider text-[var(--color-text-primary)] mb-3">
            {{ $project->title }}
        </h3>
        
        <!-- Description -->
        <p class="text-sm text-[var(--color-text-secondary)] font-body leading-relaxed mb-6">
            {{ $project->description }}
        </p>

        <!-- Tech Stack -->
        <div class="flex flex-wrap gap-2 mb-8">
            @if(is_array($project->technologies))
                @foreach($project->technologies as $tech)
                    <x-skill-tag :name="$tech" />
                @endforeach
            @endif
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center gap-4 font-mono text-xs uppercase">
        @if(!empty($project->github_url))
            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="btn text-center hover:bg-[var(--color-text-primary)] hover:text-[var(--color-bg)] transition-colors duration-300 flex-1">
                GITHUB
            </a>
        @endif
        @if(!empty($project->live_url))
            <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-accent text-center hover:bg-[var(--color-accent)] hover:text-white transition-colors duration-300 flex-1">
                LIVE DEMO
            </a>
        @endif
    </div>
</div>
