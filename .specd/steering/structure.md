# Structure — Repo layout & module boundaries

## Layout
- `app/Http/Controllers/Api/`: API controllers (thin, delegate to models).
- `app/Http/Resources/`: API resource transformers for response shaping.
- `app/Models/`: Eloquent models (e.g., `User`).
- `app/Providers/`: Service providers (e.g., `AppServiceProvider`).
- `bootstrap/`: Application bootstrapper (`app.php` - Laravel 13 slim, and `providers.php`).
- `config/`: Configuration files (values should never be hardcoded here).
- `database/factories/`: Model factories for testing/seeding.
- `database/migrations/`: Ordered migrations (never edit existing ones).
- `database/seeders/`: Database seeders (with `DatabaseSeeder` calling all others).
- `docker/`: Docker configurations:
  - `nginx/default.conf`: Nginx reverse proxy configuration.
  - `php/`: PHP-FPM configuration, `Dockerfile` (multi-stage), `entrypoint.sh`, `php.ini`, and `php-fpm.conf`.
- `routes/`: Routing files:
  - `api.php`: Stateless `/api/*` routes (no CSRF).
  - `web.php`: Web routes (health check only).
  - `console.php`: Artisan console commands.
- `tests/`: Pest-based test suite:
  - `Pest.php`: Pest bootstrap (loads `RefreshDatabase` for Feature tests).
  - `Feature/Api/`: Feature/HTTP endpoint tests.
  - `Unit/`: Pure unit tests (no database connection).
- `docker-compose.yml`: Development environment configuration.

## Module boundaries
- **Controllers**: API controllers should be thin and delegate database query/business logic to models or services.
- **Resources**: Format and shape the API responses, separating DB schemas from the public-facing API layout.
- **Models**: Eloquent models representing resource schemas, database relations, and attributes.
- **Migrations**: Always write new migration files to modify the database state; never edit or overwrite existing migrations that have already run.

## Naming
- **Controllers**: PascalCase ending with `Controller` (e.g., `UserController`).
- **Resources**: PascalCase ending with `Resource` (e.g., `UserResource`).
- **Models**: PascalCase, singular (e.g., `User`).
- **Jobs**: PascalCase (e.g., `ProcessUser`).
- **Tests**: PascalCase ending with `Test` (e.g., `UserListTest.php`).

