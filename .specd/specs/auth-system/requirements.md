# Requirements — Auth System

## Introduction
API authentication using Laravel Sanctum with role-based access control (RBAC). Users register, login, receive API tokens, and can make authenticated requests. Support admin and author roles with permission checking at controller/policy level.

## Requirement 1 — User Registration
**User story:** As a new user, I want to register with email/password, so that I can access the API.

**Acceptance criteria:**
1. WHEN POST /api/v1/auth/register with valid email/password/name THE SYSTEM SHALL return 201 with user + token
2. IF email already exists THEN THE SYSTEM SHALL return 422 Unprocessable Entity
3. IF password < 8 chars THEN THE SYSTEM SHALL return 422 validation error
4. THE SYSTEM SHALL hash password using bcrypt
5. THE SYSTEM SHALL create User model with author role by default

## Requirement 2 — User Login
**User story:** As registered user, I want to login with email/password, so that I receive a valid API token.

**Acceptance criteria:**
1. WHEN POST /api/v1/auth/login with valid email/password THE SYSTEM SHALL return 200 with token
2. IF credentials invalid THEN THE SYSTEM SHALL return 401 Unauthorized
3. THE SYSTEM SHALL issue Sanctum personal access token valid for 1 year
4. THE SYSTEM SHALL include token in Authorization: Bearer header for subsequent requests

## Requirement 3 — Token Validation
**User story:** As API client, I want authenticated requests validated, so that only authorized users access protected endpoints.

**Acceptance criteria:**
1. WHILE user is authenticated THE SYSTEM SHALL validate Sanctum token on protected routes
2. IF token missing or invalid THEN THE SYSTEM SHALL return 401 Unauthorized
3. IF token expired THEN THE SYSTEM SHALL return 401 and user must re-login
4. THE SYSTEM SHALL attach authenticated user to request (Auth::user())

## Requirement 4 — Role-Based Access Control
**User story:** As admin, I want certain endpoints restricted to my role, so that authors cannot delete users.

**Acceptance criteria:**
1. WHERE user.roles includes 'admin' THE SYSTEM SHALL allow DELETE /api/v1/users/{id}
2. IF user.roles excludes 'admin' THEN THE SYSTEM SHALL return 403 Forbidden
3. THE SYSTEM SHALL use Laravel policies for model authorization
4. THE SYSTEM SHALL check permissions in controller middleware, not inline

## Requirement 5 — User Logout
**User story:** As logged-in user, I want to logout, so that my token is revoked.

**Acceptance criteria:**
1. WHEN POST /api/v1/auth/logout with valid token THE SYSTEM SHALL return 204 No Content
2. THE SYSTEM SHALL revoke Sanctum token (delete from DB)
3. IF token used after logout THEN THE SYSTEM SHALL return 401 Unauthorized

<!--
EARS patterns (each criterion must match one):
  Ubiquitous       THE SYSTEM SHALL <response>
  Event-driven     WHEN <trigger> THE SYSTEM SHALL <response>
  State-driven     WHILE <state> THE SYSTEM SHALL <response>
  Optional-feature WHERE <feature> THE SYSTEM SHALL <response>
  Unwanted         IF <condition> THEN THE SYSTEM SHALL <response>
Add more requirements as ## Requirement 2, 3, ...
-->
