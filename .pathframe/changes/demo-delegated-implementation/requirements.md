---
schema: pathframe.requirements/v1
profile: okf-markdown/v1
---

## Requirements

- REQ-1: Add `timezone` (string, default `UTC`), `email_notifications` (boolean, default `true`), and `marketing_notifications` (boolean, default `false`) to users, with model casts/default behavior.
- REQ-2: Add authenticated owner-only `GET` and `PATCH /api/users/{user}/preferences`; non-owners must not access the resource.
- REQ-3: GET exposes only user id and the three preference fields; PATCH validates supplied fields, rejects unknown/invalid values, persists changes, and returns the preference resource.
- REQ-4: A successful PATCH records activity event `preferences.updated` with no secrets or raw request data.
- REQ-5: Existing routes and response contracts remain unchanged; no packages, queues, frontend, unrelated schema, or service layer are added.

## Acceptance

- The six approved tasks are completed in dependency order, each delegated result is scope-checked and freshly verified, and final focused tests pass.

## Questions

- none
