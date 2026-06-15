# AGENTS.md — Laravel Demo

This file is the authoritative guide for AI agents working on this codebase.
Read it fully before making any changes.

---

## Project Purpose

Minimal production-ready **Laravel 13 REST API** demonstrating:
- Public user listing endpoint with pagination
- Laravel Horizon for queue management
- Docker (Alpine) multi-service setup
- Pest-based test suite

---

## Architecture

```
laravel-demo/
├── app/
│   ├── Http/Controllers/Api/   # API controllers (thin, delegate to models)
│   ├── Http/Resources/         # API resource transformers
│   ├── Models/                 # Eloquent models
│   └── Providers/              # Service providers (AppServiceProvider)
├── bootstrap/
│   ├── app.php                 # Application bootstrapper (Laravel 13 slim)
│   └── providers.php           # Registered service providers
├── config/                     # All config files (never hardcode values here)
├── database/
│   ├── factories/              # Model factories for testing/seeding
│   ├── migrations/             # Ordered migrations (never edit existing ones)
│   └── seeders/                # Seeders (DatabaseSeeder calls all others)
├── docker/
│   ├── nginx/default.conf      # Nginx reverse proxy to php-fpm:9000
│   └── php/
│       ├── Dockerfile          # Multi-stage: base (dev) + production
│       ├── entrypoint.sh       # Waits for services, runs migrations
│       ├── php.ini             # PHP runtime config
│       └── php-fpm.conf        # FPM pool config
├── routes/
│   ├── api.php                 # All /api/* routes (stateless, no CSRF)
│   ├── web.php                 # Web routes (health check only)
│   └── console.php             # Artisan commands
├── tests/
│   ├── Pest.php                # Pest bootstrap (RefreshDatabase for Feature)
│   ├── Feature/Api/            # HTTP endpoint tests
│   └── Unit/                   # Pure unit tests (no DB)
└── docker-compose.yml          # Dev environment (volumes mounted)
```

---

## Services (Docker Compose)

| Service   | Image                  | Port(s)        | Role                         |
|-----------|------------------------|----------------|------------------------------|
| `nginx`   | nginx:alpine           | 8080→80        | Reverse proxy                |
| `app`     | php:8.3-fpm-alpine     | internal:9000  | PHP-FPM application          |
| `horizon` | php:8.3-fpm-alpine     | —              | Queue worker (Horizon)       |
| `mysql`   | mysql:8.0              | 3307→3306      | Primary database             |
| `redis`   | redis:7-alpine         | 6380→6379      | Cache, sessions, queues      |
| `mailpit` | axllent/mailpit:latest | 8025→8025      | Email catch-all (UI + SMTP)  |

---

## Key Design Decisions

1. **No authentication** — this is a public read-only API demo.
2. **Pest v3** — preferred over PHPUnit directly for expressive syntax.
3. **SQLite in-memory for tests** — set in `phpunit.xml`, no Docker needed to run tests.
4. **Horizon on Redis** — `QUEUE_CONNECTION=redis`, Horizon watches `default` queue.
5. **`phpredis` extension** — faster than predis, installed via PECL in Dockerfile.
6. **Config caching** — only done in production (`APP_ENV=production`), not dev.
7. **Anonymous volume for vendor** — prevents host vendor overwriting container vendor.

---

## Adding New Features

### New API endpoint
1. Create controller in `app/Http/Controllers/Api/`
2. Create resource in `app/Http/Resources/` if response shaping is needed
3. Register route in `routes/api.php`
4. Write Feature test in `tests/Feature/Api/`

### New model
1. `docker compose exec app php artisan make:model Foo -mf` (migration + factory)
2. Write migration, then factory definition
3. Add model to `DatabaseSeeder` if needed

### New queue job
1. `docker compose exec app php artisan make:job ProcessFoo`
2. Dispatch via `ProcessFoo::dispatch()`
3. Horizon picks it up automatically (watches `default` queue)

---

## Common Commands

```bash
make setup          # First-time: build, start, migrate, seed
make up             # Start all containers
make down           # Stop all containers
make fresh          # Drop all tables and re-seed
make test           # Run Pest test suite
make shell          # Open shell in app container
make lint           # Run Laravel Pint
make logs           # Tail all container logs
make cache-clear    # Clear all Laravel caches
make optimize       # Cache config/routes/views (production)
```

---

## Environment Variables

All configuration is driven by `.env`. Copy `.env.example` to `.env` for local dev.
Docker service hostnames match service names in `docker-compose.yml`:
- `DB_HOST=mysql`
- `REDIS_HOST=redis`
- `MAIL_HOST=mailpit`

---

## Testing

Tests use **SQLite in-memory** — no running containers required:

```bash
# Inside container:
php artisan test

# Or from host:
make test

# Single test:
docker compose exec app php artisan test --filter UserListTest
```

`RefreshDatabase` is applied to all Feature tests via `tests/Pest.php`.

---

## Production Deployment

Build the production image:

```bash
docker build --target production -t laravel-demo:latest .
```

The production stage:
- Bakes code into the image (no volume mounts)
- Runs `composer install --no-dev`
- Optimizes autoloader
- `entrypoint.sh` runs `php artisan optimize` before starting FPM

Required env vars for production:
- `APP_KEY` — generate with `php artisan key:generate --show`
- `APP_ENV=production`
- `APP_DEBUG=false`
- All `DB_*`, `REDIS_*` pointing to production services
