---
schema: pathframe.design/v1
profile: okf-markdown/v1
---

## Approach

Add the missing controller behind the already-referenced `UserController`, register `GET /api/users`, validate query input in the controller, apply conditional Eloquent filters, order by newest users, and paginate with the existing default of 10. Extend the existing feature test file with the requested focused cases.

## Decisions

- Keep the change in the route/controller/test path; the `User` model and users migration require no changes.
- Use Laravel controller validation and Eloquent `when`/`where` query construction; do not add a service layer or dependency.
- Use `per_page` bounds of 1–50, retaining the current default of 10 when omitted.

## Questions

- none
