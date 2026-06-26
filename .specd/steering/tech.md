# Tech Steering

## Stack
- PHP 8.3+ and Laravel are the backend foundation.
- Blade templates and Vite are the UI delivery path.
- Existing front-end assets already use `resources/css/design-system.css`, `resources/js/nav.js`, and `resources/js/menu.js` from the landing page.

## Canonical UI Tokens
- Palette: black, white, gray scale, and a controlled red accent.
- Typography: large display headings, compact supporting headings, and readable body copy with disciplined line-height.
- Spacing: use the documented scale from the design analysis, centered on 4px-based increments and large section gaps.
- Radius and elevation: keep surfaces subtle; use only the small set of approved rounded corners and shadows.
- Motion: use short, easing-based transitions with the same timing family across the system.

## Layout Contract
- Default pages should respect a wide content container with generous horizontal padding.
- Use responsive grids that collapse cleanly from multi-column layouts to stacked layouts.
- Preserve stable vertical rhythm between hero, content sections, and footer blocks.

## Implementation Rules
- Add or adjust visual tokens in one shared place before using them in page templates.
- Prefer semantic HTML and Blade composition over repeated inline class blobs.
- Keep interaction states explicit: hover, focus, active, disabled, and reduced-motion behavior must all be defined.
- Shared components must support current pages and foreseeable upcoming pages without page-specific overrides.

## Verification Expectations
- The UI system should be checkable through build output and consistent rendered pages.
- Any future visual drift should be treated as a system regression, not a local exception.
