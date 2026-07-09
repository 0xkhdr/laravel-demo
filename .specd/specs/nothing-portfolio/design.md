# Design — nothing-portfolio

> Name module boundaries, on-disk contracts, and preserved invariants.
> The design gate reads this file before tasks execute.

## Modules

- **Presentation shell**: Blade layout and section components that compose the single-page portfolio experience.
- **Design system**: Global CSS, Tailwind/theme configuration, typography, spacing, color, and motion tokens.
- **Portfolio data**: Route/controller/config layer that supplies structured content for hero copy, project cards, skills, and contact links.
- **Verification**: Feature tests that confirm route behavior, section presence, and the page contract.

## On-disk contracts

- `routes/web.php` resolves `/` to the portfolio home experience.
- `config/portfolio.php` or an equivalent centralized config file stores shared portfolio content.
- `resources/views/welcome.blade.php` or a dedicated page view composes the landing page from reusable Blade components.
- `resources/views/components/*` or section partials contain reusable visual primitives such as section headers, project cards, skill tags, and terminal blocks.
- `resources/css/app.css` and theme configuration files define the site-wide tokens and component styling.
- `tests/Feature/*Portfolio*.php` covers the landing page contract and critical render behavior.

## Invariants

- All portfolio copy, project summaries, and contact links come from one shared data source.
- Visual tokens for color, type, spacing, borders, and motion are centralized instead of being repeated ad hoc in components.
- The page keeps semantic landmarks intact and remains navigable without relying on animation or custom scripting.
- Motion is subtle and bounded; reduced-motion users should still get a complete, usable page.
