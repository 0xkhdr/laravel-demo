## Purpose
Provide a public, maintainable portfolio/blog that communicates the owner's
software engineering work, open-source contributions, experience, and writing.

## ADDED Requirements

### Requirement: Public portfolio landing page
The system MUST provide a landing page that identifies the owner, states their
engineering focus, and links visitors to work, writing, and contact.

#### Scenario: Visitor understands the site from the home page
- **WHEN** a visitor opens `/`
- **THEN** they see the owner name/title, one-line value proposition, a Work CTA,
  featured projects, latest articles, experience summary, skills, and contact
  links

### Requirement: Project and open-source archive
The system MUST provide project archive/detail pages with project type, summary,
stack, role, status, and configured repository or demo links.

#### Scenario: Visitor explores open-source work
- **WHEN** a visitor opens `/projects`
- **THEN** published projects are grouped or labeled clearly, open-source
  projects are distinguishable, and each project can open its detail page

#### Scenario: Visitor opens a missing project
- **WHEN** a visitor requests an unknown project slug or an unpublished project
- **THEN** the application returns 404

### Requirement: Published writing
The system MUST provide article archive/detail pages with title, excerpt, tags,
published date, reading time, and readable article content.

#### Scenario: Visitor reads published writing
- **WHEN** a visitor opens `/writing`
- **THEN** only published articles appear, ordered newest first, with links to
  readable detail pages

#### Scenario: Draft is not public
- **WHEN** an article has draft status or no publish date
- **THEN** it is absent from archive, home-page latest writing, and public detail
  routes

### Requirement: Experience and skills
The system MUST present experience chronologically and skills by category without
progress bars or invented proficiency percentages.

#### Scenario: Visitor reviews background
- **WHEN** a visitor reaches About or Experience
- **THEN** they see roles, organizations, dates, concise outcomes, and categorized
  skills in a scannable layout

### Requirement: Nothing.tech-inspired responsive UI
The system MUST implement the visual direction in `BUILD_PROMPT.md` using a
monochrome palette, sparse red accent, monospace display headings, sans-serif
body text, generous spacing, thin borders, and alternating light/dark sections.

#### Scenario: Visitor uses mobile screen
- **WHEN** viewport width is narrow
- **THEN** content remains readable, cards become one column, navigation becomes
  an accessible full-screen menu, and no horizontal scrolling is required

### Requirement: Accessibility and motion safety
The system MUST use semantic landmarks, ordered headings, descriptive link text,
keyboard focus states, sufficient contrast, alt text for every image, and a
`prefers-reduced-motion` fallback.

#### Scenario: Keyboard user navigates the site
- **WHEN** a visitor uses only keyboard input
- **THEN** every interactive control is reachable, focus is visible, and mobile
  navigation can be opened and closed without a pointer

### Requirement: Performance and ownership
The system MUST avoid unnecessary client dependencies, lazy-load optional images,
self-host production fonts, and keep content changes version-controlled and
reviewable.

#### Scenario: Owner publishes an article
- **WHEN** the owner adds valid article content with published status/date and
  deploys the application
- **THEN** the article appears in the archive and home-page writing section with
  stable slug and metadata
