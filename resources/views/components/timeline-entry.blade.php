@props(['entry'])

<article {{ $attributes->class(['timeline-entry']) }}>
    <p class="timeline-entry__period">{{ $entry['period'] }}</p>
    <div class="timeline-entry__body">
        <h3 class="timeline-entry__role">{{ $entry['role'] }}</h3>
        <p class="timeline-entry__company">{{ $entry['company'] }}</p>
        <p class="timeline-entry__summary">{{ $entry['summary'] }}</p>
    </div>
</article>
