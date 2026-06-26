# Tasks — Unified UI System

## Wave 1
- [ ] T1 — Audit the landing reference and system analysis
  - why: establish the canonical UI rule set before implementation.
  - role: investigator
  - files: resources/views/landing.blade.php, nothing-tech-design-system.md
  - contract: extract the shared visual, layout, and interaction rules without changing any code.
  - acceptance: the canonical shell, tokens, spacing, motion, and reuse rules are documented for downstream implementation.
  - verify: specd check ui-system-unification
  - depends: —
  - requirements: 1, 2, 3

- [ ] T2 — Update steering docs for the canonical UI system
  - why: make the shared design rules discoverable before any page work starts.
  - role: builder
  - files: .specd/steering/product.md, .specd/steering/structure.md, .specd/steering/tech.md
  - contract: document the product, structure, and tech rules that all future requirements must follow.
  - acceptance: steering docs describe the shared shell, tokens, component reuse, and responsive/accessibility rules.
  - verify: specd check ui-system-unification
  - depends: T1
  - requirements: 7

## Wave 2
- [ ] T3 — Build or align the shared shell and navigation
  - why: create a reusable base layout that matches the landing page shell without page-local chrome.
  - role: builder
  - files: resources/views/layouts/*, resources/views/components/*
  - contract: centralize the page shell, navigation, and section rhythm into reusable Blade structure.
  - acceptance: existing and future pages can extend one shared shell.
  - verify: npm run build
  - depends: T2
  - requirements: 1, 4

- [ ] T4 — Define shared tokens and primitives
  - why: centralize the visual vocabulary used by buttons, cards, section headers, and forms.
  - role: builder
  - files: resources/css/design-system.css, resources/views/components/*
  - contract: add or refine shared tokens and component primitives so pages consume the same system.
  - acceptance: visual primitives use the same token set and can be reused across pages.
  - verify: npm run build
  - depends: T3
  - requirements: 2, 3, 5

## Wave 3
- [ ] T5 — Refactor the landing page onto the shared system
  - why: preserve the reference UX while proving the shared system can carry the flagship page.
  - role: builder
  - files: resources/views/landing.blade.php, shared layout/component files
  - contract: keep the landing page behavior and visual intent while switching to the shared shell and primitives.
  - acceptance: the landing page still matches the reference quality and uses the shared system.
  - verify: npm run build
  - depends: T4
  - requirements: 1, 2, 3, 4

- [ ] T6 — Apply the shared system to current and future page templates
  - why: ensure new pages inherit the same shell and tokens without page-specific styling drift.
  - role: builder
  - files: resources/views/**/*.blade.php
  - contract: update existing pages and establish the default page pattern for upcoming ones.
  - acceptance: new pages inherit the same shell and tokens without page-specific styling.
  - verify: npm run build
  - depends: T4
  - requirements: 1, 2, 6

## Wave 4
- [ ] T7 — Verify responsiveness, accessibility, and consistency
  - why: confirm the unified system behaves correctly across breakpoints and interaction states.
  - role: verifier
  - files: resources/views/*, resources/css/design-system.css
  - contract: validate mobile and desktop composition, focus states, and reduced-motion behavior.
  - acceptance: system behavior is consistent across key breakpoints and interaction states.
  - verify: npm run build
  - depends: T5, T6
  - requirements: 4, 5, 6, 7
