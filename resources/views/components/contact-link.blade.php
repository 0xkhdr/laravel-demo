@props(['link'])

<a {{ $attributes->class(['contact-link']) }} href="{{ $link['href'] }}">
    <span class="contact-link__label">{{ $link['label'] }}</span>
    <span class="contact-link__value">{{ $link['value'] }}</span>
</a>
