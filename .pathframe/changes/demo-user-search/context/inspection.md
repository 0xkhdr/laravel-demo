# Inspected repository files

The following repository files were read before planning this change:

- `AGENTS.md`: required Pathframe workflow, scope, verification, acceptance, and observation rules.
- `PATHFRAME_CHANGE_PROMPTS.md`: Change 2 is standard mode `demo-user-search`.
- `app/Models/User.php`: existing Eloquent user model with fillable name/email/password and hidden secrets.
- `database/factories/UserFactory.php`: factory creates unique names and emails.
- `database/seeders/DatabaseSeeder.php` and `database/seeders/UserSeeder.php`: default seeding creates ten users.
- `routes/api.php`: health route exists and imports a missing `App\\Http\\Controllers\\Api\\UserController`.
- `tests/Feature/Api/UserListTest.php`: existing tests define `/api/users` paginated JSON shape, default ten-item page size, newest-first ordering, public access, and sensitive-field exclusion.
- `database/migrations/0001_01_01_000000_create_users_table.php`: users schema already has name and email; no schema change is needed.

Observed baseline fact: no `/api/users` route or `UserController` file exists in the inspected worktree, so the requested endpoint path must be supplied within the approved route/controller scope.
