# Requirements — SQLite Portfolio and JSON Seeding

## Introduction
The portfolio application needs to support a lightweight SQLite database setup for easier local development. It must seed project data using one or more JSON files rather than hardcoded arrays in PHP seeders. Furthermore, if the database is disconnected or down, the application must read project data directly from the JSON files to render the portfolio, failing back to config defaults as a last resort.

## Requirement 1 — SQLite Database Integration
**User story:** As a developer, I want the application database to run on SQLite, so that I can easily set up and run the portfolio locally without a full MySQL container.

**Acceptance criteria:**
1. WHEN the database connection is configured as sqlite, THE SYSTEM SHALL run migrations and seeders successfully.
2. WHILE running on a sqlite database connection, THE SYSTEM SHALL execute query operations to retrieve and persist project models correctly.

## Requirement 2 — JSON-Based Seeding
**User story:** As a developer, I want to manage project seed data in JSON files, so that I can easily update portfolio projects without editing seeder PHP files.

**Acceptance criteria:**
1. WHEN database seeding is executed, THE SYSTEM SHALL read project data from one or more JSON files and seed them into the database.
2. IF any of the project JSON files are missing or invalid, THEN THE SYSTEM SHALL throw a seeding exception and log the error.

## Requirement 3 — Offline JSON Fallback
**User story:** As a visitor, I want to view the portfolio projects even if the database is disconnected, so that the site is always functional.

**Acceptance criteria:**
1. IF the database connection is offline, THEN THE SYSTEM SHALL read and parse the project JSON files to load the projects.
2. IF both the database connection is offline and the project JSON files are unavailable or invalid, THEN THE SYSTEM SHALL load fallback projects from the application configuration.
