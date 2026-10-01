---
schema: pathframe.intent/v1
profile: okf-markdown/v1
---

## Summary

Extend the existing user-list API surface to support optional name/email search and bounded `per_page` pagination while preserving the no-parameter response contract.

## Outcomes

- `GET /api/users` continues returning the current paginated user JSON when called without parameters.
- `search` filters users by a partial match against `name` or `email`.
- `per_page` is validated and bounded, with focused coverage for the bounds.
- No database schema or dependency changes are made.

## Non-goals

- none

## Questions

- none
