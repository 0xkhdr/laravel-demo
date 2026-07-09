@props(['project'])

<article class="project-card" {{ $attributes }}>
    @if(isset($project['image']))
        <div class="project-card__image-wrapper">
            <img src="{{ $project['image'] }}" alt="{{ $project['title'] }}" class="project-card__image" loading="lazy" decoding="async" />
        </div>
    @endif

    <div class="project-card__content">
        <h3 class="project-card__title">{{ $project['title'] }}</h3>

        @if(isset($project['description']))
            <p class="project-card__description">{{ $project['description'] }}</p>
        @endif

        @if(isset($project['tags']) && !empty($project['tags']))
            <div class="project-card__tags">
                @foreach($project['tags'] as $tag)
                    <span class="project-card__tag">{{ $tag }}</span>
                @endforeach
            </div>
        @endif

        @if(isset($project['links']) && !empty($project['links']))
            <div class="project-card__links">
                @if(isset($project['links']['github']))
                    <a href="{{ $project['links']['github'] }}" class="project-card__link" target="_blank" rel="noopener noreferrer">
                        GitHub
                    </a>
                @endif
                @if(isset($project['links']['live']))
                    <a href="{{ $project['links']['live'] }}" class="project-card__link" target="_blank" rel="noopener noreferrer">
                        Live Demo
                    </a>
                @endif
            </div>
        @endif
    </div>
</article>
