# Tasks — Authentication & User Management

## Wave 1

- [ ] T1 — Create email_verification_tokens migration
  - why: Store email verification tokens with expiry (Req 2)
  - role: builder
  - files: database/migrations/YYYY_MM_DD_HHMMSS_create_email_verification_tokens_table.php
  - contract: Create table with (email PRIMARY, token, created_at, expires_at). Do NOT add user_id foreign key (tokens are email-based, not user_id-based). Use nullable created_at for null guard.
  - acceptance: Migration file exists, can be run/rolled back via artisan migrate
  - verify: php artisan migrate && php artisan migrate:rollback && php artisan migrate
  - depends: —
  - requirements: 2

- [ ] T2 — Create audit_logs migration
  - why: Log auth events for security audit trail (Req 3, 4, 5, 7)
  - role: builder
  - files: database/migrations/YYYY_MM_DD_HHMMSS_create_audit_logs_table.php
  - contract: Create table with (id, user_id nullable, action, ip_address, user_agent nullable, created_at). Index on user_id and created_at for query performance.
  - acceptance: Migration file exists, can be run/rolled back
  - verify: php artisan migrate && php artisan migrate:rollback && php artisan migrate
  - depends: —
  - requirements: 3, 4, 5, 7

- [ ] T3 — Update User model with auth methods
  - why: Add email verification + password reset token methods to User (Req 1, 2, 4, 7)
  - role: builder
  - files: app/Models/User.php
  - contract: Add methods: verifyEmail(), generateEmailVerificationToken(), generatePasswordResetToken(), revokeAllSessions(). Do NOT add columns to User table (tokens stored separately). Do NOT override password hash (use Hash facade).
  - acceptance: Methods exist, are callable, and are tested in unit test
  - verify: php artisan test tests/Unit/UserModelTest.php
  - depends: —
  - requirements: 1, 2, 4, 7

- [ ] T4 — Create AuditLog model and helper
  - why: Encapsulate audit logging for auth events (Req 3, 4, 5, 7)
  - role: builder
  - files: app/Models/AuditLog.php, app/Support/AuditLogger.php
  - contract: AuditLog model maps to audit_logs table. AuditLogger helper with static methods: login($user, $ip), logout($user, $ip), passwordReset($user, $ip), passwordChange($user, $ip). Do NOT log to AuditLog in this task (just define the interface).
  - acceptance: Models and helper exist, are importable, have correct signatures
  - verify: php artisan test tests/Unit/AuditLoggerTest.php
  - depends: T2
  - requirements: 3, 4, 5, 7

## Wave 2 — Notifications & Form Requests

- [ ] T5 — Create VerifyEmailNotification
  - why: Send email with verification link to newly registered users (Req 1, 2)
  - role: builder
  - files: app/Notifications/VerifyEmailNotification.php
  - contract: Notification class with toMail() method. Generate verification token, create signed URL (/auth/verify?email=X&token=Y), embed in email. Do NOT send email immediately (queue it from controller). Do NOT authenticate user in token logic.
  - acceptance: Notification class exists, generates correct email with signed URL, can be queued
  - verify: php artisan test tests/Unit/VerifyEmailNotificationTest.php
  - depends: T3
  - requirements: 1, 2

- [ ] T6 — Create PasswordResetNotification
  - why: Send password reset link to users who request it (Req 4)
  - role: builder
  - files: app/Notifications/PasswordResetNotification.php
  - contract: Similar to T5. Generate reset token, create signed URL (/auth/reset?email=X&token=Y), embed in email. Do NOT authenticate. Do NOT revoke tokens in notification (do in controller).
  - acceptance: Notification class exists, generates correct email with signed URL
  - verify: php artisan test tests/Unit/PasswordResetNotificationTest.php
  - depends: T3
  - requirements: 4

- [ ] T7 — Create validation form requests
  - why: Centralize validation rules for register, login, verify, reset, change-password forms (Req 1, 3, 4, 7)
  - role: builder
  - files: app/Http/Requests/RegisterRequest.php, LoginRequest.php, ResetPasswordRequest.php, ChangePasswordRequest.php
  - contract: Form request classes with rules() and messages(). RegisterRequest: name required, email unique, password min 8 confirmed. LoginRequest: email required, password required. ResetPasswordRequest: password min 8 confirmed, not same as current. ChangePasswordRequest: current_password verified, password min 8 confirmed, password != current. Do NOT authorize in these (handle in controller).
  - acceptance: All request classes exist, can be type-hinted in controllers, rules are correct
  - verify: php artisan test tests/Unit/ValidationRequestsTest.php
  - depends: —
  - requirements: 1, 3, 4, 7

## Wave 3 — Auth Routes & Core Controllers

- [ ] T8 — Create auth routes file
  - why: Define all auth endpoints (register, login, logout, verify, reset, profile) in one place (Req 1–7)
  - role: builder
  - files: routes/auth.php
  - contract: Create routes/auth.php with GET/POST for register, login, logout, verify, forgot-password, reset-password, profile, change-password. Apply middleware (guest, auth, throttle) appropriately. Do NOT implement logic in routes (use controllers). Import from routes/web.php.
  - acceptance: Routes file exists, all endpoints have controller actions, middleware is applied
  - verify: php artisan route:list | grep auth
  - depends: —
  - requirements: 1–7

- [ ] T9 — Create AuthController (register & login)
  - why: Handle user registration and login (Req 1, 3)
  - role: builder
  - files: app/Http/Controllers/Auth/AuthController.php
  - contract: Methods: showRegisterForm(), register(RegisterRequest), showLoginForm(), login(LoginRequest), logout(). Register: hash password, create User, dispatch VerifyEmailNotification, redirect to verify-email. Login: check email verified, validate password, create session, set remember-me if selected, log audit event, redirect. Logout: revoke session, clear cookie, log audit. Do NOT handle password reset in this controller (separate controller). Do NOT handle email verification (separate controller).
  - acceptance: Controller exists, methods are implemented, can be routed to
  - verify: php artisan test tests/Feature/AuthControllerTest.php
  - depends: T5, T7, T8
  - requirements: 1, 3

- [ ] T10 — Create middleware: Guest, Auth, ThrottleAuth
  - why: Guard routes and enforce state transitions (Req 1, 3, 4)
  - role: builder
  - files: app/Http/Middleware/GuestMiddleware.php, app/Http/Middleware/ThrottleAuthMiddleware.php (use built-in Auth middleware)
  - contract: GuestMiddleware: Redirect authenticated users away from auth pages (register, login, forgot-password). ThrottleAuthMiddleware: Track failed login attempts by IP, lock IP after 5 failures in 1 min (60s cooldown). Do NOT use Laravel's built-in throttle (it's rate-limit, not auth-specific). Do NOT block by email (only by IP per design).
  - acceptance: Middleware classes exist, can be registered in kernel, logic is correct
  - verify: php artisan test tests/Feature/MiddlewareTest.php
  - depends: T4
  - requirements: 1, 3

## Wave 4 — Email Verification & Password Reset

- [ ] T11 — Create VerificationController
  - why: Handle email verification flow (Req 2)
  - role: builder
  - files: app/Http/Controllers/Auth/VerificationController.php
  - contract: Methods: showVerifyEmailPage(), verify(VerifyEmailRequest), resend(). Verify: extract email + token, find token in email_verification_tokens, check expiry, mark user.email_verified_at, consume token, redirect to login. Resend: rate-limit to 1/min, generate new token, dispatch notification. Do NOT auto-login user after verify. Do NOT allow unverified emails to log in (check in AuthController, not here).
  - acceptance: Controller exists, can handle verify and resend flows
  - verify: php artisan test tests/Feature/VerificationControllerTest.php
  - depends: T5, T8
  - requirements: 2

- [ ] T12 — Create PasswordResetController
  - why: Handle forgot-password and reset-password flows (Req 4)
  - role: builder
  - files: app/Http/Controllers/Auth/PasswordResetController.php
  - contract: Methods: showForgotForm(), forgotPassword(Request), showResetForm($email, $token), resetPassword(ResetPasswordRequest). ForgotPassword: do NOT leak email existence (show success for all inputs), generate reset token, dispatch notification if email exists. ResetPassword: validate token + email, validate new password, update hash, revoke all sessions (call User::revokeAllSessions()), consume token, log audit, redirect to login. Do NOT log in user after reset.
  - acceptance: Controller exists, handles both forgot and reset flows, no email-existence leak
  - verify: php artisan test tests/Feature/PasswordResetControllerTest.php
  - depends: T6, T8
  - requirements: 4

## Wave 5 — Profile Management

- [ ] T13 — Create ProfileController
  - why: Handle profile view and password change (Req 6, 7)
  - role: builder
  - files: app/Http/Controllers/Auth/ProfileController.php
  - contract: Methods: show(), changePassword(ChangePasswordRequest). Show: render profile with user data, email verification status, last login. ChangePassword: verify current password, hash new password, update user, log audit, keep session alive, redirect with success. Do NOT allow email change in this task (future scope).
  - acceptance: Controller exists, both methods work, audit is logged
  - verify: php artisan test tests/Feature/ProfileControllerTest.php
  - depends: T9
  - requirements: 6, 7

## Wave 6 — Views & Frontend

- [ ] T14 — Create auth views (register, login, forgot, reset, verify, profile, change-password)
  - why: Render user-facing forms (Req 1–7)
  - role: builder
  - files: resources/views/auth/register.blade.php, login.blade.php, forgot-password.blade.php, reset-password.blade.php, verify-email.blade.php, profile/show.blade.php, profile/change-password.blade.php
  - contract: Create Blade templates with forms (register, login, forgot, reset, verify) and read-only profile views. Include CSRF tokens, error display, success messages. Links between flows (register → verify, login → forgot, etc.). Do NOT add CSS (use Nothing.tech design system from previous spec, or plain HTML for MVP). Do NOT add JavaScript beyond form submission.
  - acceptance: All 7 view files exist, forms have correct fields, CSRF protection included
  - verify: php artisan test tests/Feature/AuthViewsTest.php
  - depends: T9, T11, T12, T13
  - requirements: 1–7

## Wave 7 — Integration Tests & Verification

- [ ] T15 — Write feature tests for register → verify → login flow
  - why: End-to-end test of core auth journey (Req 1, 2, 3)
  - role: verifier
  - files: tests/Feature/AuthFlowTest.php
  - contract: Test: register with valid data → email queued → navigate to verify-email → click verification link → email verified → log in with same credentials → session created. Test: register with invalid data → validation errors. Test: login before email verified → redirected to verify-email. Do NOT mock the queue; use fake queue or in-memory database.
  - acceptance: All tests pass, auth flow works end-to-end
  - verify: php artisan test tests/Feature/AuthFlowTest.php
  - depends: T9, T11, T14
  - requirements: 1, 2, 3

- [ ] T16 — Write feature tests for password reset flow
  - why: End-to-end test of password reset (Req 4)
  - role: verifier
  - files: tests/Feature/PasswordResetFlowTest.php
  - contract: Test: forgot-password with registered email → reset email sent → click link → reset password → old password fails, new password works. Test: forgot-password with unregistered email → no leak (same response). Test: expired token → error. Test: token consumed → error on reuse. Do NOT mock queue.
  - acceptance: All tests pass, password reset works end-to-end
  - verify: php artisan test tests/Feature/PasswordResetFlowTest.php
  - depends: T12, T14
  - requirements: 4

- [ ] T17 — Write feature tests for profile & change-password
  - why: Test profile view and password change (Req 6, 7)
  - role: verifier
  - files: tests/Feature/ProfileFlowTest.php
  - contract: Test: authenticated user views profile → data displayed. Test: change password with correct current → password updated, session kept. Test: change password with wrong current → validation error. Test: unauthenticated user → redirect to login.
  - acceptance: All tests pass, profile flows work
  - verify: php artisan test tests/Feature/ProfileFlowTest.php
  - depends: T13, T14
  - requirements: 6, 7

- [ ] T18 — Write feature tests for logout & session
  - why: Test logout and session invalidation (Req 5)
  - role: verifier
  - files: tests/Feature/SessionFlowTest.php
  - contract: Test: authenticated user logs out → session destroyed, redirect to login. Test: remember-me token revoked after logout → can't use old cookie. Test: logout without CSRF → error.
  - acceptance: All tests pass, session handling is secure
  - verify: php artisan test tests/Feature/SessionFlowTest.php
  - depends: T9
  - requirements: 5

- [ ] T19 — Write feature tests for rate limiting & security
  - why: Test throttling and security controls (Req 3 rate-limit, email send rate-limit)
  - role: verifier
  - files: tests/Feature/SecurityTest.php
  - contract: Test: 5 failed logins from same IP → 6th attempt throttled for 60s. Test: resend verification email > 1/min → throttled. Test: email verification link → signed URL + token validation (no tampering). Test: password reset token → one-time use, expiry enforced.
  - acceptance: All tests pass, security controls are enforced
  - verify: php artisan test tests/Feature/SecurityTest.php
  - depends: T10, T11, T12
  - requirements: 3, 2, 4
