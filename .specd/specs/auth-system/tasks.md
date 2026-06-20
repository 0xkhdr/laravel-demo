# Tasks — Auth System

## Wave 1 — Foundation & Migrations

- [ ] T1 — Create User migration
  - why: Foundation for all auth features (Req 1-5). User table holds email/password/name.
  - role: builder
  - files: database/migrations/0001_01_01_000000_create_users_table.php
  - contract: Use Laravel's default users migration (name, email, password, timestamps). Add nullable email_verified_at. Do NOT modify existing migration if it exists — check first.
  - acceptance: Migration exists, can run `php artisan migrate:fresh`, users table has: id, name, email, password, email_verified_at, remember_token, created_at, updated_at
  - verify: php artisan migrate:fresh && php artisan tinker -e "echo \DB::table('users')->getConnection()->getSchemaBuilder()->getColumnListing('users');"
  - depends: —
  - requirements: 1, 2, 3, 4, 5

- [ ] T2 — Create Role and Permission migrations (Spatie)
  - why: Store roles and permissions for RBAC (Req 4). Use Spatie's package structure.
  - role: builder
  - files: database/migrations/XXXX_XX_XX_XXXXXX_create_roles_table.php, database/migrations/XXXX_XX_XX_XXXXXX_create_permissions_table.php, database/migrations/XXXX_XX_XX_XXXXXX_create_model_has_roles_table.php, database/migrations/XXXX_XX_XX_XXXXXX_create_role_has_permissions_table.php
  - contract: Run `composer require spatie/laravel-permission` then publish migrations. Do NOT modify published migrations. Keep role_user pivot table name as model_has_roles (Spatie default).
  - acceptance: 4 new migration files exist, can run without errors, role/permission/model_has_roles/role_has_permissions tables created
  - verify: php artisan migrate:fresh && php artisan tinker -e "echo \DB::table('roles')->count();"
  - depends: T1
  - requirements: 4

- [ ] T3 — Seed default roles (author, admin)
  - why: Bootstrap roles for new users (Req 4). RegisterUser assigns author role by default.
  - role: builder
  - files: database/seeders/RoleSeeder.php
  - contract: Create seeder that creates 'author' and 'admin' roles. Add permissions: create_posts, edit_posts, delete_posts, view_posts, delete_users (admin only). Do NOT seed random data — use fixed role/permission names.
  - acceptance: Seeder exists, runs without error, creates exactly 2 roles and 5 permissions, admin has all permissions, author has post-only permissions
  - verify: php artisan db:seed --class=RoleSeeder && php artisan tinker -e "echo \App\Models\User::role('author')->count();"
  - depends: T2
  - requirements: 4

## Wave 2 — Models

- [ ] T4 — Create User model with roles/permissions
  - why: User entity central to auth (Req 1-5). Relationships to roles and permissions.
  - role: builder
  - files: app/Models/User.php
  - contract: Update User model to use Spatie's HasRoles trait. Add methods: hasRole(name), hasPermission(name), roles(), permissions(). Keep factory for seeding. Do NOT add password mutation (bcrypt should be in Action, not model).
  - acceptance: User model has HasRoles trait, hasRole/hasPermission methods exist, roles() and permissions() relationships return collections, factory can create users with roles
  - verify: php artisan tinker -e "\$u = \App\Models\User::factory()->create(); \$u->assignRole('author'); echo \$u->hasRole('author') ? 'OK' : 'FAIL';"
  - depends: T3
  - requirements: 1, 4

- [ ] T5 — Create Role and Permission models (Spatie)
  - why: Represent roles and permissions as Eloquent models for database queries.
  - role: builder
  - files: app/Models/Role.php, app/Models/Permission.php
  - contract: Spatie's package auto-creates these. Verify they exist in app/Models and have relationships (permissions(), roles()). Do NOT modify published stubs beyond adding custom methods if needed.
  - acceptance: Role and Permission models exist, can query \App\Models\Role::all(), permissions() relationship works
  - verify: php artisan tinker -e "echo count(\App\Models\Role::all()) > 0 ? 'OK' : 'FAIL';"
  - depends: T2
  - requirements: 4

## Wave 3 — Business Logic (Actions)

- [ ] T6 — Create RegisterUser action
  - why: Handle user registration with password hashing and author role assignment (Req 1).
  - role: builder
  - files: app/Actions/RegisterUser.php
  - contract: Accept name, email, password from RegisterRequest. Hash password using bcrypt (Hash::make). Create User. Assign author role. Return User instance with roles eager-loaded. Throw ValidationException if email exists.
  - acceptance: Action callable, creates user with bcrypt'd password, auto-assigns author role, returns User with roles, throws on duplicate email
  - verify: php artisan test tests/Unit/Actions/RegisterUserTest.php
  - depends: T4
  - requirements: 1

- [ ] T7 — Create LoginUser action
  - why: Authenticate user and issue Sanctum token (Req 2).
  - role: builder
  - files: app/Actions/LoginUser.php
  - contract: Accept email, password from LoginRequest. Verify credentials with Auth::attempt() (not direct DB query). Issue Sanctum token with \$user->createToken('token')->plainTextToken. Return token and user. Throw AuthenticationException if invalid.
  - acceptance: Action callable, validates credentials, issues Sanctum token on success, throws on invalid, token can authenticate requests
  - verify: php artisan test tests/Unit/Actions/LoginUserTest.php
  - depends: T4
  - requirements: 2

- [ ] T8 — Create LogoutUser action
  - why: Revoke user's API tokens (Req 5).
  - role: builder
  - files: app/Actions/LogoutUser.php
  - contract: Accept authenticated User. Delete all tokens from personal_access_tokens table: \$user->tokens()->delete(). Return null. Do NOT throw on already-logged-out users.
  - acceptance: Action callable, deletes all user tokens, subsequent requests with old token return 401
  - verify: php artisan test tests/Unit/Actions/LogoutUserTest.php
  - depends: T4
  - requirements: 5

## Wave 4 — Routes & Controllers

- [ ] T9 — Create auth routes
  - why: Define endpoints for register, login, logout, me (Req 1, 2, 3, 5).
  - role: builder
  - files: routes/api.php
  - contract: Add routes under /api/v1/auth prefix: POST register, POST login, POST logout (middleware: auth:sanctum), GET me (middleware: auth:sanctum). No model binding, use named routes (auth.register, auth.login, etc).
  - acceptance: Routes defined, can GET /api/v1/auth endpoints, middleware attached, no 404s
  - verify: php artisan route:list | grep auth
  - depends: T3
  - requirements: 1, 2, 3, 5

- [ ] T10 — Create auth controllers
  - why: HTTP handlers for auth routes (Req 1-5).
  - role: builder
  - files: app/Http/Controllers/Auth/RegisterController.php, app/Http/Controllers/Auth/LoginController.php, app/Http/Controllers/Auth/LogoutController.php, app/Http/Controllers/Auth/MeController.php
  - contract: Thin controllers — validate with Request class, call Action, return JsonResponse. RegisterController → RegisterUser action. LoginController → LoginUser action. LogoutController → LogoutUser action. MeController returns Auth::user(). No business logic in controller.
  - acceptance: Controllers exist, route to them works, all return JSON (no HTML), validation errors return 422
  - verify: php artisan test tests/Feature/Auth/RegisterTest.php
  - depends: T6, T7, T8, T9
  - requirements: 1, 2, 3, 5

- [ ] T11 — Create request validation classes
  - why: Validate register/login requests before Actions (Req 1, 2).
  - role: builder
  - files: app/Http/Requests/Auth/RegisterRequest.php, app/Http/Requests/Auth/LoginRequest.php
  - contract: RegisterRequest: require name, email (unique), password (min 8). LoginRequest: require email, password. Return validated data via ->validated(). Do NOT call Action from Request — only validate.
  - acceptance: Request classes exist, validation rules enforced, invalid input returns 422 with error messages
  - verify: php artisan test tests/Feature/Auth/ -k "validation"
  - depends: —
  - requirements: 1, 2

- [ ] T12 — Create policies (UserPolicy, PostPolicy)
  - why: Authorize resource actions based on roles (Req 4).
  - role: builder
  - files: app/Policies/UserPolicy.php, app/Policies/PostPolicy.php
  - contract: UserPolicy: user can update/delete only self or if admin. PostPolicy: author can update/delete own posts, admin can delete any. Use \$user->hasRole('admin') for checks. Register in AuthServiceProvider.
  - acceptance: Policies exist, register in AuthServiceProvider, \$this->authorize() in controllers works
  - verify: php artisan test tests/Feature/Auth/AuthorizationTest.php
  - depends: T4
  - requirements: 4

## Wave 5 — Tests

- [ ] T13 — Write unit tests for Auth Actions
  - why: Verify business logic (RegisterUser, LoginUser, LogoutUser).
  - role: builder
  - files: tests/Unit/Actions/RegisterUserTest.php, tests/Unit/Actions/LoginUserTest.php, tests/Unit/Actions/LogoutUserTest.php
  - contract: Use Pest syntax. Test: valid input → success, invalid → exception, side effects (role assigned, token issued, token revoked). Mock database if needed for speed.
  - acceptance: 9+ assertions total (3 per action), all pass, coverage > 90%
  - verify: php artisan test tests/Unit/Actions/
  - depends: T6, T7, T8
  - requirements: 1, 2, 5

- [ ] T14 — Write feature tests for auth endpoints
  - why: Verify HTTP layer (Req 1-5).
  - role: builder
  - files: tests/Feature/Auth/RegisterTest.php, tests/Feature/Auth/LoginTest.php, tests/Feature/Auth/LogoutTest.php, tests/Feature/Auth/MeTest.php
  - contract: Use Pest with database transactions (RefreshDatabase). Test: happy path (201/200 with token), validation errors (422), authentication errors (401), authorization errors (403). Assert response structure and database state.
  - acceptance: 16+ assertions total (4 per endpoint), all pass, happy path + error cases covered
  - verify: php artisan test tests/Feature/Auth/
  - depends: T10, T11, T12
  - requirements: 1, 2, 3, 4, 5

- [ ] T15 — Write integration tests
  - why: Full auth flow (register → login → authenticated request → logout).
  - role: builder
  - files: tests/Feature/Auth/AuthFlowTest.php
  - contract: Single test: register user → login → GET /me → assert user returned → logout → GET /me returns 401. Verify end-to-end state consistency.
  - acceptance: Test passes, all 4 assertions pass, flow is realistic
  - verify: php artisan test tests/Feature/Auth/AuthFlowTest.php
  - depends: T10, T14
  - requirements: 1, 2, 3, 5

## Wave 6 — Verification

- [ ] T16 — Run full test suite
  - why: Verify all auth features work together.
  - role: verifier
  - files: N/A
  - contract: Run `php artisan test tests/Unit/Actions/ tests/Feature/Auth/`. All tests must pass. No skips.
  - acceptance: Exit code 0, all tests pass, no warnings
  - verify: php artisan test tests/Unit/Actions/ tests/Feature/Auth/
  - depends: T13, T14, T15
  - requirements: 1, 2, 3, 4, 5
