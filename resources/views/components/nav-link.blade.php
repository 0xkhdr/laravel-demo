@props(['href'])

<a {{ $attributes->class(['nav-link']) }} href="{{ $href }}">
    {{ $slot }}
</a>
