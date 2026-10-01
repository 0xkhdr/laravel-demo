# Pathframe Change Prompts

Run these changes one at a time. Each prompt is the starting message for a new Pathframe change. Record each session in its own Markdown file under [`observations/`](observations/), following [`observations/README.md`](observations/README.md).

## Change 1 — API health endpoint

Mode: `quick`  
ID: `demo-health-endpoint`

### Prompt

> Use Pathframe to implement the smallest useful health endpoint in this Laravel demo. First inspect the project and Pathframe status. Create and validate a quick change named `demo-health-endpoint`, then wait for approval before editing application code. Add `GET /api/health` that returns JSON with `status: ok` and a stable application identifier. Add one focused feature test for the response status, JSON shape, and content type. Reuse existing route and test conventions; do not add a package, database work, authentication, or frontend work. Run the approved checks, verify the task, accept it only if the implementation and evidence satisfy the prompt, and report the exact files and commands changed. Record the session in a new Markdown file under `observations/`.

Expected scope: `routes/api.php`, one feature test, and only the minimum supporting file if the repository requires it.

## Change 2 — User search and pagination

Mode: `standard`  
ID: `demo-user-search`

### Prompt

> Use Pathframe to add a small user-list API improvement. First inspect the current user model, factory, seed data, route, existing API test, and Pathframe status. Create and validate a standard change named `demo-user-search`, with explicit required reads, task dependencies, write scope, and verification commands; wait for approval before implementation. Extend the existing user list endpoint to support optional `search` filtering by name or email and bounded `per_page` pagination. Preserve the current default response contract for callers that provide no parameters. Validate input using Laravel’s existing facilities, avoid new dependencies and avoid changing the database schema. Add focused tests for default behavior, matching search, no match, and the pagination bounds. Verify and semantically accept only after the approved checks pass. Record the session in a new Markdown file under `observations/`.

Expected scope: existing user route/controller/model path and focused API tests. Do not create a new service layer unless current code proves it is necessary.

## Change 3 — User activity audit trail

Mode: `high-risk`  
ID: `demo-user-audit-trail`

### Prompt

> Use Pathframe to design and implement a bounded user activity audit trail for this Laravel demo. Treat this as a high-risk change: inspect existing authentication assumptions, user routes, migrations, model conventions, tests, and Pathframe status before planning. Create and validate a high-risk change named `demo-user-audit-trail` with separate tasks for schema/model, write behavior, read behavior, and verification. Wait for explicit approval before editing. Record user-facing activity without storing secrets or raw credentials; define the event fields, retention assumptions for this demo, ordering, and authorization behavior in the approved intent. Add migration/model code, the smallest event-writing integration that matches the existing application, a read endpoint limited to the relevant user data, and focused tests. Prefer existing Laravel primitives and do not add a package or build an admin UI. If the current demo has no trustworthy actor context, stop and request a plan decision instead of inventing one. Verify each task, inspect changed-file scope, and accept only after semantic review. Record the session in a new Markdown file under `observations/`.

Expected scope: only the files justified by the approved plan. This task is intentionally allowed to stop at a documented blocker.

## Change 4 — Recovery rehearsal

Mode: `standard`  
ID: `demo-recovery-rehearsal`

### Prompt

> Use Pathframe to rehearse recovery without adding a product feature. Create and validate a standard change named `demo-recovery-rehearsal` with one harmless documentation task. After approval, pause the change, inspect status, resume it, and document the state transitions. Then introduce a controlled task-level check failure in the plan or test command, observe the reported recovery action, and restore the approved plan without deleting `.pathframe/` or rewriting Git history. Do not change Laravel application behavior. Record the session in a new Markdown file under `observations/`. Finish only when the change is either accepted or explicitly cancelled with its history preserved.

Expected scope: the observation file and Pathframe-authored state only. No application code.

## Change 5 — Delegated multi-layer implementation

Mode: `high-risk`
ID: `demo-delegated-implementation`

### Prompt

> Use Pathframe to implement a bounded, multi-layer user-preferences feature through delegation. First inspect the existing users schema, `User` model, authentication middleware, activity-event model, API controller/routes, factories, tests, and Pathframe status. Create and validate a high-risk change named `demo-delegated-implementation` with explicit reads, write scope, task dependencies, and verification commands. Define separate ready tasks for: (1) the database migration and model casts/defaults, (2) owner-only authorization behavior, (3) the authenticated read endpoint, (4) the validated update endpoint, (5) recording a non-sensitive `preferences.updated` activity event, and (6) focused feature tests plus final verification. Wait for explicit approval before editing. After approval, the Brain must prepare and lease each ready task to Pinky in dependency order; Pinky may edit only the leased files and must return its exact structured result. The Brain must not implement a leased task as a fallback. Add authenticated owner-only `GET` and `PATCH /api/users/{user}/preferences` endpoints. Store `timezone` (string, default `UTC`), `email_notifications` (boolean, default `true`), and `marketing_notifications` (boolean, default `false`) on the users table. The read response must expose only the user id and these preference fields. The update endpoint must validate supplied fields, reject unknown or invalid values using Laravel’s existing facilities, persist the changes, and write an activity event without secrets or raw request data. Preserve existing routes and response contracts. Reuse existing Laravel primitives, add no package, queue, frontend, or unrelated schema work. Verify each delegated task with the approved checks, inspect changed-file scope after every result, semantically accept only when the complete feature and evidence meet the approved objective, and record delegation order, dependencies, verification, recovery, and acceptance evidence in a new Markdown observation file.

Expected scope: one users migration, the existing user model/controller/routes, the smallest validation or policy file justified by the implementation, focused API tests, the approved Pathframe artifacts, and one new observation record. No new service layer unless existing code proves it necessary; no unrelated application changes.
