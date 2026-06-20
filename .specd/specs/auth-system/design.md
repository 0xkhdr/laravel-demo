# Design — Auth System

## Overview
Use Laravel Sanctum (personal access tokens) for stateless API authentication. Sanctum is Laravel-native, lightweight, and designed for SPA/mobile APIs. Model-based roles/permissions using Spatie's role-permission package. Thin controllers delegate to Actions, Actions handle business logic, Policies enforce authorization.

## Architecture
```
Client
  ↓ POST /auth/register
  ↓ POST /auth/login (receive token)
  ↓ Requests with Authorization: Bearer {token}
  ↓
API Route Middleware (auth:sanctum)
  ↓ Validates token, attaches User to request
  ↓
Controller → Action → Model
  ↓
Policy authorization check (if applicable)
  ↓
Response or 403 Forbidden
```

Sanctum stored tokens in `personal_access_tokens` table (created by migration). No JWT complexity, database-backed tokens revokable immediately.

## Components and interfaces

### Component 1: User Model + Factories
- **Responsibility**: User entity, roles/permissions relationship
- **Schema**: id, name, email, email_verified_at, password, created_at, updated_at
- **Methods**: hasRole(), hasPermission(), roles(), permissions()
- **Relationships**: roles() hasMany via role_user, permissions() hasMany via model_has_permissions
- **Input**: RegisterRequest validation, LoginRequest validation
- **Output**: User with roles/permissions eager-loaded

### Component 2: Auth Actions (RegisterUser, LoginUser, LogoutUser)
- **Responsibility**: Authentication business logic
- **RegisterUser Action**
  - Input: name, email, password from RegisterRequest
  - Process: hash password, create User, assign author role
  - Output: User instance
  - Throws: ValidationException on duplicate email
- **LoginUser Action**
  - Input: email, password from LoginRequest
  - Process: verify credentials, issue Sanctum token
  - Output: token + user object
  - Throws: AuthenticationException on invalid credentials
- **LogoutUser Action**
  - Input: authenticated User from request
  - Process: revoke all tokens (delete from personal_access_tokens)
  - Output: null

### Component 3: Auth Routes + Controllers
- **POST /api/v1/auth/register** → RegisterController → RegisterUser → 201 + user + token
- **POST /api/v1/auth/login** → LoginController → LoginUser → 200 + user + token
- **POST /api/v1/auth/logout** → LogoutController → LogoutUser → 204 (middleware: auth:sanctum)
- **GET /api/v1/auth/me** → MeController → return Auth::user() → 200 (middleware: auth:sanctum)

### Component 4: Policies (authorization)
- **UserPolicy**: Can delete/update only self or if admin
- **PostPolicy**: Can publish/delete own, admin can delete any
- Applied in controller methods: `$this->authorize('delete', $post)`

## Data models

### User
```php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
```

### Role + Permission (Spatie)
```php
Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->string('guard_name');
    $table->timestamps();
});

Schema::create('permissions', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->string('guard_name');
    $table->timestamps();
});

Schema::create('role_has_permissions', function (Blueprint $table) {
    $table->foreignId('permission_id')->constrained('permissions');
    $table->foreignId('role_id')->constrained('roles');
    $table->primary(['permission_id', 'role_id']);
});

Schema::create('model_has_roles', function (Blueprint $table) {
    $table->foreignId('role_id')->constrained('roles');
    $table->morphs('model');
    $table->unique(['role_id', 'model_id', 'model_type']);
});
```

### Sanctum Personal Access Tokens (auto-created)
```php
// Laravel's personal_access_tokens table created by Sanctum migration
Schema::create('personal_access_tokens', function (Blueprint $table) {
    $table->id();
    $table->morphs('tokenable');
    $table->string('name');
    $table->string('token', 80)->unique();
    $table->text('abilities')->nullable();
    $table->timestamp('last_used_at')->nullable();
    $table->timestamp('expires_at')->nullable();
    $table->timestamps();
});
```

## Error handling

| Scenario | Status | Response |
|----------|--------|----------|
| Invalid registration (bad email) | 422 | `{errors: {email: "must be valid"}}` |
| Duplicate email on register | 422 | `{errors: {email: "already registered"}}` |
| Invalid login credentials | 401 | `{message: "Unauthorized"}` |
| Missing token on protected route | 401 | `{message: "Unauthenticated"}` |
| Expired/revoked token | 401 | `{message: "Unauthenticated"}` |
| Insufficient permissions (403) | 403 | `{message: "This action is unauthorized"}` |

All errors use JsonResponse, no HTML fallback on API routes.

## Verification strategy

**Unit tests** (tests/Unit/Actions/)
- RegisterUser: valid input → user created + author role assigned
- LoginUser: valid credentials → token issued; invalid → throws AuthenticationException
- LogoutUser: revokes all tokens → subsequent login required

**Feature tests** (tests/Feature/Auth/)
- POST /auth/register: 201 + token on valid input; 422 on invalid
- POST /auth/login: 200 + token on valid; 401 on invalid
- POST /auth/logout: 204 + token revoked → 401 on next request
- GET /auth/me (with token): 200 + user; (without token): 401
- Policy authorization: author cannot delete other users; admin can

**Integration**
- Full flow: register → login → authenticated request → logout → 401

## Risks and open questions

- **Decision**: Email verification required before login? (Current: no, but could add middleware)
- **Risk**: Token expiration handled (1 year default) — monitor revocation cleanup
- **Question**: Should we implement refresh tokens? (Current: no, 1-year expiry sufficient for portfolio)
