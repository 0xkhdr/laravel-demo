---
schema: pathframe.rollout/v1
profile: okf-markdown/v1
---

## Steps

- Apply the audit migration and model.
- Add the approved write integration and user-scoped read route.
- Run focused tests and inspect changed-file scope before accepting each task.

## Rollback

- Roll back the audit migration and remove only the approved audit files/routes if the task is rejected; do not alter existing user data or unrelated changes.

## Questions

- none
