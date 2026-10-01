# Repository Guidelines

## Project Structure & Module Organization

This is a Laravel 13 application targeting PHP 8.3. Application code is in
`app/`; HTTP controllers are in `app/Http/Controllers`, models in
`app/Models`, and shared configuration in `config/`. Routes are split between
`routes/web.php` and `routes/api.php`. Blade templates and frontend assets are
in `resources/views`, `resources/js`, and `resources/css`. Database migrations,
factories, and seeders are under `database/`. Tests are in `tests/Feature` and
`tests/Unit`. Docker and service configuration lives in `docker/` and
`docker-compose.yml`.

## Build, Test, and Development Commands

Use the Makefile for the normal workflow:

- `make setup` creates `.env`, builds and starts containers, links storage, and
  seeds the database.
- `make up` / `make down` start or stop the Docker services.
- `make test` runs the Pest suite through `php artisan test`.
- `make lint` runs Laravel Pint and applies formatting fixes.
- `make migrate`, `make seed`, and `make fresh` manage the database; `fresh`
  drops and recreates all tables, so use it only when data can be discarded.
- `make logs` tails service logs; `make shell` opens a shell in the app
  container.

## Coding Style & Naming Conventions

Follow Laravel conventions and PSR-12-style PHP formatting. Use four spaces,
typed method signatures, descriptive camelCase variables and methods, and
PascalCase classes. Keep controllers thin and place portfolio values in
`config/portfolio.php`. Run `make lint` before submitting PHP changes. Use
Blade conventions for views and REST-style, lowercase paths for API routes.

## Testing Guidelines

Tests use Pest with Laravel's testing helpers. Name files with a `Test.php`
suffix and describe behavior in the test name, for example
`tests/Feature/Api/PingTest.php`. Add or update feature tests for route,
response, and rendered-view changes. Run `make test`; the suite uses an
in-memory SQLite database and does not require persistent test data.

## Commit & Pull Request Guidelines

Use short, imperative commit subjects, such as `Add portfolio capability
details` or `Remove unused route`. Keep commits focused. Pull requests should
explain the behavior change, list verification commands, link the relevant
issue when one exists, and include screenshots for UI or Blade changes.

## Security & Configuration Tips

Never commit `.env`, credentials, or generated secrets. Update `.env.example`
when a new required setting is introduced. Review configuration and migration
changes carefully, and do not run `make fresh` against a database containing
data you need to preserve.
