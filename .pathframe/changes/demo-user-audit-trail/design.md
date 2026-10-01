---
schema: pathframe.design/v1
profile: okf-markdown/v1
---

## Approach

Use Laravel's existing session guard, Auth primitives, route middleware, request validation, migration, Eloquent relationship/model, and feature tests. Add minimal session login/logout routes, one narrow audit table and model, a login activity write, and one user-scoped read endpoint. Enforce the demo's 100-event bound in the write path and select events by created_at descending followed by ID descending.

## Decisions

- Proposed event fields: id, user_id, event (short string), metadata (nullable JSON containing allowlisted non-secret values), created_at, and updated_at only if required by Laravel convention.
- Proposed retention: keep the newest 100 events per user for this disposable demo; no scheduler or production archival process.
- Proposed ordering: created_at descending, then id descending.
- Proposed authorization: require the session web guard and allow a user to read only their own events; do not expose a global/admin listing.
- Actor attribution: use the authenticated session user; reject unauthenticated writes and reads. Do not treat a route parameter as actor identity.
- Authentication scope: add only login/logout for this demo, using existing password hashing and session guard; no token system, registration, password reset, or package.

## Questions

- none
