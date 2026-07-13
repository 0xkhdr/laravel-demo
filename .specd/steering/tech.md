<!-- specd:managed:steering/tech.md:v2 begin -->
# Steering: Tech

> Fill this in for your project. Replace the prompts below with your real stack and
> constraints. The harness reads these before proposing changes.

## Stack
- **Language / runtime:** PHP 8.3 (Alpine, via php:8.3-fpm-alpine)
- **Framework:** Laravel 13 (slim bootstrap)
- **Build / test:** `composer install`, `php artisan test` (Pest v3)
- **Dependencies:** Laravel Horizon, Redis, Eloquent ORM; phpredis extension (PECL, not predis); no unnecessary packages

## Invariants (do not break without a recorded decision)
- Tests always use SQLite in-memory (phpunit.xml configured) — no container startup
- Migrations are immutable; never edit existing migrations
- Config caching only in production (`APP_ENV=production`); dev uses live config
- Horizon watches `default` queue on Redis; all async jobs dispatch there
- Controllers are thin (delegate to models); models own business logic
- No hardcoded values; env-sensitive config lives in `config/` with env helpers
- Public API only; no auth middleware on /api/* routes
- Anonymous volume for vendor/ prevents host vendor overwriting container vendor
<!-- specd:managed:steering/tech.md:v2 end -->
