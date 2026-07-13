# Design — dashboard-articles

Authenticated dashboard for article CRUD. Reuses Article model from portfolio-landing.

## Modules

**Dashboard Controller** (`app/Http/Controllers/ArticleDashboardController.php`)
- GET `/articles` — list user's articles (paginated, 10/page)
- GET `/articles/create` — show create form
- POST `/articles` — store article (validate, create, redirect)
- GET `/articles/{id}/edit` — show edit form
- PUT `/articles/{id}` — update article (validate, update, redirect)
- DELETE `/articles/{id}` — delete article (confirm, hard delete, redirect)

**Middleware: Article Ownership** (`app/Http/Middleware/ArticleOwnership.php`)
- Routes: PATCH/PUT/DELETE `/articles/{id}`
- Check: if Article.author_id !== Auth::id(), return 403

**Views**
- `resources/views/articles/index.blade.php` — list, search, pagination
- `resources/views/articles/create.blade.php` — form (create mode)
- `resources/views/articles/edit.blade.php` — form (edit mode)
- `resources/views/components/article-form.blade.php` — reusable form (create + edit)
- `resources/css/app.css` — Tailwind dashboard styles (responsive)

**Routes** (`routes/web.php`)
- POST `/login`, GET `/login` — auth (assume Laravel auth scaffold exists)
- GET/POST/PUT/DELETE `/articles*` — dashboard routes under `auth` middleware

## On-disk contracts

| File | Responsibility | Mutation |
|------|---|---|
| `app/Http/Controllers/ArticleDashboardController.php` | Route dashboard, CRUD logic | New |
| `app/Http/Middleware/ArticleOwnership.php` | Verify user owns article | New |
| `routes/web.php` | Add `/articles*` routes, auth group | Edit |
| `resources/views/articles/index.blade.php` | List view with pagination | New |
| `resources/views/articles/create.blade.php` | Create form view | New |
| `resources/views/articles/edit.blade.php` | Edit form view | New |
| `resources/views/components/article-form.blade.php` | Shared form component | New |
| `resources/css/app.css` | Dashboard-specific styles | Edit |
| `app/Models/Article.php` | Reuse from portfolio-landing | No change |
| `database/migrations/create_articles_table.php` | Reuse from portfolio-landing | No change |

## Invariants

- **Auth required:** All `/articles*` routes require `auth` middleware; unauthenticated requests redirect to login.
- **Ownership enforced:** Only article author can edit/delete their articles; 403 for unauthorized access.
- **Draft vs published:** Articles with `published_at = NULL` are drafts; `published_at ≤ NOW` are published.
- **Input sanitized:** All user input validated server-side; body escaped with `e()` in views; CSRF tokens on all forms.
- **Graceful errors:** Form errors shown inline; no 500 errors on validation failure; redirect on success.
- **Mobile responsive:** All views render correctly 320px–2560px; no horizontal scroll.
- **No external calls:** Dashboard is entirely local (no API calls, no GitHub sync).
