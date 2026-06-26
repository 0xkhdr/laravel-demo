# Structure Steering

## Source Of Truth
- `resources/views/landing.blade.php` is the reference page for shell, section rhythm, and page composition.
- `nothing-tech-design-system.md` is the reference analysis for palette, typography, spacing, motion, and tone.
- Shared UI decisions should be expressed centrally, then consumed by pages.

## File Placement Rules
- Put the base page shell in shared layout files, not inside individual page templates.
- Put reusable UI fragments in Blade components or shared partials.
- Put design tokens and shared visual primitives in the design-system stylesheet, not inline on pages.
- Keep page-specific content in page templates; keep presentation rules in shared files.

## Composition Rules
- New pages should extend the same layout and inherit the same spacing and width constraints.
- Section wrappers, headings, button treatments, cards, and form surfaces should be built from reusable primitives.
- Avoid duplicated markup for navigation, mobile menus, or repeated content blocks.

## Anti-Patterns
- No per-page color palettes.
- No one-off spacing scales.
- No isolated button or card styles that bypass the shared system.
- No layout decisions hidden inside arbitrary page templates.
