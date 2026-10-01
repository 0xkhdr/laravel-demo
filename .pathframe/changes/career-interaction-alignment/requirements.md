---
schema: pathframe.requirements/v1
profile: okf-markdown/v1
---

## Requirements

- REQ-1: Render each Career entry as an accessible selectable control with a stable pressed state.
- REQ-2: Show the selected entry's period, company, title, and description in a live status region, with a reset message when deselected.
- REQ-3: Match the existing Skills interaction's active, hover, focus, and reduced-motion behavior without adding dependencies.

## Acceptance

- The Career section contains selectable controls with `aria-pressed` and data-backed role details.
- Selecting a role updates the live Career status; selecting it again restores the prompt.
- Existing portfolio rendering tests pass and the page remains accessible without JavaScript content loss.

## Questions

- none
