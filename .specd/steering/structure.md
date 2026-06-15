# Structure — Repo layout & module boundaries

## Layout
- `app/Http/Controllers/`: Contains `PortfolioController.php` for rendering views and API endpoints.
- `app/Models/`: Contains `Project.php` and other models.
- `config/`: Contains `portfolio.php` configuration.
- `database/`: Migrations, factories, and seeders (like `ProjectSeeder.php`).
- `public/`: Public assets including self-hosted fonts (`public/fonts/`).
- `resources/css/`: Tailwind and custom component styles (`app.css` and subdirectories).
- `resources/js/`: Javascript logic (`app.js`, `animations.js`, `canvas-grid.js`).
- `resources/views/`: Blade templates:
  - `layouts/app.blade.php`: Root HTML structure, scripts, and meta tags.
  - `components/`: Modular UI units (nav, footer, skill-tag, etc.).
  - `sections/`: Main content sections (hero, about, experience, projects, skills, contact).
- `routes/web.php`: Core route mapping for pages and actions.

## Module boundaries
- **Controllers**: Render blade views and load portfolio data from models or config.
- **Models**: Database interfaces for projects and experiences.
- **Views**: Separation of sections and components to ensure maintainability and reusability.

## Naming
- **Controllers**: PascalCase ending with `Controller` (e.g., `PortfolioController.php`).
- **Models**: PascalCase, singular (e.g., `Project`).
- **Views**: kebab-case (e.g., `project-card.blade.php`).
- **CSS/JS**: kebab-case (e.g., `canvas-grid.js`).

