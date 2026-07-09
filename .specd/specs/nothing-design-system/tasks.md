# Nothing Design System Tasks

## Phase 1: Foundation

### Task 1.1: CSS Custom Properties & Global Styles
**Role:** craftsman
**Files:**
- `resources/css/app.css` (create if missing, or append)
**Scope:**
- Define `:root` CSS custom properties for colors, typography scale, spacing, borders
- Add `[data-theme="dark"]` overrides
- Reset & base styles (margin, padding, font-family, line-height)
- Focus states: `:focus-visible { outline: 2px solid var(--color-accent) }`
- Body text defaults (Inter, 16px, line-height 1.4, color-secondary)
- Heading defaults (tight line-height, no margin-top)
**Verify:**
```bash
grep -c "color-accent\|color-text-primary\|space-4" resources/css/app.css
```

### Task 1.2: Tailwind Config & Font Setup
**Role:** craftsman
**Files:**
- `tailwind.config.js` (update)
- `public/fonts/` (create, add woff2 files)
- `resources/css/app.css` (@font-face declarations)
**Scope:**
- Add Nothing color palette to Tailwind extend.colors
- Add custom font families (display, body, mono)
- Add custom spacing, tracking, leading utilities
- Add transition timing function: cubic-bezier(0.25, 0.1, 0.25, 1)
- Download/add font files: Space Mono Bold, Inter (400–700), JetBrains Mono (400–500)
- Add @font-face rules with `font-display: swap`
**Verify:**
```bash
ls public/fonts/*.woff2 && grep -c "@font-face" resources/css/app.css
```

---

## Phase 2: Core Components

### Task 2.1: Navigation Component
**Role:** craftsman
**Files:**
- `resources/views/components/nav.blade.php` (create)
- `resources/css/components/nav.css` (create if needed)
- `resources/js/theme-toggle.js` (create, for dark mode toggle)
**Scope:**
- Fixed top, height 64px, backdrop-filter blur(20px), background rgba(255,255,255,0.8)
- Logo: monospace, uppercase, tracking-wide
- Nav links: text-xs, uppercase, hover color-accent transition
- Mobile: hamburger toggle (hidden on desktop), full-screen overlay on mobile
- Dark mode toggle: icon in top-right, emit event to toggle [data-theme]
- No underlines on links
**Verify:**
```bash
grep -c "backdrop-filter\|fixed\|data-theme" resources/views/components/nav.blade.php
```

### Task 2.2: Hero Component
**Role:** craftsman
**Files:**
- `resources/views/components/hero.blade.php` (create)
- `resources/css/components/hero.css` (create if needed)
**Scope:**
- Full viewport height (100vh)
- Centered content: name (text-5xl Space Mono), subtitle (text-lg, secondary color, max-width 600px)
- CTA button: outlined, transparent, hover fill
- Optional: animated dot-matrix background (very low opacity, 0.05–0.1)
- Responsive: name scales down to text-3xl on mobile
**Verify:**
```bash
grep -c "100vh\|text-5xl\|Space Mono" resources/views/components/hero.blade.php
```

### Task 2.3: Section Header Component
**Role:** craftsman
**Files:**
- `resources/views/components/section-header.blade.php` (create)
**Scope:**
- Label: text-xs, uppercase, letter-spacing 0.15em, color-muted
- Heading: text-3xl–4xl, tight line-height (1.0–1.15), no margin-top
- Separator: thin 1px line below, currentColor (becomes solid on hover if section card)
**Verify:**
```bash
grep -c "uppercase\|letter-spacing\|1px solid" resources/views/components/section-header.blade.php
```

### Task 2.4: Project Card Component
**Role:** craftsman
**Files:**
- `resources/views/components/project-card.blade.php` (create)
- `resources/css/components/project-card.css` (create if needed)
**Scope:**
- Bordered container: border 1px solid color-border, padding space-6
- Content: title (display font), description (text-sm), tech tags
- Links: GitHub, Live Demo (button components)
- Hover: border-color becomes text-primary, transform translateY(-4px)
- No rounded corners, no shadows
**Verify:**
```bash
grep -c "border.*1px\|translateY\|project-card" resources/views/components/project-card.blade.php
```

### Task 2.5: Button Component (Variants)
**Role:** craftsman
**Files:**
- `resources/views/components/btn.blade.php` (create)
- `resources/css/components/btn.css` (create if needed)
**Scope:**
- Default variant: outlined (border 1px), transparent bg, uppercase, letter-spacing 0.1em
- Accent variant: red border/text (color-accent)
- Hover: bg becomes text-primary, text becomes white (invert)
- Focus: outline 2px solid color-accent
- Padding: 1rem 2rem
- Font: Space Mono, text-xs
**Verify:**
```bash
grep -c "btn\|@apply\|letter-spacing" resources/views/components/btn.blade.php
```

### Task 2.6: Terminal/Code Block Component
**Role:** craftsman
**Files:**
- `resources/views/components/terminal.blade.php` (create)
- `resources/css/components/terminal.css` (create if needed)
**Scope:**
- Background black, color white, font JetBrains Mono, text-sm
- Border: 1px solid color-border-inverse
- Padding: space-6
- Overflow-x auto for long lines
- Syntax coloring: prompt green (#00FF00), commands white, output gray (#888888)
**Verify:**
```bash
grep -c "#000000\|#00FF00\|terminal" resources/views/components/terminal.blade.php
```

### Task 2.7: Skill Tag Component
**Role:** craftsman
**Files:**
- `resources/views/components/skill-tag.blade.php` (create)
**Scope:**
- Bordered pill: border 1px solid color-border, padding 0.5rem 1rem
- Font: JetBrains Mono, text-xs
- Display: inline-block, margin 0.25rem
- Hover: border becomes solid black (color-text-primary)
**Verify:**
```bash
grep -c "skill-tag\|inline-block\|border" resources/views/components/skill-tag.blade.php
```

---

## Phase 3: Page Sections

### Task 3.1: Hero Section Page
**Role:** craftsman
**Files:**
- `resources/views/sections/hero.blade.php` (create)
**Scope:**
- Render Hero component with:
  - Name (user's name)
  - Subtitle (title, e.g., "Backend Engineer")
  - Value proposition (1-line)
  - CTA button text
- Optional: call to canvas-grid.js for dot-matrix background
**Verify:**
```bash
grep -c "hero\|Backend Engineer" resources/views/sections/hero.blade.php
```

### Task 3.2: About Section
**Role:** craftsman
**Files:**
- `resources/views/sections/about.blade.php` (create)
**Scope:**
- Section wrapper with data-theme="dark"
- Section Header component (label: "About", heading: "Who I am")
- White text on black: 2–3 paragraphs, max-width 700px
- No photo, text-focused
**Verify:**
```bash
grep -c "data-theme.*dark\|about" resources/views/sections/about.blade.php
```

### Task 3.3: Experience Section
**Role:** craftsman
**Files:**
- `resources/views/sections/experience.blade.php` (create)
- `resources/css/components/timeline.css` (create if needed)
**Scope:**
- Section Header component
- Timeline layout: vertical line on left, entries offset to right
- Each entry: company name, role, date (monospace), 2–3 bullet points
- White bg, responsive (stack on mobile)
**Verify:**
```bash
grep -c "timeline\|experience\|vertical" resources/views/sections/experience.blade.php
```

### Task 3.4: Projects Section
**Role:** craftsman
**Files:**
- `resources/views/sections/projects.blade.php` (create)
**Scope:**
- Section Header component
- 2-col grid desktop (grid-template-columns: repeat(2, 1fr)), 1-col mobile
- Grid gap: var(--grid-gap) = 24px
- Black background, white text
- Compose Project Card components for each project
**Verify:**
```bash
grep -c "grid\|2fr\|project-card" resources/views/sections/projects.blade.php
```

### Task 3.5: Skills Section
**Role:** craftsman
**Files:**
- `resources/views/sections/skills.blade.php` (create)
**Scope:**
- Section Header component
- Categories: Languages, Frameworks, Databases, DevOps, Tools
- Each category: flex row, wrap
- Skill Tag components for each skill
- White bg
**Verify:**
```bash
grep -c "skill-tag\|Languages\|Frameworks" resources/views/sections/skills.blade.php
```

### Task 3.6: Contact Section
**Role:** craftsman
**Files:**
- `resources/views/sections/contact.blade.php` (create)
**Scope:**
- Black background, white text
- Heading: "Let's build something." (text-4xl, display font)
- Email link (large, display font, color-accent)
- Social links: GitHub, LinkedIn, Twitter/X (outline buttons or links)
- Optional: minimal contact form (name, email, message inputs, no labels, placeholder text only)
**Verify:**
```bash
grep -c "contact\|Let's build\|email" resources/views/sections/contact.blade.php
```

---

## Phase 4: Polish & Refinement

### Task 4.1: Dark Mode Toggle Implementation
**Role:** craftsman
**Files:**
- `resources/js/theme-toggle.js` (create or update)
- `resources/views/components/nav.blade.php` (update to emit events)
**Scope:**
- Listen for theme toggle click in nav
- Update `document.documentElement.setAttribute('data-theme', 'dark'/'light')`
- Persist to localStorage
- Check localStorage on page load, restore previous theme
- Smooth transition: CSS `transition: background-color 0.5s ease, color 0.5s ease;` on root
- Test all sections switch correctly
**Verify:**
```bash
grep -c "localStorage\|data-theme\|toggle" resources/js/theme-toggle.js
```

### Task 4.2: Scroll Animations
**Role:** craftsman
**Files:**
- `resources/js/animations.js` (create or update)
- `resources/css/app.css` (add .reveal states)
**Scope:**
- Use Intersection Observer (vanilla, no GSAP dependency first)
- Elements with class `.reveal`: opacity 0, transform translateY(30px)
- On intersection: add class `.visible`, transition to opacity 1, translateY(0)
- Easing: cubic-bezier(0.25, 0.1, 0.25, 1)
- Duration: 0.8s
- Respect prefers-reduced-motion: if `true`, disable all transitions
- Apply to: section headers, project cards, text blocks
**Verify:**
```bash
grep -c "IntersectionObserver\|prefers-reduced-motion" resources/js/animations.js
```

### Task 4.3: Responsive Design
**Role:** craftsman
**Files:**
- `tailwind.config.js` (verify breakpoints)
- `resources/css/app.css` (add media queries if needed)
- `resources/views/` (all sections, review mobile layout)
**Scope:**
- Mobile (320px–640px): single column, full-bleed sections, large typography
- Tablet (641px–1024px): 1.5-col or 2-col grids where applicable, adjusted padding
- Desktop (1025px+): full 2-col grids, generous spacing
- Use clamp() for responsive typography: `clamp(min, preferred, max)`
- Touch targets: 44px+ on mobile
- Test on: iPhone SE, iPad, MacBook
**Verify:**
```bash
grep -c "@media\|md:\|lg:\|clamp" resources/css/app.css
```

### Task 4.4: Accessibility Audit & Fixes
**Role:** auditor (read-only), then craftsman (if fixes needed)
**Files:**
- All files (review)
**Scope:**
- ✅ Heading hierarchy: h1 (hero name), h2 (sections), h3 (subsections)
- ✅ Focus states: all interactive elements have `:focus-visible { outline: 2px solid var(--color-accent) }`
- ✅ Color contrast: test with WCAG AA (4.5:1 minimum for body text) — axe DevTools
- ✅ Semantic HTML: `<main>`, `<section>`, `<article>`, `<nav>`, `<footer>` where appropriate
- ✅ Alt text: all `<img>` have descriptive alt text
- ✅ Form labels: if form present, `<label>` associated with `<input>` via `for=id`
- ✅ Screen reader test: verify nav, hero CTA, all links are navigable
**Verify:**
```bash
lighthouse http://localhost:8000 --only-categories=accessibility
```

### Task 4.5: Performance Optimization
**Role:** craftsman
**Files:**
- `vite.config.js` (verify minification, tree-shaking)
- `tailwind.config.js` (content paths for purge)
- `resources/css/app.css` (check unused declarations)
**Scope:**
- Run Lighthouse audit: aim for 95+ on Performance, Accessibility, Best Practices, SEO
- Check First Contentful Paint (< 1.5s)
- Lazy load images (if any): `loading="lazy"` on `<img>`
- Fonts: verify all are self-hosted, no CDN requests
- CSS: purge unused Tailwind classes (content config correct)
- JS: tree-shake unused code via Vite
- Minify & compress assets (Vite default)
**Verify:**
```bash
lighthouse http://localhost:8000 --output=json | grep "performance.*95"
```

---

## Task Status Template

Each task follows pattern:
```
[ID] [Title]
Status: not_started → in_progress → blocked → completed
Completed by: [agent name]
Evidence: [git commit, test output, etc.]
```

Tracked in `state.json` (updated by specd tooling).
