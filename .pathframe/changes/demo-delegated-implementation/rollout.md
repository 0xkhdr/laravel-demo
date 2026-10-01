---
schema: pathframe.rollout/v1
profile: okf-markdown/v1
---

## Steps

- Complete T1 through T6 in dependency order; recovery added T7 for preference persistence and T8 for the stale unit expectation before retrying T6. After every Pinky result submit the exact structured result, inspect scope, run Pathframe verification, and semantically accept or request changes.
- Run the final focused feature test and the full approved test suite in T6.

## Rollback

- If a task fails, use Pathframe request-changes/recovery and preserve the recorded state. If the complete change must be abandoned, stop at a documented blocker; do not delete `.pathframe/` or rewrite history.

## Questions

- none
