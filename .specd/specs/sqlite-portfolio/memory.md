# Memory — SQLite Portfolio and JSON Seeding

<!--
Source-attributed, generalizable learnings (append-only). Use
`specd memory <spec> add --key <slug> --pattern "<one-line>" --body "<detail>"
  --source "<Turn N, Task T?, role>" --criticality <minor|important|critical> [--related k,k]`.
Only generalizable patterns, never raw observations. Promote to project steering at 3+ specs via
`specd memory <spec> promote --key <slug>`. Format:

## <key-slug>
**Pattern:** <one-line generalizable claim>
**Detail:** <why it's true; the mechanism>
**Source:** Task T3, Turn 2, discovered by investigator
**Criticality:** important
**Related:** [[other-key]]
-->

## sqlite-test-isolation
**Pattern:** Isolate database test environment modifications from test framework transactions.
**Detail:** When testing database failure modes or offline fallbacks in Laravel feature tests, avoid corrupting the default database connection used by the test framework's DatabaseTransactions trait. Instead, dynamically register a broken connection configuration and temporarily swap config('database.default') during the request life-cycle, restoring the original default database name in a finally block to prevent transaction teardown failures.
**Source:** Task T6, Turn 0, verifier
**Criticality:** important
**Related:** —
