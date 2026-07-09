# Tech

## Runtime
- PHP `^8.3`
- Laravel `^13.0`

## Test and Quality Tooling
- Pest `^4.4`
- Laravel Pint `^1.13`
- Faker, Mockery, and Collision for test support

## App Shape
- Traditional Laravel structure under `app/`, `routes/`, `database/`, and
  `resources/`
- User domain model in `app/Models/User.php`
- API routes in `routes/api.php`
- Web routes in `routes/web.php`
- Tests in `tests/Feature` and `tests/Unit`

## Local Runtime
The repo is Docker-oriented.
The stack includes the app container plus supporting services such as MySQL,
Redis, and Mailpit.

## Preferred Commands
- `make test`
- `vendor/bin/pint`
- `php artisan test` when a direct Laravel test run is useful
- `docker build --target production -t laravel-demo:latest .` for image checks

## Tech Constraints
- Keep changes compatible with the current Laravel version in `composer.json`
- Avoid adding dependencies unless the project needs them
- Prefer framework-native solutions over custom infrastructure
