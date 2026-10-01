---
schema: pathframe.risks/v1
profile: okf-markdown/v1
---

## Risks

- Attribution could be forged or ambiguous if public requests are treated as authenticated activity.
- Metadata could become a secret-bearing dump if arbitrary request data is persisted.
- A per-user retention trim can be incorrect if ordering is unstable.
- A user-scoped endpoint could leak another user's activity without an explicit authorization check.

## Mitigations

- Block implementation until actor context is explicitly chosen; test unauthenticated and unauthorized paths.
- Persist only an allowlisted event name and deliberately constructed metadata; never serialize credentials or full requests.
- Use created_at plus descending ID ordering and test the 101-event boundary.
- Require the approved user identity before querying the event relation.

## Questions

- none
