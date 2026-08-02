# 🎯 LARAVEL BACKEND PORTFOLIO — NOTHING.TECH DESIGN SYSTEM

## PROJECT: `nothing-portfolio`

---

## 1. DESIGN PHILOSOPHY (Non-negotiable)

**Core mantra:** *"Less is more. Every element has a clear purpose."*

Nothing.tech's visual identity is built on:
- **Transparency** — Literal (glassmorphism) and metaphorical (honest, no-fluff content)
- **Technological nostalgia** — Dot-matrix typography, IBM mainframe era (1980s) raw digital aesthetic
- **Monochromatic discipline** — Grayscale palette with surgical red accents
- **Weightlessness** — Ample whitespace, floating elements, no heavy shadows
- **Industrial honesty** — Expose structure, don't hide it

---

## 2. COLOR SYSTEM

Define these CSS custom properties globally (`:root`):

```css
:root {
  /* Primary Palette */
  --color-bg: #FFFFFF;
  --color-bg-alt: #F5F5F5;
  --color-bg-dark: #000000;
  --color-bg-dark-alt: #0A0A0A;
  
  /* Text */
  --color-text-primary: #000000;
  --color-text-secondary: #666666;
  --color-text-muted: #999999;
  --color-text-inverse: #FFFFFF;
  
  /* Accent — Nothing Red (used SPARINGLY) */
  --color-accent: #FF3B30;
  --color-accent-hover: #E6352B;
  
  /* Surface */
  --color-surface: rgba(255, 255, 255, 0.05);
  --color-surface-glass: rgba(255, 255, 255, 0.08);
  --color-border: rgba(0, 0, 0, 0.08);
  --color-border-inverse: rgba(255, 255, 255, 0.12);
  
  /* Dark mode surfaces */
  --color-surface-dark: rgba(0, 0, 0, 0.6);
  --color-surface-glass-dark: rgba(0, 0, 0, 0.4);
}
```

**Rules:**
- 90% of the site is pure black and white
- Red accent appears only for: active states, critical CTAs, hover indicators
- No gradients. No drop shadows (use `backdrop-filter: blur()` instead)
- Dark sections use `#000000` not dark gray

---

## 3. TYPOGRAPHY SYSTEM

### Font Stack (Nothing.tech uses custom fonts — we approximate):

```css
/* Primary Display — Dot Matrix inspired */
@font-face {
  font-family: 'NDot';
  src: url('/fonts/SpaceMono-Bold.woff2') format('woff2');
  font-weight: 700;
  font-display: swap;
}

/* Body & UI — Clean geometric sans */
@font-face {
  font-family: 'NType';
  src: url('/fonts/Inter.woff2') format('woff2');
  font-weight: 400;
  font-display: swap;
}

/* Monospace — Code blocks, terminal aesthetic */
@font-face {
  font-family: 'NMono';
  src: url('/fonts/JetBrainsMono-Regular.woff2') format('woff2');
  font-weight: 400;
  font-display: swap;
}
```

**Google Fonts fallback:** `Inter` (400, 500, 600, 700) + `JetBrains Mono` (400, 500) + `Space Mono` (700)

### Type Scale:

```css
:root {
  --font-display: 'Space Mono', 'JetBrains Mono', monospace;
  --font-body: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  --font-mono: 'JetBrains Mono', 'Courier New', monospace;
  
  /* Scale — Nothing uses tight, architectural sizing */
  --text-xs: 0.75rem;      /* 12px — captions, labels */
  --text-sm: 0.875rem;     /* 14px — secondary text */
  --text-base: 1rem;       /* 16px — body */
  --text-lg: 1.125rem;     /* 18px — lead paragraphs */
  --text-xl: 1.5rem;       /* 24px — section headers */
  --text-2xl: 2rem;        /* 32px — major headings */
  --text-3xl: 3rem;        /* 48px — hero secondary */
  --text-4xl: 4.5rem;      /* 72px — hero primary */
  --text-5xl: 6rem;        /* 96px — massive display */
  
  /* Line heights — Tight, architectural */
  --leading-tight: 1.0;
  --leading-snug: 1.15;
  --leading-normal: 1.4;
  --leading-relaxed: 1.6;
  
  /* Letter spacing */
  --tracking-tight: -0.02em;
  --tracking-normal: 0;
  --tracking-wide: 0.05em;
  --tracking-wider: 0.1em;
}
```

**Typography rules:**
- Hero headlines: `Space Mono`, `700`, uppercase, `letter-spacing: 0.05em`
- Body text: `Inter`, `400`, `color: var(--color-text-secondary)`
- Code/terminal blocks: `JetBrains Mono`, `400`, `background: #000`, `color: #00FF00` (matrix green) or white
- All-caps for labels, navigation, section markers
- NEVER use bold on body text — use weight 500 max
- Headings have NO margin-top, tight line-height (1.0-1.15)

---

## 4. SPACING SYSTEM

```css
:root {
  --space-1: 0.25rem;   /* 4px */
  --space-2: 0.5rem;    /* 8px */
  --space-3: 0.75rem;   /* 12px */
  --space-4: 1rem;      /* 16px */
  --space-5: 1.5rem;    /* 24px */
  --space-6: 2rem;      /* 32px */
  --space-8: 3rem;      /* 48px */
  --space-10: 4rem;     /* 64px */
  --space-12: 6rem;     /* 96px */
  --space-16: 8rem;     /* 128px */
  --space-20: 12rem;    /* 192px */
  --space-24: 16rem;    /* 256px */
  
  /* Section padding */
  --section-py: clamp(6rem, 10vh, 12rem);
  --section-px: clamp(1.5rem, 5vw, 4rem);
  
  /* Grid gutter */
  --grid-gap: 1.5rem;
}
```

**Rules:**
- Sections have MASSIVE vertical padding (`--section-py`)
- Content max-width: `1400px` centered
- No container padding on mobile — full-bleed sections with internal padding
- Grid: 12-column, gap `24px`

---

## 5. LAYOUT & GRID

```css
.container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 0 var(--section-px);
}

.grid {
  display: grid;
  grid-template-columns: repeat(12, 1fr);
  gap: var(--grid-gap);
}

/* Nothing.tech uses asymmetric layouts */
.grid-asymmetric {
  grid-template-columns: 2fr 1fr;
}

.grid-reverse {
  grid-template-columns: 1fr 2fr;
}
```

---

## 6. COMPONENTS

### A. Navigation
- Fixed top, `height: 64px`, `backdrop-filter: blur(20px)`, `background: rgba(255,255,255,0.8)`
- Logo: Monospace font, "DEV.NAME" or your name in dot-matrix style
- Links: `text-xs`, `uppercase`, `letter-spacing: 0.1em`, `font-weight: 500`
- No underline on hover — use `color: var(--color-accent)` transition
- Mobile: Full-screen overlay, black background, massive typography

### B. Hero Section
- Full viewport height (`100vh`)
- Massive display text: `var(--text-5xl)` on desktop, `var(--text-3xl)` mobile
- Subtitle: `var(--text-lg)`, `color: var(--color-text-secondary)`, max-width `600px`
- NO background image — pure typography on white/black
- Optional: Subtle animated dot-matrix grid background (canvas/WebGL)
- CTA: Outlined button, `border: 1px solid currentColor`, no fill, hover fills black with white text

### C. Section Headers
- Small label above: `text-xs`, `uppercase`, `letter-spacing: 0.15em`, `color: var(--color-text-muted)`
- Large heading below: `text-3xl` to `text-4xl`, tight line-height
- Separator: Thin `1px` line, not decorative dots

### D. Cards (Project Cards)
```css
.project-card {
  background: transparent;
  border: 1px solid var(--color-border);
  padding: var(--space-6);
  transition: border-color 0.3s ease, transform 0.3s ease;
}

.project-card:hover {
  border-color: var(--color-text-primary);
  transform: translateY(-4px);
}

/* NO box-shadow, NO border-radius (or max 2px) */
```

### E. Buttons
```css
.btn {
  font-family: var(--font-display);
  font-size: var(--text-xs);
  text-transform: uppercase;
  letter-spacing: 0.1em;
  padding: 1rem 2rem;
  border: 1px solid currentColor;
  background: transparent;
  color: var(--color-text-primary);
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn:hover {
  background: var(--color-text-primary);
  color: var(--color-bg);
}

.btn-accent {
  border-color: var(--color-accent);
  color: var(--color-accent);
}

.btn-accent:hover {
  background: var(--color-accent);
  color: white;
}
```

### F. Code/Terminal Blocks
```css
.terminal {
  background: #000000;
  color: #FFFFFF;
  font-family: var(--font-mono);
  font-size: var(--text-sm);
  padding: var(--space-6);
  border: 1px solid var(--color-border-inverse);
  overflow-x: auto;
}

.terminal-prompt {
  color: #00FF00; /* Matrix green */
}

.terminal-command {
  color: #FFFFFF;
}

.terminal-output {
  color: #888888;
}
```

### G. Skill Tags / Pills
```css
.skill-tag {
  font-family: var(--font-mono);
  font-size: var(--text-xs);
  padding: 0.5rem 1rem;
  border: 1px solid var(--color-border);
  display: inline-block;
  margin: 0.25rem;
}

/* Hover: border turns solid black */
```

### H. Footer
- Massive padding top (`var(--space-20)`)
- Minimal: Name, email, GitHub, LinkedIn links
- Copyright: `text-xs`, `color: var(--color-text-muted)`
- No decorative elements

---

## 7. ANIMATIONS & INTERACTIONS

### Philosophy
Nothing.tech uses **restrained, purposeful motion**:
- No bouncy animations
- No parallax overload
- Smooth, linear or `cubic-bezier(0.25, 0.1, 0.25, 1)` easing
- Elements fade in and slide up slightly on scroll

### Scroll Reveal
```css
.reveal {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.8s ease, transform 0.8s ease;
}

.reveal.visible {
  opacity: 1;
  transform: translateY(0);
}
```

### Hover States
- Links: `opacity: 0.6` → `1.0`, 200ms
- Cards: `border-color` transition + subtle `translateY(-4px)`
- Buttons: Fill inversion (transparent → solid)

### Page Transitions
- Simple fade, 300ms
- No complex route transitions

### Optional: Dot Matrix Grid Background
- Canvas-based subtle animated grid
- Dots that pulse on hover
- Monochrome (black dots on white, or white on black)
- Very low opacity (`0.05-0.1`)

---

## 8. DARK MODE

Nothing.tech switches sections between white and black. Implement:

```css
[data-theme="dark"] {
  --color-bg: #000000;
  --color-bg-alt: #0A0A0A;
  --color-text-primary: #FFFFFF;
  --color-text-secondary: #888888;
  --color-text-muted: #555555;
  --color-border: rgba(255, 255, 255, 0.1);
}
```

**Toggle:** Small icon in nav, smooth transition (`transition: background-color 0.5s ease, color 0.5s ease`)

---

## 9. LARAVEL PROJECT STRUCTURE

```
nothing-portfolio/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── PortfolioController.php
│   └── Models/
│       └── Project.php (optional, for CMS)
├── config/
│   └── portfolio.php
├── database/
│   └── seeders/
│       └── ProjectSeeder.php
├── public/
│   ├── fonts/           # Self-hosted fonts
│   ├── images/
│   └── js/
│       └── app.js
├── resources/
│   ├── css/
│   │   ├── app.css      # Tailwind entry + custom props
│   │   ├── components/  # Component styles
│   │   └── utilities/   # Utilities
│   ├── js/
│   │   ├── app.js
│   │   ├── animations.js
│   │   └── canvas-grid.js
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── components/
│       │   ├── nav.blade.php
│       │   ├── hero.blade.php
│       │   ├── section-header.blade.php
│       │   ├── project-card.blade.php
│       │   ├── skill-tag.blade.php
│       │   ├── terminal-block.blade.php
│       │   └── footer.blade.php
│       └── sections/
│           ├── about.blade.php
│           ├── experience.blade.php
│           ├── projects.blade.php
│           ├── skills.blade.php
│           └── contact.blade.php
├── routes/
│   └── web.php
└── vite.config.js
```

---

## 10. TECH STACK

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 11 |
| Frontend | Blade + Vite |
| CSS | Tailwind CSS (custom config matching above) |
| JS | Vanilla JS (no framework needed) |
| Fonts | Self-hosted Inter, JetBrains Mono, Space Mono |
| Icons | Lucide (outline style only, 1.5px stroke) |
| Animations | GSAP (ScrollTrigger) or vanilla IntersectionObserver |

---

## 11. TAILWIND CONFIG

```js
// tailwind.config.js
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        display: ['"Space Mono"', '"JetBrains Mono"', 'monospace'],
        body: ['Inter', 'system-ui', 'sans-serif'],
        mono: ['"JetBrains Mono"', 'monospace'],
      },
      colors: {
        nothing: {
          black: '#000000',
          white: '#FFFFFF',
          red: '#FF3B30',
          gray: {
            50: '#F5F5F5',
            100: '#EEEEEE',
            200: '#DDDDDD',
            300: '#CCCCCC',
            400: '#999999',
            500: '#666666',
            600: '#444444',
            700: '#333333',
            800: '#222222',
            900: '#111111',
          }
        }
      },
      spacing: {
        '18': '4.5rem',
        '22': '5.5rem',
        '30': '7.5rem',
      },
      letterSpacing: {
        'nothing': '0.05em',
        'nothing-wide': '0.1em',
        'nothing-wider': '0.15em',
      },
      transitionTimingFunction: {
        'nothing': 'cubic-bezier(0.25, 0.1, 0.25, 1)',
      },
    },
  },
  plugins: [],
}
```

---

## 12. SECTIONS TO BUILD

### Hero
- Fullscreen, white background
- Name in massive dot-matrix font (`Space Mono Bold`, 96px+)
- Subtitle: "Backend Engineer" or your title
- One-line value proposition
- Single CTA: "View Work" (outlined button)
- Optional: Animated dot grid canvas behind text

### About
- Black background section
- White text
- Large heading: "About"
- 2-3 paragraphs, max-width `700px`
- No photo — keep it text-focused or use a minimal line-art SVG

### Experience
- White background
- Timeline-style layout (vertical line, left side)
- Each entry: Company, Role, Date range, 2-3 bullet points
- Monospace font for dates

### Projects
- Black background
- Grid of project cards (2 columns desktop, 1 mobile)
- Each card:
  - Project name (display font)
  - Tech stack (skill tags)
  - 1-line description
  - Links: GitHub, Live Demo (outlined buttons)
- Hover: border brightens, card lifts slightly

### Skills
- White background
- Categorized: Languages, Frameworks, Databases, DevOps, Tools
- Each skill as a bordered tag/pill
- No progress bars, no percentages — binary: you know it or you don't

### Contact
- Black background
- Large heading: "Let's build something."
- Email link (display font, large)
- Social links: GitHub, LinkedIn, Twitter/X
- Minimal form (optional): Name, Email, Message — no labels, placeholder text only

---

## 13. PERFORMANCE REQUIREMENTS

- Lighthouse score: 95+ on all metrics
- First Contentful Paint: < 1.5s
- Self-host ALL fonts (no Google Fonts CDN)
- Lazy load images (if any)
- No external dependencies except GSAP (if used for scroll animations)
- CSS: Purge unused Tailwind classes
- JS: Bundle with Vite, tree-shake

---

## 14. ACCESSIBILITY

- WCAG 2.1 AA compliance
- Proper heading hierarchy (h1 → h2 → h3)
- Focus states: `outline: 2px solid var(--color-accent)`, no `outline: none`
- Respect `prefers-reduced-motion`: disable all animations
- Semantic HTML: `<main>`, `<section>`, `<article>`, `<nav>`, `<footer>`
- Alt text for any images
- Color contrast: 4.5:1 minimum for body text

---

## 15. CONTENT VOICE & TONE

Nothing.tech's copy is:
- **Direct** — No fluff, no buzzwords
- **Confident** — Short sentences, declarative
- **Technical but accessible** — Show expertise without gatekeeping
- **Minimal** — Every word earns its place

**Example:**
- ❌ "I am a passionate and driven software engineer with a deep love for crafting scalable backend solutions..."
- ✅ "I build systems that scale. Clean architecture. Clean code."

---

## 16. IMPLEMENTATION ORDER

1. **Setup:** Laravel + Tailwind + Vite + font files
2. **Global styles:** CSS custom properties, base typography, utilities
3. **Layout:** App layout, navigation, footer
4. **Hero:** Fullscreen, typography, optional canvas grid
5. **Sections:** About → Experience → Projects → Skills → Contact
6. **Dark mode:** Toggle + transitions
7. **Animations:** Scroll reveals, hover states
8. **Responsive:** Mobile-first, test all breakpoints
9. **Performance:** Optimize, audit, refine
10. **Deploy:** Laravel Forge / Vercel / Railway

---

## 17. KEY DESIGN DECISIONS (Do NOT deviate)

| Decision | Rule |
|----------|------|
| Border radius | `0px` or `2px` max. No rounded corners. |
| Shadows | NONE. Use borders and glassmorphism instead. |
| Gradients | NONE. Solid colors only. |
| Icons | Lucide, outline, 1.5px stroke. No filled icons. |
| Images | Avoid. If used, black & white, high contrast. |
| Backgrounds | Pure white `#FFF` or pure black `#000`. No grays. |
| Typography | Monospace for headings, sans for body. No serif fonts. |
| Animation | Subtle, linear, purposeful. No bounce, no elastic. |
| Spacing | Generous. Let content breathe. |
| Borders | `1px solid`, low opacity. Become solid on hover. |
