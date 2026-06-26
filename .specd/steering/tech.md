# Tech — Stack, dependencies, runtime

Laravel 13 REST API built with PHP 8.3+, Composer package manager. See: composer.json, phpunit.xml

## Backend

- **Framework**: Laravel 13 (PHP 8.3+)
- **Database**: SQLite (default) with Laravel migrations
- **ORM**: Eloquent
- **Testing**: PHPUnit with Feature and Unit test suites
  - Test database: SQLite in-memory (`:memory:`)
  - Config: phpunit.xml with APP_ENV=testing

## Build & Package Management

- **PHP**: Composer for dependencies
- **Node**: NPM for frontend build tools (Laravel Mix/Vite)
- **Scripts**: Defined in composer.json

## Running the App

- **Dev server**: `php artisan serve` (localhost:8000)
- **Testing**: `php artisan test` or `vendor/bin/phpunit`
- **Migrations**: `php artisan migrate`
- **Database reset**: `php artisan migrate:refresh`

## Code Standards

- PHP PSR-12 style (enforced via CI)
- Laravel conventions (PascalCase models, kebab-case routes)
- No type errors or strict mode violations

## Environment

- **.env**: Local config (git-ignored, template at .env.example)
- **config/**: Cached in production
- **Key services**: Database, Cache, Queue (sync by default in tests)

---

# Design System — Nothing.tech Inspired Minimalist Aesthetic

Unified UI/UX across all project pages. Retro-futuristic, monochromatic-first with strategic red accents. Philosophy: "less is more" — every element serves a purpose.

## Colors

### Palette
- **Primary**: Pure black (#000000) and pure white (#FFFFFF)
- **Accent**: Nothing red (#FF0000) for CTAs, toggles, interactive states
- **Grayscale**: Gray-50 (#FAFAFA) through Gray-900 (#212121) for neutrals
- **Dark theme**: Dark-surface (#0A0A0A), dark-elevated (#141414), dark-border (#2A2A2A)

### Semantic
- Text primary: Gray-900 / Dark-text-primary
- Text secondary: Gray-600 / Dark-text-secondary
- Text muted: Gray-500 / Dark-text-muted
- Backgrounds: Pure white/black with gray-50/dark-surface for sections
- Borders: Gray-200 / Dark-border (1px, never drop shadows)

## Typography

### Font Stacks (with fallbacks)
- **Display** (headlines): NDot → NType 82 → Courier New (dot-matrix aesthetic)
- **Body**: NType 82 → Inter → Helvetica Neue (clean, geometric)
- **Mono** (data, specs): NType 82 Mono → SF Mono → Fira Code
- **Editorial**: LL Lettera Mono → Courier New (special moments)

### Type Scale
- Hero: `clamp(48px, 8vw, 120px)` line-height 0.95, letter-spacing -0.03em
- H1: `clamp(36px, 5vw, 72px)` line-height 1.0
- H2: `clamp(28px, 3.5vw, 48px)` line-height 1.1
- H3: `clamp(22px, 2.5vw, 32px)` line-height 1.2
- H4 (card titles): `clamp(18px, 1.8vw, 24px)` line-height 1.3, weight 500
- Body: 16px line-height 1.6, weight 400
- Caption: 12px line-height 1.4

## Spacing (Base unit: 4px)
- Scale: 4, 8, 12, 16, 20, 24, 32, 40, 48, 64, 80, 96, 128px
- Max content width: 1440px
- Page padding: `clamp(16px, 4vw, 80px)` horizontal
- Section padding: `clamp(80px, 10vh, 160px)` vertical
- Grid: 12 columns, 24px gap

## Components

### Buttons
- **Primary**: Black bg, white text, 16px h-padding 32px, sharp corners (0px radius), weight 500, uppercase, letter-spacing 0.05em
  - Hover: Gray-800; Active: Gray-900; Transition: 0.3s ease
- **Secondary (Outline)**: Transparent bg, black/white border 1px, same padding/text, inverts on hover
- **Accent (Red)**: Red bg, white text, hover #CC0000
- **Links**: Underline on hover (1px solid, 4px offset), no text decoration by default

### Cards
- **Product Card**: Sharp corners, 1px border, 24px content padding, image bleeds edge, aspect 4:3 or 1:1
  - Hover: `scale(1.02)` on image, subtle shadow; Transition: 0.4s ease
- **Feature Card**: Transparent, no border, 48px icon/image, stacked layout

### Navigation
- **Header**: Fixed top, 64px height, transparent → blur on scroll
  - Logo left, links centered/right, uppercase 12px letter-spacing 0.08em
  - Color: White on dark hero, switches to black on light sections (0.3s transition)
- **Mobile Menu** (below 1024px): Full-screen overlay, black bg, white text, stacked links, large display font

### Forms / Inputs
- **Text Input**: Transparent bg, bottom border only 1px, no radius
  - Border gray-300 default, black on focus; 12px top/bottom padding
  - Font body 16px; placeholder gray-400

### Toggles
- Track: 48x24px, border-radius 12px, bg gray-300 (off) / red (on)
- Thumb: 20px circle white, transition 0.3s ease

## Layout Patterns

### Hero Section
- Full viewport (100vh), black bg or full-bleed image/video
- Centered or left-aligned content, white text
- Headline: hero scale, NDot font; Subheadline: body-large, max-width 600px
- CTA button, subtle scroll indicator

### Product Showcase
- 2-column grid (image + text) or full-width centered
- Large, clean product photography on solid bg
- Vertical padding: section-padding-y

### Grid Sections
- 2/3/4 columns by content, 24px gap
- Collapses to 1 column on mobile (responsive first)

### Editorial Section
- Black bg, white text, asymmetric layout with overlapping text + imagery
- Generous whitespace, NDot headlines, NType 82 body

### Footer
- Black bg, white text, multi-column grid
- Links: caption size uppercase gray-500, hover white; social icons 24px monochrome
- Padding: 64px vertical

## Effects & Motion

### Shadows (subtle, rarely used)
- Small: `0 1px 2px rgba(0,0,0,0.05)`
- Medium: `0 4px 12px rgba(0,0,0,0.08)`
- Large: `0 12px 40px rgba(0,0,0,0.12)`
- Dark: `0 4px 20px rgba(0,0,0,0.4)`

### Transitions
- Fast: 0.15s ease
- Base: 0.3s ease
- Slow: 0.5s ease
- Transform: 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)

### Animations (minimal, purposeful)
- **Fade in up**: opacity 0→1, translateY 30px→0, 0.8s cubic-bezier
- **Stagger children**: 0.1-0.15s delay between items
- **Image reveal**: clip-path or scale with overflow hidden, 1-1.2s
- **Hover effects**: Images scale(1.03) 0.6s; buttons color shift 0.3s; links underline reveal

## Responsive Breakpoints
- sm: 640px (small tablets)
- md: 768px (tablets)
- lg: 1024px (small desktops, hamburger menu breaks here)
- xl: 1280px (desktops)
- 2xl: 1536px (large screens)

## Design Principles
1. **Monochrome first** — black/white/gray foundation, red sparingly for accent
2. **Dot-matrix aesthetic** — NDot font + pixel-inspired elements reference 1980s IBM
3. **Sharp corners everywhere** — 0px border-radius (no rounded buttons, cards, inputs)
4. **Generous whitespace** — sections breathe, padding intentional and large
5. **Minimal shadows** — elevation via contrast, not drop shadows
6. **Uppercase UI** — nav, buttons, labels with wide letter-spacing
7. **Purposeful motion** — smooth, subtle, always serves content
8. **Product-centric** — clean photography on solid backgrounds
9. **Transparency** — honest, clear communication
10. **Less is more** — every element must justify its existence