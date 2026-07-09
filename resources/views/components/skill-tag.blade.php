@props(['skill', 'variant' => 'default', 'size' => 'md'])

<span class="skill-tag skill-tag--{{ $variant }} skill-tag--{{ $size }}">
    {{ $skill }}
</span>
