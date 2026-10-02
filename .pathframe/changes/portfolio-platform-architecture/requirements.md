---
schema: pathframe.requirements/v1
profile: okf-markdown/v1
---

## Requirements

- REQ-1: The portfolio home route remains `GET /`, named `portfolio.home`, and renders all existing portfolio sections without requiring a database.
- REQ-2: The visual layer uses Tailwind CSS with a small project-local theme and responsive layouts; duplicated inline CSS and ad-hoc styling are removed only after equivalent behavior is covered.
- REQ-3: Alpine.js handles local-only UI state such as mobile navigation, theme preference, and disclosure controls; state is keyboard accessible and honors `prefers-reduced-motion`.
- REQ-4: Livewire is introduced only for an interaction that benefits from server-side state or validation; static portfolio presentation remains Blade-rendered.
- REQ-5: Portfolio data has one authoritative source and a stable presentation boundary. Templates contain markup rather than duplicated portfolio facts or transformation logic.
- REQ-6: Laravel code stays framework-compatible: controllers remain thin, route behavior is explicit, escaping is preserved, and no unnecessary abstraction layer is added.
- REQ-7: Feature coverage includes route status, rendered portfolio content, accessibility-critical controls, and any new interactive/server-backed behavior.
- REQ-8: The project continues to support PHP 8.3, Laravel 13, Docker Compose, `make test`, and `make lint`; frontend build instructions are reproducible.

## Acceptance

- `make test` and `make lint` pass; the frontend production build succeeds from a clean dependency install.
- The page is usable at mobile and desktop widths, supports keyboard navigation, exposes meaningful labels/states, and does not depend on motion for comprehension.
- No database migration is introduced for static portfolio content; existing API ping behavior remains unchanged.

## Questions

- none
