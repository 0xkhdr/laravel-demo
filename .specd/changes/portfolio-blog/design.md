# Design

## Boundaries
portfolio/PublishedContent: Public routes read only repository-managed content;
draft content never enters public collections or detail routes.

portfolio/VisualSystem: UI follows `BUILD_PROMPT.md` and current Laravel 13
baseline. Use Blade, Vite, CSS custom properties, and small vanilla JS only.

## Interfaces
Public routes:

- `/` portfolio landing page.
- `/projects` project archive.
- `/projects/{project}` project detail.
- `/writing` article archive.
- `/writing/{article}` article detail.

Content interface:

- Project records: title, slug, kind, summary, body, stack, role, status,
  repository URL, demo URL, featured flag, and display order.
- Article records: title, slug, excerpt, body, tags, published date, reading
  time, and published/draft status.
- Experience records: company, role, start/end dates, summary, bullets, and
  display order.
- Skills grouped by category and display order.

Navigation interface: fixed desktop nav with Work, Writing, About, Contact,
theme toggle, and a mobile full-screen menu with an accessible button and focus
state.

## Invariants
- Slugs are unique and URL-safe.
- Unpublished articles and projects are never listed or reachable through public
  detail routes.
- Every page has one `h1`, ordered heading levels, a descriptive title, and a
  keyboard-visible focus style.
- Red is reserved for active states, critical CTAs, and hover indicators.
- No gradients, drop shadows, or border radii above 2px.
- Content links open only valid, explicitly configured destinations.

## Failure behavior
Missing content returns a normal 404. Invalid external links are omitted rather
than rendered as empty controls. Missing optional images render text-only cards.
Reduced-motion users receive no reveal/transition animation. Content parse or
build failure must fail the verification command rather than publish partial
output.

## Integration
Replace the default `welcome` route/view while preserving existing API routes.
Keep application logic in a small portfolio content provider/controller and
Blade components. Reuse Laravel routing, validation, caching, and existing test
setup. Add no dependency until the native stack cannot satisfy a requirement.

Content starts in version-controlled files with front matter or equivalent
structured data. If authoring becomes cumbersome, move the same fields to
Eloquent/admin storage in a separate change.

## Alternatives
Database CMS: deferred; unnecessary for one author and adds auth, migrations,
editor, and security surface.

Tailwind: deferred; current project has no Tailwind setup and the design is
small enough for one CSS system.

GSAP/canvas grid: deferred; CSS and `IntersectionObserver` cover purposeful
motion with less payload and maintenance.

## Owner
portfolio
