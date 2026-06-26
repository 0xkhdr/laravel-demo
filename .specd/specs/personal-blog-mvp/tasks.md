# Tasks — Personal Blog MVP

## Wave 1
- [x] T1 — add article schema, config, and seed data ✓ complete · evidence: php artisan test --filter Article PASS · 2026-06-20T23:30:39.290756017Z
  - why: supports requirements 2, 3, and 5 by giving the site an article source and owner profile data
  - role: builder
  - files: config/portfolio.php, app/Models/Article.php, database/migrations/2026_06_21_000000_create_articles_table.php, database/factories/ArticleFactory.php, database/seeders/ArticleSeeder.php, database/seeders/DatabaseSeeder.php
  - contract: create the article persistence layer, published/latest scopes, demo content, and profile config; do not add auth or admin features
  - acceptance: articles can be seeded with title, slug, excerpt, body, and publication state, and query helpers return published items newest first
  - verify: php artisan test --filter Article
  - depends: —
  - requirements: 2, 3, 5

## Wave 2
- [x] T2 — add the public article API ✓ complete · evidence: specd verify evidenceRef 1efa6b8642872b1f506c4bb0b6d2a2a8; php artisan test --filter Api PASS · 2026-06-20T23:32:42.523275262Z
  - why: supports requirement 3 by exposing read-only JSON for the blog content
  - role: builder
  - files: routes/api.php, app/Http/Controllers/Api/ArticleController.php, app/Http/Resources/ArticleResource.php, app/Http/Resources/ArticleCollection.php
  - contract: implement public collection and show endpoints with pagination and resources; do not expose private fields or require authentication
  - acceptance: the API returns 200 for existing articles, 404 for missing articles, and readable unauthenticated JSON for the article feed
  - verify: php artisan test --filter Api
  - depends: T1
  - requirements: 3, 5

- [x] T3 — add the public web pages ✓ complete · evidence: specd verify evidenceRef aee5cee935c36b21974ef0ff4840de3f; php artisan test --filter Web PASS · 2026-06-20T23:34:22.546254308Z
  - why: supports requirements 1, 2, and 4 by presenting the homepage and article reading flow
  - role: builder
  - files: routes/web.php, app/Http/Controllers/Web/HomeController.php, app/Http/Controllers/Web/ArticleController.php, resources/views/layouts/app.blade.php, resources/views/pages/home.blade.php, resources/views/pages/articles/index.blade.php, resources/views/pages/articles/show.blade.php
  - contract: implement the homepage, article index, and article detail views with semantic Blade markup and empty-state handling
  - acceptance: the root page introduces the owner, shows latest articles, article pages render, and missing slugs return 404
  - verify: php artisan test --filter Web
  - depends: T1
  - requirements: 1, 2, 4

## Wave 3
- [x] T4 — implement Nothing.tech styling and motion rules ✓ complete · evidence: specd verify evidenceRef 1e986daf94836ba0eafba196934ff2ed; php artisan test --filter Theme PASS · 2026-06-20T23:37:31.382993679Z
  - why: supports requirements 1 and 4 by turning the public pages into the requested visual system
  - role: builder
  - files: package.json, vite.config.js, tailwind.config.js, postcss.config.js, resources/css/app.css, resources/js/app.js, resources/views/components/hero.blade.php, resources/views/components/section-header.blade.php, resources/views/components/article-card.blade.php, resources/views/components/footer.blade.php
  - contract: encode the monochrome palette, typography, spacing, no shadows or gradients, focus states, reduced motion behavior, and responsive layout hooks
  - acceptance: the public pages use the Nothing.tech tokens and preserve keyboard and reduced-motion behavior
  - verify: php artisan test --filter Theme
  - depends: T3
  - requirements: 1, 4

## Wave 4
- [x] T5 — add feature tests for the MVP surfaces ✓ complete · evidence: specd verify evidenceRef 5914a24ba5115da8992b1653d298d570; php artisan test --filter 'HomePageTest|ArticlePagesTest|ArticleApiTest|SeededContentTest' PASS · 2026-06-20T23:37:53.193915064Z
  - why: supports requirements 1 through 5 by proving the homepage, article pages, API, and seeded content work together
  - role: builder
  - files: tests/Feature/Web/HomePageTest.php, tests/Feature/Web/ArticlePagesTest.php, tests/Feature/Api/ArticleApiTest.php, tests/Feature/Content/SeededContentTest.php
  - contract: cover homepage intro, latest article previews, article navigation, API JSON shape, seed data, and omission of private fields
  - acceptance: the focused feature tests pass locally against SQLite in-memory
  - verify: php artisan test --filter 'HomePageTest|ArticlePagesTest|ArticleApiTest|SeededContentTest'
  - depends: T2, T3, T4
  - requirements: 1, 2, 3, 4, 5

## Wave 5
- [x] T6 — verify the full suite ✓ complete · evidence: specd verify evidenceRef 8672cbfa18802623eed535256e7d10cf; php artisan test PASS · 2026-06-20T23:38:10.085928355Z
  - why: supports requirements 1 through 5 by proving the complete MVP does not regress existing behavior
  - role: verifier
  - files: tests/Feature, tests/Unit
  - contract: run the spec-level verification command and record evidence for the complete MVP
  - acceptance: the whole test suite passes with no regressions
  - verify: php artisan test
  - depends: T5
  - requirements: 1, 2, 3, 4, 5
