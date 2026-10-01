---
schema: pathframe.design/v1
profile: okf-markdown/v1
---

## Approach

Use Laravel's migration, Eloquent relationship/model, route middleware already available in the application, request validation, and feature tests. Add one narrow audit table and model, one user-facing write integration after the actor decision, and one user-scoped read endpoint. Enforce the demo's 100-event bound in the write path and select events by created_at descending followed by ID descending.

## Decisions

- Proposed event fields: id, user_id, event (short string), metadata (nullable JSON containing allowlisted non-secret values), created_at, and updated_at only if required by Laravel convention.
- Proposed retention: keep the newest 100 events per user for this disposable demo; no scheduler or production archival process.
- Proposed ordering: created_at descending, then id descending.
- Proposed authorization: deny reads unless the approved actor context authorizes the requested user; do not expose a global/admin listing.
- Actor attribution: use the authenticated user from Laravel's existing auth context; reject unauthenticated writes and reads. Do not treat a route parameter as actor identity.

## Questions

- none
