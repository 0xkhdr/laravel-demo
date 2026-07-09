@php
    // Button component with variants, sizes, and states
    $variant ??= 'primary';
    $size ??= 'md';
    $rounded ??= 'default';
    $icon ??= null;
    $label ??= null;
    $href ??= null;
    $disabled ??= false;

    $sizeClasses = [
        'sm' => 'btn-sm',
        'md' => 'btn-md',
        'lg' => 'btn-lg',
    ];

    $variantClasses = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'ghost' => 'btn-ghost',
    ];

    $roundedClasses = [
        'default' => 'btn-rounded',
        'pill' => 'btn-pill',
    ];

    $btnSizeClass = $sizeClasses[$size] ?? 'btn-md';
    $btnVariantClass = $variantClasses[$variant] ?? 'btn-primary';
    $btnRoundedClass = $roundedClasses[$rounded] ?? 'btn-rounded';

    $classes = "btn {$btnSizeClass} {$btnVariantClass} {$btnRoundedClass}";
    if ($disabled) {
        $classes .= ' btn-disabled';
    }

    $attributes = $attributes->merge([
        'class' => $classes,
        'disabled' => $disabled,
    ]);
@endphp

@if ($href && !$disabled)
    <a href="{{ $href }}" {{ $attributes }}>
        @if ($icon && $icon === 'left')
            <span class="btn-icon btn-icon-left">
                {{ $slot }}
            </span>
        @endif

        @if ($label)
            <span class="btn-label">{{ $label }}</span>
        @else
            {{ $slot }}
        @endif

        @if ($icon && $icon === 'right')
            <span class="btn-icon btn-icon-right">
                {{ $slot }}
            </span>
        @endif
    </a>
@else
    <button {{ $attributes }}>
        @if ($icon && $icon === 'left')
            <span class="btn-icon btn-icon-left">
                {{ $slot }}
            </span>
        @endif

        @if ($label)
            <span class="btn-label">{{ $label }}</span>
        @else
            {{ $slot }}
        @endif

        @if ($icon && $icon === 'right')
            <span class="btn-icon btn-icon-right">
                {{ $slot }}
            </span>
        @endif
    </button>
@endif
