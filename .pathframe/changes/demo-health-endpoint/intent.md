---
schema: pathframe.intent/v1
profile: okf-markdown/v1
---

## Summary

Add a public `GET /api/health` endpoint with a stable JSON health response and one focused feature test.

## Outcomes

- `GET /api/health` returns HTTP 200 JSON with `status: ok` and a stable `application` identifier.
- A focused feature test covers the status, JSON shape, and JSON content type.

## Non-goals

- no package, database, authentication, frontend, or unrelated route changes

## Questions

- none
