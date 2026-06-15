# Design — Nothing Portfolio

## Overview
We will implement a developer portfolio styled with the Nothing.tech design system. The architecture uses Laravel Blade templates served via a central controller, styled with custom Tailwind CSS utilities, and animated using vanilla JavaScript (or simple CSS triggers). Dynamic content like projects will be database-backed using Eloquent models, while static sections (about text, experience, skills) will be configured in a central config file (`config/portfolio.php`) for maintainability.

## Architecture
The application uses the standard MVC pattern provided by Laravel, with a frontend built using Blade templates and bundled via Vite:

```
[Request] -> [routes/web.php] -> [PortfolioController] 
                                         |
                                         v
   [Blade Templates] <----- [config/portfolio.php] & [Project Model]
           |
           v
[Vite (Tailwind, JS, Canvas)] -> [Browser]
```

- **Routes**: A single root route (`/`) maps to `PortfolioController@index`.
- **Controller**: `PortfolioController` reads static info from `config/portfolio.php` and retrieves `Project` models, passing them to the layout.
- **Model**: `Project` represents portfolio projects, seeded with mock data.
- **Vite & Assets**: Vite bundles styles (`app.css`) and script modules (`app.js`, `canvas-grid.js`).

## Components and interfaces
- **PortfolioController**:
  - `index()`: Returns the layout view with projects and configured experiences/skills.
- **Database Migrations / Seeds**:
  - `create_projects_table`: Standard schema containing `title`, `description`, `github_url`, `live_url`, and `technologies`.
  - `ProjectSeeder`: Populates the database with default showcase projects.
- **Blade Components**:
  - `layouts/app.blade.php`: Renders page shell, meta descriptions, SEO tags, and asset injection.
  - `components/nav.blade.php`: Sticky top navbar with dot-matrix title and theme toggle.
  - `components/hero.blade.php`: High-impact landing zone with name display, subtitle, and canvas grid background.
  - `components/project-card.blade.php`: Card for each project, styled with stark 1px outline borders and hover states.
  - `components/skill-tag.blade.php`: Monospace skill tag/pill.
  - `components/footer.blade.php`: Minimal footer with email, copyright, and social links.
  - `sections/`: Individual template files for About, Experience, Projects, Skills, and Contact to keep the structure modular.

## Data models
- **Project**:
  - Columns:
    - `id`: INT (Primary Key)
    - `title`: VARCHAR(255)
    - `description`: TEXT
    - `github_url`: VARCHAR(255) (Nullable)
    - `live_url`: VARCHAR(255) (Nullable)
    - `technologies`: JSON (Array of tags, e.g., `["Laravel", "Tailwind", "Docker"]`)
    - `created_at` / `updated_at`: Timestamps

## Error handling
- **Database Connection Failure**: The controller wraps database queries in a try-catch block. If the connection fails, it falls back to loading project data from `config/portfolio.php` so the site still renders.
- **Invalid Routes**: Fallback routes redirect to a custom 404 page styled with a monochromatic terminal theme.

## Verification strategy
- **Feature Tests (Pest)**:
  - `test_portfolio_page_loads`: Asserts that `GET /` returns a 200 response.
  - `test_portfolio_displays_projects`: Asserts that seeded projects are visible on the page.
  - `test_portfolio_fallback_on_db_error`: Asserts that the page still renders using config fallback if the database is down.
- **Visual Audit**:
  - Verify WCAG color contrast matches 4.5:1.
  - Verify responsive styling for mobile, tablet, and desktop viewports.
  - Verify accessibility (keyboard navigation for focus states, `prefers-reduced-motion` compliance).

## Risks and open questions
- **Performance & Asset Loading**: Self-hosted fonts could block rendering. Mitigated by using `font-display: swap` and system monospace fallbacks.
- **Animation Overhead**: Heavy JavaScript animations or WebGL canvas grids could lag on mobile devices. Mitigated by implementing a lightweight canvas-based dot grid with CPU-efficient math and disabling canvas/animations on mobile screens or under `prefers-reduced-motion`.
