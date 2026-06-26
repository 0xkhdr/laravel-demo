# Tech — Stack, dependencies, runtime

Laravel 13 REST API built with PHP 8.3+, Composer package manager. See: composer.json, phpunit.xml

## Backend

- **Framework**: Laravel 13 (PHP 8.3+)
- **Database**: SQLite (default) with Laravel migrations
- **ORM**: Eloquent
- **Testing**: PHPUnit with Feature and Unit test suites
  - Test database: SQLite in-memory (`:memory:`)
  - Config: phpunit.xml with APP_ENV=testing

## Build & Package Management

- **PHP**: Composer for dependencies
- **Node**: NPM for frontend build tools (Laravel Mix/Vite)
- **Scripts**: Defined in composer.json

## Running the App

- **Dev server**: `php artisan serve` (localhost:8000)
- **Testing**: `php artisan test` or `vendor/bin/phpunit`
- **Migrations**: `php artisan migrate`
- **Database reset**: `php artisan migrate:refresh`

## Code Standards

- PHP PSR-12 style (enforced via CI)
- Laravel conventions (PascalCase models, kebab-case routes)
- No type errors or strict mode violations

## Environment

- **.env**: Local config (git-ignored, template at .env.example)
- **config/**: Cached in production
- **Key services**: Database, Cache, Queue (sync by default in tests)