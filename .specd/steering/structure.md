# Structure

## Top-Level Layout
- `app/` contains application code
- `bootstrap/` and `config/` hold framework bootstrapping and settings
- `database/` holds migrations, factories, and seeders
- `resources/` holds Blade views and other frontend assets
- `routes/` holds HTTP route definitions
- `tests/` holds Pest feature and unit tests
- `docker/` and `docker-compose.yml` define the local container setup

## Important App Paths
- `app/Models/User.php` for the user model
- `app/Providers/AppServiceProvider.php` for application bootstrapping
- `routes/api.php` for the user API route
- `routes/web.php` for the landing page
- `database/factories/UserFactory.php` for user test data
- `database/seeders/UserSeeder.php` for seed data

## Naming Conventions
- Controllers should live under `app/Http/Controllers`
- API controllers should use the `Api` subnamespace when they are API-only
- Tests should name the behavior they verify, not the implementation class
- Seeders and factories should describe their domain purpose clearly

## Scope Boundaries
Keep unrelated concerns out of the current structure:
- no new top-level modules unless they are required
- no duplicate route or model layers
- no premature service layer unless the app complexity justifies it

## Current Structural Note
The route layout suggests an API controller layer, but the controller file is
currently missing. If that path is needed, add it in the expected namespace.
