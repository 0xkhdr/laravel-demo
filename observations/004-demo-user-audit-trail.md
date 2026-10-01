# demo-user-audit-trail — 2026-10-01

- Agent/host: Codex / codex
- Pathframe version: unknown
- Mode: high-risk
- Prompt: Change 3 in PATHFRAME_CHANGE_PROMPTS.md
- Outcome: accepted
- Elapsed time: unknown
- Commands observed:
  - `sed -n '1,240p' .agents/skills/pathframe/SKILL.md`
  - `pathframe_orient` equivalent typed tool: multiple changes found; select one
  - `pathframe_create_change` equivalent typed tool for `demo-user-audit-trail`
  - `pathframe_validate_plan` equivalent typed tool: valid plan; approval required

## Observed

- Orientation: The repository was clean. Pathframe reported multiple existing changes until the new change ID was selected.
- Planning and context: `config/auth.php` has only a session guard; `bootstrap/app.php` adds no custom middleware; `routes/api.php` exposes public `/api/health` and `/api/users`; the existing test asserts `/api/users` is publicly accessible; no login or token route exists.
- Implementation: After approval and replan, T0 added the minimum session login/logout actor boundary; T1 added the user-owned audit schema/model; T2 recorded successful login events with 100-event retention; T3 added authenticated self-only reads; T4 performed final verification.
- Verification: `php artisan test` passed 32 tests and 121 assertions; `git diff --check` passed; Pathframe accepted T0 through T4. T2's first check exposed SQLite's invalid OFFSET-without-LIMIT retention query, which was corrected before acceptance.
- Recovery or interruption: The initial plan stopped on missing actor context. The user approved a replan adding the minimum session boundary. Artifact validation also required corrections for duplicate front matter, placeholders, references, and required-read paths.
- Scope behavior: Application changes stayed within the approved authentication boundary, audit model/migration, route/controller paths, and focused tests. Pathframe reported those declared files as scope violations because the task write scopes were generic; they were explicitly reviewed and kept.
- Pathframe contract friction: The generated high-risk artifacts did not validate immediately. The validator rejected duplicate `profile` front matter, placeholder-like syntax, unquoted reference arrays, direct repository-relative required reads, and non-`none` question text. A blocker therefore had to be described outside the `Questions` section before the plan could validate.
- Scope/commit behavior: Pathframe verification repeatedly returned every declared changed file in `scope_violations`, even when those files matched the task's intended scope, requiring `keep_scope_violations: true`. Git history also showed audit-related commits (`d38b081`, `7aac4d6`, `aa7c150`, `6e9121f`, `4bc7688`) although no explicit commit command was part of the observed workflow; final `git status --short` was clean.
- Instruction friction: `AGENTS.md` documents Pathframe CLI commands, while the Pathframe skill requires typed Pathframe tools only. The typed tools were used, but the repository instructions and skill did not describe the same interface.

## Ratings

| Dimension | Score (1–5) | Evidence |
| --- | ---: | --- |
| Native feel | 4 | Typed orientation, approval, sequential tasks, and acceptance fit the staged workflow. |
| Guidance value | 5 | The workflow surfaced the missing actor context and preserved the replan decision. |
| Overhead | 3 | High-risk artifact authoring and per-task verification required repeated corrections. |
| Recovery | 5 | The actor-context blocker and SQLite verification failure were recoverable without losing evidence. |

## Good / native

- Pathframe made the actor-context blocker explicit before risky code, then preserved the approved replan and task frontier.

## Interpretation

- The strongest failure was planning-contract friction, not loss of implementation state: validation errors were actionable, but the agent had to reverse-engineer the accepted artifact format and move a real blocker out of the machine-checked Questions section.
- Scope enforcement was conservative but noisy. Requiring explicit keep decisions for files already named by the work reduced confidence in the meaning of `scope_violations`.
- The actor-context stop and T2 verification failure demonstrate useful safety/recovery behavior; both prevented silent acceptance of an unsafe or non-portable implementation.
- The unexplained commit history is a workflow-observability gap. The session ended clean, but the evidence does not show who or what created the intermediate commits.

## Wrong / confusing / overhead

- The generated templates and validator differed on accepted front matter/reference formatting; validation feedback was needed to converge. Scope reports also required explicit keep decisions for the declared files.

## Recommendation

- Recommendation: Preserve the early actor-context gate, but make generated high-risk templates validator-clean and document accepted repository-relative reads.
- Evidence: Initial validation rejected duplicate `profile` fields, unquoted reference arrays, unresolved questions, and incorrect required-read paths; later T2 verification caught the SQLite retention query issue.
- Expected benefit: Less planning friction while retaining the safety stop.
- Confidence: high
- Recommendation: Make `scope_violations` distinguish undeclared files from declared files, and record commit authorship/source in the workflow evidence.
- Evidence: T0–T4 verification reported the declared task files as violations, and `git log` showed multiple audit commits without an observed commit command.
- Expected benefit: Faster semantic review and clearer preservation of user changes.
- Confidence: medium
- Recommendation: Align `AGENTS.md` and the Pathframe skill on one supported command interface.
- Evidence: The repository instructions show CLI examples while the skill prohibits constructing CLI commands.
- Expected benefit: Fewer invalid or contradictory agent actions at session start.
- Confidence: high

## Verification evidence

- Pathframe commands/results: high-risk change created, replanned, validated, explicitly approved, five tasks verified and accepted; final phase `done` with progress `5/5`.
- Laravel commands/results: `php artisan test --filter Auth` passed 5 tests; `php artisan test --filter Audit` passed 10 tests/27 assertions; `php artisan test` passed 32 tests/121 assertions; `git diff --check` passed.
- Changed files: `app/Http/Controllers/Api/AuthController.php`, `app/Http/Controllers/Api/UserController.php`, `app/Models/User.php`, `app/Models/UserActivityEvent.php`, `database/migrations/2026_10_01_000000_create_user_activity_events_table.php`, `routes/api.php`, `tests/Feature/Api/AuthTest.php`, `tests/Feature/Api/AuditSchemaTest.php`, `tests/Feature/Api/AuditWriteTest.php`, `tests/Feature/Api/AuditReadTest.php`, plus Pathframe state/run artifacts and this observation record.
