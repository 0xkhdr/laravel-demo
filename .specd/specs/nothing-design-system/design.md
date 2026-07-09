# Nothing Design System — Implementation Strategy

## Architecture

### Phase 1: Foundation (2 tasks)
**Goal:** Establish design tokens, typography, and layout infrastructure.

**Why:** CSS custom properties and Tailwind config are prerequisites for all components. Font setup must be done early to avoid layout shifts.

**Files touched:**
- `resources/css/app.css`
- `tailwind.config.js`
- `public/fonts/` (new)
- `resources/views/layouts/app.blade.php`

**Tasks:**
1. **CSS Custom Properties & Global Styles**
   - Define color system (CSS variables)
   - Define typography scale
   - Define spacing system
   - Reset/base styles
   - Focus states (accessibility)

2. **Tailwind Config & Font Setup**
   - Configure Tailwind to use Nothing palette + typography
   - Add custom utilities (tracking-nothing, leading-tight, etc.)
   - Self-host font files (Space Mono, Inter, JetBrains Mono)
   - Add @font-face declarations

---

### Phase 2: Core Components (7 tasks)
**Goal:** Build reusable, styled Blade components matching the design system.

**Why:** Components are the building blocks for pages; establishing them early means sections can compose them cleanly.

**Files touched:**
- `resources/views/components/` (new)

**Tasks:**
3. **Navigation Component**
   - Fixed top, 64px height, glassmorphic backdrop blur
   - Logo (monospace, "DEV.NAME")
   - Nav links (uppercase, letter-spacing)
   - Mobile overlay toggle
   - Dark mode toggle icon

4. **Hero Section Component**
   - Fullscreen height, typography-focused
   - Massive display text (Space Mono Bold)
   - Subtitle (secondary color, max-width 600px)
   - CTA button (outlined)
   - Optional: animated dot-matrix grid background

5. **Section Header Component**
   - Small uppercase label + large heading
   - Thin 1px separator line
   - Consistent spacing

6. **Project Card Component**
   - Bordered container (1px solid)
   - Project name, tech tags, description
   - GitHub & Live Demo links (buttons)
   - Hover: border brightens, card lifts (translateY -4px)

7. **Button Component (Variants)**
   - Default: outlined, transparent, uppercase
   - Accent: red border/text
   - Hover: fill inversion
   - Focus: red outline

8. **Terminal/Code Block Component**
   - Black background, monospace font
   - Syntax coloring (green prompt, white commands, gray output)
   - Overflow scroll on long content

9. **Skill Tag Component**
   - Bordered pill (1px solid)
   - Inline display with margin
   - Hover: border becomes solid black

---

### Phase 3: Page Sections (6 tasks)
**Goal:** Build full-page sections, compose components, integrate content.

**Why:** Sections are where user sees the design; early validation catches component issues.

**Files touched:**
- `resources/views/sections/` (new)
- `resources/views/pages/` (new, or use single index page)

**Tasks:**
10. **Hero Page**
    - Use Hero component
    - Name, title, value prop, CTA
    - Optional: canvas grid animation

11. **About Section**
    - Black background (data-theme="dark")
    - White text, 2-3 paragraphs
    - Max-width container
    - No photo (text-focused)

12. **Experience Section**
    - White background
    - Timeline: vertical line + entries
    - Company, role, date, bullet points
    - Dates in monospace

13. **Projects Section**
    - Black background
    - 2-col grid desktop, 1-col mobile
    - Compose Project Card components
    - Grid gap, hover effects

14. **Skills Section**
    - White background
    - Categories: Languages, Frameworks, Databases, DevOps, Tools
    - Skill Tag components
    - Flex layout, centered

15. **Contact Section**
    - Black background
    - Large heading: "Let's build something."
    - Email link (display font, large)
    - Social links (GitHub, LinkedIn, Twitter)
    - Optional: minimal contact form (no labels, placeholder only)

---

### Phase 4: Polish & Refinement (5 tasks)
**Goal:** Animations, responsive design, accessibility audit, performance.

**Why:** Polish separates production-ready from prototype; these are cross-cutting and require full page context.

**Files touched:**
- `resources/js/` (new)
- `tailwind.config.js` (refinement)
- `resources/css/` (refinement)

**Tasks:**
16. **Dark Mode Toggle**
    - Toggle icon in nav
    - Update `[data-theme]` on root
    - Persist to localStorage
    - Smooth color transition (0.5s)
    - Test all sections

17. **Scroll Animations**
    - Intersection Observer: fade in + translateY reveal
    - Apply to: section headers, cards, text blocks
    - Easing: cubic-bezier(0.25, 0.1, 0.25, 1)
    - Respect prefers-reduced-motion

18. **Responsive Design**
    - Mobile: 320px–640px (single column, full-bleed sections)
    - Tablet: 641px–1024px (adjust grids, padding)
    - Desktop: 1025px+ (2-col grids, generous padding)
    - Typography: clamp() for scalable sizing
    - Test grid breakpoints, touch targets

19. **Accessibility Audit & Fixes**
    - Heading hierarchy validation
    - Focus states on all interactive elements
    - Color contrast check (WCAG AA)
    - Semantic HTML verification
    - Alt text for images
    - Test with screen reader

20. **Performance Optimization**
    - Lighthouse audit (aim for 95+)
    - Lazy load images
    - Tree-shake unused CSS/JS
    - Font loading: `font-display: swap`
    - Minify & compress assets via Vite

---

## Implementation Order

**Why this order:**
- Foundation first → everything else depends on it
- Components second → reusable, testable units
- Sections third → real page context, composing components
- Polish last → cross-cutting, benefit from full page context

**Parallel Potential:**
- Components (Phase 2) can be built in parallel after Foundation is done
- Sections (Phase 3) can be built in parallel once their component dependencies exist
- Polish tasks (Phase 4) are largely independent but require all sections complete

## Decision Log

### No external component libraries
**Why:** Build custom to ensure perfect design adherence. Tailwind + Blade is sufficient; no shadcn, no Bootstrap, no Material.

### Vanilla JS, optional GSAP
**Why:** Minimize dependencies. Use IntersectionObserver for scroll reveals (native, fast). GSAP only if complex animations justify it.

### No Next.js/Nuxt
**Why:** Blade + Vite is lighter, faster to compile. Laravel's templating is sufficient; no need for JS framework overhead.

### Single-page or multi-page?
**Decision:** Start with single-page (long-scroll), sections separated by background color. If pagination needed later, easy to refactor into separate routes.

### Self-hosted fonts only
**Why:** Google Fonts CDN adds latency & external dependency. Self-host woff2 for fast load, no layout shift.

### Accessibility first, not bolted on
**Why:** Semantic HTML, focus states, color contrast defined in Phase 1 variables. Saves rework in Phase 4.
