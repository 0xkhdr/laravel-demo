# Memory

## Stable Repo Facts
- This is a Laravel demo app.
- The project is Docker-first for local development.
- The current visible app surfaces are `/` and `/api/users`.
- User data is seeded and factory-backed.

## Persistent Working Rules
- Prefix shell commands with `rtk` when using the shell.
- Read the existing code before editing.
- Keep changes minimal and test-backed.
- Do not assume missing classes or files exist elsewhere.

## Current Implementation Notes
- `routes/api.php` references `App\Http\Controllers\Api\UserController`.
- That controller is not present in the repository at the moment.
- Feature tests cover paginated user-list behavior.
- Unit tests cover the user model and factory expectations.

## Future-Agent Reminder
If you are changing API behavior, check the route, controller, model, factory,
and tests together before editing.
