---
schema: pathframe.intent/v1
profile: okf-markdown/v1
---

## Summary

Design a bounded, user-scoped activity audit trail for the Laravel demo. The approved design requires an authenticated user boundary before audit writes or reads; unauthenticated public requests do not create or disclose audit activity.

## Outcomes

- A migration and Eloquent model define an audit event tied to a user, with an event name, safe structured metadata, and timestamps.
- The approved design excludes passwords, tokens, raw credentials, and arbitrary request payloads; retention is bounded to the demo's latest 100 events per user, enforced when writing.
- Events are returned newest first, with a stable tie-breaker by descending ID, and reads are authorized to the relevant user only.
- Focused tests cover safe fields, bounded retention, ordering, write behavior, read authorization, and empty results.

## Non-goals

- No admin UI, package, authentication system, or unrelated user API changes.
- No new authentication system or admin UI is added; existing Laravel authentication primitives are used, and the demo remains blocked if no authenticated actor can be established.

## Questions

- Actor context: approved choice is an authenticated user boundary. The current demo has no login flow, so implementation must stop if the existing application cannot provide an authenticated actor without inventing credentials or auth behavior.
