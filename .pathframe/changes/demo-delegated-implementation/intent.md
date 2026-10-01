---
schema: pathframe.intent/v1
profile: okf-markdown/v1
---

## Summary

Add authenticated, owner-only user-preferences read/update endpoints backed by three users-table columns and a non-sensitive activity event, while preserving existing API contracts.

## Outcomes

- Preferences are stored with the requested defaults and boolean/string casts.
- Authenticated owners can read and patch only their own preferences.
- Unknown or invalid update fields are rejected by Laravel validation.
- Successful updates record `preferences.updated` without request payloads or secrets.
- Focused feature tests and the approved verification commands pass.

## Non-goals

- none

## Questions

- none
