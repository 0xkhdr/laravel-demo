## Purpose
Define the public contract for an engineer's portfolio and technical blog.

## ADDED Requirements

### Requirement: Portfolio landing page
The system MUST provide a single responsive landing page that presents the
engineer's identity, title, concise value statement, experience, selected work,
open-source work, skills, writing preview, and contact links.

#### Scenario: Visitor opens the home page
- **WHEN** a visitor requests `/`
- **THEN** the response is successful, includes the engineer's name and title,
  and exposes navigation to work, writing, about, and contact sections.

### Requirement: Work and open-source presentation
The system MUST distinguish professional projects from open-source
contributions and show each published item with its name, concise description,
technology labels, and only the links that exist.

#### Scenario: Visitor scans work
- **WHEN** a visitor reaches the work section
- **THEN** each project is represented by a semantic card with readable content
  and usable repository or live-demo links where configured.

### Requirement: Experience and skills
The system MUST present experience as a chronological, readable timeline and
skills as categorized labels without progress bars, percentages, or unsupported
proficiency claims.

#### Scenario: Visitor reviews background
- **WHEN** a visitor opens the about/experience area
- **THEN** role, organization, date range, and concise impact statements are
  visible, followed by categorized skills.

### Requirement: Repository-authored writing
The system MUST provide a writing index and stable slug-based article pages for
published technical articles, including title, publication date, summary, and
article body.

#### Scenario: Visitor opens an article
- **WHEN** a visitor requests `/writing/{slug}` for a published slug
- **THEN** the article page renders its metadata, semantic heading hierarchy,
  readable body, and a link back to the writing index.

#### Scenario: Visitor requests an unknown article
- **WHEN** the slug is not published
- **THEN** the application returns a normal 404 response and does not expose
  internal content paths.

### Requirement: Nothing.tech visual system
The system MUST implement the visual rules in `BUILD_PROMPT.md`: monochrome
black/white foundations, sparse `#FF3B30` accent states, monospace display
headings, sans-serif body copy, generous whitespace, thin borders, asymmetric
desktop layout, and mobile-first responsive behavior.

#### Scenario: Visitor uses the interface
- **WHEN** a visitor hovers, focuses, or changes theme
- **THEN** controls expose a visible state using border/color inversion or the
  red accent, without gradients, drop shadows, excessive motion, or rounded UI.

### Requirement: Accessibility and performance baseline
The system MUST use semantic landmarks and heading order, visible keyboard
focus, sufficient text contrast, useful link names, image alternatives when
images exist, reduced-motion support, and lazy loading for non-critical images.

#### Scenario: Visitor prefers reduced motion or keyboard navigation
- **WHEN** reduced motion is enabled or a visitor navigates by keyboard
- **THEN** decorative transitions are minimized and every interactive control
  remains visible, reachable, and operable.
