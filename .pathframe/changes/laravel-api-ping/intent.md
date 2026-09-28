---
schema: pathframe.intent/v1
profile: okf-markdown/v1
---

## Summary

Add a minimal Laravel API health endpoint at `GET /api/ping`.

## Outcomes

- The endpoint responds with HTTP 200 and exactly `{"data":{"status":"ok"}}`.
- A Pest feature test proves the response contract.

## Non-goals

- none

## Questions

- none
