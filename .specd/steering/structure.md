<!-- specd:managed:steering/structure.md:v2 begin -->
# Steering: Structure

> Fill this in for your project. Map the code so a task can find its files without
> scanning the whole tree. Replace the prompts below.

## Layout
- **app/Http/Controllers/Api/** — API controllers (thin, delegate to models)
- **app/Http/Resources/** — API resource transformers (response shaping)
- **app/Models/** — Eloquent models (logic lives here)
- **app/Providers/** — Service providers (AppServiceProvider only)
- **config/** — Configuration files (never hardcode values, use env)
- **database/migrations/** — Ordered migrations (never edit existing ones)
- **database/factories/** — Model factories for testing/seeding
- **database/seeders/** — Seeders (DatabaseSeeder calls all others)
- **routes/api.php** — All /api/* routes (stateless, no CSRF)
- **routes/web.php** — Web routes (health check only)
- **tests/Feature/Api/** — HTTP endpoint tests
- **tests/Unit/** — Pure unit tests (no DB)
- **docker/php/** — PHP runtime config and Dockerfile
- **docker/nginx/** — Nginx reverse proxy config

## Naming & patterns
- Controllers: `{Resource}Controller` (e.g., `UserController`)
- Resources: `{Resource}Resource` (e.g., `UserResource`)
- Models: PascalCase without suffix (e.g., `User`)
- Jobs: `Process{Job}` (e.g., `ProcessEmail`)
- Tests: `{Feature}Test` in Feature/ or Unit/ directories, mirror app/ structure
- Migrations: timestamp_create_{table}_table or timestamp_add_{column}_to_{table}
- Tests use SQLite in-memory (set in phpunit.xml), no Docker needed to run

## Spec authoring format
- `design.md` decision contract: declare `references:` (the `R<n>` requirements it
  traces to), plus `boundaries:`, `interfaces:`, `invariants:`, `failure:`,
  `integration:`, `alternatives:`, `disposition:`, and `owner:`. An unknown
  reference is always refused; the full contract is required under the production
  profile.
- `tasks.md` optional trace/risk columns: `refs`, `kind`, `risk`, `context`,
  `evidence`, `checks`. Legacy six-column tables keep working (backward compatible);
  the production planning profile requires the full set.
<!-- specd:managed:steering/structure.md:v2 end -->
