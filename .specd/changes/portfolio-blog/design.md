# Design

## Boundaries
The public Laravel web layer owns routing, content presentation, metadata, and
theme behavior. Structured portfolio content lives in a single version-controlled
PHP data source; each article is a version-controlled view/content file. No
database or external publishing service is introduced.

## Interfaces
`GET /` renders the portfolio landing page.
`GET /writing` renders the published article index.
`GET /writing/{slug}` renders one published article and returns a normal 404 for
an unknown slug.

The content source exposes stable fields for identity, experience, projects,
open-source work, skills, social links, and articles. Blade templates consume
those fields; they do not embed duplicate content or invent missing values.

## Invariants
The page has one logical `h1`, semantic `nav/main/section/article/footer`
landmarks, unique article slugs, and links with meaningful accessible names.
The visual system uses pure black/white backgrounds, red only for intentional
accent states, no gradients or shadows, and no border radius above 2px.
Animations must be disabled or reduced when `prefers-reduced-motion` is set.

## Failure behavior
An unknown article slug returns Laravel's 404 response. Missing optional social
or demo links are omitted rather than rendered as broken anchors. Empty content
collections render an honest empty state without changing the page structure.
Invalid author-controlled links and article metadata fail validation in tests.

## Integration
Keep `PortfolioController` as the public presentation owner and extend the
existing web route. Reuse Laravel Blade, Vite, and the installed test stack.
Use vanilla CSS/JavaScript and native browser behavior; do not add Tailwind,
GSAP, Lucide, a CMS, or another dependency solely to implement this brief.
Existing `/api` behavior remains untouched.

## Alternatives
An admin CMS and database were rejected because this is a personal site with a
small author-owned content set and no current editing workflow. Tailwind and
GSAP were rejected because the brief is achievable with the existing stack and
native `IntersectionObserver`. A contact form was rejected until a mail
delivery requirement exists.

## Owner
`app/Http/Controllers/PortfolioController.php`, `routes/web.php`,
`resources/views/`, and the new portfolio content/style assets. The portfolio
owner supplies real identity, work history, links, and article copy before
release; placeholder facts must not ship.
