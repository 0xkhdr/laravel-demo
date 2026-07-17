# Design — test

> Implementation strategy for requirements. Architecture, contracts, traceability, failure modes, dependencies.

## Traceability to requirements

| Requirement | Implementation | File(s) |
| --- | --- | --- |
| R1.1, R1.2 | REST routing via Laravel API conventions | `routes/api.php`, Controllers |
| R2.1, R2.2 | User model + migrations | `app/Models/User.php`, `database/migrations/*` |
| R3.1, R3.2 | Code cleanup, style enforcement | `.github/workflows/*`, `phpstan.neon`, `pint.json` |
| R4.1, R4.2 | Pest test framework + test database | `tests/*`, `phpunit.xml` |

## System decomposition

### API Layer (routes/api.php, app/Http/Controllers/)

references: R1.1, R1.2
owner: 0xkhdr
boundaries: HTTP request boundary; Laravel routing gate
interfaces:
- Input: POST/GET/PUT/DELETE requests with JSON payloads on `/api/users/*`
- Output: JSON responses with status codes (200/201/400/404/422/500)
invariants: All responses include Content-Type: application/json; all endpoints return status code, no bare error strings
failure:
- Malformed JSON → 400 Bad Request
- Invalid/missing model → 404 Not Found
- DB constraint violation (e.g., duplicate email) → 422 Unprocessable Entity
integration: Routes map to Controllers; Controllers use Models for persistence; Validators throw on invalid input

### User Model (app/Models/User.php)

references: R2.1, R2.2
owner: 0xkhdr
boundaries: ORM/database entity; Eloquent model contract
interfaces:
- Schema: id, name, email, password, email_verified_at, remember_token, created_at, updated_at
- Scopes: all(), active(), verified()
invariants: Email is unique per user; timestamps (created_at, updated_at) auto-managed; password always hashed on write
failure: DB duplicate key on email → PDO exception caught by handler, returns 422
integration: Models are loaded by route model binding; Filled by FormRequest validation; Persisted via Laravel save()

### Migrations (database/migrations/)

references: R2.2
owner: 0xkhdr
boundaries: Schema definition/versioning layer
interfaces:
- Syntax: Laravel migration class with up() and down() methods
- Idempotence: Every migration must be fully reversible (down() recreates original state)
invariants: All migrations use Laravel naming conventions; foreign keys CASCADE on delete where appropriate; no data migration (schema only)
failure: Migration throws → rollback triggered, no orphaned schema left behind
integration: Run via `php artisan migrate`; tracked in migrations table; errors block deployment

### Tests (tests/)

references: R4.1, R4.2
owner: 0xkhdr
boundaries: Test framework boundary; Pest framework
interfaces:
- Syntax: Pest 3.x test syntax (expect(), test(), it() macros)
- Database: SQLite in-memory or separate test DB; cleaned/rolled back per test
invariants: Tests are isolated (no cross-test dependencies); use factories for seeding; assertions explicit and verifiable
failure: Test fails → blocking CI, must fix code or test before merge
integration: Run via `php artisan test`; uses phpunit.xml config; reports to CI pipeline

## Key decisions and rationale

### Framework choice: Laravel 13
- Rationale: Modern PHP MVC framework, strong ecosystem, educational value for architectural patterns
- Tradeoff: Higher startup time vs. developer productivity and maintainability

### API-only scope (no frontend)
- Rationale: Separates concerns, simpler demo, allows flexible client implementation
- Tradeoff: No full-stack reference; separate frontend project can integrate

### Pest for testing
- Rationale: Cleaner, more expressive syntax than PHPUnit; faster test authoring
- Tradeoff: Smaller ecosystem than PHPUnit; fewer third-party integrations

### Cleaned codebase (no unused routes/controllers)
- Rationale: Reduces cognitive load, clarifies intent, easier onboarding
- Tradeoff: Must maintain discipline as project grows; risks premature cleanup

## Invariants and constraints

1. **Database consistency**: All writes must preserve referential integrity (cascade deletes on Users if dependencies added)
2. **HTTP semantics**: GET operations are idempotent; POST creates new resources; PUT updates; DELETE removes
3. **Authentication readiness**: User model includes password field; auth layer can be added without schema changes
4. **Migration reversibility**: Every `up()` must have corresponding `down()` that leaves zero artifacts

## Recovery and edge cases

| Scenario | Behavior | Code path |
| --- | --- | --- |
| POST with duplicate email | Return 422 Unprocessable Entity; client retries with different email | Validator in Controller |
| GET non-existent user | Return 404 Not Found | Route model binding or explicit `findOrFail()` |
| Database connection lost | Return 503 Service Unavailable (after PDO exception) | Laravel exception handler |
| Malformed JSON | Return 400 Bad Request | Laravel JSON validation middleware |
| Missing required field | Return 422 Unprocessable Entity | FormRequest validation |

## Dependencies

- PHP 8.3+
- Laravel 13.x
- Pest 3.x (testing)
- Composer (dependency management)
- SQLite or MySQL (runtime database)

## Deployment context

- Stateless API: scales horizontally (no session affinity needed)
- Database: externalized (separate connection string per environment)
- Environment vars: `.env` for local dev, CI/CD injects for deployed stages
- CI gates: phpstan, pint, Pest tests must pass before merge

## Future extension points (non-goals; for reference)

- Authentication layer: Middleware for JWT/Sanctum (User model ready)
- Authorization: Policies/gates system (Laravel built-in)
- Rate limiting: Middleware chain (Laravel throttle)
- Logging/observability: Monolog integration (Laravel built-in)
