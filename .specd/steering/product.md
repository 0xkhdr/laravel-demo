# Product Steering

## Product Identity
- This repository is a Laravel-based portfolio/demo site with a single product goal: present content through one coherent UI system.
- The canonical UX reference is `resources/views/landing.blade.php`.
- The canonical visual analysis is `nothing-tech-design-system.md`.

## Design Principles
- Use one visual language across all current and future pages.
- Favor stark contrast, restrained color, and a single red accent over decorative theming.
- Prioritize large typography, generous whitespace, and a premium editorial rhythm.
- Keep the interface content-first: page chrome must stay quiet and predictable.
- Prefer clear hierarchy over visual variety.

## UX Rules
- Every page should feel like the same product family, not a collection of unrelated templates.
- Navigation, hero sections, CTAs, cards, and footer patterns should reuse the same proportions and spacing rhythm.
- Motion should be subtle and intentional, never gimmicky.
- New requirements should describe UI in terms of the shared system, not in terms of one-off page styling.

## Acceptance Lens
- A page passes product review only if it could be mistaken for the same design language as the landing page.
- If a proposed change introduces a new pattern, it must be justified as a reusable system addition, not a page-specific exception.
