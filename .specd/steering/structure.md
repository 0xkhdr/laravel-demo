# Structure — Repo layout & module boundaries

Laravel 13 REST API demo. Standard Laravel structure with user management API.

## Layout

- **app/** — Source code
  - **Models/** — Eloquent models (User, etc.)
  - **Http/Controllers/** — Request handlers
    - **Api/** — API-specific controllers
  - **Providers/** — Service providers
- **routes/** — Route definitions
  - **api.php** — API routes (/api/*)
  - **web.php** — Web routes (/)
- **config/** — Configuration files
- **database/** — Migrations, factories, seeders
- **tests/** — Test suites
- **resources/** — Blade views, assets
- **public/** — Web root
- **bootstrap/** — Framework initialization
- **storage/** — Logs, cache, uploads
- **vendor/** — Dependencies (Composer)
- **node_modules/** — NPM dependencies (build tools)

## Module boundaries

- **API routes** depend on controllers in Http/Controllers/Api/
- **Controllers** depend on Models
- **Models** depend on database schema
- New API endpoints: add controller in Http/Controllers/Api/, register in routes/api.php
- New models: create in app/Models/ with migration in database/migrations/

## Naming

- **Controllers**: PascalCase + Controller suffix (UserController, ProductController)
- **Models**: PascalCase, singular (User, Product)
- **Routes**: kebab-case paths (/api/users, /api/products)
- **Database tables**: snake_case, plural (users, products)
- **Methods**: camelCase (index, show, store, update, destroy for RESTful actions)
