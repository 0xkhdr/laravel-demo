---
schema: pathframe.design/v1
profile: okf-markdown/v1
---

## Approach

Add a thin web controller or route data handoff, a single Blade layout with small reusable components/partials only where repetition warrants them, and a single plain CSS/JS asset path. Keep the portfolio static and configuration-driven. Use native `localStorage`, `matchMedia`, `IntersectionObserver`, CSS media queries, and `prefers-reduced-motion`. Do not introduce Tailwind, GSAP, Lucide, a CMS, a model, a contact backend, canvas/WebGL, or deployment work.

## Decisions

- Use Laravel 13 conventions already present; do not downgrade to Laravel 11.
- Keep `/api/*` unchanged and scope the work to the web portfolio.
- Use system font fallbacks until licensed font files are supplied; never fabricate binary assets.
- Use text labels/simple CSS glyphs instead of adding an icon dependency.
- Treat performance/Lighthouse claims as unmeasured unless a real browser audit is run; verification records commands and outcomes only.
- Split work into four sequential delegated tasks: foundation/data, Blade structure, CSS/JS behavior, then tests/build/refinement.

## Questions

- none
