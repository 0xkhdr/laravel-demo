---
name: pathframe-observe
description: Observe and analyze Pathframe workflows across projects, producing concise evidence-based records without changing application or Pathframe state.
---

# Pathframe Observe

Use this skill when the user asks to observe, evaluate, audit, analyze, or record a Pathframe session or observation corpus. It applies to any repository; do not assume Laravel, a specific test runner, file layout, or CLI availability.

## Safety and scope

- Observe read-only. Do not approve, accept, replan, recover, verify, edit application code, or edit `.pathframe/` unless the user separately requests that action.
- Never delete or manually rewrite Pathframe state.
- Prefer typed Pathframe operations such as orientation/status and next-action queries when available. Do not construct Pathframe CLI commands if the active Pathframe integration requires typed tools.
- Preserve unrelated user changes. If creating a record, add exactly one new file; never append to or overwrite an earlier record.
- If evidence is unavailable, write `unknown`. Do not infer elapsed time, version, authorship, or outcomes.

## Discover the project contract

Before analyzing, inspect the repository instructions and observation contract:

1. Find applicable `AGENTS.md` files, observation README/templates, and any project-specific prompt.
2. Find the target change’s `.pathframe/changes/<change>/` artifacts, history, state, runs, and changed-file evidence.
3. Read relevant prior records. Treat them as evidence, not as facts about the current session.
4. Use the project’s required output location and filename convention. If none exists, return Markdown in the response instead of inventing a repository convention.

For a live session, capture a baseline first, then inspect again after meaningful transitions. Do not disturb the workflow to manufacture events.

## Evidence collection

Record exact, concise support for:

- orientation: phase, progress, blockers, and recommended next action;
- planning/context: reads, dependencies, scope, checks, approval, and mismatches between prompt and repository;
- implementation: files and behavior actually changed;
- verification: exact commands, exit status, pass/fail counts, scope violations, and whether the check was fresh;
- recovery: failures, pause/resume/replan/request-changes paths, and whether evidence survived;
- scope: declared versus actual files, unrelated changes, and any ambiguous ownership;
- final state: semantic acceptance versus tests alone.

Separate these layers in the record:

```md
## Observed
Direct facts from tool output, messages, artifacts, or diff.

## Interpretation
What those facts likely mean; label uncertainty.

## Recommendation
One actionable improvement, with evidence, expected benefit, and confidence.
```

Keep product/workflow findings separate from application defects. A failing test is evidence of a result or recovery path; it is not automatically a Pathframe defect.

## Ratings

When the project defines a rubric, use it exactly. Otherwise use 1–5 for:

- Native feel: fit with the normal agent workflow.
- Guidance value: improvement to focus, correctness, or legal next action.
- Overhead: ceremony, repetition, context cost, and delay.
- Recovery: clarity, safety, and evidence preservation after interruption or failure.

Use `unknown` when a dimension was not exercised. Cite the evidence beside every score.

## Cross-session analysis

For a corpus, group findings by recurring pattern rather than repeating records. Distinguish:

- repeated evidence across independent sessions;
- one-off repository or prompt inconsistencies;
- workflow friction caused by instructions, tool mismatch, or validator behavior;
- missing evidence that limits confidence.

Rank recommendations by recurrence and impact. Do not turn one observation into a universal product requirement. Prefer the smallest change that addresses repeated friction while preserving approval, verification, semantic acceptance, and recovery boundaries.

## Completion check

Before returning a record, confirm:

- every placeholder is replaced;
- facts, interpretation, and recommendation are separate;
- commands and relevant output are exact but concise;
- secrets and private data are absent;
- outcome and final Pathframe state are stated;
- post-acceptance edits are disclosed if they weaken correspondence with accepted evidence.
