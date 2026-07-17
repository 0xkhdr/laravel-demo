<!-- specd:managed:steering/tech.md:v3 begin -->
# Steering: Tech

> Fill this in for your project. Replace the prompts below with your real stack and
> constraints. The harness reads these before proposing changes.

## Stack
- **Language / runtime:** PHP 8.3, Laravel 13
- **Build / test:** `composer install`, `./vendor/bin/pest` or `make test`
- **Dependencies:** Composer (Pest, PHPStan, Pint); Docker optional for consistency

## Invariants (do not break without a recorded decision)
- All API responses include Content-Type: application/json and explicit status codes
- Email uniqueness constraint enforced at DB schema layer; duplicate email → 422 Unprocessable Entity
- Password always hashed on write (never stored plaintext); migrations fully reversible with down()
- All tests pass before merge: `pest` exit 0, `phpstan` exit 0, `pint --check` exit 0
<!-- specd:managed:steering/tech.md:v3 end -->
