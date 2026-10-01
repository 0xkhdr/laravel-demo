---
schema: pathframe.design/v1
profile: okf-markdown/v1
---

## Approach

Use the existing `UserController`, `routes/api.php`, session `auth` middleware, route model binding, Eloquent casts, request validation, and `activityEvents()` relationship. Implement the smallest sequential slices: persistence, authorization, read, update, event, then tests/final verification.

## Decisions

- Owner authorization follows the existing activity endpoint convention: authenticated non-owners receive 404, avoiding resource disclosure.
- Preferences are selected explicitly in JSON rather than serializing the whole user model.
- PATCH accepts partial updates and uses Laravel validation with an allowlisted field set; no raw request data is stored in activity metadata.
- Each task is delegated to Pinky with a disjoint intended write scope and accepted only after Brain semantic review plus Pathframe verification.

## Questions

- none
