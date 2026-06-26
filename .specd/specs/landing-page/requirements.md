# Requirements — Landing Page

## Introduction
Home page showcasing portfolio, recent articles, and projects. Visitors land here, explore work, and navigate to detailed article/package sections. First impression; must be clean, fast, and highlight best work.

## Requirement 1 — Hero Section
**User story:** As a visitor, I want to see who the author is and what they do, so that I understand the site's purpose immediately.

**Acceptance criteria:**
1. THE SYSTEM SHALL display hero section with name, title, and brief tagline
2. THE SYSTEM SHALL include call-to-action button linking to articles or projects
3. THE SYSTEM SHALL render hero section at top of page above fold on desktop (< 1000px viewport height)

## Requirement 2 — Featured Projects
**User story:** As a potential client, I want to see highlighted projects, so that I can assess the author's work quality.

**Acceptance criteria:**
1. THE SYSTEM SHALL display 3–4 featured projects in a grid layout
2. WHEN a visitor clicks a project card THE SYSTEM SHALL navigate to /projects detail page
3. WHERE project has an external link THE SYSTEM SHALL show "View Live" button linking to it
4. THE SYSTEM SHALL display project title, short description, and thumbnail image

## Requirement 3 — Recent Articles
**User story:** As a reader, I want to see latest articles without leaving homepage, so that I discover recent content.

**Acceptance criteria:**
1. THE SYSTEM SHALL display 3 most recent articles as cards
2. WHEN visitor clicks article card THE SYSTEM SHALL navigate to /articles/{slug}
3. THE SYSTEM SHALL show article title, publish date, excerpt (first 150 chars), and thumbnail
4. THE SYSTEM SHALL include link to /articles page ("View All Articles") below card list

## Requirement 4 — Responsive Design
**User story:** As a mobile user, I want the page to work on my phone, so that I can explore the portfolio anywhere.

**Acceptance criteria:**
1. THE SYSTEM SHALL reflow layout to single column on screens < 768px width (mobile)
2. THE SYSTEM SHALL display proper 2-column grid on tablets (768px–1024px)
3. THE SYSTEM SHALL display 3+ column layouts on desktop (> 1024px)
4. THE SYSTEM SHALL ensure touch targets are ≥ 44px on mobile

## Requirement 5 — Navigation
**User story:** As a visitor, I want clear navigation to other sections, so that I can explore the full portfolio.

**Acceptance criteria:**
1. THE SYSTEM SHALL display navbar with links: Home, Articles, Projects, Packages
2. THE SYSTEM SHALL keep navbar fixed/sticky as visitor scrolls
3. WHILE on mobile viewport THE SYSTEM SHALL show hamburger menu (collapsed nav)
4. THE SYSTEM SHALL highlight current page in navbar ("Home" when on landing page)

## Requirement 6 — Performance
**User story:** As a visitor on slow internet, I want pages to load quickly, so that I don't abandon the site.

**Acceptance criteria:**
1. THE SYSTEM SHALL load and render landing page in < 2 seconds on 3G connection
2. THE SYSTEM SHALL serve images optimized (WEBP, responsive sizes)
3. THE SYSTEM SHALL achieve Lighthouse score ≥ 80 for performance

## Requirement 7 — Footer
**User story:** As a visitor, I want to contact or follow the author, so that I can stay connected.

**Acceptance criteria:**
1. THE SYSTEM SHALL display footer with social links (GitHub, LinkedIn, Twitter if applicable)
2. THE SYSTEM SHALL include email contact link or form
3. THE SYSTEM SHALL show copyright year dynamically
