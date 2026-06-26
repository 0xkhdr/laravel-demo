# Tasks — Portfolio Landing Page using Nothing.tech Design System

## Wave 1

- [x] T1 — Create LandingController and route ✓ complete · evidence: verified: `bash verify-t1.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:12:37.114479721Z) · 2026-06-26T10:12:40.26945404Z
  - why: "Requirement 1–10 need a backend to fetch and pass data to the view; establish GET / entry point"
  - role: builder
  - files: app/Http/Controllers/Web/LandingController.php, routes/web.php
  - contract: "Create LandingController with index() method; fetch featured projects (limit 4, ordered by featured + created_at), recent articles (limit 6, ordered by published_at desc), featured packages (limit 4); return view('landing') with data. DO NOT modify models or migrations yet. DO NOT add auth/permissions."
  - acceptance: "GET / returns 200 with landing view; view receives $featuredProjects, $recentArticles, $featuredPackages; collections are non-null (empty array if no records)"
  - verify: bash verify-t1.sh
  - depends: —
  - requirements: 1, 2, 3, 4, 5, 6

- [x] T2 — Create landing.blade.php view skeleton ✓ complete · evidence: verified: `bash verify-t2.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:14:14.202884824Z) · 2026-06-26T10:14:17.437596491Z
  - why: "Requirement 1–10 need a Blade view to render sections; establish HTML structure and Tailwind/design-system CSS imports"
  - role: builder
  - files: resources/views/landing.blade.php, resources/css/design-system.css
  - contract: "Create resources/views/landing.blade.php with doctype, html, head (meta, design-system.css import), body (sections: hero, nav, projects, articles, packages, CTAs, footer). Create/import resources/css/design-system.css with CSS custom properties (:root) for colors, typography, spacing, shadows, transitions. DO NOT implement hover effects or JavaScript yet. DO NOT hardcode colors/spacing."
  - acceptance: "landing.blade.php renders without errors; design-system.css loads (zero console errors); HTML is semantic (header, nav, main, section, article, footer); all color/spacing in CSS uses var(--*) tokens"
  - verify: bash verify-t2.sh
  - depends: T1
  - requirements: 1, 2, 8

- [x] T3 — Implement Hero section (full-viewport, black bg, NDot headline, CTA) ✓ complete · evidence: verified: `bash verify-t3.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:15:56.177458608Z) · 2026-06-26T10:15:59.318977237Z
  - why: "Requirement 1 specifies hero layout and design tokens; implement first to establish visual identity"
  - role: builder
  - files: resources/views/landing.blade.php, resources/css/design-system.css
  - contract: "Add hero section HTML: div.hero (height: 100vh, background: var(--color-pure-black)), headline (h1.text-hero, font-display, white text, clamp(48px, 8vw, 120px)), subheading (p.text-body-large, white, max-width 600px), CTA button (primary black or red variant), scroll indicator at bottom. DO NOT add JavaScript scroll listeners yet. DO NOT add animations beyond hover."
  - acceptance: "Hero renders full-viewport (100vh); headline uses NDot font and clamp sizing; subheading is white and readable; button is black or red with white text; scroll indicator is visible at bottom; no hardcoded colors/sizes"
  - verify: bash verify-t3.sh
  - depends: T2
  - requirements: 1

## Wave 2

- [x] T4 — Implement Navigation bar (fixed, scroll detection, adaptive color) ✓ complete · evidence: verified: `bash verify-t4.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:16:58.175062385Z) · 2026-06-26T10:17:01.823509801Z
  - why: "Requirement 2 specifies fixed navbar with dynamic background/text color; implement early to ensure all sections work with it"
  - role: builder
  - files: resources/views/landing.blade.php, resources/css/design-system.css, resources/js/nav.js
  - contract: "Add fixed navbar HTML: position fixed, top 0, z-index 100, height 64px, transparent initially, logo left, links center/right, uppercase. Add CSS: backdrop-blur on scroll, color switching logic (white on dark sections, black on light). Add minimal JS: detect scroll position, toggle backdrop-blur class, change text color based on section background. DO NOT add smooth scroll or anchor links yet. DO NOT make hamburger menu responsive (defer to T11)."
  - acceptance: "Navbar is fixed at top; renders transparent on page load; applies blur(12px) saturate(180%) when scrolled >100px; text color switches white/black based on section; logo is monochrome; links are uppercase with letter-spacing 0.08em; no hardcoded colors"
  - verify: bash verify-t4.sh
  - depends: T3
  - requirements: 2

- [x] T5 — Implement Featured projects grid (responsive, 2→1 columns, hover scale) ✓ complete · evidence: verified: `bash verify-t5.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:17:45.836949082Z) · 2026-06-26T10:17:45.855838252Z
  - why: "Requirement 3 specifies project showcase; implement data rendering and responsive layout"
  - role: builder
  - files: resources/views/landing.blade.php (loop $featuredProjects), resources/css/design-system.css
  - contract: "Add projects section: div.grid (CSS Grid, gap var(--grid-gap) 24px, grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)) for 2→1 responsive reflow). Loop @foreach($featuredProjects as $project): card with image (full-width, aspect-ratio 4/3), title (h4.text-h4), description (p.text-body-small), link. Card styling: border 1px solid var(--color-gray-200), sharp corners (border-radius 0), padding 0 for image (bleeds), padding var(--space-6) for content. Hover: image scale(1.02) over 0.4s, shadow increase. DO NOT fetch projects; assume $featuredProjects passed from controller."
  - acceptance: "Grid renders 4 projects (or fewer if data is sparse); 2 columns on desktop (1440px), 1 column on mobile (375px); image aspect-ratio 4:3 holds on resize; hover scales image smoothly; all spacing/colors use tokens; border-radius is 0px"
  - verify: bash verify-t5.sh
  - depends: T2
  - requirements: 3

- [x] T6 — Implement Recent articles grid (responsive, 3→1 columns, black bg, red "View All" link) ✓ complete · evidence: verified: `bash verify-t6.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:18:30.376333447Z) · 2026-06-26T10:18:30.394019745Z
  - why: "Requirement 4 specifies article feed; implement data rendering, grid layout, and call-to-action"
  - role: builder
  - files: resources/views/landing.blade.php (loop $recentArticles), resources/css/design-system.css
  - contract: "Add articles section: background var(--color-pure-black), white text, div.grid (3 columns desktop → 2 tablet → 1 mobile, gap var(--grid-gap)). Loop @foreach($recentArticles as $article): card with title (h5.text-h5), date (p.text-caption, gray-500), excerpt (p.text-body-small). Cards: border 1px solid var(--color-dark-border), sharp corners. Footer: link 'View All Articles' in red (var(--color-nothing-red)). DO NOT render article body; excerpt only. DO NOT add search/filter."
  - acceptance: "Grid renders 6 articles (or fewer); 3 columns on desktop, 2 on tablet, 1 on mobile; background is pure black; text is white; 'View All' link is red; border, spacing, font sizes all use tokens; no hardcoded colors"
  - verify: bash verify-t6.sh
  - depends: T2
  - requirements: 4

- [x] T7 — Implement Packages preview grid (3–4 feature cards with icons, "Explore All" button) ✓ complete · evidence: verified: `bash verify-t7.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:19:01.936336914Z) · 2026-06-26T10:19:01.955215192Z
  - why: "Requirement 5 specifies package showcase; implement feature card layout and navigation"
  - role: builder
  - files: resources/views/landing.blade.php (loop $featuredPackages), resources/css/design-system.css
  - contract: "Add packages section: light background (var(--color-gray-50) or white). Layout: flex or CSS Grid, 4 columns desktop → 2 tablet → 1 mobile. Loop @foreach($featuredPackages as $package): feature card with icon/image top (48px, monochrome), title (h4.text-h4), description (p.text-body). Button: 'Explore All Packages' (secondary outline: transparent bg, border 1px solid, white text if on dark). DO NOT fetch packages from API; assume $featuredPackages passed. DO NOT add pagination."
  - acceptance: "Grid renders 4 packages (or fewer); icon is 48px and centered; title/description use correct font sizes; 'Explore All' button is outline style (no background, border); responsive reflow works (4→2→1 columns); all tokens used"
  - verify: bash verify-t7.sh
  - depends: T2
  - requirements: 5

- [x] T8 — Implement CTA sections and footer ✓ complete · evidence: verified: `bash verify-t8.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:19:47.473758798Z) · 2026-06-26T10:19:47.493042391Z
  - why: "Requirement 6–7 specify call-to-action and footer; implement navigation/engagement elements"
  - role: builder
  - files: resources/views/landing.blade.php, resources/css/design-system.css
  - contract: "Add 2–3 CTA sections: headline (h2.text-h2), subtext (p.text-body-large), two buttons side-by-side (primary black + secondary outline) or centered. Alternate background colors (black ↔ white) for visual break. Add footer: black background (var(--color-pure-black)), white text, multi-column layout (Links 50%, Social 25%, Copyright 25%). Links use var(--text-caption), uppercase, gray-500 color, white on hover. Social icons: 24px, monochrome. Copyright bar at bottom. DO NOT add copyright year logic; hardcode current year. DO NOT add social link targets yet."
  - acceptance: "2+ CTA sections render with headline, subtext, 2 buttons; buttons are positioned side-by-side on desktop, stacked on mobile; backgrounds alternate black/white; footer is black with white text; links are uppercase gray; social icons are 24px; all spacing/colors use tokens"
  - verify: bash verify-t8.sh
  - depends: T2
  - requirements: 6, 7

## Wave 3

- [x] T9 — Implement responsive design (mobile-first, hamburger menu on <1024px) ✓ complete · evidence: verified: `bash verify-t9.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:21:07.165469908Z) · 2026-06-26T10:21:07.192669632Z
  - why: "Requirement 9 specifies responsive breakpoints; ensure layout reflows correctly and mobile nav works"
  - role: builder
  - files: resources/views/landing.blade.php, resources/css/design-system.css, resources/js/menu.js
  - contract: "Add media queries: @media (max-width: 1024px) for desktop→mobile nav switch. Hamburger button (3-line icon, top-right, z-index 101) toggles full-screen mobile menu overlay. Menu: black background, white text, stacked links, large font size, close button. Grids reflow: projects 4→2→1, articles 3→2→1, packages 4→2→1. Section padding reduces ~40% on mobile (use clamp()). Button layout: side-by-side on desktop, stacked on mobile. Images: full-width on mobile, constrained on desktop. DO NOT use Tailwind's @apply; write explicit CSS for breakpoints."
  - acceptance: "Viewport 375px (mobile): hamburger menu appears, clicking toggles overlay, menu is readable, grids are single-column, buttons stack, images are full-width. Viewport 1440px: hamburger hidden, nav is horizontal, grids have 3+ columns, buttons side-by-side. No layout shift between breakpoints."
  - verify: bash verify-t9.sh
  - depends: T4, T5, T6, T7
  - requirements: 9

- [x] T10 — Verify accessibility (WCAG AA, semantic HTML, keyboard navigation, screen reader) ✓ complete · evidence: verified: `bash verify-t10.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:22:56.214501167Z) · 2026-06-26T10:22:56.240093569Z
  - why: "Requirement 10 specifies accessibility compliance; ensure page is usable for all visitors"
  - role: verifier
  - files: resources/views/landing.blade.php, resources/css/design-system.css
  - contract: "Audit page for: (1) semantic HTML (header, nav, main, section, article, footer), (2) WCAG AA contrast (white on black 21:1, black on white 21:1, all text ≥4.5:1), (3) alt text on images, (4) ARIA labels on buttons/links, (5) keyboard nav (Tab, Enter, Escape), (6) focus indicators (visible outline on interactive elements). Use WAVE tool, Lighthouse accessibility audit, manual keyboard testing. DO NOT fix violations; report findings as evidence. DO NOT modify HTML structure; only add ARIA/alt where missing."
  - acceptance: "WAVE audit: zero errors, <2 contrast warnings (none critical). Lighthouse accessibility score ≥95. Keyboard nav: all interactive elements reachable, focus indicators visible, Enter/Escape work. Alt text: all images have descriptive alt. ARIA labels: buttons have labels, links have text or aria-label."
  - verify: bash verify-t10.sh
  - depends: T8
  - requirements: 10

- [x] T11 — Verify responsive design breakpoints and performance (Lighthouse >85, CLS <0.1, FCP <2s) ✓ complete · evidence: verified: `bash verify-t11.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:28:25.00342834Z) · 2026-06-26T10:28:25.020764033Z
  - why: "Requirement 9–10 specify performance and CLS targets; measure and fix bottlenecks"
  - role: verifier
  - files: resources/views/landing.blade.php, resources/css/design-system.css, resources/images/
  - contract: "Run Lighthouse audit on production build (npm run build). Check: Performance score ≥85, CLS <0.1, FCP <2s on 4G mobile. Screenshot page at 375px, 768px, 1440px; verify no layout shift between breakpoints, grids reflow correctly, text is readable, images load without jank. DO NOT optimize images/code yet; report findings as evidence. DO NOT modify HTML; only identify issues."
  - acceptance: "Lighthouse performance ≥85, CLS <0.1, FCP <2s. Screenshots show clean reflow at all breakpoints. No unexpected layout shift during image load (aspect-ratio CSS prevents reflow). Images below fold load lazily (inspect DevTools)."
  - verify: bash verify-t11.sh
  - depends: T9, T10
  - requirements: 9, 10

- [x] T12 — Final integration test: render full landing page, verify all sections, all tokens, no errors ✓ complete · evidence: verified: `bash verify-t12.sh` → exit 0 @ cdf250fb33152c910033188ee1a8f0f73901ce6a (2026-06-26T10:29:43.631562203Z) · 2026-06-26T10:29:43.666841313Z
  - why: "Requirement 1–10 must all pass together; final gate before spec is complete"
  - role: verifier
  - files: resources/views/landing.blade.php, resources/css/design-system.css, app/Http/Controllers/Web/LandingController.php
  - contract: "Run full page load at desktop (1440px) viewport. Visually inspect: (1) Hero black bg + white headline + button, (2) Nav fixed at top, (3) Projects grid 2 columns, (4) Articles grid 3 columns black bg, (5) Packages 4 cards light bg, (6) CTAs alternating bg, (7) Footer black. Audit CSS: grep for hardcoded colors/spacing (should be zero). Audit HTML: all color/spacing uses var(--*) tokens. Run npm run lint && npm run build without errors. DO NOT modify code; only verify."
  - acceptance: "Page renders without console errors. All sections visible and correctly styled. Zero hardcoded colors or spacing in CSS/HTML. Lighthouse >85, WCAG AA pass, no layout shift. npm run build succeeds. npm run lint zero warnings."
  - verify: bash verify-t12.sh
  - depends: T11
  - requirements: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10
