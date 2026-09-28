---
schema: pathframe.requirements/v1
profile: okf-markdown/v1
---

## Requirements

- REQ-1: Register `GET /api/ping` in `routes/api.php`.
- REQ-2: Return exactly `{"data":{"status":"ok"}}` as JSON with HTTP 200.
- REQ-3: Add a Pest feature test at `tests/Feature/Api/PingTest.php`.

## Acceptance

- `php artisan test --compact tests/Feature/Api/PingTest.php` exits successfully.
- The feature test confirms status 200 and the exact JSON response `{"data":{"status":"ok"}}`.

## Questions

- none
