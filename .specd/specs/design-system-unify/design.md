# Design System Unification — Design

## Overview

The design unification initiative applies the Nothing.tech minimalist aesthetic (monochromatic + red accents, sharp corners, generous whitespace, minimal shadows) to all project pages via:

1. **Complete CSS Design System** (`resources/css/design-system.css`) — all color, typography, spacing, component, layout, effect, animation tokens as CSS variables
2. **Semantic HTML in Blade templates** — proper tag selection, class naming, accessibility structure
3. **Responsive mobile-first layout** — clamp() sizing, breakpoint-based reflow, no horizontal scroll
4. **Dark theme support** — [data-theme="dark"] overrides for all colors
5. **Consistent component library** — buttons (primary/secondary/accent), cards (product/feature), forms, navigation, links
6. **Accessibility baseline** — WCAG AA contrast, keyboard navigation, focus states, semantic HTML

## Architecture

### Layer 1: CSS Tokens (Design System Foundation)
- File: `resources/css/design-system.css`
- Scope: Global CSS variables, base styles, component definitions
- Tokens:
  - Colors (primary, grayscale, dark-theme)
  - Typography (font stacks, type scales with clamp())
  - Spacing (4px unit, scale 1–32)
  - Layout (max-width, padding, grid)
  - Effects (shadows, blur, transitions, z-index)
  - Animations (fade-in-up, stagger, image-reveal, hover effects)

### Layer 2: Component Styles (Reusable Patterns)
- Scope: CSS class definitions in design-system.css
- Components:
  - Buttons: .btn, .btn--primary, .btn--secondary, .btn--accent
  - Cards: .card, .card--product, .card--feature
  - Forms: .form-input, .form-label, .form-error, .toggle
  - Navigation: .nav-header, .nav-link, .nav-mobile-overlay
  - Layout: .container, .grid, .section, .hero
  - Typography: .text-hero, .text-h1–.text-h5, .text-body, .text-caption, .text-overline

### Layer 3: Blade Template Structure (Semantic HTML)
- Scope: `resources/views/` — auth, profile, landing, articles, packages, projects
- Structure:
  - Proper heading hierarchy (h1 → h2 → h3)
  - Semantic buttons, links, labels
  - Form inputs with aria-describedby, aria-required
  - Images with alt text
  - Navigation markup with <nav>, <a> elements
  - Consistent class naming on elements

### Layer 4: Page-Specific Overrides (Optional)
- Scope: `resources/css/pages/` (if needed) — page-specific styling that extends base design system
- Examples: article-detail typography adjustments, profile-page card layout, landing-page hero background
- Constraint: Must use design system tokens; no new colors, spacing, or animations

### Layer 5: Dark Theme Override
- Scope: `[data-theme="dark"]` selector in design-system.css
- Behavior: All semantic color tokens automatically override to dark variants
- Implementation: CSS variable override, no conditional class logic

## Components and Interfaces

### Design System Components

**Buttons (3 variants)**
```
Primary: .btn--primary
  Background: var(--color-pure-black)
  Text: var(--color-pure-white)
  Hover: var(--color-gray-800)
  Padding: 16px 32px
  Border-radius: 0px
  Transition: all 0.3s ease

Secondary: .btn--secondary
  Background: transparent
  Border: 1px solid var(--color-pure-black) / var(--color-pure-white)
  Text: var(--color-pure-black) / var(--color-pure-white)
  Hover: Inverts background and text
  Padding: 16px 32px
  Transition: all 0.3s ease

Accent: .btn--accent
  Background: var(--color-nothing-red)
  Text: var(--color-pure-white)
  Hover: #CC0000
  Padding: 16px 32px
```

**Cards (2 variants)**
```
Product: .card--product
  Background: var(--color-pure-white) / var(--color-dark-surface)
  Border: 1px solid var(--color-gray-200) / var(--color-dark-border)
  Border-radius: 0px
  Padding: 0px (image), 24px (content)
  Image: Full-width, aspect 4:3 or 1:1
  Hover: scale(1.02) on image, shadow appears
  Transition: 0.4s ease

Feature: .card--feature
  Background: transparent
  Border: none
  Padding: 8px
  Layout: Icon/image top, text below
  Icon: 48px, monochrome or red
```

**Forms**
```
Input: .form-input
  Background: transparent
  Border: none bottom 1px solid
  Border-color: var(--color-gray-300) / var(--color-dark-border)
  Padding: 12px 0
  Focus: Border-color var(--color-pure-black) / var(--color-pure-white)
  Transition: 0.3s ease

Label: .form-label
  Font-size: var(--text-h5)
  Font-weight: 500
  Letter-spacing: 0.02em
  Color: var(--color-gray-700) / var(--color-dark-text-secondary)
  Margin-bottom: var(--space-3)

Error: .form-error
  Border-color: var(--color-nothing-red)
  Color: var(--color-nothing-red)
  Font-size: var(--text-caption)
  Margin-top: var(--space-2)

Toggle: .toggle
  Track: 48px × 24px, border-radius 12px
  Background: var(--color-gray-300) / var(--color-nothing-red)
  Thumb: 20px white circle
  Transition: 0.3s ease
```

**Navigation**
```
Header: .nav-header
  Position: fixed
  Top: 0
  Height: 64px
  Z-index: 100
  Background: transparent → blur(12px) on scroll
  Transition: 0.3s ease

Link: .nav-link
  Font-size: 12px
  Letter-spacing: 0.08em
  Weight: 500
  Uppercase
  Color: var(--color-pure-white) / var(--color-pure-black)
  Transition: 0.3s ease

Mobile (below 1024px):
  Hamburger icon: 3-line icon, clickable
  Overlay: Full-screen, black bg, white text, z-index 300
  Links: Stacked, large display font
  Close: Top-right button
```

**Typography Classes**
```
.text-hero: clamp(48px, 8vw, 120px), line-height 0.95, letter-spacing -0.03em, font-display
.text-h1: clamp(36px, 5vw, 72px), line-height 1.0, font-display
.text-h2: clamp(28px, 3.5vw, 48px), line-height 1.1, font-display
.text-h3: clamp(22px, 2.5vw, 32px), line-height 1.2, font-body
.text-h4: clamp(18px, 1.8vw, 24px), line-height 1.3, weight 500, font-body
.text-h5: 16px, line-height 1.4, weight 500, font-body
.text-body: 16px, line-height 1.6, weight 400, font-body
.text-body-large: 18px, line-height 1.6, font-body
.text-body-small: 14px, line-height 1.5, font-body
.text-caption: 12px, line-height 1.4, letter-spacing 0.02em, font-body
.text-overline: 11px, line-height 1.2, letter-spacing 0.08em, weight 500, uppercase, font-body
```

### Page Layout Components

**Hero Section**
```
Height: 100vh
Background: var(--color-pure-black) or full-bleed image
Text color: var(--color-pure-white)
Headline: .text-hero, font-display
Subheadline: .text-body-large, max-width 600px
CTA: Primary or secondary button
Scroll indicator: Subtle arrow or "Scroll" text, opacity 0.6
Padding: clamp(80px, 10vh, 160px) vertical
```

**Grid Section**
```
Display: Grid, 12 columns, 24px gap
Cards: Product or feature cards, consistent spacing
Responsive:
  mobile (<640px): 1 column
  tablet (640–1024px): 2 columns
  desktop (1024px+): 3–4 columns
Padding: var(--section-padding-y) vertical, page-padding horizontal
```

**Footer**
```
Background: var(--color-pure-black)
Text: var(--color-pure-white)
Layout: Multi-column grid (4–5 columns on desktop, 1–2 on mobile)
Links: .text-caption, uppercase, gray-500, hover white, transition 0.3s ease
Social icons: 24px, monochrome, hover color change
Padding: var(--space-16) vertical, page-padding horizontal
```

## Data Models

Not applicable — design system is purely CSS/HTML/structure. No data models or backend logic changes.

## Error Handling

Design system CSS errors:
1. **Missing CSS variables** — If a color/spacing token is undefined, cascade to fallback (e.g., gray-700 if gray-800 missing)
2. **Invalid clamp() sizing** — Fallback to fixed pixel sizes (e.g., 16px if clamp() fails)
3. **Unsupported browsers** — CSS variables not supported in IE11; provide fallback hex colors (optional, not required for modern stack)
4. **Missing Blade assets** — If images not found, use alt text and gray placeholder background

HTML/Accessibility errors:
1. **Missing form labels** — Warn in CI; labels required for accessibility
2. **Missing alt text** — Warn in CI; alt text required for all images
3. **Improper heading hierarchy** — Warn in CI; h1 → h2 → h3 order enforced
4. **Inaccessible buttons** — Warn in CI; proper semantic <button> or <a> required, not <div>

No user-facing errors; design system is declarative. Runtime errors caught via CSS validation and accessibility audit.

## Verification Strategy

**Phase 1: Design System CSS (Automated + Manual)**
- Validate CSS syntax: `npm run lint:css` (if available)
- Check all color tokens defined: grep for --color-* in design-system.css
- Check all typography tokens defined: grep for --text-*, --font-*
- Check all spacing tokens defined: grep for --space-*
- Manual review: Colors apply correctly on light and dark themes

**Phase 2: Component Library (Manual)**
- Buttons: Test primary, secondary, accent variants on light and dark backgrounds
- Cards: Test product and feature card styling, hover effects, image aspect ratios
- Forms: Test input focus, error/success states, label positioning, placeholder text
- Navigation: Test header sticky behavior, blur on scroll, color transitions, mobile hamburger menu
- Links: Test underline on hover, focus state

**Phase 3: Page Styling (Manual Browser Testing)**
- Auth pages: login, register, reset-password, forgot-password, verify-email, change-password
  - Check form styling, button alignment, error/success messages, centering
- Profile pages: show, change-password
  - Check header, card layout, button styling, spacing
- Landing page: hero section, featured grid, footer
  - Check hero sizing, grid responsiveness, footer layout
- Article pages: list (grid), detail (article header + content + nav)
  - Check card sizing, article typography, sidebar/footer nav
- Package pages: directory (grid), detail
  - Check package card styling, feature showcase
- Project pages: showcase grid
  - Check project card styling, grid responsiveness

**Phase 4: Responsive Design (Manual + DevTools)**
- Test on mobile (375px–640px): no horizontal scroll, hamburger menu, full-width images, 44px+ button heights
- Test on tablet (640px–1024px): 2-column grids, hamburger menu, readable text
- Test on desktop (1024px+): 3–4-column grids, desktop nav, constrained content width 1440px
- Test on large screens (1536px+): layout maintained, no excessive whitespace

**Phase 5: Dark Theme**
- Toggle theme to dark mode
- Verify all colors adapt: text colors, backgrounds, borders, button states
- Check for hardcoded colors (should find none)
- Test on all pages

**Phase 6: Accessibility (Manual + Tools)**
- Keyboard navigation: Tab through all pages, verify focus visible on all interactive elements
- Heading hierarchy: h1 → h2 → h3, no skipped levels
- Alt text: All images have descriptive alt text
- Form labels: All inputs have <label> with for attribute, linked to input id
- Color contrast: Check WCAG AA ratios (4.5:1 normal, 3:1 large text) via WebAIM or similar tool
- Semantic HTML: Use HTML validator to check for proper tag selection

**Phase 7: Cross-Browser Testing**
- Chrome (latest): All pages render correctly
- Firefox (latest): All pages render correctly
- Safari (latest): All pages render correctly
- Edge (latest): All pages render correctly

**Verification Command:**
```bash
# CSS validation
npm run lint:css (or equivalent)

# Accessibility audit
npx axe-core (or similar tool)

# Manual testing checklist (spreadsheet or task list)
1. ✓ Design system CSS complete
2. ✓ All colors, typography, spacing tokens defined
3. ✓ Component library styled
4. ✓ All pages styled (auth, profile, landing, articles, packages, projects)
5. ✓ Responsive on mobile/tablet/desktop
6. ✓ Dark theme working
7. ✓ Accessibility baseline (WCAG AA, keyboard nav, semantic HTML)
8. ✓ Cross-browser tested
```

## Risks and Open Questions

**Risks:**

1. **Browser compatibility** — CSS variables and clamp() not supported in older browsers (IE11). Mitigation: Provide fallback hex colors; require modern browser support (Chrome, Firefox, Safari, Edge latest 2 versions).

2. **Design debt** — Existing pages may have custom CSS that conflicts with new design system. Mitigation: Audit and clean up old CSS before applying new system; document exceptions in comments.

3. **Performance** — Large CSS file with many variables. Mitigation: Use CSS minification; measure file size (target <50KB).

4. **Font loading** — Custom fonts (NDot, NType 82, etc.) may slow page load. Mitigation: Use web-safe fallbacks (Courier New, Inter, Helvetica); lazy-load custom fonts if available; measure LCP (Largest Contentful Paint).

5. **Dark theme complexity** — Overriding all colors via [data-theme="dark"] may increase CSS file size. Mitigation: Use CSS variables to minimize duplication; verify no performance impact on color transition.

6. **Scope creep** — Additional pages (e.g., admin dashboard, API docs) not included in this spec. Mitigation: Document design system for future developers to extend; consider second phase for additional pages.

**Open Questions:**

1. **Tailwind CSS vs Custom CSS?** — Current design uses custom CSS. If moving to Tailwind, would require config file setup and class refactoring. Decision: Maintain custom CSS for full control; optional Tailwind migration in future.

2. **Font licensing** — Are NDot, NType 82, LL Lettera Mono fonts available/licensed for this project? If not, fallback to web-safe fonts sufficient? Assumption: Using fallback fonts (Courier New, Inter, Helvetica Neue); custom fonts optional enhancement.

3. **Animations performance** — Do fade-in-up and image-reveal animations impact performance on mobile? Mitigation: Test on low-end devices; disable animations via prefers-reduced-motion if needed.

4. **Dark mode default** — Should system default to light or respect user's system preference (prefers-color-scheme)? Decision: Respect system preference; fallback to light mode.

5. **Form validation library** — Should use Laravel validation + Blade errors, or separate JavaScript? Decision: Use Laravel Blade validation; optional JavaScript enhancement for real-time validation.

6. **Navigation structure** — Should mobile nav close on link click or stay open? Decision: Close on link click for better UX; optional close button for user control.

7. **Image optimization** — Should images be art-directed per breakpoint (different crops on mobile), or use responsive sizing (srcset)? Decision: Use responsive sizing (srcset) for initial implementation; optional art direction in future.

8. **Footer presence** — Should footer appear on all pages, or only landing/public pages? Decision: Footer on landing and content pages; optional on auth pages (simplicity).

