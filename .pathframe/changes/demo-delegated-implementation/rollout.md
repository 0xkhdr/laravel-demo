---
schema: pathframe.rollout/v1
profile: okf-markdown/v1
---

## Steps

- Complete T1 through T6 in dependency order; after every Pinky result submit the exact structured result, inspect scope, run Pathframe verification, and semantically accept or request changes.
- Run the final focused feature test and the full approved test suite in T6.

## Rollback

- If a task fails, use Pathframe request-changes/recovery and preserve the recorded state. If the complete change must be abandoned, stop at a documented blocker; do not delete `.pathframe/` or rewrite history.

## Questions

- none
