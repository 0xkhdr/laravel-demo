---
schema: pathframe.design/v1
profile: okf-markdown/v1
---

## Approach

Add the smallest route implementation, commit an empty Unit test directory marker, and configure the base test case to use `sys_get_temp_dir()` for compiled views.

## Decisions

- Keep production storage configuration unchanged; the writable compiled-view path is test-only.

## Questions

- none
