# Requirements — dashboard-auth-articles

> Author EARS-shaped requirements. Each is testable and unambiguous.

## Authentication

- **R1** When user navigates to `/articles`, if unauthenticated, the system shall redirect to `/login`.
- **R2** When user submits credentials at `/login`, the system shall verify email + password against users table and establish session if valid.
- **R3** When user submits invalid credentials, the system shall display "Invalid email or password" error on `/login`.
- **R4** When user clicks logout, the system shall destroy session and redirect to homepage.
- **R5** When user is authenticated, the system shall display user email in dashboard header.

## Article Dashboard

- **R6** When user accesses `/articles`, the system shall display list of articles owned by authenticated user.
- **R7** When articles exceed 10 items, the system shall paginate with ≥10 articles per page.
- **R8** When user clicks "New Article", the system shall show form with fields: title, slug, body, featured_image, published.
- **R9** When user submits valid article form, the system shall create article linked to user and redirect to articles list.
- **R10** When user clicks edit on an article, the system shall populate form with article data and allow changes.
- **R11** When user clicks delete on an article, the system shall remove article from database.
- **R12** When user attempts to edit/delete another user's article, the system shall reject with 403 Forbidden.
- **R13** When article list loads, the system shall show title, slug, status (published/draft), and action buttons per row.
