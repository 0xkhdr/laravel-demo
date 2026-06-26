# Nothing.tech Website Design System

## Overview
Nothing.tech is the official website of Nothing Technology Ltd. The design system is built around a minimalist, retro-futuristic aesthetic inspired by 1980s IBM mainframe dot-matrix typography and a strict monochromatic palette with strategic red accents. The philosophy is "less is more" — every element serves a purpose.

---

## 1. Color Palette

### Primary Colors
| Token | Hex | RGB | Usage |
|-------|-----|-----|-------|
| `--color-pure-black` | `#000000` | `rgb(0, 0, 0)` | Primary dark backgrounds, hero sections, footer |
| `--color-pure-white` | `#FFFFFF` | `rgb(255, 255, 255)` | Primary light backgrounds, text on dark |
| `--color-nothing-red` | `#FF0000` | `rgb(255, 0, 0)` | Brand accent, CTAs, interactive states, toggles |

### Neutral / Grayscale
| Token | Hex | RGB | Usage |
|-------|-----|-----|-------|
| `--color-gray-50` | `#FAFAFA` | `rgb(250, 250, 250)` | Light page backgrounds |
| `--color-gray-100` | `#F5F5F5` | `rgb(245, 245, 245)` | Subtle section backgrounds |
| `--color-gray-200` | `#EEEEEE` | `rgb(238, 238, 238)` | Borders, dividers on light |
| `--color-gray-300` | `#E0E0E0` | `rgb(224, 224, 224)` | Disabled states, subtle borders |
| `--color-gray-400` | `#BDBDBD` | `rgb(189, 189, 189)` | Placeholder text |
| `--color-gray-500` | `#9E9E9E` | `rgb(158, 158, 158)` | Secondary text, captions |
| `--color-gray-600` | `#757575` | `rgb(117, 117, 117)` | Muted body text |
| `--color-gray-700` | `#616161` | `rgb(97, 97, 97)` | Body text on light backgrounds |
| `--color-gray-800` | `#424242` | `rgb(66, 66, 66)` | Strong text, headings on light |
| `--color-gray-900` | `#212121` | `rgb(33, 33, 33)` | Primary text on light backgrounds |

### Dark Theme Variants
| Token | Hex | RGB | Usage |
|-------|-----|-----|-------|
| `--color-dark-surface` | `#0A0A0A` | `rgb(10, 10, 10)` | Card backgrounds on dark |
| `--color-dark-elevated` | `#141414` | `rgb(20, 20, 20)` | Elevated surfaces, modals |
| `--color-dark-border` | `#2A2A2A` | `rgb(42, 42, 42)` | Borders on dark backgrounds |
| `--color-dark-text-primary` | `#FFFFFF` | `rgb(255, 255, 255)` | Primary text on dark |
| `--color-dark-text-secondary` | `#A0A0A0` | `rgb(160, 160, 160)` | Secondary text on dark |
| `--color-dark-text-muted` | `#666666` | `rgb(102, 102, 102)` | Muted text on dark |

### Semantic Colors
| Token | Value | Usage |
|-------|-------|-------|
| `--color-text-primary` | `var(--color-gray-900)` / `var(--color-dark-text-primary)` | Main body text |
| `--color-text-secondary` | `var(--color-gray-600)` / `var(--color-dark-text-secondary)` | Subheadings, descriptions |
| `--color-text-muted` | `var(--color-gray-500)` / `var(--color-dark-text-muted)` | Captions, metadata |
| `--color-background` | `var(--color-pure-white)` / `var(--color-pure-black)` | Page background |
| `--color-surface` | `var(--color-gray-50)` / `var(--color-dark-surface)` | Card/section backgrounds |
| `--color-border` | `var(--color-gray-200)` / `var(--color-dark-border)` | Dividers, borders |
| `--color-accent` | `var(--color-nothing-red)` | Brand accent, interactive highlights |
| `--color-accent-hover` | `#CC0000` | Accent hover state |
| `--color-accent-active` | `#990000` | Accent active/pressed state |

---

## 2. Typography

### Font Families
| Token | Font Stack | Usage |
|-------|-----------|-------|
| `--font-display` | `"NDot", "NType 82", "Courier New", monospace` | Hero headlines, large display text, brand moments |
| `--font-body` | `"NType 82", "Inter", "Helvetica Neue", Arial, sans-serif` | Body text, paragraphs, descriptions |
| `--font-mono` | `"NType 82 Mono", "SF Mono", "Fira Code", monospace` | Technical specs, data, code-like elements |
| `--font-lettera` | `"LL Lettera Mono", "Courier New", monospace` | Special editorial moments, quotes |

### Custom Fonts (Nothing Proprietary)
1. **NDot** — Dot-matrix inspired display font. Used for large headlines and brand statements. Pixelated/retro aesthetic.
2. **NType 82** — Primary sans-serif. Clean, geometric, slightly technical. Used for body and UI.
3. **NType 82 Mono** — Monospace variant of NType 82. Used for technical data, specs, and code-like UI elements.
4. **LL Lettera Mono** — Paired monospace font for editorial/web use. Slightly more refined than NDot.

> **Note:** NDot, NType 82, and NType 82 Mono are custom fonts created by Colophon Foundry for Nothing. For mockups, use "Courier New" or "Space Mono" as fallbacks for the dot-matrix aesthetic, and "Inter" or "Helvetica Neue" for the clean sans-serif feel.

### Type Scale
| Token | Size | Line Height | Letter Spacing | Weight | Usage |
|-------|------|-------------|----------------|--------|-------|
| `--text-hero` | `clamp(48px, 8vw, 120px)` | `0.95` | `-0.03em` | 400 | Hero headlines |
| `--text-h1` | `clamp(36px, 5vw, 72px)` | `1.0` | `-0.02em` | 400 | Page titles |
| `--text-h2` | `clamp(28px, 3.5vw, 48px)` | `1.1` | `-0.02em` | 400 | Section headings |
| `--text-h3` | `clamp(22px, 2.5vw, 32px)` | `1.2` | `-0.01em` | 400 | Subsection headings |
| `--text-h4` | `clamp(18px, 1.8vw, 24px)` | `1.3` | `-0.01em` | 500 | Card titles |
| `--text-h5` | `16px` | `1.4` | `0` | 500 | Labels, small headings |
| `--text-body` | `16px` | `1.6` | `0` | 400 | Paragraphs |
| `--text-body-large` | `18px` | `1.6` | `0` | 400 | Lead paragraphs |
| `--text-body-small` | `14px` | `1.5` | `0` | 400 | Secondary body |
| `--text-caption` | `12px` | `1.4` | `0.02em` | 400 | Captions, metadata |
| `--text-overline` | `11px` | `1.2` | `0.08em` | 500 | Uppercase labels |

### Typography Rules
- **Hero text** uses NDot with tight line-height (0.95) and negative letter-spacing
- **Body text** uses NType 82 with generous line-height (1.6) for readability
- **Uppercase** is used sparingly for overlines, buttons, and navigation
- **Font weight** is predominantly 400 (regular). 500 is used for emphasis. Bold (700) is rare.
- **Text on dark backgrounds** is always pure white or light gray
- **Text on light backgrounds** is near-black (#212121) or dark gray

---

## 3. Spacing System

### Base Unit
`--space-unit: 4px`

### Spacing Scale
| Token | Value | Usage |
|-------|-------|-------|
| `--space-1` | `4px` | Micro gaps, icon padding |
| `--space-2` | `8px` | Tight gaps, inline spacing |
| `--space-3` | `12px` | Small component padding |
| `--space-4` | `16px` | Standard gap, card padding |
| `--space-5` | `20px` | Medium gaps |
| `--space-6` | `24px` | Section internal padding |
| `--space-8` | `32px` | Card padding, section gaps |
| `--space-10` | `40px` | Large section gaps |
| `--space-12` | `48px` | Section vertical padding |
| `--space-16` | `64px` | Large section padding |
| `--space-20` | `80px` | Hero section padding |
| `--space-24` | `96px` | Major section breaks |
| `--space-32` | `128px` | Page-level spacing |

### Layout
| Token | Value | Usage |
|-------|-------|-------|
| `--page-max-width` | `1440px` | Maximum content width |
| `--page-padding` | `24px` / `clamp(16px, 4vw, 80px)` | Horizontal page padding |
| `--grid-columns` | `12` | Grid system columns |
| `--grid-gap` | `24px` | Grid column gap |
| `--section-padding-y` | `clamp(80px, 10vh, 160px)` | Vertical section padding |

---

## 4. Components

### Buttons

#### Primary Button
```
Background: var(--color-pure-black)
Text: var(--color-pure-white)
Font: var(--font-body), 14px, weight 500, uppercase
Letter-spacing: 0.05em
Padding: 16px 32px
Border-radius: 0px (sharp corners)
Border: none
Hover: Background shifts to var(--color-gray-800)
Active: Background shifts to var(--color-gray-900)
Transition: all 0.3s ease
```

#### Secondary Button (Outline)
```
Background: transparent
Text: var(--color-pure-black) / var(--color-pure-white)
Font: var(--font-body), 14px, weight 500, uppercase
Letter-spacing: 0.05em
Padding: 16px 32px
Border-radius: 0px
Border: 1px solid var(--color-pure-black) / var(--color-pure-white)
Hover: Background fills with border color, text inverts
```

#### Accent Button (Red)
```
Background: var(--color-nothing-red)
Text: var(--color-pure-white)
Font: var(--font-body), 14px, weight 500, uppercase
Padding: 16px 32px
Border-radius: 0px
Border: none
Hover: Background #CC0000
```

#### Text Link
```
Color: var(--color-pure-black) / var(--color-pure-white)
Font: var(--font-body), 14px, weight 400
Text-decoration: none
Underline: 1px solid, appears on hover
Underline offset: 4px
Transition: all 0.2s ease
```

### Cards

#### Product Card
```
Background: var(--color-pure-white) / var(--color-dark-surface)
Border-radius: 0px (sharp corners)
Border: 1px solid var(--color-gray-200) / var(--color-dark-border)
Padding: 0px (image bleeds to edge)
Overflow: hidden
Image: Full-width, aspect-ratio 4:3 or 1:1
Content padding: 24px
Title: var(--text-h4)
Description: var(--text-body-small), var(--color-text-secondary)
Hover: Subtle scale(1.02) on image, shadow appears
Transition: transform 0.4s ease, box-shadow 0.4s ease
```

#### Feature Card
```
Background: transparent
Border: none
Padding: var(--space-8)
Layout: Icon/Image top, text below
Icon: 48px, monochrome or red accent
Title: var(--text-h4)
Description: var(--text-body)
```

### Navigation

#### Header/Navbar
```
Position: fixed, top: 0
Background: transparent initially, blur backdrop on scroll
Height: 64px
Padding: 0 var(--page-padding)
Z-index: 100
Logo: Left-aligned, monochrome
Links: Center or right, uppercase, 12px, letter-spacing 0.08em
Color: var(--color-pure-white) on dark hero, switches to black on light sections
Transition: background 0.3s ease, color 0.3s ease
```

#### Mobile Menu
```
Full-screen overlay
Background: var(--color-pure-black)
Text: var(--color-pure-white)
Font: var(--font-display), large sizes
Links stacked vertically, generous spacing
Close button: Top right
```

### Forms / Inputs

#### Text Input
```
Background: transparent
Border: none none 1px none (bottom border only)
Border-color: var(--color-gray-300) / var(--color-dark-border)
Border-radius: 0px
Padding: 12px 0
Font: var(--font-body), 16px
Color: var(--color-text-primary)
Placeholder: var(--color-gray-400)
Focus: Border-color changes to var(--color-pure-black) / var(--color-pure-white)
```

### Toggles / Switches
```
Track: 48px x 24px, border-radius 12px
Background (off): var(--color-gray-300)
Background (on): var(--color-nothing-red)
Thumb: 20px circle, white
Transition: all 0.3s ease
```

---

## 5. Layout Patterns

### Hero Section
```
Height: 100vh (full viewport)
Background: var(--color-pure-black) or full-bleed image/video
Content: Centered or left-aligned
Text color: var(--color-pure-white)
Headline: var(--text-hero), NDot font
Subheadline: var(--text-body-large), max-width 600px
CTA: Primary or outline button, positioned below text
Scroll indicator: Subtle arrow or text at bottom
```

### Product Showcase Section
```
Background: var(--color-pure-white) or var(--color-pure-black)
Layout: 2-column grid (image + text) or full-width centered
Image: Large, high-quality product photography on solid background
Text: Left or center aligned
Padding: var(--section-padding-y) vertical
```

### Grid Sections
```
Grid: 2, 3, or 4 columns depending on content
Gap: var(--grid-gap)
Cards: Product cards or feature cards
Responsive: Collapses to 1 column on mobile
```

### Editorial / Story Section
```
Background: var(--color-pure-black)
Text: var(--color-pure-white)
Layout: Asymmetric, large imagery with overlapping text
Font: NDot for headlines, NType 82 for body
Generous whitespace between elements
```

### Footer
```
Background: var(--color-pure-black)
Text: var(--color-pure-white)
Layout: Multi-column grid
Links: var(--text-caption), uppercase, gray-500
Hover: White
Social icons: 24px, monochrome
Bottom bar: Copyright, legal links
Padding: var(--space-16) vertical
```

---

## 6. Effects & Visual Treatments

### Shadows
```
--shadow-sm: 0 1px 2px rgba(0,0,0,0.05)
--shadow-md: 0 4px 12px rgba(0,0,0,0.08)
--shadow-lg: 0 12px 40px rgba(0,0,0,0.12)
--shadow-dark: 0 4px 20px rgba(0,0,0,0.4)
```
> Shadows are subtle and rarely used. The design relies on contrast and whitespace rather than elevation.

### Backdrop Blur
```
--backdrop-blur: blur(12px) saturate(180%)
```
> Used for navigation bar background on scroll and modal overlays.

### Transitions
```
--transition-fast: 0.15s ease
--transition-base: 0.3s ease
--transition-slow: 0.5s ease
--transition-transform: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)
```

### Image Treatment
- Product images: Shot on solid white or black backgrounds
- No gradients, no drop shadows on products
- Clean, studio lighting
- Occasionally: Products shown in lifestyle/contextual settings with muted tones

### Dot Matrix / Pixel Effects
- NDot font creates a dot-matrix aesthetic for headlines
- Occasional pixelated or glitch-like transitions
- Glyph-inspired UI elements (referencing Nothing Phone's LED patterns)

---

## 7. Animation & Motion

### Principles
- Minimal, purposeful motion
- Smooth easing (cubic-bezier)
- No bouncy or playful animations
- Motion supports the content, never distracts

### Common Patterns

#### Fade In Up
```
Initial: opacity: 0, translateY(30px)
Final: opacity: 1, translateY(0)
Duration: 0.8s
Easing: cubic-bezier(0.25, 0.46, 0.45, 0.94)
Trigger: Scroll into view
```

#### Stagger Children
```
Delay between items: 0.1s - 0.15s
Used for: Grid items, list items, feature cards
```

#### Image Reveal
```
Initial: clip-path inset or scale with overflow hidden
Final: Full reveal
Duration: 1s - 1.2s
Easing: cubic-bezier(0.77, 0, 0.175, 1)
```

#### Hover Effects
```
Images: scale(1.03), duration 0.6s
Cards: Subtle shadow increase
Buttons: Background color shift, 0.3s
Links: Underline reveal
```

#### Page Transitions
```
Fade between pages
Duration: 0.4s
Black screen fade for dramatic effect on hero sections
```

### Scroll Behavior
- Smooth scrolling enabled globally
- Parallax: Subtle, used on hero images (0.5x speed)
- Pinning: Section titles may pin while content scrolls

---

## 8. Responsive Breakpoints

| Token | Width | Description |
|-------|-------|-------------|
| `--breakpoint-sm` | `640px` | Small tablets |
| `--breakpoint-md` | `768px` | Tablets |
| `--breakpoint-lg` | `1024px` | Small desktops |
| `--breakpoint-xl` | `1280px` | Desktops |
| `--breakpoint-2xl` | `1536px` | Large screens |

### Responsive Patterns
- **Mobile First** approach
- **Navigation**: Hamburger menu below 1024px
- **Hero text**: Scales down significantly on mobile (clamp used)
- **Grids**: 4-col → 2-col → 1-col
- **Section padding**: Reduces by ~40% on mobile
- **Images**: Full-width on mobile, constrained on desktop

---

## 9. Icons & Assets

### Icon Style
- Monochrome (black or white)
- Line icons, 1.5px stroke
- Minimal, geometric
- No filled icons (except social media)
- Size: 20px (UI), 24px (navigation), 48px (features)

### Logo Usage
- Nothing wordmark: Monochrome, clean
- Glyph pattern: Referenced as decorative elements
- Always maintain clear space around logo

---

## 10. Z-Index Scale

| Token | Value | Usage |
|-------|-------|-------|
| `--z-base` | `0` | Default content |
| `--z-dropdown` | `50` | Dropdown menus |
| `--z-sticky` | `100` | Sticky header |
| `--z-overlay` | `200` | Overlays, backdrops |
| `--z-modal` | `300` | Modals, dialogs |
| `--z-toast` | `400` | Notifications |
| `--z-max` | `999` | Critical overlays |

---

## 11. CSS Custom Properties (Full Reference)

```css
:root {
  /* === COLORS === */
  --color-pure-black: #000000;
  --color-pure-white: #FFFFFF;
  --color-nothing-red: #FF0000;
  --color-nothing-red-hover: #CC0000;
  --color-nothing-red-active: #990000;

  --color-gray-50: #FAFAFA;
  --color-gray-100: #F5F5F5;
  --color-gray-200: #EEEEEE;
  --color-gray-300: #E0E0E0;
  --color-gray-400: #BDBDBD;
  --color-gray-500: #9E9E9E;
  --color-gray-600: #757575;
  --color-gray-700: #616161;
  --color-gray-800: #424242;
  --color-gray-900: #212121;

  --color-dark-surface: #0A0A0A;
  --color-dark-elevated: #141414;
  --color-dark-border: #2A2A2A;
  --color-dark-text-primary: #FFFFFF;
  --color-dark-text-secondary: #A0A0A0;
  --color-dark-text-muted: #666666;

  --color-text-primary: var(--color-gray-900);
  --color-text-secondary: var(--color-gray-600);
  --color-text-muted: var(--color-gray-500);
  --color-background: var(--color-pure-white);
  --color-surface: var(--color-gray-50);
  --color-border: var(--color-gray-200);
  --color-accent: var(--color-nothing-red);

  /* === TYPOGRAPHY === */
  --font-display: "NDot", "NType 82", "Courier New", monospace;
  --font-body: "NType 82", "Inter", "Helvetica Neue", Arial, sans-serif;
  --font-mono: "NType 82 Mono", "SF Mono", "Fira Code", monospace;
  --font-lettera: "LL Lettera Mono", "Courier New", monospace;

  --text-hero: clamp(48px, 8vw, 120px);
  --text-h1: clamp(36px, 5vw, 72px);
  --text-h2: clamp(28px, 3.5vw, 48px);
  --text-h3: clamp(22px, 2.5vw, 32px);
  --text-h4: clamp(18px, 1.8vw, 24px);
  --text-h5: 16px;
  --text-body: 16px;
  --text-body-large: 18px;
  --text-body-small: 14px;
  --text-caption: 12px;
  --text-overline: 11px;

  /* === SPACING === */
  --space-unit: 4px;
  --space-1: 4px;
  --space-2: 8px;
  --space-3: 12px;
  --space-4: 16px;
  --space-5: 20px;
  --space-6: 24px;
  --space-8: 32px;
  --space-10: 40px;
  --space-12: 48px;
  --space-16: 64px;
  --space-20: 80px;
  --space-24: 96px;
  --space-32: 128px;

  /* === LAYOUT === */
  --page-max-width: 1440px;
  --page-padding: clamp(16px, 4vw, 80px);
  --grid-columns: 12;
  --grid-gap: 24px;
  --section-padding-y: clamp(80px, 10vh, 160px);

  /* === EFFECTS === */
  --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
  --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
  --shadow-lg: 0 12px 40px rgba(0,0,0,0.12);
  --shadow-dark: 0 4px 20px rgba(0,0,0,0.4);
  --backdrop-blur: blur(12px) saturate(180%);

  /* === TRANSITIONS === */
  --transition-fast: 0.15s ease;
  --transition-base: 0.3s ease;
  --transition-slow: 0.5s ease;
  --transition-transform: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);

  /* === Z-INDEX === */
  --z-base: 0;
  --z-dropdown: 50;
  --z-sticky: 100;
  --z-overlay: 200;
  --z-modal: 300;
  --z-toast: 400;
  --z-max: 999;
}

/* Dark Theme Override */
[data-theme="dark"] {
  --color-text-primary: var(--color-dark-text-primary);
  --color-text-secondary: var(--color-dark-text-secondary);
  --color-text-muted: var(--color-dark-text-muted);
  --color-background: var(--color-pure-black);
  --color-surface: var(--color-dark-surface);
  --color-border: var(--color-dark-border);
}
```

---

## 12. Design Principles Summary

1. **Monochrome First**: Black, white, and grays are the foundation. Red is used sparingly as an accent.
2. **Dot Matrix Aesthetic**: NDot font and pixel-inspired elements reference 1980s IBM mainframes.
3. **Zero Border Radius**: Sharp corners everywhere. No rounded buttons, cards, or inputs.
4. **Generous Whitespace**: Sections breathe. Padding is large and intentional.
5. **Minimal Shadows**: Elevation is communicated through contrast, not drop shadows.
6. **Uppercase for UI**: Navigation, buttons, and labels use uppercase with wide letter-spacing.
7. **Purposeful Motion**: Animations are smooth, subtle, and always serve the content.
8. **Product-Centric**: Clean product photography on solid backgrounds. No distractions.
9. **Transparency**: Literal (transparent materials in products) and metaphorical (honest, clear communication).
10. **Less is More**: Every element must justify its existence.

---

## 13. Mockup Checklist

When building a mockup of Nothing.tech:

- [ ] Use **NDot** (or Courier New fallback) for all large headlines
- [ ] Use **NType 82** (or Inter/Helvetica fallback) for body text
- [ ] Keep **border-radius at 0px** for all components
- [ ] Use **pure black (#000)** and **pure white (#FFF)** as primary backgrounds
- [ ] Add **red (#FF0000)** only for accents, CTAs, and active states
- [ ] Ensure **generous whitespace** — never crowd elements
- [ ] Use **uppercase + wide letter-spacing** for buttons and navigation
- [ ] Keep **shadows minimal or absent**
- [ ] Use **sharp, clean product images** on solid backgrounds
- [ ] Apply **subtle fade-in-up animations** on scroll
- [ ] Maintain **high contrast** for accessibility
- [ ] Use **1px borders** instead of shadows to separate sections

---

*Design System extracted from analysis of https://intl.nothing.tech/ and Nothing brand research.*
*Custom fonts (NDot, NType 82, NType 82 Mono) are proprietary to Nothing Technology Ltd.*
