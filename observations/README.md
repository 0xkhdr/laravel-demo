# Pathframe Observation Records

Create one Markdown file for every coding-agent session that uses Pathframe in this Laravel demo. Keep all records in this directory.

## Filename convention

Use a stable sequence and change ID:

```text
observations/001-demo-health-endpoint.md
observations/002-demo-user-search.md
observations/003-demo-user-audit-trail.md
```

If the same change has multiple sessions, use a distinct suffix, for example `002-demo-user-search-retry.md`. Never overwrite an earlier record and never append multiple sessions to one file.

## Recording rules

- Use UTC timestamps or include the timezone.
- Record facts before interpretation.
- Mark unavailable evidence `unknown`; do not guess.
- Include exact commands and concise relevant output when they support a finding.
- Record native behavior, friction, overhead, recovery, and recommendations.
- Never store secrets, tokens, credentials, or private user data.

## Rating rubric

Use `1` to `5`:

- Native feel: `1` fights the normal agent workflow; `5` fits it naturally.
- Guidance value: `1` adds little; `5` materially improves focus or correctness.
- Overhead: `1` negligible; `5` materially slows or distracts the workflow.
- Recovery: `1` unclear or lossy; `5` clear, safe, and evidence-preserving.

## Per-record template

Copy this template into a new file. Replace every placeholder before marking the session complete.

```md
# <change-id> — <session date>

- Agent/host:
- Pathframe version:
- Mode:
- Prompt: <change and prompt filename>
- Outcome: accepted | changes requested | blocked | cancelled
- Elapsed time:
- Commands observed:

## Observed

- Orientation:
- Planning and context:
- Implementation:
- Verification:
- Recovery or interruption:
- Scope behavior:

## Ratings

| Dimension | Score (1–5) | Evidence |
| --- | ---: | --- |
| Native feel |  |  |
| Guidance value |  |  |
| Overhead |  |  |
| Recovery |  |  |

## Good / native

-

## Wrong / confusing / overhead

-

## Recommendation

- Recommendation:
- Evidence:
- Expected benefit:
- Confidence: low | medium | high

## Verification evidence

- Pathframe commands/results:
- Laravel commands/results:
- Changed files:
```

## Mock record

[`000-mock-demo-health-endpoint.md`](000-mock-demo-health-endpoint.md) demonstrates a complete record. It is explicitly mock evidence and must not be counted in the evaluation.
