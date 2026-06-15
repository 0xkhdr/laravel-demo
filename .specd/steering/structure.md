# Structure — Repo layout & module boundaries

## Layout
- `app/Http/Controllers/`: Contains the controller logic handling requests and returning responses.
- `app/Models/`: Contains the Eloquent models defining database schemas, casts, and business logic.
- `app/Providers/`: Service provider classes mapping framework services.
- `bootstrap/`: Application bootstrap and configuration cache setup.
- `config/`: Laravel config files (e.g., `database.php`, `app.php`).
- `database/`: Contains migrations (`database/migrations`), factories (`database/factories`), and seeders (`database/seeders`).
- `routes/`: Routing rules (`routes/api.php` for JSON API endpoints).
- `tests/`: Pest test suite, containing integration/HTTP feature tests (`tests/Feature`) and unit tests (`tests/Unit`).

## Module boundaries
- **Controllers**: May depend on Models and Eloquent query builders. Must be placed under `app/Http/Controllers/Api/` for REST API endpoints.
- **Models**: Independent of HTTP controllers. Placed in `app/Models/` and used for database interactions.
- **Migrations/Factories/Seeders**: Define and populate the state of models in the database.
- **Routing**: API endpoints are registered in `routes/api.php` under the `/api` prefix.

## Naming
- **Controllers**: PascalCase ending with `Controller` (e.g., `UserController`).
- **Models**: PascalCase, singular (e.g., `User`).
- **Factories**: PascalCase ending with `Factory` (e.g., `UserFactory`).
- **Seeders**: PascalCase ending with `Seeder` (e.g., `UserSeeder`).
- **Tests**: PascalCase ending with `Test.php` (e.g., `UserListTest.php`).
- **Routes**: kebab-case URL naming conventions (e.g., `/api/users`).
