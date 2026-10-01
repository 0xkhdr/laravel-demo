---
schema: pathframe.requirements/v1
profile: okf-markdown/v1
---

## Requirements

- REQ-1: Audit events belong to one user and contain only a safe event name, safe JSON metadata, created_at, and ID; no secrets or raw credentials.
- REQ-2: The demo retention assumption is at most 100 events per user; the write path removes older events after a successful insert.
- REQ-3: The read endpoint returns only the requested user's events, newest first with descending ID tie-breaking, and denies access when the approved actor context does not authorize that user.
- REQ-4: The write integration records the smallest existing user-facing action justified by the approved actor-context decision.

## Acceptance

- Migration/model, write integration, read endpoint, and focused tests are present within approved scope.
- Tests prove fields exclude credentials, retention is bounded, ordering is deterministic, and unauthorized reads do not disclose events.
- The approved actor-context decision is reflected in route middleware/controller behavior and tests.

## Questions

- none
