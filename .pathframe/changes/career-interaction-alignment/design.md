---
schema: pathframe.design/v1
profile: okf-markdown/v1
---

## Approach

Reuse the existing timeline markup and CSS. Convert each timeline article into a button with span-based text, store the full role description in a data attribute, and add a Career status paragraph. Extend the existing small selection handler pattern in `resources/js/app.js` to update `aria-pressed` and the live text.

## Decisions

- Keep the timeline visible and use the status region for the detailed description, matching Skills rather than introducing an accordion or new dependency.
- Keep the first state unselected so the user explicitly chooses a role.
- Preserve the existing hover/focus emphasis and add selected-state styling.

## Questions

- none
