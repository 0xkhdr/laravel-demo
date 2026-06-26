# Structure — Repo layout & module boundaries

Portfolio platform. Laravel 13 with landing page, article publishing, package directory. See: app/, routes/, .specd/steering/product.md

## Layout

- **app/** — Source code
  - **Models/** — Article, Package, Project models
  - **Http/Controllers/** — Request handlers
    - **Web/** — Landing page, article/package views
    - **Api/** — JSON endpoints for articles, packages
  - **Providers/** — Service providers
- **routes/** — Route definitions
  - **web.php** — Public pages (/, /articles, /articles/{slug}, /packages, /projects)
  - **api.php** — JSON APIs (/api/articles, /api/packages)
- **resources/views/** — Landing page, article layout, package showcase
- **database/migrations/** — Articles, packages, projects tables
- **storage/** — Article markdown files, images
- **public/** — Static assets
- **tests/** — Feature & unit tests

## Pages / Web Routes

- **GET /** — Landing page (hero, featured projects, recent articles)
- **GET /articles** — Article listing
- **GET /articles/{slug}** — Article detail (rendered markdown)
- **GET /packages** — Package directory
- **GET /projects** — Projects showcase

## API Routes

- **GET /api/articles** — List articles (JSON)
- **GET /api/articles/{slug}** — Article detail (JSON)
- **GET /api/packages** — List packages (JSON)

## Module boundaries

- Web routes serve rendered Blade views
- API routes return JSON for frontends/clients
- Models (Article, Package, Project) encapsulate data/relationships
- Controllers route requests to models/views
- Markdown storage: raw files in storage/, parsed on read

## Naming

- **Routes**: kebab-case (get /articles, /articles/my-post-title)
- **Models**: PascalCase (Article, Package, Project)
- **Controllers**: PascalCase + Controller (ArticleController, PackageController)
- **Methods**: RESTful (index, show for GET; store for POST)
- **Files**: snake_case for blade templates (article_detail.blade.php)
- **Slugs**: kebab-case, auto-generated from title or explicit
