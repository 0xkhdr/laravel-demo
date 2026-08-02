<!-- specd:begin schema=1 hash=62bcddc8494d8d92be1c69da7ac00fc79a476219b1eec934f5ba87b37be39972 -->
# specd agent guide

Generated from the operation registry (schema 1). The bytes
between the managed markers are harness-owned: edit them and refresh refuses as
drift. Write your own notes outside the markers; they are preserved verbatim.

## Root and change

Selection is explicit. Every operation resolves one project root, passed as
`--root <path>`, and one change by name. Nothing is inferred from the
repository, the branch, or the last thing you ran.

## Who owns what

You author Markdown: `proposal.md`, `design.md`, `tasks.md`, and the capability
deltas under `specs/<capability>/spec.md`. The harness owns everything else
under `.specd/` — `state.json`, `history.jsonl`, `evidence.jsonl`, and the lock
files. Writing to a harness-owned path is never a repair; it is a refusal you
caused.

## The loop

`next` -> `context` -> `start` -> edit only the declared files -> `verify` ->
`complete`. Run one task at a time and take the next action the result names.

When every task is complete, a human authorizes the transition that turns the
proposal into accepted truth. You are never handed that verb. Once it has
happened, `archive` is the last local step, and it claims nothing beyond the
local repository: it does not deploy, commit, push, or open anything.

## Declared scope

`context` and `start` tell you the exact files the task may write. That list is
the whole permission. A file you were not given is out of scope even when the
fix is obvious: stop and report instead of widening it.

## Verification is not completion

`verify` records one observation against current HEAD. It never completes
anything, and a passing run is not a done task. `complete` is the harness
transition that consumes that evidence; if HEAD moved, the evidence is stale and
you verify again.

## The human gate

Semantic authorization is human-only. It is not in your palette, it has no
agent-callable form, and no flag reveals one. When a result hands you
`next.kind = "human_handoff"`, stop and report the instruction verbatim to the
human. Do not continue, do not work around it, and do not claim the human gate
has been passed.

## When you are refused

Every refusal names exactly one legal next action. Take that one. Stale state,
a moved HEAD, an ambiguous selector, or a malformed artifact all fail closed on
purpose; retrying the same call unchanged, or hand-editing managed state to get
past it, is always wrong.

## Host assurance

The harness declares and validates scope, actor class, and approval. It cannot
contain a process. Unless your host proves otherwise, treat every such
guarantee as `advisory`: it is checked, not enforced. Do not report an advisory
guarantee as an enforced one.

## Review is a separate pair of eyes

`review` carries a verdict a separate human authored. You may record it, you may
never author it: the reviewer identity is resolved from a trusted source and can
be neither the human who authorized the plan nor the actor that implemented the
task. A verdict is bound to one attempt, one commit, and one policy, and any
observation recorded after it makes it stale. It proves nothing runnable: a
review never replaces a check you were asked to run.

## Reports project truth, they do not change it

`report` renders exactly four kinds: `status`, `proof`, `history`, and `review`.
Each is a read-only projection of state, readiness, history, evidence, and
policy; none of them writes, transitions, or authorizes anything. A report
carries bounded identities, counts, and codes — never source bodies, command
output, patches, or logs — so quote its facts rather than inventing detail it
deliberately omits. Deferred-domain friction eligibility appears in `status` and
`review` as a fact for a root owner to weigh: it never authorizes a domain and
never unblocks an operation.

## Operations available to you

### init

Create or adopt the managed .specd root and install the agent guidance file.

- usage: `specd init [root] [--root <root>] [--json]`
- effect: project_write
- example: `specd init`

### new

Create a change with its planning artifacts and state.

- usage: `specd new <change> [--root <root>] [--json] [--capability <capability>]`
- effect: state_write
- example: `specd new safe-create --capability safety`

### check

Run planning gates over the change and report findings.

- usage: `specd check <change> [--root <root>] [--json]`
- effect: read
- example: `specd check safe-create`

### status

Report lifecycle, approval, readiness, and next action for a change.

- usage: `specd status <change> [--root <root>] [--json]`
- effect: read
- example: `specd status safe-create`

### next

Project the ready task frontier or the single blocking action.

- usage: `specd next <change> [task] [--root <root>] [--json]`
- effect: read
- example: `specd next safe-create`

### context

Assemble the bounded read context for exactly one task.

- usage: `specd context <change> <task> [--root <root>] [--json] [--budget-bytes <budget-bytes>]`
- effect: read
- example: `specd context safe-create S1-01 --budget-bytes 65536`

### start

Bind a clean Git baseline and open one task attempt.

- usage: `specd start <change> <task> [--root <root>] [--json] --revision <revision>`
- effect: state_write
- example: `specd start safe-create S1-01 --revision 4`

### verify

Run the task's declared verification and record evidence at current HEAD.

- usage: `specd verify <change> <task> <attempt> [--root <root>] [--json] [--timeout <timeout>] [--output-limit <output-limit>]`
- effect: state_write
- example: `specd verify safe-create S1-01 A1 --timeout 2m`

### complete

Consume applicable passing evidence and close the task.

- usage: `specd complete <change> <task> [--root <root>] [--json] --revision <revision>`
- effect: state_write
- example: `specd complete safe-create S1-01 --revision 6`

### review

Record or project one separate reviewer verdict for a task.

- usage: `specd review <change> <task> <attempt> [--root <root>] [--json] [--reviewer <reviewer>] [--verdict <verdict>] [--findings <findings>]`
- effect: state_write
- example: `specd review safe-create S1-01 A1 --reviewer reviewer@example.com`

### archive

Validate and move a reconciled change into the archive.

- usage: `specd archive <change> [--root <root>] [--json]`
- effect: state_write
- example: `specd archive safe-create`

### report

Project one of the four canonical read-only reports.

- usage: `specd report <change> [--root <root>] [--json] --kind <kind> [--profile <profile>]`
- effect: read
- example: `specd report safe-create --kind status`

### friction

Record one observation that a deferred domain blocked real work.

- usage: `specd friction <change> <task> [--root <root>] [--json] --domain <domain> --blocked-operation <blocked-operation> --consequence <consequence> --revision <revision>`
- effect: state_write
- example: `specd friction safe-create S1-01 --domain orchestration --blocked-operation next --consequence no-route-exists --revision 6`

Nothing outside this list is callable. If you want an operation that is not
here, report that instead of inventing one.
<!-- specd:end -->
