---
schema: pathframe.recovery/v1
profile: okf-markdown/v1
---

## Failures

- Missing actor-context decision.
- Migration or focused tests fail.
- Changed files exceed the approved task scope.

## Recovery

- Ask the user to choose the actor-context behavior; do not implement attribution by assumption.
- Inspect the failure, request changes or revise the affected task, then rerun its approved verification.
- Preserve unrelated changes and request a keep/revert/replan decision before proceeding.

## Questions

- none
