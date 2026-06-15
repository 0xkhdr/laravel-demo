# Tech — Stack, conventions, verify commands

## Stack
- **Language**: PHP ^8.3 (configured for platform 8.3.0 in `composer.json`).
- **Framework**: Laravel ^13.0 (with Blade templates).
- **Frontend Build**: Vite ^5.0 / Laravel Vite plugin.
- **CSS**: Tailwind CSS (with custom theme extensions for nothing design system).
- **JS**: Vanilla JS (for animations and interactive canvas dot grid).
- **Testing**: Pest PHP ^4.4.
- **Code Style/Linter**: Laravel Pint ^1.13.
- **Environment**: Docker containers for PHP (app), Nginx, MySQL 8.0, Redis 7, Mailpit.

## Conventions
- **Code Style**: Checked and formatted automatically using Laravel Pint via `make lint`.
- **Theme**: Monochromatic discipline, using borders/glassmorphism instead of drop shadows.
- **Fonts**: Self-hosted Space Mono, Inter, and JetBrains Mono.
- **Borders**: 1px border width, border-radius of 0px or 2px max.
- **Icons**: Lucide outline icons, 1.5px stroke.

## Verify commands
- **test**: `make test` (runs Pest test suite)
- **lint**: `make lint` (runs Laravel Pint linter)
- **migrate**: `make migrate` (runs pending migrations)
- **fresh**: `make fresh` (resets database and seeds)

