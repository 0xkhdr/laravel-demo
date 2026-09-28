---
schema: pathframe.intent/v1
profile: okf-markdown/v1
---

## Summary

Add a small Laravel web endpoint that exposes a fixed health-style JSON response.

## Outcomes

- `GET /pathframe-demo` returns HTTP 200 with JSON `{"status":"ok"}`.
- A focused Pest feature test protects the endpoint contract.

## Non-goals

- Authentication, persistence, controllers, or additional endpoint behavior.

## Questions

- none
