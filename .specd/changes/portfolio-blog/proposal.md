# Proposal

## Problem
The repository is an API demo with no public identity, portfolio, project archive,
or publishing flow. Visitors need one place to understand the engineer's work,
open-source contributions, experience, and technical writing.

## Outcome
Ship a fast, responsive personal portfolio and blog with a clear home page,
project and open-source work pages, experience and skills, article index/detail
pages, and direct contact/social links. Content must be easy for the owner to
publish without adding an admin product to the first release.

## Scope
- Public home page with hero, short positioning statement, featured work,
  latest writing, experience summary, skills, and contact CTA.
- Project archive and project detail pages. Projects distinguish client,
  personal, and open-source work and link to repositories/live demos.
- Article archive and article detail pages. Only published articles are public;
  drafts remain private to the repository.
- Experience timeline, skill categories, and stable external links.
- Repository-managed content with explicit publish dates/status, suitable for a
  single author. No database-backed CMS in MVP.
- Nothing.tech-inspired visual system from `BUILD_PROMPT.md`: monochrome
  sections, restrained red accent, monospace display type, generous whitespace,
  asymmetric grids, thin borders, no gradients/shadows/rounded UI.
- Responsive, keyboard-accessible, semantic, reduced-motion-aware UI.

## Non-goals
- Authentication, author dashboard, multi-author workflows, comments, likes,
  newsletters, analytics, search, and social publishing.
- Contact form processing; use email and social links first.
- Image-heavy case studies, canvas/WebGL background, GSAP, or other animation
  dependencies unless the finished content proves they are needed.
- Replacing the existing API demo or adding a frontend framework.

## Affected capabilities
portfolio
writing
content
