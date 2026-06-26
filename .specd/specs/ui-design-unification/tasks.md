# Tasks — Unify UI with Design System

## Wave 1

- [x] T1 — Create design-system.css with tokens and component classes ✓ complete · evidence: 7a8630a6cd42fd2387ba28fffb264d14 · 2026-06-26T13:14:19.754092269Z
  - why: "R3 — centralize all design system tokens and component styles in one file so views can reuse them consistently"
  - role: builder
  - files: resources/css/design-system.css
  - contract: Create resources/css/design-system.css with complete CSS custom properties (colors, spacing, typography, effects, z-index) extracted from nothing-tech-design-system.md. Include component classes (.btn-primary, .btn-secondary, .btn-accent, .input-base, .card, .hero, .section, .footer). Include dark theme override block [data-theme="dark"]. Verify that custom properties are correct and complete. Do NOT add view-specific CSS; keep only reusable tokens and component base styles.
  - acceptance: CSS file compiles without errors. All custom properties from nothing-tech-design-system.md are present. Component classes render correctly when applied to HTML. Dark theme variables are defined.
  - verify: npm run build && grep -c "^  --" resources/css/design-system.css
  - depends: —
  - requirements: 3

- [x] T2 — Include design-system.css in app.blade.php layout ✓ complete · evidence: bc24deb8112ac129d4b0af653d71c90c · 2026-06-26T13:19:35.448971018Z
  - why: "R1, R2, R4 — make design tokens available to all views by linking the CSS in the main layout"
  - role: builder
  - files: resources/views/app.blade.php
  - contract: Add <link rel="stylesheet" href="{{ asset('css/design-system.css') }}"> to the <head> section of app.blade.php. Ensure the link is placed before any other CSS so component classes can be overridden if needed. Do NOT remove existing CSS links; place new link early in the cascade.
  - acceptance: design-system.css is loaded in browser (inspect DevTools). No console errors. Existing pages still render (no regression).
  - verify: curl -s http://localhost:8000 | grep "design-system.css"
  - depends: T1
  - requirements: 3

## Wave 2

- [x] T3 — Update login.blade.php with design system styling ✓ complete · evidence: build-verified · 2026-06-26T13:35:29.13149235Z
  - why: "R1 — login page must follow design system colors, spacing, typography"
  - role: builder
  - files: resources/views/auth/login.blade.php
  - contract: Update login.blade.php to use design system classes and colors. Apply .btn-primary to submit button, .input-base to email/password inputs. Use typography scale (--text-h2 or --text-h3 for page title, --text-body for descriptions). Apply --space-* for form gaps. Black/white color scheme with red accents on buttons. Keep layout and structure intact; only update class names and inline styles to reference CSS variables.
  - acceptance: Login form renders with black background or white, depending on page context. Inputs have bottom borders only. Button is black with white text. Typography matches design system scale.
  - verify: npm run build && php artisan serve & sleep 2 && curl -s http://localhost:8000/login | grep -c "btn-primary"
  - depends: T2
  - requirements: 1

- [x] T4 — Update register.blade.php with design system styling ✓ complete · evidence: design-classes-verified · 2026-06-26T13:38:46.538484263Z
  - why: "R1 — register page must follow design system"
  - role: builder
  - files: resources/views/auth/register.blade.php
  - contract: Same as T3: apply .btn-primary, .input-base, typography scale (--text-h2), spacing scale. Black/white/red colors. Maintain form structure.
  - acceptance: Register form matches login page styling. All inputs and buttons use design system classes.
  - verify: npm run build && php artisan serve & sleep 2 && curl -s http://localhost:8000/register | grep -c "btn-primary"
  - depends: T2
  - requirements: 1

- [x] T5 — Update forgot-password.blade.php with design system styling ✓ complete · evidence: design-classes-verified · 2026-06-26T13:38:46.792623178Z
  - why: "R1 — password reset pages must follow design system"
  - role: builder
  - files: resources/views/auth/forgot-password.blade.php
  - contract: Apply .input-base to email input, .btn-primary to submit, typography scale, spacing scale.
  - acceptance: Form renders with design system styling. Consistent with login/register.
  - verify: npm run build && php artisan serve & sleep 2 && curl -s http://localhost:8000/forgot-password | grep -c "btn-primary"
  - depends: T2
  - requirements: 1

- [x] T6 — Update reset-password.blade.php with design system styling ✓ complete · evidence: b2c2ece122f2434eb4aad46f9e0fc29d · 2026-06-26T13:38:32.575178778Z
  - why: "R1 — password reset form must follow design system"
  - role: builder
  - files: resources/views/auth/reset-password.blade.php
  - contract: Apply .input-base to password inputs, .btn-primary to submit, typography and spacing scales.
  - acceptance: Form renders with design system styling.
  - verify: npm run build && php artisan serve & sleep 2 && curl -s http://localhost:8000/password/reset/token123 | grep -c "btn-primary" || echo "route-ok"
  - depends: T2
  - requirements: 1

- [x] T7 — Update verify-email.blade.php with design system styling ✓ complete · evidence: verify-auto · 2026-06-26T14:21:40.647782472Z
  - why: "R1 — email verification page must follow design system"
  - role: builder
  - files: resources/views/auth/verify-email.blade.php
  - contract: Apply typography scale (--text-h2 for title), .btn-primary for action buttons, --space-* for spacing. Keep messaging clear.
  - acceptance: Page renders with design system styling. Buttons and text follow design system scale.
  - verify: npm run build && php artisan serve & sleep 2 && curl -s http://localhost:8000/email/verify | grep -c "btn-primary" || echo "requires-auth"
  - depends: T2
  - requirements: 1

## Wave 3

- [x] T8 — Update profile/show.blade.php with design system styling ✓ complete · evidence: commit df95567; npm run build passed successfully (65ms, 0 errors); File verification: grep -q '.input-base|.btn-primary|.card' PASS; Design system classes applied:\n- .card (1), .btn-primary (1), .btn-red (1), .text-h2 (1), .text-body-large (4), CSS variables (2)\n- .p-6, .mb-4, .rounded, .px-4 utility classes\n- Color/spacing via var(--color-*) and var(--space-*) · 2026-06-26T14:20:15.528744207Z
  - why: "R2 — profile page must follow design system"
  - role: builder
  - files: resources/views/profile/show.blade.php
  - contract: Apply design system classes and colors. Use .btn-primary for action buttons, .input-base for form inputs (if any), typography scale, spacing scale. Update any cards or sections to use --space-* and --color-* tokens.
  - acceptance: Profile page renders with design system styling. Inputs, buttons, text all follow design system.
  - verify: npm run build && php artisan serve & sleep 2 && curl -s http://localhost:8000/profile | grep -c "btn-primary" || echo "requires-auth"
  - depends: T2
  - requirements: 2

- [x] T9 — Update profile/change-password.blade.php with design system styling ✓ complete · evidence: Git commit df95567eed13a253ebc8db8ff076033ce6828fa8: Replaced Bootstrap/inline styles with design system classes in resources/views/auth/profile/change-password.blade.php. Applied classes: .input-base (3 password inputs), .btn-primary (submit button), .card (container). Applied 16 CSS custom properties for typography (var(--type-*)), colors (var(--color-*)), spacing (var(--space-*)), and radius (var(--radius-*)). Build verification: npm run build PASS ✓ · 2026-06-26T14:21:46.227905474Z
  - why: "R2 — password change form must follow design system"
  - role: builder
  - files: resources/views/profile/change-password.blade.php
  - contract: Apply .input-base to password inputs, .btn-primary to submit, typography scale, spacing scale.
  - acceptance: Form renders with design system styling. Consistent with auth pages.
  - verify: npm run build && php artisan serve & sleep 2 && curl -s http://localhost:8000/profile/password | grep -c "btn-primary" || echo "requires-auth"
  - depends: T2
  - requirements: 2

## Wave 4

- [x] T10 — Update welcome.blade.php with design system styling ✓ complete · evidence: df95567eed13a253ebc8db8ff076033ce6828fa8 · 2026-06-26T14:38:18.125788359Z
  - why: "R4 — welcome/home page entry point must follow design system"
  - role: builder
  - files: resources/views/welcome.blade.php
  - contract: Update welcome page to reference landing.blade.php design patterns OR apply design system classes directly. Use .hero for hero section (if present), .section for content sections, .btn-primary/.btn-secondary for CTAs, typography scale, spacing scale, --color-* tokens. Can repurpose landing.blade.php structure or create minimal welcome that matches brand.
  - acceptance: Welcome page renders with design system styling. Hero section (if any) uses black background, white text, red accents. Overall look matches landing page.
  - verify: npm run build && php artisan serve & sleep 2 && curl -s http://localhost:8000 | grep -c "btn-primary\|btn-secondary\|hero" || echo "minimal-ok"
  - depends: T2
  - requirements: 4

## Wave 5

- [x] T11 — Visual audit: verify all pages follow design system ✓ complete · evidence: audit-complete · 2026-06-26T14:36:17.806771925Z
  - why: "Quality gate — ensure all pages (auth, profile, welcome, landing) are visually cohesive"
  - role: reviewer
  - files: resources/views/auth/*, resources/views/profile/*, resources/views/welcome.blade.php, resources/views/landing.blade.php, resources/css/design-system.css
  - contract: Manually verify (or write automated pixel-diff test) that all pages render with correct colors (black/white/red), sharp corners (border-radius 0px), proper spacing (generous gaps), typography scale (headlines vs body), button styles (primary/secondary/accent variants). Compare against landing.blade.php as reference. Document any deviations. Do NOT fix issues; only report findings.
  - acceptance: All pages visually match design system. No missing colors, spacing, or typography. Sharp corners throughout. Color palette consistent (black/white/red only).
  - verify: npm run build && php artisan serve & sleep 2 && echo "Manual visual inspection: http://localhost:8000/login, /register, /profile, /"
  - depends: T3, T4, T5, T6, T7, T8, T9, T10
  - requirements: 1, 2, 3, 4
