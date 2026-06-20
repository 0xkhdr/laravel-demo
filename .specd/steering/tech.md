# Tech — Stack, conventions, verify commands

## Stack
- PHP 8.3 (see `composer.json`).
- Laravel 13 (see `composer.json` and `bootstrap/app.php`).
- Pest 4 for tests (`composer.json`, `tests/Pest.php`).
- Laravel Horizon 5 for queue monitoring (`composer.json`, `.env.example`, `Makefile`).
- MySQL 8, Redis 7, Mailpit, and Nginx via Docker Compose (`docker-compose.yml`, `.env.example`).
- Blade views for the public site; add Vite/Tailwind assets if the blog UI needs them.

## Conventions
- Keep controllers thin; push response shaping into resources or view models.
- Public HTML pages should be semantic, responsive, and follow the Nothing.tech rules from `BUILD_PROMPT.md`.
- Keep API responses read-only and predictable; omit sensitive fields.
- Use factory + seeder data for demo content.
- Prefer Pest feature tests for HTTP behavior; keep unit tests focused and DB-free.
- Do not edit existing migrations; add new ones for schema changes.

## Verify commands
- unit/feature: `php artisan test`
- style: `./vendor/bin/pint` (or `docker compose exec app ./vendor/bin/pint` in container)
- full stack smoke: `php artisan test`
