# Design — portfolio-landing

Laravel portfolio landing page. Displays articles, GitHub repos, and contact options.

## Modules

**Landing Page Controller** (`app/Http/Controllers/LandingController.php`)
- Fetches latest 5 articles from blog posts table
- Fetches latest 5 GitHub repos (via API or cached DB)
- Renders homepage view with sections

**Blog Article Model** (`app/Models/Article.php`)
- Represents published blog posts: title, excerpt, slug, body, published_at, author_id
- Scope: `published()` — filters to published_at ≤ now
- Scope: `latest()` — orders by published_at DESC

**GitHub Repo Sync** (`app/Console/Commands/SyncGitHubRepos.php`)
- Scheduled command (daily) pulls user's public repos via GitHub API
- Stores/updates: name, description, url, stars, forks, language, updated_at
- Caches result 24h to avoid API throttling

**Views**
- `resources/views/landing.blade.php` — hero + articles + repos + footer + contact CTA
- `resources/views/components/article-card.blade.php` — reusable article card
- `resources/views/components/repo-card.blade.php` — reusable repo card

## On-disk contracts

| File | Responsibility | Mutation |
|------|---|---|
| `app/Http/Controllers/LandingController.php` | Route landing page, load data | New or edit if exists |
| `app/Models/Article.php` | Article model with scopes | New or edit if exists |
| `app/Models/GitHubRepo.php` | GitHub repo model | New if needed |
| `app/Console/Commands/SyncGitHubRepos.php` | Fetch repos from GitHub API | New if needed |
| `routes/web.php` | Route `/` to LandingController | Edit: add route |
| `resources/views/landing.blade.php` | Homepage template | New or edit |
| `config/services.php` | Store GitHub token/username | Edit: add `github` config |
| `.env.example` | Document required env vars | Edit: add `GITHUB_USERNAME`, `GITHUB_TOKEN` |
| `database/migrations/create_articles_table.php` | Article schema | New if needed |
| `database/migrations/create_github_repos_table.php` | GitHub repo schema | New if needed |

## Invariants

- **Published articles only:** Article displayed on landing must have `published_at IS NOT NULL AND published_at <= NOW()`.
- **External link safety:** All outbound links (GitHub, articles, contact) open in `target="_blank" rel="noopener noreferrer"`.
- **Mobile responsive:** Landing page renders correctly on viewport widths 320px–2560px; no horizontal scroll.
- **Data freshness:** GitHub repos refreshed at most once per 24h; stale data acceptable after that window.
- **No sensitive data:** GitHub token never logged or exposed in views; stored only in `.env`.
- **Fallback graceful:** If GitHub API unavailable, landing renders without repos section; no 500 error.
