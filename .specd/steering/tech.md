# Tech — Stack, conventions, verify commands

> TODO: Fill this in. Always-loaded steering.

## Stack

- PHP 8.3 (strict types enforced)
- Laravel 13.0 (latest, no legacy patterns)
- Pest 3.x for testing (no PHPUnit verbose syntax)
- MySQL 8.0 (via Docker)
- Redis for caching/queue
- Laravel Horizon for queue monitoring
- Sanctum for API authentication
- Spatie packages (roles, permissions, query builder helpers)

## Conventions

- **Style**: PSR-12 enforced via Pint
- **Naming**: {Action}{Model} for jobs, {Model}Event for events, {Model}Observer for listeners
- **Modules**: Controllers ↔ Actions (thin controller, logic in Action), Models use MassPrunable + soft deletes
- **Errors**: Custom exceptions extend HttpException, include status/message/extra context
- **Async**: Jobs use queues (sync in tests), events trigger listeners, use events not direct calls

## Verify commands

- **test**: `php artisan test` (Pest, includes coverage)
- **lint**: `./vendor/bin/pint --test` (check only, no fix)
- **types**: `./vendor/bin/phpstan --memory-limit=4G`
- **db**: `php artisan migrate:fresh --seed` (verify schema runs clean)
