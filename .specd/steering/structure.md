# Structure — Repo layout & module boundaries

## Layout
- `app/` — application code; keep controllers, models, and HTTP resources here.
- `bootstrap/` — Laravel bootstrap wiring.
- `config/` — runtime configuration.
- `database/` — migrations, factories, and seeders.
- `public/` — web entrypoint and public assets.
- `resources/` — Blade views plus CSS/JS assets for the public site.
- `routes/` — HTTP route definitions (`web.php`, `api.php`, `console.php`).
- `tests/` — Pest feature and unit tests.
- `docker/` and `docker-compose.yml` — local runtime and service wiring.

## Module boundaries
- `routes/web.php` owns the public website surface.
- `routes/api.php` owns stateless JSON endpoints.
- `app/Http/Controllers/Web` may return Blade views only.
- `app/Http/Controllers/Api` may return JSON only.
- `app/Http/Resources` shapes API responses; controllers should stay thin.
- `app/Models` owns Eloquent persistence and query helpers.
- `database/migrations` define schema; do not rewrite old migrations.
- `database/seeders` provide sample portfolio/article content.
- `resources/views`, `resources/css`, and `resources/js` own presentation for the blog site.
- Feature tests should mirror the surface they cover (`tests/Feature/Web`, `tests/Feature/Api`).

## Naming
- Controllers: singular PascalCase (`BlogController`, `ArticleController`).
- Models: singular PascalCase (`Article`).
- Blade partials/components: kebab-case file names.
- Migrations: framework timestamp format plus snake_case table intent.
- Tests: descriptive `*Test.php` files, one behavior per test.
