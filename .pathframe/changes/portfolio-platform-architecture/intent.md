---
schema: pathframe.intent/v1
profile: okf-markdown/v1
---

## Summary

Evolve the existing Laravel 13 portfolio into a polished TALL-stack experience: Tailwind CSS for the visual system, Alpine.js for small browser interactions, and Livewire only where server-backed interaction is justified. Preserve the current portfolio’s accessibility while establishing a clean Laravel-native application boundary that remains easy to test, deploy, and extend.

## Outcomes

- The home page presents the portfolio with a coherent responsive design system, keyboard support, reduced-motion support, useful metadata, and fast first render.
- Frontend interactions use the smallest appropriate TALL layer and core content/navigation remain useful without JavaScript.
- Portfolio content remains centralized and validated at the application boundary rather than duplicated across templates or client code.
- Laravel code follows framework conventions: thin controllers, explicit response boundaries, focused domain services only where behavior warrants them, and feature tests for observable behavior.
- The existing route, content, Docker workflow, and test commands remain compatible.

## Non-goals

- No CMS, admin panel, authentication flow, database-backed portfolio editor, or public write API.
- No microservices, repository/interface layer, event bus, or custom design-system package without a demonstrated need.

## Questions

- none
