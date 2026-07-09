@props(['project'])

<article {{ $attributes->class(['project-card']) }}>
    <p class="project-card__category">{{ $project['category'] }}</p>
    <h3 class="project-card__title">{{ $project['title'] }}</h3>
    <p class="project-card__summary">{{ $project['summary'] }}</p>
    <ul class="project-card__details">
        <li>{{ $project['impact'] }}</li>
        <li>{{ implode(' · ', $project['stack']) }}</li>
    </ul>
</article>
