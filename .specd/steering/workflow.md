# Workflow

## Working Loop
1. Read the relevant code and tests first.
2. Make the smallest change that satisfies the behavior.
3. Run the most specific verification possible.
4. Expand to broader checks only if the task needs it.

## Specd Discipline
When working under specd, keep the flow forward-only:
- inspect the current on-disk state
- implement the task in scope
- verify the result
- record evidence before calling the task complete

## Repository Workflow
- Keep edits scoped to the behavior being changed
- Update tests alongside implementation changes
- Use factories and seeders for deterministic test data
- Prefer existing Makefile targets over ad hoc command strings when possible

## Quality Gates
Use these checks as the default order:
- targeted test for the changed behavior
- `make test`
- `vendor/bin/pint` if formatting is affected

## Known Workflow Hazard
`routes/api.php` currently references a `UserController` that does not exist.
If a task touches that route, resolve the missing implementation explicitly
instead of assuming the controller is elsewhere.

## Command Hygiene
Follow the repository shell conventions and avoid destructive git commands unless
explicitly requested.
