---
schema: pathframe.requirements/v1
profile: okf-markdown/v1
---

## Requirements

- REQ-1: The web root renders semantic portfolio sections for hero, about, experience, projects, skills, contact, and footer from Blade.
- REQ-2: Portfolio data is editable in one application-owned configuration/data location; absent personal facts use clearly marked placeholders rather than invented identity, history, projects, contact details, or URLs.
- REQ-3: Styling implements the supplied design tokens and constraints with plain CSS: responsive layouts, white/black sections, sparse red accent, no gradients, no shadows, and maximum 2px radius.
- REQ-4: Navigation supports desktop links, a keyboard-accessible mobile menu, and a theme toggle. Theme preference persists locally and respects the system default when unset.
- REQ-5: JavaScript uses vanilla APIs only for menu, theme persistence, and restrained scroll reveal; reduced motion disables reveal/transitions that move or fade content.
- REQ-6: Existing API behavior, including `GET /api/ping`, remains unchanged.
- REQ-7: The page has semantic landmarks, heading order, labeled interactive controls, visible focus styles, sufficient text contrast by inspection, and no required external service.

## Acceptance

- `/` returns 200 and contains the required section landmarks and configured content.
- Focused portfolio feature tests and the full Laravel test suite pass.
- The frontend production build passes using the repository's actual package tooling, or the plan records that no frontend build exists and verifies the chosen native asset path honestly.
- Manual browser checks cover desktop/mobile layout, keyboard navigation, reduced motion, theme persistence, and absence of fabricated content.

## Questions

- none
