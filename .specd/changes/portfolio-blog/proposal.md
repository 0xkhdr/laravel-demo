# Proposal

## Problem
The Laravel app exposes only a placeholder home page. It does not show the
engineer's experience, shipped work, open-source contributions, or technical
writing in a coherent public narrative. The page also has no defined visual
system, responsive behavior, article route, or content contract.

## Outcome
Deliver a fast, accessible personal portfolio and blog with a focused landing
page, project and open-source work, experience, skills, contact links, and
publishable article pages. The interface follows `BUILD_PROMPT.md`: stark
black/white sections, restrained red accent, monospace display type, generous
spacing, asymmetric grid, subtle motion, and no visual excess.

## Scope
Replace the placeholder home view with the portfolio information architecture;
add version-controlled portfolio and article content; add project, experience,
skill, and writing routes/views; add responsive styling, theme switching,
keyboard/focus behavior, reduced-motion handling, metadata, and automated
feature checks for the public routes.

## Non-goals
An admin CMS, database-backed publishing workflow, comments, authentication,
newsletter, contact form delivery, analytics, payment flow, social feed
integration, custom animation engine, and deployment configuration are outside
this change. Articles are authored in the repository until publishing volume
proves a CMS is needed.

## Affected capabilities
- `portfolio`: public identity, experience, projects, open source, skills, and
  contact information.
- `writing`: article index, article detail pages, metadata, and repository-based
  publishing.
- `presentation`: responsive Nothing.tech-inspired visual system and accessible
  interactions.
