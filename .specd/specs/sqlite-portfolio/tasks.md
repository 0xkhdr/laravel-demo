# Tasks — SQLite Portfolio and JSON Seeding

## Wave 1
- [x] T1 — Create database files and project JSON data ✓ complete · evidence: verified: `php -r "assert(file_exists('database/data/projects.json'));"` → exit 0 @ 994072e4a148ed759daff449653f17950df755c8 (2026-06-15T18:18:18.852847408Z) · 2026-06-15T18:18:21.484262174Z
  - why: Setup the data source and SQLite database file so that seeding and reading have files to work with.
  - role: builder
  - files: database/database.sqlite, database/data/projects.json
  - contract: Create SQLite database file if not exists. Create database/data/projects.json file containing portfolio projects.
  - acceptance: Files exist and projects.json contains valid JSON array of projects.
  - verify: php -r "assert(file_exists('database/data/projects.json'));"
  - depends: —
  - requirements: 1, 2

- [x] T2 — Create and implement App\Services\ProjectLoader ✓ complete · evidence: verified: `php artisan tinker --execute="class_exists('App\\Services\\ProjectLoader') || throw new Exception('Not found');"` → exit 0 @ 994072e4a148ed759daff449653f17950df755c8 (2026-06-15T18:18:48.965161982Z) · 2026-06-15T18:18:52.971310791Z
  - why: Encapsulate the logic of loading, parsing, and validating project JSON files.
  - role: builder
  - files: app/Services/ProjectLoader.php
  - contract: Implement ProjectLoader class with loadProjects method to read database/data/projects.json and return a collection of stdClass objects representing projects. Validate required fields and handle errors.
  - acceptance: ProjectLoader class exists and implements loadProjects returning a Collection.
  - verify: php artisan tinker --execute="class_exists('App\Services\ProjectLoader') || throw new Exception('Not found');"
  - depends: T1
  - requirements: 2, 3

- [x] T3 — Implement ProjectLoaderTest ✓ complete · evidence: verified: `php artisan test --filter=ProjectLoaderTest` → exit 0 @ 994072e4a148ed759daff449653f17950df755c8 (2026-06-15T18:19:07.808108219Z) · 2026-06-15T18:19:11.609923116Z
  - why: Ensure the ProjectLoader behaves correctly under different scenarios.
  - role: verifier
  - files: tests/Unit/ProjectLoaderTest.php
  - contract: Write unit tests to check ProjectLoader parses valid file, throws exception on missing file, and throws exception on malformed JSON.
  - acceptance: All tests in tests/Unit/ProjectLoaderTest.php pass.
  - verify: php artisan test --filter=ProjectLoaderTest
  - depends: T2
  - requirements: 2, 3

## Wave 2
- [x] T4 — Update ProjectSeeder to use ProjectLoader ✓ complete · evidence: verified: `docker compose exec app php artisan db:seed --class=ProjectSeeder && docker compose exec app php artisan tinker --execute="App\\Models\\Project::count() > 0 || exit(1);"` → exit 0 @ 994072e4a148ed759daff449653f17950df755c8 (2026-06-15T18:20:08.027596542Z) · 2026-06-15T18:20:12.339769823Z
  - why: Populate the database using JSON source data rather than hardcoded php arrays.
  - role: builder
  - files: database/seeders/ProjectSeeder.php
  - contract: Inject ProjectLoader into ProjectSeeder run method and seed database using its output.
  - acceptance: Seeder successfully runs and seeds database from JSON file contents.
  - verify: docker compose exec app php artisan db:seed --class=ProjectSeeder && docker compose exec app php artisan tinker --execute="App\Models\Project::count() > 0 || exit(1);"
  - depends: T2
  - requirements: 1, 2

- [x] T5 — Update PortfolioController for offline JSON fallback ✓ complete · evidence: verified: `docker compose exec app php artisan test --filter="successfully loads the portfolio homepage"` → exit 0 @ 994072e4a148ed759daff449653f17950df755c8 (2026-06-15T18:20:41.231248789Z) · 2026-06-15T18:20:46.218532354Z
  - why: Implement the fallback flow (DB -> JSON -> Config) when database connection is offline.
  - role: builder
  - files: app/Http/Controllers/PortfolioController.php
  - contract: Update index method to catch database exception, call ProjectLoader, and catch ProjectLoader exceptions to fall back to config fallback_projects.
  - acceptance: Controller falls back to JSON or config gracefully under exception.
  - verify: docker compose exec app php artisan test --filter="successfully loads the portfolio homepage"
  - depends: T2
  - requirements: 3

- [x] T6 — Update PortfolioTest feature tests ✓ complete · evidence: verified: `docker compose exec app php artisan test --filter=PortfolioTest` → exit 0 @ 994072e4a148ed759daff449653f17950df755c8 (2026-06-15T18:21:32.654190427Z) · 2026-06-15T18:21:37.609442306Z
  - why: Ensure the fallback behavior is fully verified by feature tests.
  - role: verifier
  - files: tests/Feature/PortfolioTest.php
  - contract: Update feature tests to assert correct rendering under DB connected, DB disconnected with JSON present, and DB disconnected with JSON missing scenarios.
  - acceptance: Feature tests pass successfully.
  - verify: docker compose exec app php artisan test --filter=PortfolioTest
  - depends: T5
  - requirements: 3
