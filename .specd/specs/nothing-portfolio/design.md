# Design — Nothing.tech Design System Portfolio

> Replace prompts. Trace every decision to approved requirement IDs.

## Decision: Monolithic Blade + Tailwind Architecture

- references: R1, R2, R3, R4, R5, R6
- disposition: accepted
- owner: Mohamed Khedr

## Boundaries

**In scope:**
- Laravel 11 Blade templating for all HTML structure
- Tailwind CSS with custom theme extending Nothing design system
- Vanilla JavaScript for scroll reveals and interactions (no framework)
- Self-hosted fonts (Inter, JetBrains Mono, Space Mono)
- Single-page sections with semantic HTML

**Out of scope:**
- Backend API development (static portfolio)
- Complex state management (use data attributes + CSS)
- External libraries beyond GSAP/Lucide if needed
- Form submission backend (placeholder form only)

## Interfaces

**File Structure:**
```
resources/css/app.css                 # Tailwind entry + custom properties
resources/css/components/             # Component-scoped styles
resources/css/utilities/               # Utility overrides
resources/views/layouts/app.blade.php  # Main layout with nav/footer
resources/views/components/            # Reusable Blade components
resources/views/sections/              # Page section templates
resources/js/app.js                    # Entry point + dark mode
resources/js/animations.js             # Scroll reveals + interactions
public/fonts/                          # Self-hosted font files
```

**CSS Custom Properties:**
- Color system: `--color-bg`, `--color-text-primary`, `--color-accent` (red #FF3B30)
- Typography: `--font-display`, `--font-body`, `--font-mono`
- Spacing: `--space-1` through `--space-24`
- Layout: `--section-py`, `--section-px`, `--grid-gap`

**Blade Component Contracts:**
- Each component receives props only (no global state)
- Dark mode via `[data-theme="dark"]` on `<html>` element
- CSS-only interactions (no JavaScript imperative DOM manipulation)

## Invariants

- **Monochromatic discipline:** 90% grayscale, red used only for CTAs and active states
- **No shadows:** Use borders and glassmorphism (`backdrop-filter: blur()`) instead
- **Borders only:** `1px solid` low-opacity, become solid on hover
- **Typography hierarchy:** Monospace for display, sans-serif for body, monospace for code
- **Responsive baseline:** Mobile-first with semantic breakpoints (sm, md, lg, xl)
- **Contrast minimum:** All text meets 4.5:1 on backgrounds for WCAG AA
- **No external JS:** Vanilla JS for reveals + CSS for hover/transitions
- **Performance ceiling:** Lighthouse 95+, FCP <1.5s with self-hosted fonts

## Failure

**Failure mode: Fonts don't load**
- Containment: System font stack fallback (system-ui, -apple-system, monospace)
- Recovery: No layout shift (`font-display: swap`), renders in fallback font
- Observation: Check WebFonts in Chrome DevTools; compare rendered metrics

**Failure mode: Dark mode toggle in reduced-motion**
- Containment: Disable transition on `prefers-reduced-motion: reduce`
- Recovery: Theme still switches, no animation
- Observation: Test with `emulation/accessibility/reduced-motion` in DevTools

**Failure mode: Responsive breakpoint squash**
- Containment: `clamp()` functions for responsive scaling
- Recovery: Content reflows to mobile-first baseline
- Observation: Manual test on actual devices (not just viewport emulation)

## Integration

**Vite + Tailwind:**
- Tailwind scans `resources/**/*.blade.php` for class discovery
- Vite bundles compiled CSS + JS with tree-shaking
- Development mode: `npm run dev` (hot reload)
- Production build: `npm run build` (purge + minify)

**Laravel structure:**
- `app/Http/Controllers/PortfolioController.php` renders main view
- `routes/web.php` single route pointing to controller
- No database (static seed data in Blade or config)
- No authentication required

**Dark mode state:**
- Stored in `localStorage` under key `theme`
- Applied to `<html data-theme="dark|light">`
- Toggleable via nav icon
- CSS applies via `@media (prefers-color-scheme)` and `:root[data-theme]` override

## Alternatives Considered

**Option 1: SPA (Vue/React)**
- Rejected: Adds 100+ KB JS overhead, excessive for static portfolio
- Accepted path: Blade + vanilla JS is 20x smaller and sufficient

**Option 2: CSS-in-JS (Styled Components)**
- Rejected: Requires runtime, breaks static builds, worse performance
- Accepted path: Tailwind + CSS files are zero-runtime, ship only CSS

**Option 3: External font service (Google Fonts CDN)**
- Rejected: Adds third-party request, variable latency, breaks offline
- Accepted path: Self-hosted fonts with `font-display: swap`, guaranteed FCP

**Option 4: Dynamic CMS (headless API)**
- Deferred: Start with static data, add CMS only if needed
- Accepted path: Config-driven or Blade-native data (no external API)

## Verification

**Invariant: Monochromatic discipline**
- Test: `grep -r "#[0-9a-f]{6}" resources/css/ | grep -v "^#000|^#FFF|^#FF3B30"` returns only system colors
- Proof: Color audit passes

**Invariant: No external JS frameworks**
- Test: `grep -r "import.*vue|react|svelte" resources/` returns nothing
- Proof: Package.json has no framework dependency

**Invariant: Contrast minimum 4.5:1**
- Test: Run Axe DevTools, WebAIM contrast checker on all text pairs
- Proof: Zero color-contrast violations

**Invariant: Lighthouse 95+**
- Test: `lighthouse https://localhost:3000 --output-path lighthouse.html`
- Proof: Performance, Accessibility, Best Practices, SEO all >= 95

**Invariant: Responsive mobile-first**
- Test: Manual viewport sizes 320px, 768px, 1024px, 1440px
- Proof: No horizontal scroll, text readable, touch targets >= 48px

## Deployment

**Rollout:**
- Build: `npm run build` outputs to `public/` (Vite manifest)
- Serve: `php artisan serve` or Laravel Forge/Railway deployment
- Observation: Lighthouse audit, cross-device manual test, DNS propagation check

**Owner:** Mohamed Khedr

## Rollback

**Trigger:** Lighthouse drop below 90, accessibility violations, font loading timeout

**Safe restoration:**
1. Revert git commit `git revert -n HEAD` (no auto-commit)
2. Rebuild: `npm run build && php artisan serve`
3. Re-audit Lighthouse and accessibility
4. Post-mortem: Document what broke and why

**Owner:** Mohamed Khedr
