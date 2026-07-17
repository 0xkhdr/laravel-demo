<!-- specd:managed:steering/structure.md:v3 begin -->
# Steering: Structure

> Fill this in for your project. Map the code so a task can find its files without
> scanning the whole tree. Replace the prompts below.

## Layout
- **app/Http/Controllers/** — API endpoint logic; one controller per resource (e.g. UserController)
- **app/Models/** — Eloquent models; one model per entity (User, etc.)
- **database/migrations/** — Laravel migrations; one file per schema change, reversible
- **routes/api.php** — REST routing: POST /users, GET /users/{id}, PUT /users/{id}, DELETE /users/{id}
- **tests/** — Pest test suite; Feature/ for HTTP tests, Unit/ for logic tests
- **config/**, **.env** — Application configuration; project.yml and .specd/ for process governance

## Naming & patterns
- Controllers: PascalCase, singular resource (UserController), methods match HTTP verbs (store, show, update, destroy)
- Models: PascalCase, singular (User); auto-maps to users table
- Migrations: timestamp + snake_case (2026_07_01_000000_create_users_table.php)
- Tests: Pest syntax; Feature tests mirror routes (tests/Feature/UserTest.php), Unit tests for logic
- Routes: RESTful conventions; /api/users/* for User resource; all responses JSON

## Spec authoring format
- `design.md` decision contract: declare `references:` (the `R<n>` requirements it
  traces to), plus `boundaries:`, `interfaces:`, `invariants:`, `failure:`,
  `integration:`, `alternatives:`, `disposition:`, and `owner:`. An unknown
  reference is always refused; the full contract is required under the production
  profile.
- `tasks.md` optional trace/risk columns: `refs`, `kind`, `risk`, `complexity`,
  `capabilities`, `context`, `evidence`, `checks`. Legacy six-column tables keep working (backward compatible);
  the production planning profile requires the full set.
<!-- specd:managed:steering/structure.md:v3 end -->
