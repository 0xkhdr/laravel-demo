# Tech — Stack, conventions, verify commands

## Stack
- **Language**: PHP ^8.3 (configured for platform 8.3.0 in `composer.json`).
- **Framework**: Laravel ^13.0.
- **Testing**: Pest PHP ^4.4 (Pest v3 preferred for expressive syntax).
- **Code Style/Linter**: Laravel Pint ^1.13.
- **Environment**: Docker multi-service architecture:
  - `nginx` (nginx:alpine, port 8080->80) - reverse proxy.
  - `app` (php:8.3-fpm-alpine, internal:9000) - PHP-FPM application.
  - `horizon` (php:8.3-fpm-alpine) - queue worker.
  - `mysql` (mysql:8.0, port 3307->3306) - primary database.
  - `redis` (redis:7-alpine, port 6380->6379) - cache, sessions, queues.
  - `mailpit` (axllent/mailpit:latest, port 8025->8025) - email catch-all.

## Key Design Decisions & Conventions
- **No authentication**: Public read-only API demo.
- **Testing Database**: SQLite in-memory for tests (`phpunit.xml`). No running containers required on the host (run via `make test` or `php artisan test`).
- **Queue System**: Laravel Horizon on Redis (`QUEUE_CONNECTION=redis`), watching the `default` queue.
- **PHP Redis Client**: `phpredis` extension (installed via PECL).
- **Config Caching**: Only enabled in production (`APP_ENV=production`), disabled in dev.
- **Docker Volumes**: Anonymous volume for `vendor` to prevent host vendor from overwriting container vendor.
- **Code Style**: Checked and formatted automatically using Laravel Pint via `make lint`.

## Environment Variables
- Local dev uses `.env` copied from `.env.example`.
- Docker service hostnames:
  - `DB_HOST=mysql`
  - `REDIS_HOST=redis`
  - `MAIL_HOST=mailpit`
- Production requires:
  - `APP_KEY`
  - `APP_ENV=production`
  - `APP_DEBUG=false`

## Common Commands
- `make setup` - Copy env, build images, start containers, run storage link, migrate and seed.
- `make up` - Start containers in background.
- `make down` - Stop and remove containers.
- `make fresh` - Reset database migrations and seed.
- `make test` - Run full Pest test suite.
- `make shell` - Open shell in the `app` container.
- `make lint` - Run Laravel Pint formatting.
- `make logs` - Tail container logs.
- `make cache-clear` - Clear all Laravel caches.
- `make optimize` - Cache config, routes, views (production).

## Verify commands
- **test**: `make test` (runs Pest test suite)
- **lint**: `make lint` (runs Laravel Pint linter)
- **migrate**: `make migrate` (runs pending migrations)
- **fresh**: `make fresh` (resets database and seeds)

