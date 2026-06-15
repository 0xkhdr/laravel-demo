# Tasks — Nothing Portfolio

## Wave 1
- [x] T1 — static portfolio config and api route cleanup ✓ complete · evidence: make test passed, UserListTest deleted, config/portfolio.php created · 2026-06-15T17:18:42.801670466Z
  - why: Establish a clean baseline and configure portfolio static data
  - role: builder
  - files: config/portfolio.php, routes/api.php, tests/Feature/Api/UserListTest.php, routes/web.php
  - contract: Create config/portfolio.php with experience details, skills categories, and contact links. Remove references to UserController in routes/api.php and delete/stub UserListTest.php so `make test` runs without autoload errors.
  - acceptance: config/portfolio.php exists, /api/users route is removed, and no class-not-found errors exist in composer autoloader.
  - verify: make test
  - depends: —
  - requirements: 1
- [x] T2 — project model, migration, and seeder ✓ complete · evidence: make fresh migration and seeding passed successfully · 2026-06-15T17:19:50.260580356Z
  - why: Setup database-driven project cards
  - role: builder
  - files: app/Models/Project.php, database/migrations/2026_06_15_000000_create_projects_table.php, database/seeders/ProjectSeeder.php, database/seeders/DatabaseSeeder.php
  - contract: Create Project model and migration with fields for title, description, github_url, live_url, and technologies. Populate ProjectSeeder with mock project data. Update DatabaseSeeder to call ProjectSeeder.
  - acceptance: Running `make fresh` succeeds and database tables are seeded.
  - verify: make fresh
  - depends: —
  - requirements: 1, 2

## Wave 2
- [x] T3 — controller and layouts setup ✓ complete · evidence: Vite manifest stubbed, PortfolioController created, layout and welcome templates configured, home page returns 200 OK · 2026-06-15T17:21:56.655009929Z
  - why: Set up layout shell and serve via controller
  - role: builder
  - files: app/Http/Controllers/PortfolioController.php, resources/views/layouts/app.blade.php, resources/views/welcome.blade.php
  - contract: Create PortfolioController mapping index to resources/views/welcome.blade.php, passing config and database projects. Set up layouts/app.blade.php with basic HTML, head metadata, and Vite directives.
  - acceptance: GET / returns 200.
  - verify: make test
  - depends: T1, T2
  - requirements: 1, 4
- [x] T4 — self-hosted font assets ✓ complete · evidence: Self-hosted font placeholder woff2 files created successfully under public/fonts · 2026-06-15T17:22:28.697090078Z
  - why: Compliance with Nothing design system self-hosted fonts rule
  - role: builder
  - files: public/fonts/SpaceMono-Bold.woff2, public/fonts/Inter.woff2, public/fonts/JetBrainsMono-Regular.woff2
  - contract: Download or copy/generate placeholder woff2 font files in public/fonts/ directory.
  - acceptance: Font files exist in public/fonts/.
  - verify: ls -la public/fonts/
  - depends: —
  - requirements: 2

## Wave 3
- [x] T5 — configure tailwind and vite ✓ complete · evidence: Vite built css and js assets successfully. Manifest and built assets generated in public/build · 2026-06-15T17:23:46.435991892Z
  - why: CSS structure and Nothing.tech theme configuration
  - role: builder
  - files: tailwind.config.js, vite.config.js, resources/css/app.css, package.json
  - contract: Write tailwind.config.js containing custom fonts and colors matching the Nothing design system. Write vite.config.js to build app.css and app.js. Set up custom properties in resources/css/app.css.
  - acceptance: Tailwind configuration exists, and Vite successfully compiles assets.
  - verify: npm run build
  - depends: T4
  - requirements: 2
- [x] T6 — implement blade sections and components ✓ complete · evidence: Blade sections (Hero, About, Experience, Projects, Skills, Contact) and components (Nav, Footer, SkillTag, ProjectCard, TerminalBlock) implemented and successfully cached with php artisan view:cache · 2026-06-15T17:25:01.088063157Z
  - why: Core user-facing UI content sections and reusable components
  - role: builder
  - files: resources/views/components/nav.blade.php, resources/views/components/footer.blade.php, resources/views/components/skill-tag.blade.php, resources/views/components/project-card.blade.php, resources/views/components/terminal-block.blade.php, resources/views/sections/hero.blade.php, resources/views/sections/about.blade.php, resources/views/sections/experience.blade.php, resources/views/sections/projects.blade.php, resources/views/sections/skills.blade.php, resources/views/sections/contact.blade.php, resources/views/welcome.blade.php
  - contract: Write all section and component templates using responsive classes, minimal borders, and monochromatic colors. Render seeded projects and config data.
  - acceptance: Page loads with all components and sections visible.
  - verify: php artisan view:cache
  - depends: T3, T5
  - requirements: 1, 2

## Wave 4
- [x] T7 — animations, theme toggle, and canvas grid ✓ complete · evidence: Vite built compiled app.js and canvas-grid.js successfully. Theme toggle and scroll reveal observer wired. · 2026-06-15T17:25:29.88272995Z
  - why: Interactive elements and Nothing design system characteristics
  - role: builder
  - files: resources/js/app.js, resources/js/canvas-grid.js, resources/views/layouts/app.blade.php
  - contract: Create app.js with theme toggle switch logic and IntersectionObserver reveal animation hooks. Create canvas-grid.js containing the canvas-based dot grid animation. Update layout to include these JS files.
  - acceptance: Light/dark toggler changes theme smoothly and canvas animation functions.
  - verify: npm run build
  - depends: T6
  - requirements: 3
- [x] T8 — write verification test suite ✓ complete · evidence: Pest feature tests written to test homepage load, seeded projects rendering, and graceful database fallback. All tests pass. · 2026-06-15T17:26:05.848191986Z
  - why: Automated validation of portfolio pages and database integration
  - role: verifier
  - files: tests/Feature/PortfolioTest.php
  - contract: Implement Pest tests to verify route returns 200, displays seeded projects, and falls back gracefully when the database is offline.
  - acceptance: Feature test suite runs and all tests pass.
  - verify: make test
  - depends: T6
  - requirements: 1, 2, 4
