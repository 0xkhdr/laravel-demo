@props([
    'eyebrow' => 'Nothing Portfolio',
    'status' => 'READY',
    'class' => '',
])

<main {{ $attributes->merge(['class' => trim('page-shell ' . $class)]) }}>
    <section class="page-shell__frame">
        <div class="page-shell__topbar">
            <span class="page-shell__badge">{{ $eyebrow }}</span>
            <span>{{ $status }}</span>
            <span class="page-shell__badge page-shell__badge--muted">LOCAL / STATIC</span>
        </div>
        <div class="page-shell__rail" aria-hidden="true">
            <span class="page-shell__rail-line"></span>
            <span class="page-shell__badge">NO BUILD PIPELINE</span>
            <span class="page-shell__rail-line"></span>
        </div>
        <div class="page-shell__body">
            {{ $slot }}
        </div>
    </section>
</main>
