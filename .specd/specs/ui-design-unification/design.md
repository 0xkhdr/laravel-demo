# Design — Unify UI with Design System

## Overview
Extract all design system tokens (colors, typography, spacing, effects, components) from `nothing-tech-design-system.md` into a reusable CSS custom properties file (`resources/css/design-system.css`). This file becomes the single source of truth, included in the main layout (`app.blade.php`). All Blade views (auth pages, profile pages, welcome) import this file and adopt the component styles (buttons, forms, cards, layout patterns) defined in the design system. This approach ensures consistency, reduces duplication, and makes future brand updates centralized.

Why: Landing page already implements the design system successfully. Rather than re-implementing per-view, we centralize tokens and reuse them across all pages. Leverage CSS custom properties for theming (dark mode support via `[data-theme="dark"]`). Blade views reference component classes like `.btn-primary`, `.input-base`, `.card`, etc., defined in CSS classes that use the tokens.

## Architecture
```
resources/css/
  ├─ design-system.css       [CSS custom properties + component classes]
  └─ (linked in app.blade.php)

resources/views/
  ├─ app.blade.php            [Main layout, includes design-system.css]
  ├─ landing.blade.php        [Template reference for design patterns]
  ├─ welcome.blade.php        [Update to match design system]
  ├─ auth/
  │  ├─ login.blade.php
  │  ├─ register.blade.php
  │  ├─ forgot-password.blade.php
  │  ├─ reset-password.blade.php
  │  └─ verify-email.blade.php
  └─ profile/
     ├─ show.blade.php
     └─ change-password.blade.php

nothing-tech-design-system.md [Source of truth for tokens and patterns]
```

Responsibility: design-system.css owns all tokens and component base styles. Blade views inherit these styles via class names. No view-specific CSS; all styling is token-driven and reusable.

## Components and interfaces
**CSS Classes (in design-system.css):**
- `.btn-primary` — Black background, white text, uppercase, 16px 32px padding, 0px border-radius
- `.btn-secondary` — Transparent, 1px solid border, uppercase
- `.btn-accent` — Red background, white text, uppercase
- `.input-base` — Bottom border only, transparent background, 1px solid var(--color-gray-300)
- `.card` — 1px border, padding 24px, 0px border-radius
- `.hero` — 100vh height, centered content, black background
- `.section` — Vertical padding var(--section-padding-y), max-width 1440px

Blade usage: `<button class="btn-primary">Sign In</button>`, `<input type="email" class="input-base">`

Font stack: --font-display (NDot, fallback Courier), --font-body (NType 82, fallback Inter), --font-mono (NType 82 Mono, fallback SF Mono)

## Data models
No database changes. All styling is CSS-driven. Blade views remain unchanged in structure; only class names and CSS classes are updated.

## Error handling
Missing fonts: @font-face includes fallback stack. If custom fonts unavailable, system fonts render correctly (Courier, Inter, SF Mono). Ensure fallbacks are web-safe.

## Verification strategy
1. **Unit**: CSS linting (if stricter linter used), validate custom properties syntax
2. **Integration**: Each Blade view renders without errors, applies correct classes
3. **System**: Visual inspection of each page (login, register, profile, welcome) matches landing page design (colors, spacing, typography, sharp corners)
4. **Requirements traceability**: R1 via auth page renders → R2 via profile renders → R3 via design-system.css exists → R4 via welcome updated

## Risks and open questions
- **Font availability**: Nothing proprietary fonts (NDot, NType 82) may not be available. Fallbacks to Courier/Inter must be acceptable for MVP.
- **Dark mode**: Design system includes dark theme. Do we need to implement theme toggle, or is light-only sufficient for MVP?
- **Component reusability**: Should we create Blade components (Button.blade.php, Input.blade.php) for DRY, or use class-based approach? Defer to execution; class-based is simpler for now.
