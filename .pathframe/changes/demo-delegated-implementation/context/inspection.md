# Inspection

- `AGENTS.md` requires Pathframe orientation, approval before code edits, sequential verification/acceptance, and one new observation record.
- `PATHFRAME_CHANGE_PROMPTS.md` Change 5 selects high-risk `demo-delegated-implementation` and requires six delegated tasks in order.
- `database/migrations/0001_01_01_000000_create_users_table.php` creates the users table; it currently has no preference columns.
- `app/Models/User.php` uses fillable name/email/password, hides password/remember_token, casts email_verified_at/password, and has an activityEvents relationship.
- `routes/api.php` groups login/logout/activity routes under web middleware; activity uses auth middleware and `/api/users` is public.
- `app/Http/Controllers/Api/UserController.php` uses owner-only 404 behavior for activity reads and explicit JSON fields for user lists/events.
- `app/Models/UserActivityEvent.php` casts metadata to array; its migration stores user_id, event, nullable JSON metadata, timestamps, and an index.
- `database/factories/UserFactory.php` supplies standard user fields and should remain compatible with schema defaults.
- Existing Pest feature tests use RefreshDatabase and `actingAs`; audit tests establish authentication and safe event conventions.
- The worktree initially had an unrelated modified `PATHFRAME_CHANGE_PROMPTS.md`; it must be preserved.

## Delegation policy

- Brain prepares and leases T1-T6 one at a time in dependency order.
- Pinky edits only the leased task's write scope and returns the exact `pathframe.task-result/v1` structure.
- Brain never implements a leased task as fallback; failures use request-changes or Pathframe recovery.
