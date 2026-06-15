# Product — WHAT we're building & why

## Product
A Laravel 13 REST API Demo codebase designed to expose API endpoints for user resources. The core functionality currently consists of a paginated list of users endpoint (`GET /api/users`).

## Users
API clients, front-end developers, and integration services who need to retrieve user listings programmatically. They require consistent JSON API response formats with pagination support and metadata, quick response times, and proper serialization masks for sensitive security fields.

## Value / why it exists
This demo provides a standardized, scalable REST API structure using Laravel. It demonstrates how to implement pagination (at 10 items per page), data sorting (most recently created first), and sensitive data masking (`password` and `remember_token` hidden), backed by automated Pest tests.

## Out of scope
- Frontend UI client components (pure REST API backend).
- User authentication, authorization, or registration flow implementation (endpoints are publicly accessible).
- Writing operations like POST, PUT, DELETE for user resources.
