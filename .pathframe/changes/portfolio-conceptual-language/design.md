---
schema: pathframe.design/v1
profile: okf-markdown/v1
---

## Approach

Edit the canonical portfolio configuration and the career knowledge base only. Reuse the existing view and test structure; no new abstraction or dependency is needed. Update the CDC description to generic concepts already supported by the knowledge base, and update the public experiment name, URL, and associated prose to Pathframe.

## Decisions

- Change the portfolio-facing CDC text, not the technical stack or claims.
- Treat `config/portfolio.php` as the rendered portfolio source and `mohamed-khedr-career-knowledge-base.md` as the related canonical reference that must stay consistent.
- Verify with targeted search plus the existing portfolio feature test.

## Questions

- none
