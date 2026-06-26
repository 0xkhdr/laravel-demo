# Design — Landing Page

## Overview
Single Blade template rendering hero, featured projects, recent articles, and footer. Server-fetches 3 recent articles and 3–4 featured projects from database. No client-side JS framework; plain HTML + CSS for fast load. Responsive mobile-first design with CSS Grid/Flexbox. Images optimized via Laravel's storage assets.

Approach favors simplicity: one Blade view, controller fetches data, cache recent articles/projects for performance. No SPA complexity.

## Architecture
- **Route**: GET / → HomeController@index
- **Controller**: Fetches Article & Project models (cached)
- **View**: landing.blade.php renders hero, sections, footer
- **Styling**: Tailwind CSS (responsive utilities)
- **Images**: Stored in storage/app/public/images/

```
GET / 
  ↓
HomeController::index()
  ├→ Article::latest()->limit(3).get() [cached 1 hour]
  ├→ Project::featured().limit(4).get() [cached 1 hour]
  ↓
landing.blade.php
  ├→ @include('partials.navbar')
  ├→ @include('partials.hero')
  ├→ @include('partials.featured-projects')
  ├→ @include('partials.recent-articles')
  ├→ @include('partials.footer')
```

## Components and interfaces

### HomeController::index()
- **Input**: HTTP GET request
- **Output**: Rendered Blade template
- **Contract**: Returns 200 with landing page HTML; caches query results; handles missing articles/projects gracefully

### landing.blade.php
- **Input**: $articles (Collection[Article]), $projects (Collection[Project])
- **Output**: HTML (hero, navbar, sections, footer)
- **Sections**: Hero, navbar (fixed), featured projects grid, articles carousel, footer
- **Responsive**: mobile-first, breakpoints at 768px (tablet) and 1024px (desktop)

### Article & Project Models
- **Article** fields: title, slug, excerpt, body, thumbnail_url, published_at, created_at
- **Project** fields: title, slug, description, thumbnail_url, live_url, featured (boolean), order (for sorting)
- **Relationships**: None initially (single author)

### Partials (reusable components)
- **navbar.blade.php**: Logo, nav links, hamburger menu (mobile)
- **hero.blade.php**: Name, tagline, CTA button
- **featured-projects.blade.php**: Grid of 4 project cards
- **recent-articles.blade.php**: 3 article cards + "View All" link
- **footer.blade.php**: Social links, copyright, email

## Data models

```
articles table:
  id, title, slug (unique), excerpt, body, thumbnail_url, published_at, created_at, updated_at

projects table:
  id, title, slug (unique), description, thumbnail_url, live_url, featured (bool), order (int), created_at, updated_at
```

Slugs auto-generated from title on save (or explicit). Both support soft-delete if needed later.

## Error handling

- **No articles**: Show placeholder "No articles yet" in section
- **No projects**: Show placeholder "No projects yet"
- **Missing images**: Serve fallback/placeholder via CSS `background-image: url()`
- **Database down**: Cache ensures 1-hour stale data served; after cache expires, 503 Service Unavailable
- **Slow queries**: Implement eager loading (withCount) and indexes on published_at, featured columns

## Verification strategy

**Unit Tests** (Models):
- Article/Project model relationships and scopes (featured(), latest())
- Slug generation

**Feature Tests** (Controller + View):
- R1 (Hero): GET / returns hero section with name, tagline, CTA
- R2 (Projects): GET / displays 3–4 featured projects with titles, descriptions, "View Live" buttons
- R3 (Articles): GET / displays 3 recent articles with title, date, excerpt
- R5 (Navigation): GET / includes navbar with Home, Articles, Projects, Packages links
- R7 (Footer): GET / includes footer with social links and copyright

**System/Visual Tests** (Manual/Screenshot):
- R4 (Responsive): Mobile (< 768px), tablet, desktop layouts render correctly
- R6 (Performance): Lighthouse audit ≥ 80, load time < 2s

## Risks and open questions

1. **Featured project selection**: How are projects marked "featured"? Manual in DB, or algorithm? → Decision: Boolean flag + order column, manual curation
2. **Image optimization**: WEBP vs. JPEG? CDN caching? → Will use Laravel's asset pipeline + caching headers; optimize in Image field later
3. **Article body rendering**: Markdown or HTML? Sanitization needed? → MVP: Plain HTML in DB; sanitization can be added when accepting user-submitted content
4. **SEO/Meta tags**: Open Graph, title/description for social sharing? → Out of scope for MVP; add later
5. **Caching invalidation**: How do recent articles/projects stay fresh? → Cache 1 hour; admin can manually bust cache later
