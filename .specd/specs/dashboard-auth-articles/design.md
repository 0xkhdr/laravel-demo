# Design — dashboard-auth-articles

> Name module boundaries, on-disk contracts, and preserved invariants.
> The design gate reads this file before tasks execute.

## Modules

**Authentication Controller** (`app/Http/Controllers/AuthController.php`)
- GET `/login` — show login form (redirect to /articles if authenticated)
- POST `/login` — accept credentials, validate, establish session or show error
- POST `/logout` — destroy session, redirect to homepage

**Login View** (`resources/views/auth/login.blade.php`)
- Display email/password form with CSRF token
- Show error messages on failed authentication
- Link to register (if applicable)

**Authentication Middleware** (`app/Http/Middleware/EnsureAuthenticated.php`)
- Check if user is authenticated; redirect to /login if not
- Guard all article routes

**Article Dashboard Controller** (`app/Http/Controllers/ArticleDashboardController.php`)
- GET `/articles` — list user's articles (paginated, ≥10/page)
- GET `/articles/create` — show create form
- POST `/articles` — store article (validate, create, redirect)
- GET `/articles/{id}/edit` — show edit form
- PUT `/articles/{id}` — update article (validate, update, redirect)
- DELETE `/articles/{id}` — delete article (verify ownership, delete, redirect)

**Article Ownership Middleware** (`app/Http/Middleware/ArticleOwnership.php`)
- Verify article belongs to authenticated user
- Return 403 Forbidden if ownership check fails
- Apply to edit/delete routes

## On-disk contracts

| File | Responsibility | Mutation |
|------|---|---|
| `app/Http/Controllers/AuthController.php` | Login/logout logic, form submission | New |
| `app/Http/Middleware/EnsureAuthenticated.php` | Auth guard for dashboard routes | New |
| `resources/views/auth/login.blade.php` | Login form UI | New |
| `routes/web.php` | Auth routes and article routes | Edit |
| `app/Http/Controllers/ArticleDashboardController.php` | Article CRUD logic | Reuse from dashboard-articles |
| `app/Http/Middleware/ArticleOwnership.php` | Ownership validation for edit/delete | Reuse from dashboard-articles |
| `resources/views/articles/index.blade.php` | Article list view | Reuse from dashboard-articles |
| `resources/views/articles/create.blade.php` | Create form | Reuse from dashboard-articles |
| `resources/views/articles/edit.blade.php` | Edit form | Reuse from dashboard-articles |
| `app/Models/Article.php` | Article model with user relationship | Reuse from dashboard-articles |
| `app/Models/User.php` | User model with articles relationship | Edit |
| `database/migrations/create_users_table.php` | Users table (id, email, password) | Ensure exists |
| `database/migrations/create_articles_table.php` | Articles table with user_id FK | Reuse from dashboard-articles |

## Invariants

- Auth required: All `/articles*` routes require auth middleware; unauthenticated redirect to /login
- Session isolation: User can only view/edit their own articles; 403 on unauthorized access
- Email uniqueness: No two users share email; enforced at DB and validation layer
- Ownership chain: articles.user_id must match authenticated user or middleware rejects
- Login validation: Failed login shows error; valid credentials establish session
- Logout clears session: All stored auth state removed immediately on logout
