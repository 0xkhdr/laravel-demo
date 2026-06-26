# Requirements — Authentication & User Management

## Introduction

Portfolio platform requires a complete auth flow (register, verify email, login, logout, password reset) with secure session management and user account controls. Users can create accounts, verify email, authenticate, reset forgotten passwords, view profiles, and change passwords. This unlocks future features like user-generated content, saved preferences, and admin capabilities.

## Requirement 1 — User Registration

**User story:** As a guest, I want to register for an account with email and password, so that I can log in and access user features.

**Acceptance criteria:**
1. WHEN guest submits registration form THE SYSTEM SHALL validate inputs (name required, email unique and valid format, password min 8 chars, passwords match)
2. WHEN validation passes THE SYSTEM SHALL hash password using bcrypt and create user record in database
3. WHEN user created THE SYSTEM SHALL send email with verification link (24h expiry) and redirect to `/auth/verify-email`
4. IF email already exists THEN THE SYSTEM SHALL return validation error for duplicate email
5. IF passwords do not match THEN THE SYSTEM SHALL return validation error for mismatch
6. THE SYSTEM SHALL NOT auto-login user after registration

## Requirement 2 — Email Verification

**User story:** As a registered user, I want to verify my email address, so that I can activate my account and log in.

**Acceptance criteria:**
1. WHEN user clicks verification link with token THE SYSTEM SHALL verify token validity and expiry (max 24h old)
2. WHEN token is valid THE SYSTEM SHALL mark email_verified_at timestamp, consume token (one-time use), and redirect to login with success message
3. IF token is invalid or expired THEN THE SYSTEM SHALL redirect to verify-email page with error message and resend option
4. WHEN user requests resend on verify-email page THE SYSTEM SHALL rate-limit to 1 per minute and send new verification email
5. THE SYSTEM SHALL display verify-email page until email is verified

## Requirement 3 — User Login

**User story:** As a registered user with verified email, I want to log in with email and password, so that I can access my account.

**Acceptance criteria:**
1. WHEN user submits login form with email and password THE SYSTEM SHALL validate credentials against user record
2. WHEN credentials are valid THE SYSTEM SHALL create session, set httpOnly secure cookie, and redirect to intended URL or `/dashboard`
3. IF credentials are invalid THEN THE SYSTEM SHALL return generic error message (no user-existence leak)
4. IF user email is not verified THEN THE SYSTEM SHALL redirect to verify-email page
5. WHEN user selects "Remember me" THE SYSTEM SHALL create persistent token cookie (30-day expiry)
6. IF more than 5 failed login attempts from same IP in 1 minute window THEN THE SYSTEM SHALL lock that IP for 60 seconds
7. THE SYSTEM SHALL log login attempts including IP, timestamp, and success/fail status for audit

## Requirement 4 — Password Reset

**User story:** As a user who forgot my password, I want to reset it via email link, so that I can regain access to my account.

**Acceptance criteria:**
1. WHEN user submits forgot-password form with email THE SYSTEM SHALL generate reset token (1h expiry) and send reset link email
2. WHEN email is registered THE SYSTEM SHALL send reset link; WHEN email is not registered THE SYSTEM SHALL show same success message (no email-existence leak)
3. WHEN user clicks reset link THE SYSTEM SHALL display reset-password form with new password and confirmation fields
4. WHEN reset form is submitted THE SYSTEM SHALL validate new password (min 8 chars, matches confirmation, differs from current)
5. WHEN validation passes THE SYSTEM SHALL update password hash, consume reset token (one-time use), revoke all active sessions, and redirect to login
6. IF reset token is invalid or expired THEN THE SYSTEM SHALL redirect to forgot-password with error message
7. THE SYSTEM SHALL NOT send password reset email to unverified email addresses

## Requirement 5 — User Logout

**User story:** As a logged-in user, I want to log out, so that my account is secure when I leave.

**Acceptance criteria:**
1. WHEN user clicks logout button THE SYSTEM SHALL destroy session, clear session cookie, revoke remember-me token
2. WHEN logout complete THE SYSTEM SHALL redirect to login page with success message
3. THE SYSTEM SHALL verify CSRF token before processing logout
4. THE SYSTEM SHALL log logout event (user_id, timestamp)

## Requirement 6 — User Profile View

**User story:** As a logged-in user, I want to view my profile, so that I can see my account details.

**Acceptance criteria:**
1. WHEN user navigates to `/dashboard/profile` THE SYSTEM SHALL display name, email, email verification status, and last login timestamp
2. THE SYSTEM SHALL display "Change Password" and "Logout" action buttons
3. WHEN email not yet verified THE SYSTEM SHALL show "Verify email" link and timestamp of last verification email
4. THE SYSTEM SHALL require authentication (redirect to login if not authenticated)
5. THE SYSTEM SHALL not allow edit in this view (read-only MVP)

## Requirement 7 — Change Password

**User story:** As a logged-in user, I want to change my password, so that I can update my security credentials.

**Acceptance criteria:**
1. WHEN user navigates to `/dashboard/change-password` THE SYSTEM SHALL display form with current password, new password, and confirmation fields
2. WHEN user submits form THE SYSTEM SHALL verify current password against user record
3. IF current password is incorrect THEN THE SYSTEM SHALL return validation error
4. WHEN new password is valid (min 8 chars, matches confirmation, differs from current) THE SYSTEM SHALL update password hash
5. WHEN password is updated THE SYSTEM SHALL keep session active and redirect to profile with success message
6. THE SYSTEM SHALL require authentication before accessing this endpoint
7. THE SYSTEM SHALL log password change event including user_id and timestamp

## Non-Functional Requirements

- **Security**: All auth routes protected with middleware. CSRF tokens on all forms. No sensitive data in logs/errors. Password reset tokens stored as hashed (not plaintext).
- **Performance**: Login and registration complete in <200ms. Password hashing uses bcrypt with cost 10.
- **Notifications**: Emails sent async (queue). No blocking on notification failures.
- **Data Integrity**: Migrations reversible. No cascading deletes of users.
- **Session Management**: Cookie attributes: HttpOnly=true, Secure=true (prod), SameSite=Lax.

## Out of Scope (Future Phases)

- OAuth / Social login (GitHub, Google)
- Two-factor authentication (2FA / TOTP)
- Admin user management panel
- User roles and permissions
- Email domain blocklists / allowed domains
- Rate-limiting by email address
- Account deletion / GDPR data export
- Login activity history / device management
