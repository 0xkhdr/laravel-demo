---
schema: pathframe.design/v1
profile: okf-markdown/v1
---

## Approach

Use a route closure in the existing API routes file and one focused Pest feature test.

## Decisions

- Keep the implementation within the two requested files; no controller or new abstraction.
- Use Laravel's native JSON response behavior and Pest/Laravel response assertions.

## Questions

- none
