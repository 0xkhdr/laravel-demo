# Nothing Design System — Portfolio Implementation

## Goal
Implement the Nothing.tech design system in the Laravel portfolio, adhering strictly to the Nothing aesthetic: minimal, transparent, monochromatic with surgical red accents, technological nostalgia.

## Core Requirements

### 1. Design Philosophy
- **Transparency** — Literal (glassmorphism) and metaphorical (honest content)
- **Technological nostalgia** — Dot-matrix typography, IBM mainframe era (1980s) raw digital
- **Monochromatic discipline** — 90% black & white, red only for CTAs/active states
- **Weightlessness** — Ample whitespace, no heavy shadows
- **Industrial honesty** — Expose structure, don't hide it

### 2. Visual System (Non-Negotiable)
- **Color palette:** Pure black `#000000`, pure white `#FFFFFF`, Nothing Red `#FF3B30`
- **No gradients, no shadows** (use borders + glassmorphism instead)
- **Borders:** `1px solid`, low opacity, become solid on hover
- **Border radius:** `0px` or `2px` max
- **Typography:** Space Mono (display), Inter (body), JetBrains Mono (code)
- **Spacing:** Generous, clamp-based responsive system

### 3. Component Library
Must implement:
- Navigation (fixed top, glassmorphic backdrop blur)
- Hero section (fullscreen, massive typography)
- Section headers (small label + large heading)
- Project cards (bordered, hover lift)
- Buttons (outlined, fill on hover)
- Terminal/code blocks (black bg, green prompt, gray output)
- Skill tags (bordered pills)
- Footer (minimal, large padding)

### 4. Sections
- Hero — fullscreen, name + subtitle + CTA
- About — black bg, white text, 2-3 paragraphs
- Experience — timeline, vertical layout
- Projects — 2-col grid, project cards with tech tags
- Skills — categorized tags (Languages, Frameworks, Databases, DevOps, Tools)
- Contact — email link, social links, minimal form

### 5. Dark Mode
- Toggle in nav, smooth transition
- Use `[data-theme="dark"]` attribute on root
- Swap colors while maintaining contrast and hierarchy

### 6. Animations & Interactions
- **Philosophy:** Restrained, purposeful (no bounce, no elastic)
- **Scroll reveals:** Fade in + translateY on intersection
- **Hover states:** Border color transition + subtle lift (translateY -4px)
- **Easing:** Linear or `cubic-bezier(0.25, 0.1, 0.25, 1)`

### 7. Accessibility (WCAG 2.1 AA)
- Proper heading hierarchy (h1 → h2 → h3)
- Focus states: `outline: 2px solid var(--color-accent)`, no `outline: none`
- Semantic HTML: `<main>`, `<section>`, `<article>`, `<nav>`, `<footer>`
- Respect `prefers-reduced-motion`
- Color contrast: 4.5:1 minimum for body text
- Alt text for all images

### 8. Performance
- Lighthouse score: 95+ all metrics
- First Contentful Paint: < 1.5s
- Self-host ALL fonts (no CDN)
- Lazy load images
- CSS: Purge unused Tailwind
- JS: Tree-shake via Vite

### 9. Tech Stack
- **Framework:** Laravel 11
- **Frontend:** Blade + Vite
- **CSS:** Tailwind (custom config matching design system)
- **JS:** Vanilla JS (no framework)
- **Fonts:** Self-hosted (Space Mono, Inter, JetBrains Mono)
- **Icons:** Lucide (outline only, 1.5px stroke)
- **Animations:** GSAP (ScrollTrigger) or vanilla IntersectionObserver

## Acceptance Criteria
✅ All components match BUILD_PROMPT.md exactly
✅ Lighthouse 95+ on all metrics
✅ WCAG 2.1 AA compliance verified
✅ Responsive: tested on mobile, tablet, desktop
✅ Dark mode toggle works, smooth transition
✅ All font files self-hosted
✅ No external CSS/JS beyond GSAP (optional)

## Success Measures
- Design adherence: 100% match to BUILD_PROMPT.md
- Performance: 95+ Lighthouse
- Accessibility: WCAG 2.1 AA pass
- Responsiveness: works on 320px–2560px viewports
