# Requirements — Unify UI with Design System

## Introduction
Apply the Nothing.tech design system (as defined in nothing-tech-design-system.md) to all pages in the project. Currently only the landing page follows the design system. All authentication pages, profile pages, and other public pages must adopt the monochromatic + red accent aesthetic, sharp corners, generous whitespace, proper typography scale, and component styling defined in the design system.

## Requirement 1 — Auth Pages Follow Design System
**User story:** As a user, I want all authentication pages (login, register, password reset, email verification) to match the landing page styling, so the experience feels cohesive and professional.

**Acceptance criteria:**
1. THE SYSTEM SHALL render login, register, forgot-password, reset-password, and verify-email views using design system colors (black/white/red)
2. THE SYSTEM SHALL apply design system typography (NDot for headlines, NType 82 for body)
3. THE SYSTEM SHALL use design system spacing and layout (--space-* tokens, --page-padding, generous vertical gaps)
4. THE SYSTEM SHALL style form inputs with bottom borders only (transparent background, 1px solid border on bottom)
5. THE SYSTEM SHALL apply sharp corners (border-radius: 0px) to all components

## Requirement 2 — Profile Pages Follow Design System
**User story:** As an authenticated user, I want profile and account pages to follow the design system, so account management feels consistent with the rest of the site.

**Acceptance criteria:**
1. THE SYSTEM SHALL style profile show, change-password, and account settings pages using design system colors and typography
2. THE SYSTEM SHALL apply design system spacing, borders, and button styles

## Requirement 3 — Global Design System Assets
**User story:** As a developer, I want a global CSS file with design system tokens, so pages can reuse them consistently.

**Acceptance criteria:**
1. THE SYSTEM SHALL define CSS custom properties in resources/css/design-system.css for all tokens (colors, spacing, typography, transitions, z-index)
2. THE SYSTEM SHALL include this file in the main app layout (app.blade.php)
3. THE SYSTEM SHALL include fallback fonts (NDot, NType 82, etc.) with @font-face or CDN links

## Requirement 4 — Welcome/Home Pages Updated
**User story:** As a visitor, I want welcome and index pages to match the design system, so the entry point is aligned with the brand.

**Acceptance criteria:**
1. THE SYSTEM SHALL update welcome.blade.php to use design system styling or repurpose landing page template
2. THE SYSTEM SHALL ensure all public routes render cohesive, on-brand experience
