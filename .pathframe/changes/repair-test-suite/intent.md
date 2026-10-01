---
schema: pathframe.intent/v1
profile: okf-markdown/v1
---

## Summary

Repair the test suite's missing API route, missing Unit directory, and test-only view compilation permissions.

## Outcomes

- `php artisan test --compact` runs without bootstrap errors.
- The API ping and portfolio feature tests pass.

## Non-goals

- none

## Questions

- none
