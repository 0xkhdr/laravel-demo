# Tech — Stack, conventions, verify commands

## Stack
- **Language**: PHP ^8.3 (configured for platform 8.3.0 in `composer.json`).
- **Framework**: Laravel ^13.0 (REST API project).
- **Queue/Worker**: Laravel Horizon ^5.30.
- **Testing**: Pest PHP ^4.4 with `pestphp/pest-plugin-laravel` ^4.1.
- **Code Style/Linter**: Laravel Pint ^1.13.
- **Environment**: Docker containers for PHP (app), Nginx, MySQL 8.0, Redis 7, and Mailpit.

## Conventions
- **Code Style**: Checked and formatted automatically using Laravel Pint via `make lint`.
- **Database**: Eloquent models with Laravel-standard migrations, factories, and seeders.
- **Serialization**: Sensitive attributes (`password`, `remember_token`) must be added to the `$hidden` array on the Model to prevent leak in API payloads.
- **API Responses**: Standard JSON envelopes including pagination links and metadata as defined by Laravel's default resource/pagination schemas.

## Verify commands
- **test**: `make test` (runs Pest test suite inside docker: `docker compose exec app php artisan test`)
- **lint**: `make lint` (runs Laravel Pint linter: `docker compose exec app ./vendor/bin/pint`)
- **migrate**: `make migrate` (runs pending migrations: `docker compose exec app php artisan migrate`)
- **fresh**: `make fresh` (resets database and seeds: `docker compose exec app php artisan migrate:fresh --seed`)
