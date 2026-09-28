---
schema: pathframe.requirements/v1
profile: okf-markdown/v1
---

## Requirements

- REQ-1: The production Kafka + Debezium CDC copy must focus on backend concepts and omit the system names AVL, Taxi, and Fleet.
- REQ-2: The public experiments entry and all related portfolio knowledge-base references must use `pathframe` instead of `specd-cli`.
- REQ-3: The change must preserve the existing structure, links, and factual scope except for the requested naming and framing updates.

## Acceptance

- `rg -n -i "AVL|taxi|fleet|specd-cli" config/portfolio.php resources/views mohamed-khedr-career-knowledge-base.md` returns no affected production-copy names or retired project references, and the portfolio test suite passes.

## Questions

- none
