---
schema: pathframe.intent/v1
profile: okf-markdown/v1
---

## Summary

Design a bounded, user-scoped activity audit trail for the Laravel demo, including the minimum session-authentication boundary needed to establish a trustworthy actor. Unauthenticated public requests do not create or disclose audit activity.

## Outcomes

- A migration and Eloquent model define an audit event tied to a user, with an event name, safe structured metadata, and timestamps.
- The approved design excludes passwords, tokens, raw credentials, and arbitrary request payloads; retention is bounded to the demo's latest 100 events per user, enforced when writing.
- Events are returned newest first, with a stable tie-breaker by descending ID, and reads are authorized to the relevant user only.
- Focused tests cover safe fields, bounded retention, ordering, write behavior, read authorization, and empty results.
- A minimal session login/logout boundary establishes the actor without adding a package or storing credentials in audit events.

## Non-goals

- No admin UI, package, token authentication, or unrelated user API changes.

## Questions

- none
