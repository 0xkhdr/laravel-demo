<!-- Hero Section Page: Full-page viewport with navigation overlay -->
<section class="hero-section relative w-full min-h-screen overflow-hidden" style="height: 100vh;">
    <!-- Navigation Overlay Component with semi-transparent gradient background -->
    <div class="absolute top-0 left-0 right-0 z-50 bg-gradient-to-b from-black/40 to-transparent">
        <x-nav :active="'home'" />
    </div>

    <!-- Hero Component: Displays headline, subtitle, and primary CTA button centered -->
    <x-hero
        :headline="$portfolio['hero']['title'] ?? 'Welcome to My Portfolio'"
        :subheading="$portfolio['hero']['description'] ?? 'Full-Stack Developer & Creative Problem Solver'"
        :ctaText="$portfolio['hero']['primary_cta']['label'] ?? 'View My Work'"
        :ctaUrl="$portfolio['hero']['primary_cta']['href'] ?? '#projects'"
    />
</section>
