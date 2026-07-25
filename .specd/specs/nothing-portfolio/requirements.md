# Requirements — Nothing.tech Design System Portfolio

> Use stable requirement and criterion IDs. Write testable EARS behavior; replace all prompts.

## R1 — Design System Foundation

owner: Mohamed Khedr
priority: must
risk: high

- R1.1: When the site loads, the system shall apply CSS custom properties for color palette (grayscale + red accent #FF3B30).
- R1.2: When typography renders, the system shall use Space Mono (display), Inter (body), JetBrains Mono (code) from self-hosted fonts.
- R1.3: When sections load, the system shall apply spacing scale (--space-1 to --space-24) consistently.
- R1.4: When containers render, the system shall respect max-width 1400px with responsive padding via clamp().

## R2 — Component Library

owner: Mohamed Khedr
priority: must
risk: medium

- R2.1: When navigation renders, the system shall display fixed top bar with backdrop-filter blur and proper typography.
- R2.2: When hero section renders, the system shall display fullscreen with massive display text and outlined CTA button.
- R2.3: When project cards render, the system shall apply 1px borders with hover state (border-color transition + translateY).
- R2.4: When buttons render, the system shall support normal and accent variants with proper hover fills.
- R2.5: When skill tags render, the system shall display bordered pills with inline-block display.

## R3 — Page Sections

owner: Mohamed Khedr
priority: must
risk: medium

- R3.1: When hero section loads, the system shall display fullscreen with name in massive text, subtitle, and CTA.
- R3.2: When about section loads, the system shall display on black background with white text (2-3 paragraphs).
- R3.3: When projects section loads, the system shall display grid of project cards (2 columns desktop, 1 mobile).
- R3.4: When skills section loads, the system shall display categorized skill tags (Languages, Frameworks, Databases, DevOps, Tools).
- R3.5: When contact section loads, the system shall display email link, social links, and optional contact form.

## R4 — Interactions & Animations

owner: Mohamed Khedr
priority: should
risk: low

- R4.1: When elements enter viewport, the system shall fade in and slide up slightly (opacity + translateY).
- R4.2: When user hovers links, the system shall transition color to accent with 200ms easing.
- R4.3: When user hovers cards, the system shall brighten border and lift card (translateY -4px).
- R4.4: When page transitions occur, the system shall use simple fade over 300ms.

## R5 — Responsive & Accessibility

owner: Mohamed Khedr
priority: must
risk: medium

- R5.1: When viewport is mobile, the system shall stack components vertically with full-bleed sections.
- R5.2: When user has reduced-motion preference, the system shall disable all animations.
- R5.3: When user tabs through page, the system shall show 2px solid accent focus outline on all interactive elements.
- R5.4: When page renders, the system shall maintain WCAG 2.1 AA color contrast (4.5:1 minimum).
- R5.5: When page renders, the system shall use semantic HTML (main, section, article, nav, footer).

## R6 — Performance & Optimization

owner: Mohamed Khedr
priority: must
risk: medium

- R6.1: When Lighthouse audits, the system shall score 95+ on all metrics.
- R6.2: When page loads, the system shall render FCP under 1.5s with self-hosted fonts.
- R6.3: When CSS bundles, the system shall purge unused Tailwind classes.
- R6.4: When JS bundles via Vite, the system shall tree-shake unused code.

## Edge and failure behavior

- Dark mode toggle switches between white and black sections smoothly
- Missing fonts fallback to system stack without layout shift
- Keyboard navigation works on all interactive components
- Images respect max-width:100% and don't cause horizontal scroll

## Non-goals

- Server-side rendering beyond Laravel Blade templates
- Complex stateful frontend framework beyond vanilla JS
- External API integrations (static portfolio)
- Form submission to backend (contact form optional)
