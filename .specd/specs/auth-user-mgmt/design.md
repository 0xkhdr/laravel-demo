# Design — Authentication & User Management

## Overview

Build a complete Laravel-native auth system using Laravel's built-in authentication scaffolding (Illuminate\Auth, gates, policies) plus custom routes/controllers for registration, email verification, password reset, and profile management. Leverage Laravel's session middleware, CSRF protection, rate limiting, and notification queue. Store email verification and password reset tokens in database with expiry timestamps. Use bcrypt password hashing. Existing User model (name, email, password, email_verified_at, timestamps) requires no schema changes; password_reset_tokens and sessions tables already exist.

**Why**: Laravel's auth foundation is stable, secure, and battle-tested. We build on that rather than reinvent. Minimal database migrations. Async email via queue avoids blocking requests.

## Architecture

```
HTTP Request
    ↓
Route (routes/auth.php)
    ↓
Middleware (Guest | Auth | ThrottleAuth)
    ↓
Controller (AuthController, VerificationController, PasswordResetController, ProfileController)
    ↓
User Model + Notifications
    ↓
Database (users, password_reset_tokens, audit_logs)
    ↓
Queue (send verification email, password reset email)
```

### Components

1. **Routes** (routes/auth.php)
   - Responsibility: Map HTTP requests to controller actions, apply middleware.
   - Inputs: HTTP method + URI
   - Outputs: Rendered view or redirect

2. **Controllers** (app/Http/Controllers/Auth/)
   - `AuthController`: register, login, logout
   - `VerificationController`: verify email via token, resend verification
   - `PasswordResetController`: forgot password, reset password
   - `ProfileController`: view profile, change password
   - Responsibility: Handle form submission, validation, business logic orchestration

3. **Middleware** (app/Http/Middleware/)
   - `Auth`: Require user logged in
   - `Guest`: Require user NOT logged in (for auth pages)
   - `ThrottleAuth`: Rate-limit failed login attempts by IP
   - Responsibility: Guard routes, enforce state transitions

4. **User Model** (app/Models/User.php)
   - Exists; add: `verifyEmail()` method, password reset token methods
   - Responsibility: User data + auth methods

5. **Notifications** (app/Notifications/)
   - `VerifyEmailNotification`: Send verification email with token link
   - `ResetPasswordNotification`: Send password reset link with token
   - Responsibility: Render email + push to queue
   - Async: Queue driver (database or sync for tests)

6. **Validation** (app/Http/Requests/)
   - `RegisterRequest`: Validates registration form
   - `LoginRequest`: Validates login form
   - `VerifyEmailRequest`: Validates email verification token
   - `ResetPasswordRequest`: Validates password reset form
   - `ChangePasswordRequest`: Validates change-password form
   - Responsibility: Centralized validation rules, error messages

7. **Database** (database/migrations/)
   - Existing: `users` (id, name, email, password, email_verified_at, remember_token, timestamps)
   - Existing: `password_reset_tokens` (email PRIMARY, token, created_at)
   - New: `email_verification_tokens` (email PRIMARY, token, created_at, expires_at)
   - New: `audit_logs` (id, user_id, action, ip_address, created_at) for login/logout/password-change audit
   - Alternative: Embed tokens in users table with `verification_token` + `verification_token_expires_at` columns (fewer tables, simpler)

## Components and interfaces

### AuthController (register, login, logout)

**register (GET)**: Show registration form
- Input: none
- Output: Blade view with form
- Middleware: guest

**register (POST)**: Process registration
- Input: name, email, password, password_confirmation (form)
- Output: Redirect to verify-email or redirect to register with errors
- Rules: name required, email unique + valid, password min 8 + confirmed
- Process: 1) Validate 2) Hash password 3) Create User 4) Dispatch VerifyEmailNotification 5) Redirect

**login (GET)**: Show login form
- Input: none
- Output: Blade view with form (show intent if redirected)
- Middleware: guest

**login (POST)**: Process login
- Input: email, password, remember_me (optional checkbox)
- Output: Redirect to intended or /dashboard, or errors
- Rate limit: 5 attempts per minute per IP (ThrottleAuth middleware)
- Process: 1) Check email exists + is verified 2) Validate password 3) Create session 4) Set remember-me cookie if selected 5) Log login 6) Redirect
- Contract: If not verified, redirect to verify-email with hint message

**logout (POST)**: Process logout
- Input: none (CSRF token in body or header)
- Output: Redirect to login with success message
- Middleware: auth
- Process: 1) Verify CSRF 2) Revoke session 3) Clear remember-me token 4) Log logout 5) Redirect

### VerificationController

**show (GET)**: Show verify-email page
- Input: none
- Output: Blade view showing verification status, resend link
- Middleware: auth (user must be logged in to resend)

**verify (GET)**: Verify email via token link
- Input: email, token (query string: /auth/verify?email=user@test.com&token=abc123)
- Output: Redirect to login with success, or verify-email page with error
- Process: 1) Find token record 2) Check expiry 3) Update user.email_verified_at 4) Consume token 5) Redirect
- No middleware (guest can click email link)

**resend (POST)**: Resend verification email
- Input: none (use authenticated user.email)
- Output: Redirect to verify-email with success message
- Middleware: auth, throttle (1 per minute)
- Process: 1) Create new verification token 2) Dispatch VerifyEmailNotification 3) Redirect

### PasswordResetController

**forgot (GET)**: Show forgot-password form
- Input: none
- Output: Blade view
- Middleware: guest

**forgot (POST)**: Send reset link email
- Input: email (form)
- Output: Always redirect with success (no email-existence leak)
- Rate limit: 3 per hour per email (throttle)
- Process: 1) If email exists 2) Create reset token 3) Dispatch ResetPasswordNotification 4) Redirect
- Security: Never reveal whether email exists

**reset (GET)**: Show reset-password form with token embedded
- Input: email, token (query string: /auth/reset?email=user@test.com&token=abc123)
- Output: Blade view with form, or 404
- Middleware: guest
- Process: 1) Find + validate token 2) Embed email + token in form (hidden) 3) Render

**reset (POST)**: Process password reset
- Input: email, token (hidden), password, password_confirmation
- Output: Redirect to login with success, or reset form with errors
- Process: 1) Validate token + email 2) Validate password 3) Update user.password 4) Consume token 5) Revoke all sessions (log out everywhere) 6) Log password reset 7) Redirect

### ProfileController

**show (GET)**: Show user profile
- Input: none (from Auth::user())
- Output: Blade view with name, email, verification status, last login
- Middleware: auth
- Reads: User model

**changePassword (GET)**: Show change-password form
- Input: none
- Output: Blade view
- Middleware: auth

**changePassword (POST)**: Process password change
- Input: current_password, password, password_confirmation
- Output: Redirect to profile with success, or form with errors
- Middleware: auth
- Process: 1) Verify current_password matches user 2) Validate new password 3) Update hash 4) Log change 5) Keep session 6) Redirect

## Data models

### users table (existing, no migration needed)
```
id: bigint primary key
name: string(255)
email: string(255) unique
password: string(255) [hashed bcrypt]
email_verified_at: timestamp nullable
remember_token: string(100) nullable [for "remember me"]
created_at: timestamp
updated_at: timestamp
```

### email_verification_tokens table (new)
```
email: string(255) primary key
token: string(64) [hashed or plaintext?]
created_at: timestamp
expires_at: timestamp [created_at + 24h]
```

**Decision**: Store as plaintext token in DB, send hashed link in email? Or hash on send? Laravel convention is to hash tokens before storing. Use a migration to create this table.

**Alternative** (simpler): Add to users table:
```
verification_token: string(64) nullable [hashed]
verification_token_expires_at: timestamp nullable
```

### password_reset_tokens table (exists, unchanged)
```
email: string(255) primary key
token: string(64) [hashed]
created_at: timestamp
```

### audit_logs table (new, optional)
```
id: bigint primary key
user_id: bigint nullable [null if guest action]
action: string(50) [login, logout, password_reset, password_change, email_verified]
ip_address: string(45) [IPv6-safe]
user_agent: text nullable
created_at: timestamp
```

## Error handling

| Scenario | Response | Status |
|----------|----------|--------|
| Registration: email exists | Validation error on field | 422 |
| Registration: password mismatch | Validation error on field | 422 |
| Login: credentials invalid | Generic "Invalid email or password" | 401 |
| Login: email not verified | Redirect to verify-email with hint | 302 |
| Login: IP throttled (>5 attempts/min) | "Too many login attempts. Try again in 60s" | 429 |
| Verify: token invalid | Redirect with error, show resend option | 302 |
| Verify: token expired | Redirect with error, show resend option | 302 |
| Password reset: email not found | Success message (no leak) | 200 |
| Password reset: token invalid | Redirect to forgot-password with error | 302 |
| Change password: current password wrong | Validation error | 422 |
| Profile: not authenticated | Redirect to login | 302 |

## Verification strategy

### Unit Tests (app/tests/Unit/)
- Test User model methods: `verifyEmail()`, password hashing
- Test Validation rules in isolation
- Test notification generation (message content)

### Feature/Integration Tests (app/tests/Feature/)
- Req1 (Registration): Register → verify email exists + hashed, notification queued, redirect to verify-email page
- Req2 (Email Verification): Click link → email_verified_at set, token consumed, redirect to login
- Req3 (Login): Login with verified email → session created, redirect to dashboard
- Req4 (Password Reset): Request reset → email sent (not leaked), click link → password updated, sessions revoked
- Req5 (Logout): Logout → session cleared, redirect to login
- Req6 (Profile): Authenticated user → profile page loads with data
- Req7 (Change Password): Change password with correct current → password updated, session kept

### System Tests
- Full flow: Register → verify → login → change password → logout
- Negative flows: Invalid token, expired token, wrong password
- Rate limiting: Verify throttle, login throttle, email resend throttle

### Mapping

| Test | Requirement(s) |
|------|---|
| test_register_creates_user_and_sends_verification | Req 1 |
| test_email_verification_marks_email_verified | Req 2 |
| test_login_with_verified_email | Req 3 |
| test_password_reset_flow | Req 4 |
| test_logout_clears_session | Req 5 |
| test_profile_page_shows_user_data | Req 6 |
| test_change_password | Req 7 |
| test_login_rate_limit | Req 3 (rate limit) |

## Risks and open questions

1. **Email verification tokens table or columns in users table?**
   - Option A: Separate table (email_verification_tokens) — explicit, easy to clear after verify, but extra migration
   - Option B: Add columns to users table (verification_token, verification_token_expires_at) — fewer tables, simpler schema
   - Decision: Defer to discussion; both are viable. I recommend **Option B** for simplicity.

2. **Token storage: plaintext or hashed?**
   - Laravel convention: Hash before storing, but then you can't verify against hashed input (chicken-egg). Password resets use plaintext.
   - Decision: Store plaintext for email verification tokens. They're short-lived (24h) and one-time-use.

3. **Remember-me token reuse across devices?**
   - Current: One token per user (remember_token column). Logged-out elsewhere = all remember-me tokens revoked.
   - Risk: User logs in on device A, logs out on device B → A's remember-me invalidated.
   - Decision: Acceptable for MVP. Future: Device-specific tokens if needed.

4. **Audit logging: required for MVP?**
   - Adds complexity (new table, migrations, logging on every auth action).
   - Alternative: Laravel's audit packages (Spatie Activitylog) or manual logging.
   - Decision: Defer audit_logs table for now; log to Laravel logs (storage/logs/laravel.log) for MVP. Add audit_logs later if compliance required.

5. **Email send failures: retry policy?**
   - Queue job fails → notification not sent → user can't verify.
   - Decision: Use Laravel's built-in queue retry (database queue, 3 retries, exponential backoff). Log failures. User can resend manually.

6. **Session timeout: infinite or expiring?**
   - Laravel default: SESSION_LIFETIME = 120 min. Session can be extended by activity (auth middleware touches last_activity).
   - Decision: Use Laravel default (120 min idle). Configurable in .env.
