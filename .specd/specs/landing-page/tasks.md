# Tasks — Landing Page

## Wave 1

- [ ] T1 — Create Article model and migration
  - why: Store and retrieve articles; foundation for R3 (Recent Articles)
  - role: builder
  - files: app/Models/Article.php, database/migrations/*_create_articles_table.php
  - contract: Create Article model with title, slug, excerpt, body, thumbnail_url, published_at columns. Add scope latest() for ordering by published_at DESC. Slug must be unique and auto-generated from title on create if not set. Do NOT add user/auth fields (single author only).
  - acceptance: Model exists, migration creates articles table with all required columns, latest() scope returns articles ordered by published_at DESC
  - verify: php artisan migrate && php artisan tinker (Article::all(); Article::latest()->limit(3))
  - depends: —
  - requirements: 3, 6

- [ ] T2 — Create Project model and migration
  - why: Store featured projects; foundation for R2 (Featured Projects)
  - role: builder
  - files: app/Models/Project.php, database/migrations/*_create_projects_table.php
  - contract: Create Project model with title, slug, description, thumbnail_url, live_url, featured (bool), order (int) columns. Add scope featured() returning only projects where featured=true, ordered by order ASC. Slug unique and auto-generated from title. Do NOT add user relationships (single author).
  - acceptance: Model exists, migration creates projects table, featured() scope returns projects ordered by order ASC
  - verify: php artisan migrate && php artisan tinker (Project::featured()->get())
  - depends: —
  - requirements: 2, 6

- [ ] T3 — Seed demo articles and projects
  - why: Provide sample data for landing page display during development; tests will use this
  - role: builder
  - files: database/seeders/DatabaseSeeder.php (or new seeders), database/seeders/ArticleSeeder.php, database/seeders/ProjectSeeder.php
  - contract: Create seeder that generates 5+ Articles (with titles, slugs, thumbnails, published dates) and 4+ Projects (with featured=true, order set). Articles should have realistic publish dates in past. Do NOT use factory randomization; use explicit data so landing page is predictable.
  - acceptance: Seeders exist, running php artisan db:seed populates articles_table and projects_table with predictable data
  - verify: php artisan db:seed && php artisan tinker (Article::count(), Project::featured()->count())
  - depends: T1, T2
  - requirements: 2, 3

## Wave 2

- [ ] T4 — Create HomeController and index route
  - why: Handle GET / request and serve landing page; integrates R1-R7
  - role: builder
  - files: app/Http/Controllers/HomeController.php, routes/web.php
  - contract: Create HomeController::index() method that fetches Article::latest()->limit(3)->get() and Project::featured()->limit(4)->get(), caches both for 1 hour, passes to view. Register GET / route → HomeController@index. Do NOT implement authentication or error pages beyond 404.
  - acceptance: GET / returns 200 with rendered Blade template, controller retrieves articles and projects, both are cached
  - verify: php artisan tinker && http -v GET localhost:8000/ | grep -E 'title|article|project'
  - depends: T1, T2
  - requirements: 1, 2, 3, 5, 7

## Wave 3

- [ ] T5 — Create landing.blade.php and navbar partial
  - why: Render hero, navbar, sections; fulfill R5 (Navigation), R1 (Hero)
  - role: builder
  - files: resources/views/landing.blade.php, resources/views/partials/navbar.blade.php, resources/views/partials/hero.blade.php, resources/views/partials/footer.blade.php
  - contract: Create landing.blade.php as main template. Include navbar (fixed), hero section with name/tagline/CTA, @yield('content'), and footer. Create navbar partial with links to Home, Articles, Projects, Packages. Create hero partial with author name, title, and "Explore Articles" CTA button. Create footer with social placeholders, copyright year. Use <header>, <nav>, <main>, <footer> semantic HTML. Do NOT add JavaScript yet.
  - acceptance: landing.blade.php extends base layout, includes all partials, navbar is present and sticky, hero displays, footer shows copyright
  - verify: curl localhost:8000/ | grep -E '<nav|<header|<footer|Explore|Home'
  - depends: T4
  - requirements: 1, 5, 7

- [ ] T6 — Create featured projects section
  - why: Display 3–4 featured projects with cards; fulfill R2 (Featured Projects)
  - role: builder
  - files: resources/views/partials/featured-projects.blade.php
  - contract: Create partial that loops @foreach($projects) and displays each as a card with title, description, thumbnail image, and "View Live" button (if live_url exists). Use Grid layout (2 cols mobile, 3 cols desktop). Do NOT hardcode data; use $projects variable. Cards should be equal height.
  - acceptance: Partial renders project cards in grid, displays title/description/thumbnail, shows "View Live" button linking to live_url
  - verify: curl localhost:8000/ | grep -E 'View Live|featured|grid'
  - depends: T5, T2
  - requirements: 2

- [ ] T7 — Create recent articles section
  - why: Display 3 recent articles with preview cards; fulfill R3 (Recent Articles)
  - role: builder
  - files: resources/views/partials/recent-articles.blade.php
  - contract: Create partial that loops @foreach($articles) and displays title, publish_date, excerpt (truncate to 150 chars if needed), thumbnail, and link to /articles/{slug}. Include "View All Articles" link to /articles page at bottom. Use responsive card layout.
  - acceptance: Partial displays 3 article cards with title/date/excerpt/thumbnail, "View All" link points to /articles
  - verify: curl localhost:8000/ | grep -E 'View All Articles|excerpt|published'
  - depends: T5, T1
  - requirements: 3

## Wave 4

- [ ] T8 — Add Tailwind CSS and responsive styles
  - why: Make landing page visually polished and mobile-friendly; fulfill R4 (Responsive Design), R6 (Performance)
  - role: builder
  - files: tailwind.config.js, resources/css/app.css, webpack.mix.js (or vite.config.js)
  - contract: Configure Tailwind CSS. Style navbar with flex layout, sticky positioning. Style hero with flexbox, center content, large heading (4xl+). Style grids for projects (md:grid-cols-2 lg:grid-cols-3) and articles (responsive). Ensure 44px minimum touch targets on mobile. Use Tailwind breakpoints: sm (640px), md (768px), lg (1024px). Do NOT add animations or external fonts; keep it minimal.
  - acceptance: Landing page renders with Tailwind styles, responsive layouts, proper spacing. 44px+ touch targets. No layout shifts (CLS < 0.1).
  - verify: npm run dev && curl -s localhost:8000/ | grep -E 'sm:|md:|lg:|grid-cols'
  - depends: T5, T6, T7
  - requirements: 4, 6

- [ ] T9 — Optimize images and assets
  - why: Achieve < 2s load time on 3G; fulfill R6 (Performance)
  - role: builder
  - files: storage/app/public/images/, resources/views/partials/*.blade.php (update img tags)
  - contract: Add responsive image tags using srcset and sizes. Store thumbnails in storage/app/public/images/. Use lazy-loading (loading="lazy" attribute). Optimize PNG/JPEG to WEBP where possible (or use CSS background images). Set proper cache headers in web server config. Do NOT add image processing library yet; use static optimized files.
  - acceptance: Images load with lazy-loading, srcset present for responsive scaling, Lighthouse performance score ≥ 80
  - verify: npm run dev && curl localhost:8000/ | grep -E 'srcset|loading="lazy"|<img'
  - depends: T8
  - requirements: 6

## Wave 5

- [ ] T10 — Write feature test for landing page
  - why: Verify all requirements are met; integration test for GET /
  - role: builder
  - files: tests/Feature/LandingPageTest.php
  - contract: Write feature test that verifies: (1) GET / returns 200, (2) page contains hero section with name, (3) displays 3 article cards, (4) displays featured projects, (5) navbar includes all links, (6) footer has copyright. Test that no articles/projects doesn't crash page (graceful fallback). Do NOT test Lighthouse or 3G timing (that's manual).
  - acceptance: All tests pass, landing page responds to GET /, displays required sections
  - verify: php artisan test tests/Feature/LandingPageTest.php
  - depends: T8, T9
  - requirements: 1, 2, 3, 4, 5, 7

- [ ] T11 — Verify responsive design on multiple breakpoints
  - why: Confirm R4 (Responsive Design) — mobile, tablet, desktop layouts work
  - role: verifier
  - files: resources/views/landing.blade.php
  - contract: Manually test or use Lighthouse/Chrome DevTools to verify landing page layout at mobile (375px), tablet (768px), and desktop (1440px) viewports. Verify touch targets ≥ 44px, no horizontal scroll, text readable. Screenshot if needed.
  - acceptance: Landing page responsive across 3 viewport sizes, no layout issues, touch targets adequate
  - verify: Visit localhost:8000 in Chrome DevTools responsive mode at 375px, 768px, 1440px. Or: npm run test
  - depends: T8, T10
  - requirements: 4

- [ ] T12 — Verify performance (Lighthouse audit)
  - why: Confirm R6 (Performance) — load time < 2s, Lighthouse ≥ 80
  - role: verifier
  - files: N/A
  - contract: Run Lighthouse audit on landing page in Chrome DevTools (or via CLI). Verify performance score ≥ 80, First Contentful Paint < 2s on throttled 4G/3G. Document any issues.
  - acceptance: Lighthouse performance ≥ 80, FCP < 2s on throttled connection
  - verify: Chrome DevTools → Lighthouse → Performance audit, or: npm run audit
  - depends: T8, T9, T10
  - requirements: 6
