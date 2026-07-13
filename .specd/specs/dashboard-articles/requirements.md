# Requirements — dashboard-articles

Authenticated dashboard for creating, editing, and publishing blog articles.

## Functional

- **R1** When user navigates `/articles/create`, system shall render create-article form (title, excerpt, body, publish toggle, submit).
- **R2** When user submits create form with valid data (title ≥3 chars, body ≥10 chars), system shall create Article record with author_id = current user, published_at = NOW if publish toggle on.
- **R3** When user navigates `/articles`, system shall display paginated list of user's articles (title, status [draft/published], created_at, edit/delete links); 10 per page.
- **R4** When user navigates `/articles/{id}/edit`, system shall render edit form pre-populated with article data; submit updates article and redirects to list.
- **R5** When user clicks delete on article, system shall remove record after user confirms; redirect to list.
- **R6** When article publish_at is NULL, article status shown as "draft"; when publish_at ≤ NOW, status shown as "published".
- **R7** When user not authenticated, system shall redirect `/articles*` routes to login.
- **R8** When user modifies another user's article, system shall return 403 Forbidden.

## Non-Functional

- **R9** Form validation errors shown inline with field labels; no page reload required (client-side validation minimum).
- **R10** Dashboard responsive 320px–2560px viewport width, mobile-first Tailwind CSS.
- **R11** All user input sanitized; SQL injection, XSS, CSRF attacks prevented via Laravel middleware.
- **R12** Article body stored as plain text; rendered with `e()` escape in views.
- **R13** Soft-delete not required; hard delete OK for MVP.
