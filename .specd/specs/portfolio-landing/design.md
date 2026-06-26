# Design — Portfolio Landing Page using Nothing.tech Design System

## Overview

Portfolio landing page implemented as a single Blade view (`resources/views/landing.blade.php`) served from `GET /` route. Design approach leverages Nothing.tech CSS custom properties (color, typography, spacing, transitions, shadows) imported via `resources/css/design-system.css` compiled into the main stylesheet. No custom CSS beyond the design system; all components compose existing tokens.

Structure: Hero → Nav (fixed) → Projects → Articles → Packages → CTA sections → Footer. Responsive grid layouts use CSS Grid with `clamp()` for fluid spacing. Hover effects (scale, color shift) use CSS transitions. All hardcoded colors/spacing removed; only design tokens used.

## Architecture

```
resources/views/landing.blade.php (main view)
├── Hero component (full-viewport section)
├── Navigation component (fixed, detects scroll)
├── Featured projects grid (responsive, 2→1 columns)
├── Recent articles grid (responsive, 3→1 columns)
├── Packages preview grid (3–4 feature cards)
├── CTA sections (alternating backgrounds)
└── Footer component (multi-column links, social)

resources/css/design-system.css (imported)
├── CSS custom properties (:root)
├── Dark theme override ([data-theme="dark"])
└── Base component styles (buttons, cards, inputs)

app/Http/Controllers/Web/LandingController.php
├── Landing::index() — Queries featured projects, recent articles, packages
└── Returns view with data
```

## Components and interfaces

### 1. LandingController::index()
**Responsibility:** Aggregate data for landing page.
**Inputs:** None (GET / route)
**Outputs:** Blade view with:
- `$featuredProjects` (Collection): Top 2–4 projects, sorted by featured flag + created_at desc
- `$recentArticles` (Collection): Top 3–6 articles, sorted by published_at desc
- `$featuredPackages` (Collection): Top 3–4 packages, filtered by featured flag

**Contract:** All collections are paginated (if needed) or limited to expected counts. Null/empty collections gracefully render empty cards or hide sections.

### 2. landing.blade.php View
**Responsibility:** Render HTML structure, apply design tokens, attach event listeners for dynamic nav behavior.
**Sections:**
- **Hero section** — Black background, NDot headline (clamp(48px, 8vw, 120px)), white subtext, CTA button
- **Navbar** — Fixed, transparent → blur on scroll, dynamic text color
- **Projects grid** — CSS Grid, 2 columns (desktop), 1 column (mobile), gap 24px, scale(1.02) hover
- **Articles grid** — CSS Grid, 3 columns (desktop), 2 (tablet), 1 (mobile), gap 24px
- **Packages grid** — Flex layout, 3–4 items, feature cards (icon top, text below)
- **CTA sections** — Two buttons side-by-side (desktop), stacked (mobile), alternating bg colors
- **Footer** — Multi-column grid: Links (50%), Social (25%), Copyright (25%)

**Contract:** All color/spacing uses CSS variables. No inline styles except dynamic positioning. Transitions defined in design-system.css.

### 3. Design System CSS (design-system.css)
**Responsibility:** Define and expose design tokens as CSS custom properties.
**Properties exposed:**
- Colors: `--color-pure-black`, `--color-pure-white`, `--color-nothing-red`, `--color-gray-*`, `--color-dark-*`
- Typography: `--font-display`, `--font-body`, `--font-mono`, `--text-hero`, `--text-h1`–`--text-h5`, `--text-body`, etc.
- Spacing: `--space-1` through `--space-32`, `--page-max-width`, `--page-padding`, `--grid-gap`, `--section-padding-y`
- Effects: `--shadow-sm/md/lg/dark`, `--backdrop-blur`, `--transition-fast/base/slow/transform`, `--z-*`

**Contract:** All component styles reference tokens only; no hardcoded values. Dark theme override applies via `[data-theme="dark"]` selector.

## Data models

### Project (articles/packages/projects)
```
- id: int
- title: string
- slug: string (kebab-case, auto-generated)
- description: string (short teaser)
- image_url: string (URL to /public/images/projects/...)
- link: string (URL to /projects/{slug} or external)
- featured: boolean (highlights in grid)
- order: int (sort priority)
- created_at: timestamp
- updated_at: timestamp
```

### Article
```
- id: int
- title: string
- slug: string
- excerpt: string (displayed in grid)
- body: string or text (Markdown, stored in storage/)
- published_at: timestamp
- featured: boolean
- created_at, updated_at: timestamp
```

### Package
```
- id: int
- name: string
- slug: string
- description: string
- icon_url: string (48px SVG or image)
- link: string (to package detail or external)
- featured: boolean
- order: int
- created_at, updated_at: timestamp
```

## Error handling

### Missing Data
**Failure mode:** Database query returns null/empty for projects, articles, or packages.
**Response:** Render section with empty grid (4–6 placeholder cards or hide section). No error message to user.

### Missing Images
**Failure mode:** `image_url` or `icon_url` is null or points to 404.
**Response:** Lazy-load with `src="" onerror="this.src='/images/placeholder.jpg'"`. Fallback to monochrome placeholder.

### Slow Page Load
**Failure mode:** Page takes >2s to load (4G mobile).
**Response:** Implement lazy-loading on images below fold, deferred CSS parsing, minification. Defer optimization to DevOps phase.

### Accessibility Violations
**Failure mode:** WCAG AA contrast fails, missing alt text, non-semantic HTML.
**Response:** Detected in `specd verify` step (Lighthouse audit + manual review). Fix before ship.

## Verification strategy

**Unit tests** (future): Not in landing MVP; defer to controller logic tests.

**Integration tests:**
1. **Route loads:** `GET /` returns 200 with Blade view
2. **Data query:** Controller fetches projects, articles, packages correctly
3. **View renders:** HTML contains expected hero, sections, footer

**System tests** (Lighthouse + manual):
1. **Performance:** FCP <2s (4G), Lighthouse score ≥85
2. **Accessibility:** WCAG AA, keyboard navigation, semantic HTML
3. **Responsive:** 375px (mobile), 768px (tablet), 1440px (desktop) all reflow correctly
4. **Visual:** All colors use design tokens, spacing matches scale, border-radius 0px everywhere, red accent appears only on CTAs

**Maps to requirements:**
- Req 1–7 verified via manual visual inspection + screenshot comparison
- Req 8 verified via CSS audit (grep for hardcoded colors/spacing)
- Req 9 verified via responsive viewport tests
- Req 10 verified via Lighthouse, WAVE accessibility, keyboard nav testing

## Risks and open questions

### Risk: Design System CSS Loading
**Issue:** If design-system.css fails to load, page renders with no styling.
**Mitigation:** Inline critical CSS (color variables) in `<style>` tag in `<head>`; defer non-critical CSS to external file. Test with CSS disabled.

### Risk: Performance (Large Images)
**Issue:** Project/article image loading may cause CLS shift or slow FCP.
**Mitigation:** Lazy-load images below fold. Define aspect-ratio on cards to reserve space. Defer image optimization (WebP, srcset) to DevOps phase.

### Risk: Mobile CTA Button Overlap
**Issue:** On mobile, two side-by-side buttons may overflow or overlap text.
**Mitigation:** Use media query to stack buttons on <768px. Test on actual mobile device (iPhone, Android).

### Open Question: Dark Theme
**Issue:** Nothing.tech design system defines dark theme (`[data-theme="dark"]`), but MVP only implements light theme.
**Decision:** Dark theme is out of scope; future iteration. CSS structure supports it via `:root` + `[data-theme="dark"]` override.

### Open Question: Featured/Order Logic
**Issue:** How to prioritize projects/articles in grid? By `featured` flag, `order`, or `created_at`?
**Decision:** Controller sorts by `featured DESC, order ASC, created_at DESC`. Can be tuned in EXECUTE phase.

### Open Question: External Links vs Internal Routes
**Issue:** Project/package links may point to internal routes (/projects/...) or external URLs (GitHub, portfolio site).
**Decision:** Store `link` as flexible URL; frontend renders `<a href="{{ $item->link }}">`. Target="_blank" for external links (detect via protocol check).

### Open Question: Placeholder Content
**Issue:** If database is empty, what content appears in sections?
**Decision:** Render empty grids or hardcoded demo data (seeder). Defer to EXECUTE phase; add warning in controller if no featured items found.
