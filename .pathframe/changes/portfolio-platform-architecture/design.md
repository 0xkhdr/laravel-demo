---
schema: pathframe.design/v1
profile: okf-markdown/v1
---

## Approach

1. Establish the minimum Tailwind/Alpine/Livewire integration compatible with Laravel 13 and the existing asset workflow.
2. Extract the current page into reusable Blade layout/partial boundaries and Tailwind utility classes. Keep the page server-rendered for SEO, first paint, and no-JavaScript reading.
3. Use Alpine for browser-local state: responsive menu, theme preference, and disclosure controls. Add Livewire only if a concrete feature needs server validation or dynamic server state.
4. Keep content in `config/portfolio.php` initially. Introduce a small typed presenter/data object only if transformation or validation becomes non-trivial; do not create repositories or a database for static content.
5. Keep controllers thin and test behavior at the HTTP/view boundary. Add accessibility and asset-build checks, then verify Docker and production asset loading.

## Decisions

- TALL means Tailwind CSS + Alpine.js + Laravel + Livewire.
- Use a modular monolith, not microservices. Laravel’s routing, Blade, config, queues, and testing primitives fit the current scope.
- Prefer Blade for static content, Alpine for client-only state, and Livewire only for server-backed interaction. Do not turn a portfolio landing page into an SPA.
- Preserve configuration-backed portfolio content. Add persistence only when runtime editing or publishing is explicitly needed.
- Use Form Requests, Policies, API Resources, Actions, or Jobs only at the boundary where their behavior is needed.
- Treat accessibility, semantic HTML, escaping, performance, and reduced motion as acceptance criteria.
- Keep the existing `/api/ping` endpoint and Docker/Makefile workflow compatible.

## Questions

- none
