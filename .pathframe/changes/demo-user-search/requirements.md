---
schema: pathframe.requirements/v1
profile: okf-markdown/v1
---

## Requirements

- REQ-1: The user list endpoint accepts optional `search` and `per_page` query parameters.
- REQ-2: Search matches partial name or email values and returns an empty `data` collection when nothing matches.
- REQ-3: `per_page` is an integer constrained to the approved lower and upper bounds; invalid values receive Laravel validation errors.
- REQ-4: Requests with no parameters retain the existing pagination shape and default page size.
- REQ-5: Implementation uses existing Laravel facilities, adds no dependency, and changes no schema.

## Acceptance

- Focused API tests cover default behavior, matching search, no match, and pagination bounds.
- The approved verification commands pass.

## Questions

- none
